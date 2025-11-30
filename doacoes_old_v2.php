<?php
include './components/header.php';
include('config/conexao.php');

$message = '';
$message_type = '';

// Processar formulário de doação
if (isset($_POST['submit_doacao'])) {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $valor = floatval($_POST['valor'] ?? 0);
    $metodo_pagamento = $_POST['metodo_pagamento'] ?? '';
    $data_doacao = $_POST['data_doacao'] ?? date('Y-m-d');
    $mensagem = $_POST['mensagem'] ?? '';
    
    // Validações
    if (empty($nome) || empty($email) || $valor <= 0 || empty($metodo_pagamento)) {
        $message = 'Por favor, preencha todos os campos obrigatórios.';
        $message_type = 'danger';
    } else {
        // Upload de comprovativo (opcional)
        $comprovativo_path = null;
        if (isset($_FILES['comprovativo']) && $_FILES['comprovativo']['error'] === UPLOAD_ERR_OK) {
            // Upload simples sem helper
            $upload_dir = 'uploads/doadores/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $file_extension = pathinfo($_FILES['comprovativo']['name'], PATHINFO_EXTENSION);
            $file_name = uniqid() . '_' . time() . '.' . $file_extension;
            $file_path = $upload_dir . $file_name;
            
            if (move_uploaded_file($_FILES['comprovativo']['tmp_name'], $file_path)) {
                $comprovativo_path = $file_path;
            }
        }
        
        // Inserir no banco
        $stmt = $conn->prepare("INSERT INTO doadores (nome, email, telefone, valor, metodo_pagamento, data_doacao, comprovativo, mensagem, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pendente')");
        $stmt->bind_param("sssdssss", $nome, $email, $telefone, $valor, $metodo_pagamento, $data_doacao, $comprovativo_path, $mensagem);
        
        if ($stmt->execute()) {
            $message = 'Obrigado pela sua doação! Entraremos em contacto em breve.';
            $message_type = 'success';
        } else {
            $message = 'Erro ao registar doação. Tente novamente.';
            $message_type = 'danger';
        }
        $stmt->close();
    }
}

// Buscar configurações de doação
$sql = "SELECT * FROM configuracoes_doacoes WHERE id = 1";
$result = $conn->query($sql);
$config = $result->fetch_assoc();
?>

<style>
    .donation-page {
        padding: 100px 0 50px;
        background: #f7f8fa;
    }
    
    .donation-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        margin-bottom: 30px;
        transition: transform 0.3s;
    }
    
    .donation-card:hover {
        transform: translateY(-5px);
    }
    
    .payment-method {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        transition: all 0.3s;
    }
    
    .payment-method:hover {
        border-color: #f48924;
        background: #fff8f2;
    }
    
    .payment-icon {
        font-size: 48px;
        color: #f48924;
        margin-bottom: 15px;
    }
    
    .btn-donate {
        background: linear-gradient(135deg, #f48924 0%, #e67610 100%);
        color: white;
        padding: 15px 40px;
        font-size: 18px;
        border: none;
        border-radius: 50px;
        transition: all 0.3s;
    }
    
    .btn-donate:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 20px rgba(244, 137, 36, 0.4);
        color: white;
    }
    
    .section-title-doacoes {
        text-align: center;
        margin-bottom: 50px;
    }
    
    .section-title-doacoes h2 {
        font-size: 36px;
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
    }
    
    .section-title-doacoes p {
        font-size: 18px;
        color: #666;
    }
    
    @media (max-width: 768px) {
        .donation-page {
            padding: 80px 0 30px;
        }
        
        .donation-card {
            padding: 20px;
        }
        
        .section-title-doacoes h2 {
            font-size: 28px;
        }
    }
</style>

<section class="donation-page">
    <div class="container">
        <div class="section-title-doacoes" data-aos="fade-up">
            <h2>Apoie a Strong Woman</h2>
            <p>A sua contribuição faz a diferença na vida de muitas mulheres</p>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Métodos de Pagamento -->
        <div class="row mb-5" data-aos="fade-up">
            <div class="col-12">
                <div class="donation-card">
                    <h3 class="mb-4">Métodos de Doação</h3>
                    <div class="row">
                        
                        <?php if ($config['numero_conta']): ?>
                        <!-- Transferência Bancária -->
                        <div class="col-md-6 mb-4">
                            <div class="payment-method text-center">
                                <i class="bi bi-bank payment-icon"></i>
                                <h5>Transferência Bancária</h5>
                                <p class="mb-2"><strong><?php echo htmlspecialchars($config['banco_nome']); ?></strong></p>
                                <p class="mb-0">Conta: <strong><?php echo htmlspecialchars($config['numero_conta']); ?></strong></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($config['mpesa_numero']): ?>
                        <!-- M-Pesa -->
                        <div class="col-md-6 mb-4">
                            <div class="payment-method text-center">
                                <i class="bi bi-phone payment-icon"></i>
                                <h5>M-Pesa</h5>
                                <p class="mb-0">Número: <strong><?php echo htmlspecialchars($config['mpesa_numero']); ?></strong></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($config['emola_numero']): ?>
                        <!-- e-Mola -->
                        <div class="col-md-6 mb-4">
                            <div class="payment-method text-center">
                                <i class="bi bi-wallet2 payment-icon"></i>
                                <h5>e-Mola</h5>
                                <p class="mb-0">Número: <strong><?php echo htmlspecialchars($config['emola_numero']); ?></strong></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($config['paypal_button_code']): ?>
                        <!-- PayPal -->
                        <div class="col-md-6 mb-4">
                            <div class="payment-method text-center">
                                <i class="bi bi-paypal payment-icon"></i>
                                <h5>PayPal</h5>
                                <?php echo $config['paypal_button_code']; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ($config['instrucoes_gerais']): ?>
                    <div class="alert alert-info mt-4">
                        <i class="bi bi-info-circle"></i> <?php echo nl2br(htmlspecialchars($config['instrucoes_gerais'])); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Formulário de Registro -->
        <div class="row" data-aos="fade-up" data-aos-delay="100">
            <div class="col-lg-8 offset-lg-2">
                <div class="donation-card">
                    <h3 class="mb-4">Registar a Sua Doação</h3>
                    <p class="text-muted mb-4">Após efetuar a doação, preencha o formulário abaixo para que possamos confirmar o seu apoio.</p>
                    
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nome" class="form-label">Nome Completo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="tel" class="form-control" id="telefone" name="telefone" placeholder="Ex: 84 123 4567">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="valor" class="form-label">Valor Doado (MT) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="valor" name="valor" step="0.01" min="1" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="metodo_pagamento" class="form-label">Método de Pagamento <span class="text-danger">*</span></label>
                                <select class="form-select" id="metodo_pagamento" name="metodo_pagamento" required>
                                    <option value="">Selecione...</option>
                                    <option value="banco">Transferência Bancária</option>
                                    <option value="mpesa">M-Pesa</option>
                                    <option value="emola">e-Mola</option>
                                    <option value="paypal">PayPal</option>
                                    <option value="outro">Outro</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="data_doacao" class="form-label">Data da Doação <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="data_doacao" name="data_doacao" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label for="comprovativo" class="form-label">Comprovativo (Opcional)</label>
                                <input type="file" class="form-control" id="comprovativo" name="comprovativo" accept="image/*">
                                <div class="form-text">Envie uma captura de tela ou foto do comprovativo de pagamento</div>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label for="mensagem" class="form-label">Mensagem (Opcional)</label>
                                <textarea class="form-control" id="mensagem" name="mensagem" rows="3" placeholder="Deixe uma mensagem de apoio..."></textarea>
                            </div>
                            
                            <div class="col-12 text-center mt-4">
                                <button type="submit" name="submit_doacao" class="btn btn-donate">
                                    <i class="bi bi-heart-fill me-2"></i> Registar Doação
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vendor JS Files -->
<script src="assets/assets/vendor/aos/aos.js"></script>
<script src="assets/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/assets/js/main.js"></script>

<!-- Initialize AOS -->
<script>
    AOS.init({
        duration: 1000,
        once: true
    });
</script>

</body>
</html>
<?php
$conn->close();
?>
