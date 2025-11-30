<?php
include('config/conexao.php');

if (isset($_POST['galeria_id'])) {
    $galeria_id = $_POST['galeria_id'];

    // Execute a consulta DELETE para remover o registro da base de dados
    $sql = "DELETE FROM galeria WHERE id = $galeria_id";

    if ($conn->query($sql) === TRUE) {
        // Redirecione de volta para a página de listagem após a remoção bem-sucedida
        header('Location: galeria.php');
    } else {
        echo "Erro ao remover o registro: " . $conn->error;
    }
} else {
    echo "Parâmetros inválidos.";
}

$conn->close();
?>
