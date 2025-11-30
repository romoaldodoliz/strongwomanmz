<?php
include('config/conexao.php');

if (isset($_POST['homepagehero_id'])) {
    $homepagehero_id = $_POST['homepagehero_id'];

    // Execute a consulta DELETE para remover o registro da base de dados
    $sql = "DELETE FROM homepagehero WHERE id = $homepagehero_id";

    if ($conn->query($sql) === TRUE) {
        // Redirecione de volta para a página de listagem após a remoção bem-sucedida
        header('Location: homepagehero.php');
    } else {
        echo "Erro ao remover o registro: " . $conn->error;
    }
} else {
    echo "Parâmetros inválidos.";
}

$conn->close();
?>
