<?php
$page_title = "Strong Woman - Notícias";
include 'includes/navbar.php';
?>

<section class="py-5" style="min-height: 70vh;">
    <div class="container">
        <div class="section-title">
            <h2>NOTÍCIAS</h2>
            <p>Últimas Notícias Strong Woman</p>
        </div>
        <div class="row">
            <?php
            include('config/conexao.php');
            $sql = "SELECT * FROM noticias ORDER BY id DESC";
            $result = @$conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $imagemBLOB = base64_encode($row["foto"]);
                    echo '<div class="col-lg-4 col-md-6 mb-4">';
                    echo '<div class="card h-100">';
                    echo '<img src="data:image/jpeg;base64,' . $imagemBLOB . '" class="card-img-top" style="height:250px; object-fit:cover;">';
                    echo '<div class="card-body">';
                    echo '<h5>' . htmlspecialchars($row["titulo"]) . '</h5>';
                    echo '<p>' . htmlspecialchars(substr($row["descricao"], 0, 150)) . '...</p>';
                    echo '</div></div></div>';
                }
            } else {
                echo '<div class="col-12 text-center py-5"><h4>Nenhuma notícia disponível</h4></div>';
            }
            $conn->close();
            ?>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
