<?php
include './components/header.php';
include('config/conexao.php');
?>
<div class="container" style="height: 30px;"></div>
<!-- ======= Events Section ======= -->
<section id="portfolio" class="portfolio">
  <div class="container" data-aos="fade-up">

    <div class="section-title">
      <h2>Eventos</h2>
      <p>NOSSOS EVENTOS</p>
    </div>

    <div class="row" data-aos="fade-up" data-aos-delay="100">
      <div class="col-lg-12 d-flex justify-content-center">
        <ul id="portfolio-flters">
          <li data-filter="*" class="filter-active">Todos</li>
          <li data-filter=".filter-dec">Dezembro</li>
          <li data-filter=".filter-maio">Maio</li>
        </ul>
      </div>
    </div>

    <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">


                      <?php
                            // Consulta SELECT
                            $sql = "SELECT * FROM eventos";
                            $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<div class="col-lg-4 col-md-6 portfolio-item filter-dec">';
                                    echo '<div class="portfolio-wrap">';
                            
                                    $imagemBLOB = base64_encode($row["foto"]); 
                                    echo '<img src="data:image/jpeg;base64,' . $imagemBLOB . '" alt="Imagem da noticia" class="img-fluid w-100" style="object-fit: cover; height: 250px;">';
                                    echo '<div class="portfolio-info">';
                                    echo '<h4>'.$row["titulo"].'</h4>';
                                    echo '<p>09 Dias | 09 Horas | 09 Minutos</p>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            }
                        ?>
    </div>
  </div>
</section><!-- End Events Section -->
<?php
include './components/footer.php';
?>