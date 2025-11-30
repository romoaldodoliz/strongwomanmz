<?php
include('config/conexao.php');

if (isset($_POST['comunitarias_id'])) {
    $comunitarias_id = $_POST['comunitarias_id'];

    // Execute a consulta DELETE para remover o registro da base de dados
    $sql = "DELETE FROM comunitarias WHERE id = $comunitarias_id";

    if ($conn->query($sql) === TRUE) {
        // Redirecione de volta para a página de listagem após a remoção bem-sucedida
        header('Location: comunitarias.php');
    } else {
        echo "Erro ao remover o registro: " . $conn->error;
    }
} else {
    echo "Parâmetros inválidos.";
}

$conn->close();
?>
