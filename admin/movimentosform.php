<?php
// IMPORTANTE: Processar dados ANTES de incluir header.php para permitir redirects
include('config/conexao.php');
require_once('helpers/upload.php');

$message = '';
$message_type = '';
$editing = false;
$movimento = null;

// Verificar se está editando
if (isset($_GET['id'])) {
    $editing = true;
    $movimento_id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM movimentos WHERE id = ?");
    $stmt->bind_param("i", $movimento_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $movimento = $result->fetch_assoc();
    $stmt->close();
    
    if (!$movimento) {
        header('Location: movimentos.php');
        exit;
    }
}

// Processar formulário
if (isset($_POST['submit'])) {
    $titulo = $_POST['titulo'] ?? '';
    $tema = $_POST['tema'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $data_evento = $_POST['data_evento'] ?? null;
    $local = $_POST['local'] ?? '';
    $status = $_POST['status'] ?? 'publicado';
    
    $uploader = new ImageUploader();
    
    if ($editing) {
        // Atualizar movimento existente
        $imagem_principal = $movimento['imagem_principal'];
        
        // Se nova imagem foi enviada
        if (isset($_FILES['imagem_principal']) && $_FILES['imagem_principal']['error'] === UPLOAD_ERR_OK) {
            $result = $uploader->uploadImage($_FILES['imagem_principal'], 'movimentos', 1200, 800);
            if ($result['success']) {
                // Deletar imagem antiga
                if ($imagem_principal) {
                    $uploader->deleteImage($imagem_principal);
                }
                $imagem_principal = $result['path'];
            }
        }
        
        $stmt = $conn->prepare("UPDATE movimentos SET titulo = ?, tema = ?, descricao = ?, data_evento = ?, local = ?, imagem_principal = ?, status = ? WHERE id = ?");
        $stmt->bind_param("sssssssi", $titulo, $tema, $descricao, $data_evento, $local, $imagem_principal, $status, $movimento_id);
        
        if ($stmt->execute()) {
            $message = 'Movimento atualizado com sucesso!';
            $message_type = 'success';
            
            // Recarregar dados
            $movimento['titulo'] = $titulo;
            $movimento['tema'] = $tema;
            $movimento['descricao'] = $descricao;
            $movimento['data_evento'] = $data_evento;
            $movimento['local'] = $local;
            $movimento['imagem_principal'] = $imagem_principal;
            $movimento['status'] = $status;
        } else {
            $message = 'Erro ao atualizar movimento: ' . $conn->error;
            $message_type = 'danger';
        }
        $stmt->close();
        
    } else {
        // Criar novo movimento
        $imagem_principal = null;
        if (isset($_FILES['imagem_principal']) && $_FILES['imagem_principal']['error'] === UPLOAD_ERR_OK) {
            $result = $uploader->uploadImage($_FILES['imagem_principal'], 'movimentos', 1200, 800);
            if ($result['success']) {
                $imagem_principal = $result['path'];
            }
        }
        
        $stmt = $conn->prepare("INSERT INTO movimentos (titulo, tema, descricao, data_evento, local, imagem_principal, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $titulo, $tema, $descricao, $data_evento, $local, $imagem_principal, $status);
        
        if ($stmt->execute()) {
            $movimento_id = $conn->insert_id;
            // Redirecionar para edição (antes de qualquer output)
            header("Location: movimentosform.php?id=$movimento_id");
            exit;
        } else {
            $message = 'Erro ao criar movimento: ' . $conn->error;
            $message_type = 'danger';
        }
        $stmt->close();
    }
}

// Processar upload de fotos da galeria
if (isset($_POST['upload_fotos']) && $editing) {
    if (isset($_FILES['fotos']['name'][0]) && !empty($_FILES['fotos']['name'][0])) {
        $uploader = new ImageUploader();
        $total_success = 0;
        
        // Reorganizar array de arquivos
        $files = [];
        foreach ($_FILES['fotos']['name'] as $key => $name) {
            if ($_FILES['fotos']['error'][$key] === UPLOAD_ERR_OK) {
                $files[] = [
                    'name' => $_FILES['fotos']['name'][$key],
                    'type' => $_FILES['fotos']['type'][$key],
                    'tmp_name' => $_FILES['fotos']['tmp_name'][$key],
                    'error' => $_FILES['fotos']['error'][$key],
                    'size' => $_FILES['fotos']['size'][$key]
                ];
            }
        }
        
        // Upload cada foto
        foreach ($files as $file) {
            $result = $uploader->uploadImage($file, 'movimentos', 1200, 1200);
            if ($result['success']) {
                $foto_path = $result['path'];
                $stmt = $conn->prepare("INSERT INTO movimentos_fotos (movimento_id, foto) VALUES (?, ?)");
                $stmt->bind_param("is", $movimento_id, $foto_path);
                if ($stmt->execute()) {
                    $total_success++;
                }
                $stmt->close();
            }
        }
        
        $message = "$total_success foto(s) adicionada(s) com sucesso!";
        $message_type = 'success';
    } else {
        $message = 'Nenhuma foto foi selecionada.';
        $message_type = 'warning';
    }
}

// Remover foto da galeria
if (isset($_POST['remover_foto'])) {
    $foto_id = intval($_POST['foto_id']);
    
    // Buscar caminho da foto
    $stmt = $conn->prepare("SELECT foto FROM movimentos_fotos WHERE id = ?");
    $stmt->bind_param("i", $foto_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $foto = $result->fetch_assoc();
    $stmt->close();
    
    if ($foto) {
        // Deletar arquivo
        $uploader = new ImageUploader();
        $uploader->deleteImage($foto['foto']);
        
        // Deletar do banco
        $stmt = $conn->prepare("DELETE FROM movimentos_fotos WHERE id = ?");
        $stmt->bind_param("i", $foto_id);
        $stmt->execute();
        $stmt->close();
        
        $message = 'Foto removida com sucesso!';
        $message_type = 'success';
    }
}

// AGORA incluir header.php (após processar dados que podem fazer redirect)
include('header.php');
?>

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Movimentos /</span> <?php echo $editing ? 'Editar' : 'Adicionar Novo'; ?>
        </h4>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Formulário Principal -->
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Informações do Movimento</h5>
                    <div class="card-body">
                        <form action="<?php echo $_SERVER['PHP_SELF'] . ($editing ? '?id=' . $movimento_id : ''); ?>" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                                    <input type="text" name="titulo" id="titulo" class="form-control" 
                                           value="<?php echo htmlspecialchars($movimento['titulo'] ?? ''); ?>" required>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="publicado" <?php echo ($movimento['status'] ?? '') == 'publicado' ? 'selected' : ''; ?>>Publicado</option>
                                        <option value="rascunho" <?php echo ($movimento['status'] ?? '') == 'rascunho' ? 'selected' : ''; ?>>Rascunho</option>
                                        <option value="arquivado" <?php echo ($movimento['status'] ?? '') == 'arquivado' ? 'selected' : ''; ?>>Arquivado</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="tema" class="form-label">Tema</label>
                                    <input type="text" name="tema" id="tema" class="form-control" 
                                           value="<?php echo htmlspecialchars($movimento['tema'] ?? ''); ?>" placeholder="Ex: Empoderamento Feminino">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label for="data_evento" class="form-label">Data do Evento</label>
                                    <input type="date" name="data_evento" id="data_evento" class="form-control" 
                                           value="<?php echo $movimento['data_evento'] ?? ''; ?>">
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label for="local" class="form-label">Local</label>
                                    <input type="text" name="local" id="local" class="form-control" 
                                           value="<?php echo htmlspecialchars($movimento['local'] ?? ''); ?>" placeholder="Ex: Maputo">
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="descricao" class="form-label">Descrição <span class="text-danger">*</span></label>
                                    <textarea name="descricao" id="descricao" class="form-control" rows="6" required><?php echo htmlspecialchars($movimento['descricao'] ?? ''); ?></textarea>
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="imagem_principal" class="form-label">Imagem Principal</label>
                                    <?php if ($editing && $movimento['imagem_principal']): ?>
                                        <div class="mb-2">
                                            <img src="../<?php echo htmlspecialchars($movimento['imagem_principal']); ?>" 
                                                 style="max-width: 300px; border-radius: 8px;" class="img-fluid">
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" name="imagem_principal" id="imagem_principal" class="form-control" accept="image/*">
                                    <div class="form-text">Recomendado: 1200x800px. Formatos: JPG, PNG, WebP</div>
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <button type="submit" name="submit" class="btn btn-primary">
                                    <i class="bx bx-save"></i> <?php echo $editing ? 'Atualizar' : 'Criar'; ?> Movimento
                                </button>
                                <a href="movimentos.php" class="btn btn-secondary">
                                    <i class="bx bx-arrow-back"></i> Voltar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($editing): ?>
        <!-- Galeria de Fotos -->
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Galeria de Fotos</h5>
                    <div class="card-body">
                        <!-- Form de Upload -->
                        <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $movimento_id; ?>" method="POST" enctype="multipart/form-data" class="mb-4">
                            <div class="mb-3">
                                <label for="fotos" class="form-label">Adicionar Fotos</label>
                                <input type="file" name="fotos[]" id="fotos" class="form-control" accept="image/*" multiple>
                                <div class="form-text">Você pode selecionar múltiplas fotos de uma vez</div>
                            </div>
                            <button type="submit" name="upload_fotos" class="btn btn-success">
                                <i class="bx bx-upload"></i> Upload Fotos
                            </button>
                        </form>

                        <!-- Grid de Fotos -->
                        <div class="row">
                            <?php
                            $sql = "SELECT * FROM movimentos_fotos WHERE movimento_id = ? ORDER BY ordem, id";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $movimento_id);
                            $stmt->execute();
                            $fotos_result = $stmt->get_result();
                            
                            if ($fotos_result->num_rows > 0) {
                                while ($foto = $fotos_result->fetch_assoc()) {
                                    echo "<div class='col-md-3 mb-3'>";
                                    echo "<div class='card'>";
                                    echo "<img src='../" . htmlspecialchars($foto['foto']) . "' class='card-img-top' style='height: 200px; object-fit: cover;'>";
                                    echo "<div class='card-body p-2'>";
                                    echo "<form method='POST' action='' class='d-inline'>";
                                    echo "<input type='hidden' name='foto_id' value='" . $foto['id'] . "'>";
                                    echo "<button type='submit' name='remover_foto' class='btn btn-sm btn-danger w-100' onclick='return confirm(\"Remover esta foto?\")'>";
                                    echo "<i class='bx bx-trash'></i> Remover";
                                    echo "</button>";
                                    echo "</form>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";
                                }
                            } else {
                                echo "<div class='col-12'>";
                                echo "<p class='text-muted text-center'>Nenhuma foto adicionada ainda.</p>";
                                echo "</div>";
                            }
                            $stmt->close();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>
    <!-- / Content -->

    <!-- Footer -->
    <?php include('footerprincipal.php'); ?>
    <!-- / Footer -->

    <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
<?php
include('footer.php');
$conn->close();
?>
