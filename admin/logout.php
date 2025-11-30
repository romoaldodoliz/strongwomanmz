<?php
// Incluir helper de autenticação
require_once(__DIR__ . '/helpers/auth.php');

// Log da atividade antes de fazer logout
if (isAuthenticated()) {
    logAdminActivity('LOGOUT', 'Usuário fez logout');
}

// Fazer logout (já redireciona para index.php)
logout();
?>
