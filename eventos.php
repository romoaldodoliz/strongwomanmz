<?php
$page_title = "Strong Woman - Eventos";
include 'includes/navbar.php';
?>

<section class="py-5" style="min-height: 70vh;">
    <div class="container">
        <div class="section-title">
            <h2>EVENTOS</h2>
            <p>Nossos Eventos Strong Woman</p>
        </div>

        <div class="row">
            <?php
            include('config/conexao.php');
            $sql = "SELECT * FROM eventos ORDER BY id DESC";
            $result = @$conn->query($sql);

            if (!$result) {
                $result = new stdClass();
                $result->num_rows = 0;
            }

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $imagemBLOB = base64_encode($row["foto"]);
                    echo '<div class="col-lg-4 col-md-6 mb-4">';
                    echo '<div class="card h-100">';
                    echo '<img src="data:image/jpeg;base64,' . $imagemBLOB . '" class="card-img-top" style="height:250px; object-fit:cover;" alt="Evento">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($row["titulo"]) . '</h5>';
                    echo '<p class="card-text">' . htmlspecialchars($row["descricao"]) . '</p>';
                    if (!empty($row["data_evento"])) {
                        echo '<p class="text-muted"><i class="bi bi-calendar-event"></i> ' . date('d/m/Y', strtotime($row["data_evento"])) . '</p>';
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="col-12 text-center py-5">';
                echo '<i class="bi bi-calendar-x" style="font-size: 64px; color: var(--primary-color);"></i>';
                echo '<h4 class="mt-3">Nenhum evento disponível no momento</h4>';
                echo '<p>Volte em breve para ver nossos próximos eventos!</p>';
                echo '</div>';
            }

            $conn->close();
            ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
