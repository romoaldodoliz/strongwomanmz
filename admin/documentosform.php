<?php
include('header.php');
include('config/conexao.php');

if (isset($_POST['submit'])) {
    // Verifique se o arquivo de documento foi enviado com sucesso
    if (isset($_FILES['documento']) && $_FILES['documento']['error'] === UPLOAD_ERR_OK) {
        // Obtenha os dados do documento
        $nome_arquivo = $_FILES['documento']['name'];
        $tipo_arquivo = $_FILES['documento']['type'];
        $tamanho_arquivo = $_FILES['documento']['size'];
        $tmp_name = $_FILES['documento']['tmp_name'];

        // Prepare o documento para inserção no banco de dados
        $documento_bin = file_get_contents($tmp_name);
        $documento_bin = $conn->real_escape_string($documento_bin);

        // Dados do documento
        $nome = $_POST["nome"];
        $tipo_documento = $_POST["tipo_documento"];

        // Inserir o documento na tabela
        $sql = "INSERT INTO documentos (nome, tipo_documento, documento) VALUES ('$nome', '$tipo_documento', '$documento_bin')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>window.alert('Documento registado com sucesso!')</script>";
            echo "<script>window.location='documentos.php'</script>";
        } else {
            echo "Erro na inserção: " . $conn->error;
        }
    } else {
        echo "<script>window.alert('Erro no envio do documento.')</script>";
    }
    // Fechar a conexão
    $conn->close();
}
?>
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Adicionar Documento</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="defaultFormControlInput" class="form-label">Nome</label>
                                    <input type="text" name="nome" class="form-control" placeholder="Nome" required />
                                </div>
                                <div class="col-md-12">
                                    <label for="defaultSelect" class="form-label">Tipo de documento</label>
                                    <select id="defaultSelect" name="tipo_documento" class="form-select">
                                        <option value="Certificado">Certificado</option>
                                        <option value="Diploma">Diploma</option>
                                        <option value="Revista">Revista</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="defaultFormControlInput" class="form-label">Documento (PDF)</label>
                                    <input type="file" name="documento" class="form-control" accept=".pdf" required />
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
