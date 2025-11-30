<?php
include('config/conexao.php');

if (isset($_POST['area_id'])) {
    $area_id = $_POST['area_id'];

    // Execute a consulta DELETE para remover o registro da base de dados
    $sql = "DELETE FROM areas WHERE id = $area_id";

    if ($conn->query($sql) === TRUE) {
        // Redirecione de volta para a página de listagem após a remoção bem-sucedida
        header('Location: areas.php');
    } else {
        echo "Erro ao remover o registro: " . $conn->error;
    }
} else {
    echo "Parâmetros inválidos.";
}

$conn->close();
?>
