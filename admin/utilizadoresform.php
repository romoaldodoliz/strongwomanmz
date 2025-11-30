<?php
include('header.php');
include('config/conexao.php');


if (isset($_POST['submit'])) {
    // SQL de inserção
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    // SQL de inserção - note as aspas simples em '$senha'
    $sql = "INSERT INTO users (nome, email, senha) VALUES ('$nome', '$email', '$senha')";

    // Executar a consulta de inserção
    if ($conn->query($sql) === TRUE) {
        echo "<script>window.alert('Utilizador registado!')</script>";
        echo "<script>window.location='utilizadores.php'</script>";
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

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Adicionar Utilizador</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="defaultFormControlInput" class="form-label">Nome Completo</label>
                                    <input type="text" name="nome" class="form-control" placeholder="Nome Completo" required />
                                </div>
                                <div class="col-md-4">
                                    <label for="defaultFormControlInput" class="form-label">E-mail</label>
                                    <input type="text" name="email" class="form-control" placeholder="E-mail" required />
                                </div>
                                <div class="col-md-4">
                                    <label for="defaultFormControlInput" class="form-label">Senha</label>
                                    <input type="text" name="senha" class="form-control" placeholder="Senha" required />
                                </div>
                                <div class="col-md-8"></div>
                            </div>
                            <div class="col-md-4" style="padding-top: 5px;">
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