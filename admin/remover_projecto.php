<?php
include('config/conexao.php');

if (isset($_POST['projecto_id'])) {
    $projecto_id = $_POST['projecto_id'];

    // Execute a consulta DELETE para remover o registro da base de dados
    $sql = "DELETE FROM projectos WHERE id = $projecto_id";

    if ($conn->query($sql) === TRUE) {
        // Redirecione de volta para a página de listagem após a remoção bem-sucedida
        header('Location: projectos.php');
    } else {
        echo "Erro ao remover o registro: " . $conn->error;
    }
} else {
    echo "Parâmetros inválidos.";
}

$conn->close();
?>
