<?php
include('header.php');
include('config/conexao.php');
        $titulo = $_POST["titulo"];
        $descricao = $_POST["descricao"];
        $link = $_POST["link"];
        $data = $_POST["data"];
        $tipo = $_POST["tipo"];

if (isset($_POST['submit'])) {
    $tipo = $_POST["tipo"];
    if ($tipo === "imagem") {

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {

            $nome_arquivo = $_FILES['imagem']['name'];
            $tipo_arquivo = $_FILES['imagem']['type'];
            $tamanho_arquivo = $_FILES['imagem']['size'];
            $tmp_name = $_FILES['imagem']['tmp_name'];

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
    } elseif ($tipo === "video") {
        $titulo = $_POST["titulo"];
        $descricao = $_POST["descricao"];
        $link = $_POST["link"];
        $data = $_POST["data"];
        $tipo = $_POST["tipo"];
        $link_video = $_POST["link_video"];

        $sql = "INSERT INTO galeria (tipo, titulo, descricao, link) VALUES ('video', '$titulo', '$descricao', '$link_video')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>window.alert('Link do video registado com sucesso!')</script>";
            echo "<script>window.location='galeria.php'</script>";
        } else {
            echo "Erro ao enviar link do vídeo: " . $conn->error;
        }
    }
    $conn->close();
}


?>
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span>Adicionar</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" id="form_video" method="POST" enctype="multipart/form-data">
                            <div class="col-md-12">
                                <h2>Video</h2>
                            </div>   
                            <div class="col-md-12">
                                <label  for="tipo" class="form-label">Tipo:</label>
                                <select class="form-control tipo" name="tipo" onchange="mostrarOcultarCampo()">
                                    <option value="imagem">Imagem</option>
                                    <option value="video">Vídeo</option>
                                </select>
                            </div>            
                            <div class="col-md-12" id="campo_imagem" style="display:none;">
                                <label for="defaultFormControlInput" class="form-label">Imagem</label>
                                <input type="file" id="imagem" name="imagem" class="form-control" accept="image/*" required />
                            </div>
                        
                            <div class="col-md-12" id="campo_video">
                                <label for="defaultFormControlInput" class="form-label">Link do video</label>
                                <input type="text" id="link" name="link" class="form-control" placeholder="Link" required />
                            </div>
                        
                            <div class="col-md-12">
                                <label for="defaultFormControlInput" class="form-label">Titulo</label>
                                <input type="text" name="titulo" class="form-control" placeholder="Titulo" required />
                            </div>
                        
                            <div class="col-md-12">
                                <label for="defaultFormControlInput" class="form-label">Descrição</label>
                                <textarea class="form-control" name="descricao" rows="3"></textarea>
                            </div>
                            
                            <div class="col-md-12" style="padding-top: 5px;">
                                <button class="btn btn-dark" name="submit" type="submit" id="botao_video">Submeter</button>
                            </div>
                        </form>
                        
                        
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" id="form_imagem" method="POST" enctype="multipart/form-data">
                            <div class="col-md-12">
                                <h2>Imagem</h2>
                            </div>    
                            <div class="col-md-12">
                                <label  for="tipo" class="form-label">Tipo:</label>
                                <select class="form-control tipo" name="tipo" onchange="mostrarOcultarCampo()">
                                    <option value="imagem">Imagem</option>
                                    <option value="video">Vídeo</option>
                                </select>
                            </div>            
                            <div class="col-md-12" id="campo_imagem" style="display:none;">
                                <label for="defaultFormControlInput" class="form-label">Imagem</label>
                                <input type="file" id="imagem" name="imagem" class="form-control" accept="image/*" required />
                            </div>
                        
                            <div class="col-md-12" id="campo_video">
                                <label for="defaultFormControlInput" class="form-label">Link do video</label>
                                <input type="text" id="link" name="link" class="form-control" placeholder="Link" required />
                            </div>
                        
                            <div class="col-md-12">
                                <label for="defaultFormControlInput" class="form-label">Titulo</label>
                                <input type="text" name="titulo" class="form-control" placeholder="Titulo" required />
                            </div>
                        
                            <div class="col-md-12">
                                <label for="defaultFormControlInput" class="form-label">Descrição</label>
                                <textarea class="form-control" name="descricao" rows="3"></textarea>
                            </div>
                            
                            <div class="col-md-12" style="padding-top: 5px;">
                                <button class="btn btn-dark" name="submit" type="submit" id="botao_imagem">Submeter</button>
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
<script>
    function mostrarOcultarCampo() {
        var tipoSelecionado = document.getElementById("tipo").value;
        var campoImagem = document.getElementById("campo_imagem");
        var campoVideo = document.getElementById("campo_video");
        var botaoImagem = document.getElementById("botao_imagem");
        var botaoVideo = document.getElementById("botao_video");
    
        if (tipoSelecionado === "imagem") {
            campoImagem.style.display = "block";
            campoVideo.style.display = "none";
            
            botaoImagem.style.display = "block";
            botaoVideo.style.display = "none";
        } else if (tipoSelecionado === "video") {
            campoImagem.style.display = "none";
            campoVideo.style.display = "block";
            
            botaoImagem.style.display = "none";
            botaoVideo.style.display = "block";
        }
    }
</script>
<?php
include('footer.php');
?>