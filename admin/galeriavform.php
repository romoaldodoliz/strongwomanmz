<?php
include('header.php');
include('config/conexao.php');


if (isset($_POST['submit'])) {
    // SQL de inserção
    $titulo = $_POST["titulo"];
    $descricao = $_POST["descricao"];
    $link = $_POST["link"];
    $sql = "INSERT INTO galeria (titulo, descricao, link, foto, tipo) VALUES ('$titulo', '$descricao', '$link', '', 'video')";

    // Executar a consulta de inserção
    if ($conn->query($sql) === TRUE) {
        echo "<script>window.alert('Video carregado com sucesso!')</script>";
        echo "<script>window.location='galeria.php'</script>";
    } else {
        echo "Erro na inserção: " . $conn->error;
    }

    // Fechar a conexão
    $conn->close();
}
?>

<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Adicionar Video a galeria</h4>
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
                                    <label for="defaultFormControlInput" class="form-label">Imagem</label>
                                    <input type="text" name="link" class="form-control" required />
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
