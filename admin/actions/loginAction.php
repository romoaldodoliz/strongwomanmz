<?php
// Incluir helper de autenticação
require_once(__DIR__ . '/../helpers/auth.php');

// Incluir conexão com banco
include '../config/conexao.php';

if(isset($_POST['submit'])){
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Verifica se os campos estão preenchidos
    if(empty($email) || empty($password)) {
        $_SESSION['error_message'] = 'Por favor, preencha todos os campos.';
        header('Location: ../index.php');
        exit;
    }

    // Verificar rate limiting (proteção contra brute force)
    $identifier = $email . '_' . $_SERVER['REMOTE_ADDR'];
    if (!checkLoginRateLimit($identifier)) {
        $_SESSION['error_message'] = 'Muitas tentativas de login. Tente novamente em 15 minutos.';
        header('Location: ../index.php');
        exit;
    }

    // Verificar conexão com banco
    if ($conn->connect_error) {
        error_log('Falha na conexão: ' . $conn->connect_error);
        $_SESSION['error_message'] = 'Erro de conexão. Tente novamente.';
        header('Location: ../index.php');
        exit;
    }

    // Buscar usuário com prepared statement
    // IMPORTANTE: Senha deve ser hash (password_hash/password_verify)
    // Por enquanto mantendo compatibilidade, mas RECOMENDA-SE usar hash
    $stmt = $conn->prepare("SELECT id, nome, email FROM users WHERE email = ? AND senha = ?");
    
    if ($stmt === false) {
        error_log('Erro na preparação da consulta: ' . $conn->error);
        $_SESSION['error_message'] = 'Erro interno. Contate o administrador.';
        header('Location: ../index.php');
        exit;
    }

    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        // Usar função de login do helper
        login($row['id'], $row['nome'], $row['email']);
        
        // Limpar tentativas de login
        clearLoginAttempts($identifier);
        
        // Log da atividade
        logAdminActivity('LOGIN', 'Usuário fez login com sucesso');
        
        // Redirecionar para página que tentou acessar ou dashboard
        $redirect = $_SESSION['redirect_after_login'] ?? 'dashboard.php';
        unset($_SESSION['redirect_after_login']);
        
        header("Location: ../$redirect");
        exit;
    } else {
        error_log('Tentativa de login falhou para email: ' . $email);
        $_SESSION['error_message'] = 'Email ou senha incorretos!';
        header('Location: ../index.php');
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    $_SESSION['error_message'] = 'Requisição inválida.';
    header('Location: ../index.php');
    exit;
}
?>
