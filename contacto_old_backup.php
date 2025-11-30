<?php
include './components/header.php';
?>
  <main id="main">

<!-- ======= Breadcrumbs ======= -->
<section class="breadcrumbs">
  <div class="container">


  </div>
</section><!-- End Breadcrumbs -->
<!-- ======= Contact Section ======= -->
<section id="contact" class="contact">
  <div class="container" data-aos="fade-up">

    <div class="section-title">
      <h2>Contactos</h2>
      <p>Entre Em Contacto</p>
    </div>


    <div class="row mt-5">

      <div class="col-lg-4">
        <div class="info">
          <div class="address">
            <i class="bi bi-geo-alt"></i>
            <h4>Local:</h4>
            <p>Maputo</p>
          </div>

          <div class="email">
            <i class="bi bi-envelope"></i>
            <h4>Email:</h4>
            <p>palmira.mucavele@strongwoman-mz.org</p>
          </div>

          <div class="phone">
            <i class="bi bi-phone"></i>
            <h4>Telefone:</h4>
            <p>
              <a href="tel:+25821423103">(+258) 828372810</a>
              <a href="tel:+258823070991"> | (+258) 84768523</a>
            </p>
          </div>

        </div>

      </div>

      <div class="col-lg-8 mt-5 mt-lg-0">

        <form action="forms/contact.php" method="post" role="form" class="php-email-form">
          <div class="row">
            <div class="col-md-6 form-group">
              <input type="text" name="name" class="form-control" id="name" placeholder="Nome Completo" required>
            </div>
            <div class="col-md-6 form-group mt-3 mt-md-0">
              <input type="email" class="form-control" name="email" id="email" placeholder="Seu Email" required>
            </div>
          </div>
          <div class="form-group mt-3">
            <input type="text" class="form-control" name="subject" id="subject" placeholder="Assunto" required>
          </div>
          <div class="form-group mt-3">
            <textarea class="form-control" name="message" rows="5" placeholder="Mensagem" required></textarea>
          </div>
          <div class="my-3">
            <div class="loading">Processando</div>
            <div class="error-message"></div>
            <div class="sent-message">Sua Mensagem Foi Enviada. OBRIGADO</div>
          </div>
          <div class="text-center"><button type="submit" class="w-100">Enviar</button></div>
        </form>

      </div>

    </div>

  </div>
</section><!-- End Contact Section -->
</main><!-- End #main -->

<?php
include './components/footer.php';
?>