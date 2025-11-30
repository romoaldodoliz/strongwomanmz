<?php
include './components/header.php';
include('config/conexao.php');
?>
<main id="main">
    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
        <div class="container" data-aos="zoom-in">
            <div class="text-center">
                <h3>CAPACITAÇÕES DAS STRONG WOMAN</h3>
            </div>
        </div>
    </section><!-- End Cta Section -->

    <section id="testimonials" class="testimonials">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <?php
                // Consulta SELECT
                $sql = "SELECT * FROM comunitarias";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <div class="col-lg-4 col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="100">
                            <div class="card">
                                <iframe width="100%" height="200" src="<?php echo $row['link']; ?>" title="<?php echo $row['titulo']; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                <div class="card-body">
                                    <h6 class="card-title"><?php echo $row['titulo']; ?></h6>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>
</main>

<?php
include './components/footer.php';
?>