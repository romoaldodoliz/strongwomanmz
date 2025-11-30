<?php
include('config/conexao.php');

$message = '';
$message_type = '';

// Upload de documento
if (isset($_POST['upload'])) {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $categoria = $_POST['categoria'];
    $status = $_POST['status'];
    
    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['arquivo'];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        // Verificar se é PDF
        if ($file_ext === 'pdf') {
            // Nome único para o arquivo
            $new_name = uniqid() . '_' . time() . '.pdf';
            $upload_path = '../uploads/documentos/' . $new_name;
            
            if (move_uploaded_file($file_tmp, $upload_path)) {
                $arquivo_path = 'uploads/documentos/' . $new_name;
                
                $stmt = $conn->prepare("INSERT INTO documentos (titulo, descricao, arquivo, tipo_arquivo, tamanho_arquivo, categoria, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $tipo = 'application/pdf';
                $stmt->bind_param("ssssiis", $titulo, $descricao, $arquivo_path, $tipo, $file_size, $categoria, $status);
                
                if ($stmt->execute()) {
                    $message = 'Documento enviado com sucesso!';
                    $message_type = 'success';
                } else {
                    $message = 'Erro ao salvar no banco: ' . $conn->error;
                    $message_type = 'danger';
                }
                $stmt->close();
            } else {
                $message = 'Erro ao fazer upload do arquivo!';
                $message_type = 'danger';
            }
        } else {
            $message = 'Apenas arquivos PDF são permitidos!';
            $message_type = 'warning';
        }
    }
}

// Remover documento
if (isset($_POST['remover'])) {
    $id = intval($_POST['id']);
    
    // Buscar caminho do arquivo
    $stmt = $conn->prepare("SELECT arquivo FROM documentos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $doc = $result->fetch_assoc();
    $stmt->close();
    
    if ($doc) {
        // Deletar arquivo
        if (file_exists('../' . $doc['arquivo'])) {
            unlink('../' . $doc['arquivo']);
        }
        
        // Deletar do banco
        $stmt = $conn->prepare("DELETE FROM documentos WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $message = 'Documento removido com sucesso!';
            $message_type = 'success';
        } else {
            $message = 'Erro ao remover documento!';
            $message_type = 'danger';
        }
        $stmt->close();
    }
}

// Buscar todos os documentos
$result = $conn->query("SELECT * FROM documentos ORDER BY created_at DESC");

include('header.php');
?>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Multimedia /</span> Documentos
        </h4>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Upload Form -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <h5 class="card-header">Enviar Novo Documento</h5>
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Título *</label>
                                <input type="text" name="titulo" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Descrição</label>
                                <textarea name="descricao" class="form-control" rows="3"></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Categoria</label>
                                <select name="categoria" class="form-select">
                                    <option value="Relatórios">Relatórios</option>
                                    <option value="Políticas">Políticas</option>
                                    <option value="Projetos">Projetos</option>
                                    <option value="Outros">Outros</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Arquivo PDF *</label>
                                <input type="file" name="arquivo" class="form-control" accept=".pdf" required>
                                <small class="text-muted">Apenas arquivos PDF (máx. 10MB)</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="publicado">Publicado</option>
                                    <option value="rascunho">Rascunho</option>
                                </select>
                            </div>
                            
                            <button type="submit" name="upload" class="btn btn-primary w-100">
                                <i class="bx bx-upload"></i> Enviar Documento
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Lista de Documentos -->
            <div class="col-md-8">
                <div class="card">
                    <h5 class="card-header">Lista de Documentos</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Categoria</th>
                                    <th>Tamanho</th>
                                    <th>Downloads</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($doc = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo htmlspecialchars($doc['titulo']); ?></strong>
                                            <?php if ($doc['descricao']): ?>
                                                <br><small class="text-muted"><?php echo substr(htmlspecialchars($doc['descricao']), 0, 50); ?>...</small>
                                            <?php endif; ?>
                                        </td>
                                        <td><span class="badge bg-label-info"><?php echo $doc['categoria']; ?></span></td>
                                        <td><?php echo round($doc['tamanho_arquivo'] / 1024, 2); ?> KB</td>
                                        <td><?php echo $doc['downloads']; ?></td>
                                        <td>
                                            <?php if ($doc['status'] === 'publicado'): ?>
                                                <span class="badge bg-label-success">Publicado</span>
                                            <?php else: ?>
                                                <span class="badge bg-label-warning">Rascunho</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="../<?php echo $doc['arquivo']; ?>" target="_blank" class="btn btn-sm btn-primary" title="Ver">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            <a href="../<?php echo $doc['arquivo']; ?>" download class="btn btn-sm btn-info" title="Download">
                                                <i class="bx bx-download"></i>
                                            </a>
                                            <form method="POST" style="display:inline;" onsubmit="return confirm('Remover este documento?');">
                                                <input type="hidden" name="id" value="<?php echo $doc['id']; ?>">
                                                <button type="submit" name="remover" class="btn btn-sm btn-danger" title="Remover">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('footer.php');
$conn->close();
?>
