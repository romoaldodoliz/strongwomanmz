<?php
include('header.php');
include('config/conexao.php');
function criarSlug($str) {
    // Substituir caracteres especiais e espaços por hífens
    $str = preg_replace('/[^\p{L}\p{N}\s-]/u', '', $str);
    $str = strtolower(trim($str));
    $str = preg_replace('/\s+/', '-', $str);

    // Remover múltiplos hífens consecutivos
    $str = preg_replace('/-+/', '-', $str);

    return $str;
}

if (isset($_POST['submit'])) {
    // SQL de inserção
    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $slug = criarSlug($_POST["nome"]);
    // SQL de inserção - note as aspas simples em '$senha'
    $sql = "INSERT INTO areas (nome, slug, descricao) VALUES ('$nome', '$slug', '$descricao')";

    // Executar a consulta de inserção
    if ($conn->query($sql) === TRUE) {
        echo "<script>window.alert('Area registada com Sucesso!')</script>";
        echo "<script>window.location='areas.php'</script>";
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

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Criar area de intervenção</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="defaultFormControlInput" class="form-label">Nome</label>
                                    <input type="text" name="nome" class="form-control" placeholder="Nome" required />
                                </div>
                                <!-- <div class="col-md-12">
                                    <label for="defaultFormControlInput" class="form-label">Descricao</label>
                                    <textarea class="form-control" name="descricao" rows="3"></textarea>
                                </div> -->
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