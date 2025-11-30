<?php
    include('config/conexao.php');

    if (isset($_POST['evento_id'])) {
        $evento_id = $_POST['evento_id'];

        // Execute a consulta DELETE para remover o registro da base de dados
        $sql = "DELETE FROM eventos WHERE id = $evento_id";

        if ($conn->query($sql) === TRUE) {
            // Redirecione de volta para a página de listagem após a remoção bem-sucedida
            header('Location: eventos.php');
        } else {
            echo "Erro ao remover o registro: " . $conn->error;
        }
    } else {
        echo "Parâmetros inválidos.";
    }

    $conn->close();
?>
