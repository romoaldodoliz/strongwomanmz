<?php
include('header.php');
include('config/conexao.php');
function criarSlug($str)
{
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
    $objectivo = $_POST["objectivo"];
    $areas_tematicas = $_POST["areas_tematicas"];
    $inicio = $_POST["inicio"];
    $grupo_alvo = $_POST["grupo_alvo"];
    $area_geografica = $_POST["area_geografica"];
    $doador = $_POST["doador"];
    $coordenacao = $_POST["coordenacao"];
    $parceiros = $_POST["parceiros"];

    // SQL de inserção
    $sql = "INSERT INTO projectos (nome, descricao, objectivo, areas_tematicas, inicio, grupo_alvo, area_geografica, doador, coordenacao, parceiros) 
            VALUES ('$nome', '$descricao', '$objectivo', '$areas_tematicas', '$inicio', '$grupo_alvo', '$area_geografica', '$doador', '$coordenacao', '$parceiros')";

    // Executar a consulta de inserção
    if ($conn->query($sql) === TRUE) {
        echo "<script>window.alert('Projecto adicionado com Sucesso!')</script>";
        echo "<script>window.location='projectos.php'</script>";
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

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Adicionar Projecto</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Nome</label>
                                    <textarea class="form-control" name="nome" rows="3"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Descrição</label>
                                    <textarea class="form-control" name="descricao" rows="3"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Objectivo do projecto</label>
                                    <textarea class="form-control" name="objectivo" rows="3"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Áreas Temáticas</label>
                                    <textarea class="form-control" name="areas_tematicas" rows="3"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Inicio do projecto</label>
                                    <textarea class="form-control" name="inicio" rows="3"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Grupo-Alvo</label>
                                    <textarea class="form-control" name="grupo_alvo" rows="3"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Área Geográfica</label>
                                    <textarea class="form-control" name="area_geografica" rows="3"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Doador do projecto</label>
                                    <textarea class="form-control" name="doador" rows="3"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Coordenação</label>
                                    <textarea class="form-control" name="coordenacao" rows="3"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="defaultFormControlInput" class="form-label">Parceiros</label>
                                    <textarea class="form-control" name="parceiros" rows="3"></textarea>
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