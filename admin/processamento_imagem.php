<?php
// Verifica se o formulário de imagem foi enviado
if (isset($_POST['submit_imagem'])) {
    include('config/conexao.php');

    $titulo = $_POST['titulo_imagem'];
    $descricao = $_POST['descricao_imagem'];

    // Verifica se um arquivo de imagem foi enviado
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {

        $nome_arquivo = $_FILES['imagem']['name'];
        $tipo_arquivo = $_FILES['imagem']['type'];
        $tamanho_arquivo = $_FILES['imagem']['size'];
        $tmp_name = $_FILES['imagem']['tmp_name'];

        // Verifica se o arquivo é uma imagem
        $allowed_extensions = array('jpeg', 'jpg', 'png', 'gif');
        $extensao_arquivo = strtolower(pathinfo($nome_arquivo, PATHINFO_EXTENSION));

        if (!in_array($extensao_arquivo, $allowed_extensions)) {
            echo "Erro: arquivo não é uma imagem.";
            exit();
        }

        $imagem_bin = file_get_contents($tmp_name);
        $imagem_bin = $conn->real_escape_string($imagem_bin);

        $sql = "INSERT INTO galeria (id,titulo,descricao,link,foto,tipo)  VALUES (NULL,'$titulo', '$descricao',NULL,'$imagem_bin','imagem')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>window.alert('Imagem registada com sucesso!')</script>";
            echo "<script>window.location='galeria.php'</script>";
        } else {
            echo "Erro ao enviar imagem: " . $conn->error;
        }
    } else {
        echo "Erro no envio da imagem.";
    }
    $conn->close();
} else {
    echo "Erro: formulário de imagem não foi enviado.";
}
?>
