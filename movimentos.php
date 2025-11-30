<?php
$page_title = "Strong Woman - Nossos Movimentos";
include 'includes/navbar.php';
?>

<section class="py-5" style="min-height: 70vh;">
    <div class="container">
        <div class="section-title">
            <h2>NOSSOS MOVIMENTOS</h2>
            <p>Strong Woman Movement</p>
        </div>
        <div class="row">
            <?php
            include('config/conexao.php');
            $sql = "SELECT * FROM movimentos ORDER BY id DESC";
            $result = @$conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-lg-4 col-md-6 mb-4">';
                    echo '<div class="card h-100">';
                    if (!empty($row["imagem_principal"])) {
                        echo '<img src="' . htmlspecialchars($row["imagem_principal"]) . '" class="card-img-top" style="height:250px; object-fit:cover;">';
                    }
                    echo '<div class="card-body">';
                    echo '<h5>' . htmlspecialchars($row["titulo"]) . '</h5>';
                    echo '<p class="text-muted">' . htmlspecialchars($row["tema"]) . '</p>';
                    echo '<p>' . htmlspecialchars(substr($row["descricao"], 0, 100)) . '...</p>';
                    echo '<a href="movimento-detalhes.php?id=' . $row["id"] . '" class="btn btn-primary">Ver Detalhes</a>';
                    echo '</div></div></div>';
                }
            } else {
                echo '<div class="col-12 text-center py-5"><h4>Nenhum movimento disponível</h4></div>';
            }
            $conn->close();
            ?>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
