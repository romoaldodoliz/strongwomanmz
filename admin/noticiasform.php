<?php
    include('header.php');
    include('config/conexao.php');

    if (isset($_POST['submit'])) {
        // Verifique se o arquivo de imagem foi enviado com sucesso
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            // Obtenha os dados da imagem
            $nome_arquivo = $_FILES['imagem']['name'];
            $tipo_arquivo = $_FILES['imagem']['type'];
            $tamanho_arquivo = $_FILES['imagem']['size'];
            $tmp_name = $_FILES['imagem']['tmp_name'];

            // Verifique se o arquivo é uma imagem
            if (strpos($tipo_arquivo, "image") !== false) {
                // Prepare a imagem para inserção no banco de dados
                $imagem_bin = file_get_contents($tmp_name);
                $imagem_bin = $conn->real_escape_string($imagem_bin);

                // Dados do evento
                $titulo = $_POST["titulo"];
                $descricao = $_POST["descricao"];
                $data = $_POST["data"];

                // Inserir o evento na tabela
                $sql = "INSERT INTO noticias (titulo ,foto, descricao, data) VALUES ('$titulo','$imagem_bin', '$descricao', '$data')";

                if ($conn->query($sql) === TRUE) {
                    echo "<script>window.alert('Noticia registada com sucesso!')</script>";
                    echo "<script>window.location='noticias.php'</script>";
                } else {
                    echo "Erro na inserção: " . $conn->error;
                }
            } else {
                echo "Apenas imagens são permitidas.";
            }
        } else {
            echo "Erro no envio da imagem.";
        }
        // Fechar a conexão
        $conn->close();
    }
?>

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Adicionar Imagem as Noticias</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="defaultFormControlInput" class="form-label">Titulo</label>
                                    <input type="text" name="titulo" class="form-control" placeholder="Titulo" required />
                                </div>
                                <div class="col-md-12">
                                    <label for="defaultFormControlInput" class="form-label">Descrição</label>
                                    <textarea class="form-control" name="descricao" rows="3"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label for="defaultFormControlInput" class="form-label">Data</label>
                                    <input type="date" name="data" class="form-control" placeholder="Data" required />
                                </div>
                                <div class="col-md-12">
                                    <label for="defaultFormControlInput" class="form-label">Imagem</label>
                                    <input type="file" name="imagem" class="form-control" accept="image/*" required />
                                </div>
                            </div>
                            <div class="col-md-4" style="padding-top: 10px;">
                                <button class="btn btn-dark" name="submit" type="submit">Submeter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->

    <!-- Footer -->
    <?php include('footerprincipal.php'); ?>
    <!-- / Footer -->
    <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
<?php
    include('footer.php');
?>
