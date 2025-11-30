<?php
include('config/conexao.php');

if (isset($_POST['submit'])) {
    $titulo = $_POST["titulo"];
    $descricao = $_POST["descricao"];
    $link = $_POST["link"];
    $data = $_POST["data"];

    // Se você espera que o tipo seja 'video' e se o link não for vazio
    if ($_POST["tipo"] === "video" && !empty($_POST["link_video"])) {
        $link_video = $_POST["link_video"];

        $sql = "INSERT INTO galeria (titulo, descricao, link) VALUES ('$titulo', '$descricao', '$link_video')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>window.alert('Link de vídeo registrado com sucesso!')</script>";
            echo "<script>window.location='galeria.php'</script>";
        } else {
            echo "Erro ao enviar link do vídeo: " . $conn->error;
        }
    } else {
        echo "Erro: O tipo é inválido ou o link do vídeo está vazio!";
    }
}

$conn->close();
?>
