<?php
include('config/conexao.php');

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Execute a consulta DELETE para remover o registro da base de dados
    $sql = "DELETE FROM users WHERE id = $user_id";

    if ($conn->query($sql) === TRUE) {
        // Redirecione de volta para a página de listagem após a remoção bem-sucedida
        header('Location: utilizadores.php');
    } else {
        echo "Erro ao remover o registro: " . $conn->error;
    }
} else {
    echo "Parâmetros inválidos.";
}

$conn->close();
