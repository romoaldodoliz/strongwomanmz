<?php
    include('config/conexao.php');

    if (isset($_POST['noticia_id'])) {
        $noticia_id = $_POST['noticia_id'];

        // Execute a consulta DELETE para remover o registro da base de dados
        $sql = "DELETE FROM noticias WHERE id = $noticia_id";

        if ($conn->query($sql) === TRUE) {
            // Redirecione de volta para a página de listagem após a remoção bem-sucedida
            header('Location: noticias.php');
        } else {
            echo "Erro ao remover o registro: " . $conn->error;
        }
    } else {
        echo "Parâmetros inválidos.";
    }

    $conn->close();
?>
