<?php
include './components/header.php';
?>

<main id="main">

<section id="cta" class="cta">
  <div class="container" data-aos="zoom-in">
    <div class="text-center">
      <h3>NOSSA COBERTURA</h3>
      <p>
      </p>
      <!-- <a class="cta-btn" href="mailto:pircom@pircom.org">Volunarie-se</a> -->
    </div>
  </div>
</section>
<!-- ======= Breadcrumbs ======= -->


<section class="inner-pagearea">

</section>
</div>
<section id="portfolio" class="portfolio">
  <div class="container" data-aos="fade-up">

    <div class="section-title">
      <h2>Coberta Geografica</h2>
      <p>NOSSA COBERTURA </p>
    </div>
  </div>
  
      <div class="row">
        <div class="col-md-6">
            <?php include 'mapa.php'; ?>
        </div>
        
        <div class="col-md-6">
            <table>
  <tr>
    <th>Provincia</th>
    <th>Estado</th>
  </tr>
  <tr>
    <td>Maputo</td>
    <td>Operacional</td>
  </tr>
  <tr>
    <td>Nampula</td>
    <td>Operacional</td>
  </tr>
    <tr>
    <td>Tete</td>
    <td>Não operacional</td>
  </tr>
    <tr>
    <td>Niassa</td>
    <td>Não operacional</td>
  </tr>
    <tr>
    <td>Zambezia</td>
    <td>Operacional</td>
  </tr>
    <tr>
    <td>Sofala</td>
    <td>Operacional</td>
  </tr>
    <tr>
    <td>Cabo Delgado</td>
    <td>Operacional</td>
  </tr>
    <tr>
    <td>Manica</td>
    <td>Operacional</td>
  </tr>
    <tr>
    <td>Inhambane</td>
    <td>Operacional</td>
  </tr>
    <tr>
    <td>Gaza</td>
    <td>Operacional</td>
  </tr>
</table>
        </div>
    </div>
</section>

<div id="map"></div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

</section>

</main><!-- End #main -->

<?php
include './components/footer.php';
?>