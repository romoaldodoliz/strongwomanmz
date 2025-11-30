<?php
include('config/conexao.php');

if (isset($_POST['massmedia_id'])) {
    $massmedia_id = $_POST['massmedia_id'];

    // Execute a consulta DELETE para remover o registro da base de dados
    $sql = "DELETE FROM massmedia WHERE id = $massmedia_id";

    if ($conn->query($sql) === TRUE) {
        // Redirecione de volta para a página de listagem após a remoção bem-sucedida
        header('Location: massmedia.php');
    } else {
        echo "Erro ao remover o registro: " . $conn->error;
    }
} else {
    echo "Parâmetros inválidos.";
}

$conn->close();
?>
