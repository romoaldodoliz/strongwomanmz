<?php
include('header.php');
include('config/conexao.php');
require_once('helpers/upload.php');

$message = '';
$message_type = '';

if (isset($_POST['submit'])) {
    $numero_conta = $_POST['numero_conta'] ?? '';
    $banco_nome = $_POST['banco_nome'] ?? '';
    $mpesa_numero = $_POST['mpesa_numero'] ?? '';
    $emola_numero = $_POST['emola_numero'] ?? '';
    $paypal_button_code = $_POST['paypal_button_code'] ?? '';
    $instrucoes_gerais = $_POST['instrucoes_gerais'] ?? '';
    
    // Usar prepared statement
    $stmt = $conn->prepare("UPDATE configuracoes_doacoes SET numero_conta = ?, banco_nome = ?, mpesa_numero = ?, emola_numero = ?, paypal_button_code = ?, instrucoes_gerais = ? WHERE id = 1");
    $stmt->bind_param("ssssss", $numero_conta, $banco_nome, $mpesa_numero, $emola_numero, $paypal_button_code, $instrucoes_gerais);
    
    if ($stmt->execute()) {
        $message = 'Configurações atualizadas com sucesso!';
        $message_type = 'success';
    } else {
        $message = 'Erro ao atualizar configurações: ' . $conn->error;
        $message_type = 'danger';
    }
    $stmt->close();
}

// Buscar configurações atuais
$sql = "SELECT * FROM configuracoes_doacoes WHERE id = 1";
$result = $conn->query($sql);
$config = $result->fetch_assoc();
?>

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Doações /</span> Configurações de Pagamento
        </h4>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Métodos de Pagamento</h5>
                    <div class="card-body">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            
                            <!-- Conta Bancária -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Transferência Bancária</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="banco_nome" class="form-label">Nome do Banco</label>
                                            <input type="text" name="banco_nome" id="banco_nome" class="form-control" 
                                                   value="<?php echo htmlspecialchars($config['banco_nome'] ?? ''); ?>" 
                                                   placeholder="Ex: Banco Millennium BIM">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="numero_conta" class="form-label">Número da Conta</label>
                                            <input type="text" name="numero_conta" id="numero_conta" class="form-control" 
                                                   value="<?php echo htmlspecialchars($config['numero_conta'] ?? ''); ?>" 
                                                   placeholder="Ex: 0012345678901">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Carteiras Móveis -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Carteiras Móveis</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="mpesa_numero" class="form-label">
                                                <i class="bx bx-mobile"></i> Número M-Pesa
                                            </label>
                                            <input type="text" name="mpesa_numero" id="mpesa_numero" class="form-control" 
                                                   value="<?php echo htmlspecialchars($config['mpesa_numero'] ?? ''); ?>" 
                                                   placeholder="Ex: 84 123 4567">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="emola_numero" class="form-label">
                                                <i class="bx bx-mobile"></i> Número e-Mola
                                            </label>
                                            <input type="text" name="emola_numero" id="emola_numero" class="form-control" 
                                                   value="<?php echo htmlspecialchars($config['emola_numero'] ?? ''); ?>" 
                                                   placeholder="Ex: 85 123 4567">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PayPal -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">PayPal</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="paypal_button_code" class="form-label">Código do Botão PayPal</label>
                                        <textarea name="paypal_button_code" id="paypal_button_code" class="form-control" 
                                                  rows="5" placeholder="Cole aqui o código HTML do botão PayPal..."><?php echo htmlspecialchars($config['paypal_button_code'] ?? ''); ?></textarea>
                                        <div class="form-text">
                                            Para obter o código, acesse sua conta PayPal → Tools → PayPal Buttons → Donate
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Instruções Gerais -->
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Instruções Gerais</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="instrucoes_gerais" class="form-label">Mensagem para Doadores</label>
                                        <textarea name="instrucoes_gerais" id="instrucoes_gerais" class="form-control" 
                                                  rows="4" placeholder="Mensagem de agradecimento ou instruções adicionais..."><?php echo htmlspecialchars($config['instrucoes_gerais'] ?? ''); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" name="submit" class="btn btn-primary me-2">
                                    <i class="bx bx-save"></i> Salvar Configurações
                                </button>
                                <a href="dashboard.php" class="btn btn-secondary">
                                    <i class="bx bx-arrow-back"></i> Voltar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
