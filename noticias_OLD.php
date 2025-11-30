<?php
include './components/header.php';
include('config/conexao.php');
?>

<main id="main">
<!-- ======= Cta Section ======= -->
<section id="cta" class="cta">
  <div class="container" data-aos="zoom-in">
    <div class="text-center">
      <h3>DESCUBRA AS ÚLTIMAS NOVIDADES</h3>
      <p>Explore as histórias inspiradoras e impactantes da Strong Woman.</p>
    </div>
  </div>
</section>
<!-- End Cta Section -->



    <section class="inner-page">
      <div class="container-fluid">
        <div class="row">
          <div class="container-fluid">
            <div class="container">
              <div class="row">
                <div class="col-lg-8">
                  <div class="row">
                      <?php
// Consulta SELECT
$sql = "SELECT * FROM noticias";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-lg-6">';
        echo '<div class="position-relative mb-3">';

        $imagemBLOB = base64_encode($row["foto"]); 
        echo '<img src="data:image/jpeg;base64,' . $imagemBLOB . '" alt="Imagem da noticia" class="img-fluid w-100" style="object-fit: cover; height: 250px;">';

        echo '<div class="bg-white border border-top-0 p-4">';
        echo '<a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold" href="#">' . $row["titulo"] . '</a>';
        echo '<p class="m-0">' . $row["descricao"] . '</p>'; 
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}
?>

                  </div>
                </div>
              </div>
            </div>
          </div>
    </section>

  </main><!-- End #main -->

<?php
include './components/footer.php';
?>