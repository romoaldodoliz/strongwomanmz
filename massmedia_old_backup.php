<?php
include './components/header.php';
include('config/conexao.php');
?>

<main id="main">
  <!-- ======= Cta Section ======= -->
  <section id="cta" class="cta">
    <div class="container" data-aos="zoom-in">
      <div class="text-center">
        <h3>VIDEOS DO NOSSO CANAL YOUTUBE</h3>
      </div>
    </div>
  </section><!-- End Cta Section -->

  <section id="services" class="services">
    <div class="container" data-aos="fade-up">
      <!-- <div class="section-title">
        <h2>Nossas abordagens</h2>
        <p>Massmedia</p>
      </div> -->
          <div class="row">
            <?php
                // Consulta SELECT
                $sql = "SELECT * FROM massmedia";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-lg-6" data-aos="zoom-in" data-aos-delay="100">';
                        echo '<div>';
                        echo '<div>';
                        echo '<iframe width="100%" height="530" src="'.$row['link'].'" title="'.$row['titulo'].'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
                        echo '<h6 style="margin-top:1px; margin-bottom:1rem; font-weight:600">' . $row["titulo"] . '</h6>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
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