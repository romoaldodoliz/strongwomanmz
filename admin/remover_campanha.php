<?php
include('config/conexao.php');

if (isset($_POST['campanha_id'])) {
    $campanha_id = $_POST['campanha_id'];

    // Execute a consulta DELETE para remover o registro da base de dados
    $sql = "DELETE FROM campanhas WHERE id = $campanha_id";

    if ($conn->query($sql) === TRUE) {
        // Redirecione de volta para a página de listagem após a remoção bem-sucedida
        header('Location: campanhas.php');
    } else {
        echo "Erro ao remover o registro: " . $conn->error;
    }
} else {
    echo "Parâmetros inválidos.";
}

$conn->close();
?>
