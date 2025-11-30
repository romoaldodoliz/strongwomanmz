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
function tt()
{
    include('config/conexao.php');
    $id = $_GET['id'];
    $sql = "SELECT * FROM config WHERE id = $id";
    $resultado = mysqli_query($conn, $sql);

    if (!$resultado) {
        die("Erro na consulta: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($resultado);
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM config WHERE id = $id";
    $resultado = mysqli_query($conn, $sql);

    if (!$resultado) {
        die("Erro na consulta: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($resultado);
}

if (isset($_POST['submit'])) {
    $id = $_POST["id"];
    $missao = mysqli_real_escape_string($conn, $_POST["missao"]);
    $visao = mysqli_real_escape_string($conn, $_POST["visao"]);
    $valores = mysqli_real_escape_string($conn, $_POST["valores"]);

    $query = "UPDATE config SET missao = '$missao', valores = '$valores', visao = '$visao' WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        // header('Location: configuracoes.php');
        echo "<script>window.alert('Actualizado com Sucesso!')</script>";
        echo "<script>window.location='configuracoes.php'</script>";

        // header('Location: configuracoes.php');
    }
}

mysqli_close($conn);
?>
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Missão, Visão e Valores </h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="<?php echo $_SERVER["PHP_SELF"] . '?id=' . $id; ?>" method="POST">
                            <div class="row">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <div class="col-md-12">
                                    <label for="defaultFormControlInput" class="form-label">Missão</label>
                                    <textarea class="form-control" name="missao" rows="5"><?php echo $row['missao']; ?></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label for="defaultFormControlInput" class="form-label">Visão</label>
                                    <textarea class="form-control" name="visao" rows="5"><?php echo $row['visao']; ?></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label for="defaultFormControlInput" class="form-label">Valores</label>
                                    <textarea class="form-control" name="valores" rows="5"><?php echo $row['valores']; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4" style="padding-top: 10px;">
                                <button class="btn btn-dark" name="submit" type="submit">Actualizar</button>
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