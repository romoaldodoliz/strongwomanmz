<?php
include './components/header.php';
?>

<!-- Crie uma regra CSS personalizada ou uma variável CSS personalizada -->
<style>
  /* Regra CSS personalizada */
  #hero {
    width: 100%;
    min-height: 100vh;
    background: url('data:image/jpeg;base64, <?php echo $imagemBase64; ?>') top center;
    background-size: cover;
    position: relative;
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    background-color: #f7f8fa;
    z-index: 2;
  }

  #herorel {
    color: rgb(244, 138, 36);
  }
</style>


<!-- ======= Hero Section ======= -->
<div class="swiper-container main-slider" id="myCarousel">
  <div class="swiper-wrapper">
    <?php
    include('config/conexao.php');

    // Consulta para obter as imagens mais recentes
    $sql = "SELECT * FROM homepagehero ORDER BY id ASC LIMIT 3";
    $resultado = @$conn->query($sql);
    
    if (!$resultado) {
      // Se tabela não existe ou erro, mostrar imagem padrão
      $resultado = new stdClass();
      $resultado->num_rows = 0;
    }

    if ($resultado->num_rows > 0) {
      // Exibe as imagens mais recentes se houver resultados
      $i = 0; // contador de imagem
      while ($row = $resultado->fetch_assoc()) {
        $imagemBlob = $row['foto'];
        $imagemBase64 = base64_encode($imagemBlob);

        // Verifica se é a primeira imagem
        if ($i == 0) {
          echo '<div class="swiper-slide imagem-principal" style="width: 100%;min-height: 100vh;background:url(data:image/jpeg;base64,' . $imagemBase64 . ') top center; background-size: cover; position: relative; background-size: contain; background-repeat: no-repeat; background-position: center; background-color: #f7f8fa; z-index: 2;" data-hash="slide' . $row['id'] . '">';

          // echo ' <h2 id="herorel">PIRCOM-Plataforma Inter-Religiosa de Comunicação para a Saúde </h2>';
        } else {
          echo '<div class="swiper-slide slider-bg-position" style="background:url(data:image/jpeg;base64,' . $imagemBase64 . ') top center; background-size: cover;" data-hash="slide' . $row['id'] . '">';

          echo '<h2>' . $row['descricao'] . '</h2>';
        }

        echo '</div>';

        // incrementa o contador
        $i++;
      }
    } else {
      // Caso contrário, defina uma imagem padrão
      echo '<div class="swiper-slide slider-bg-position" style="background:url(\'https://cdn.pixabay.com/photo/2017/08/07/14/02/people-2604149_960_720.jpg\')" data-hash="slide2">';
      echo '<h2>Happiness is nothing more than good health and a bad memory</h2>';
      echo '</div>';
    }

    $conn->close();
    ?>


  </div>
  <!-- Add Pagination -->
  <div class="swiper-pagination"></div>
  <!-- Add Navigation -->
  <div class="swiper-button-prev"><i class="fa fa-chevron-left"></i></div>
  <div class="swiper-button-next"><i class="fa fa-chevron-right"></i></div>
</div>


<!-- ======= Events Section ======= -->
<section id="portfolio" class="portfolio">






  <!-- Seccao de ultimas noticias -->

  <div class="container-xxl">
    <div class="container">
      <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
        <div class="section-title mt-5">
          <h2>ÚLTIMAS</h2>
          <p>Notícias</p>
        </div>
      </div>

      <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">

          <?php
          include('config/conexao.php');
          $sql = "SELECT * FROM noticias";
          $result = @$conn->query($sql);
          
          if (!$result) {
            $result = new stdClass();
            $result->num_rows = 0;
          }

          if ($result->num_rows > 0) {
            $chunks = array_chunk($result->fetch_all(MYSQLI_ASSOC), 3); // Agrupa os resultados em conjuntos de três

            $activeClass = 'active';
            foreach ($chunks as $chunk) {
              echo '<div class="carousel-item ' . $activeClass . '">';
              echo '<div class="row justify-content-center">';

              foreach ($chunk as $row) {
                echo '<div class="col-lg-4 col-md-6 mb-4">';
                echo '<div class="card h-100">';
                echo '<a href="noticias.php?id=' . $row["id"] . '">';
                $imagemBLOB = base64_encode($row["foto"]);
                echo '<img src="data:image/jpeg;base64,' . $imagemBLOB . '" alt="Imagem da noticia" class="card-img-top" style="object-fit: cover; height: 250px;">';
                echo '<div class="card-body">';
                echo '<h4 class="card-title">' . $row["titulo"] . '</h4>';
                echo '<p class="card-text">' . substr($row["descricao"], 0, 100) . '...</p>';
                echo '</div>';
                echo '</a>';
                echo '</div>';
                echo '</div>';
              }

              echo '</div>'; // End row
              echo '</div>'; // End carousel-item
              $activeClass = ''; // Remove active class after the first item
            }
          } else {
            echo '<p class="text-center">Nenhuma notícia encontrada.</p>';
          }
          ?>

        </div>

        <a class="carousel-control-prev" href="#newsCarousel" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </a>
        <a class="carousel-control-next" href="#newsCarousel" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </a>
      </div>
    </div>
  </div>


  <!-- Fim do codigo das noticiais -->





  <div class="container" data-aos="fade-up">

    <div class="section-title mt-5">
      <h2>Eventos</h2>
      <p>NOSSOS EVENTOS</p>
    </div>

    <div class="row" data-aos="fade-up" data-aos-delay="100">
      <div class="col-lg-12 d-flex justify-content-center">
        <ul id="portfolio-flters">
          <li data-filter="*" class="filter-active">Todos</li>
          <!-- <li data-filter=".filter-dec">Dezembro</li>
          <li data-filter=".filter-maio">Maio</li> -->
        </ul>
      </div>
    </div>

    <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">


      <?php
      include('config/conexao.php');
      // Consulta SELECT
      $sql = "SELECT * FROM eventos";
      $result = @$conn->query($sql);
      
      if (!$result) {
        $result = new stdClass();
        $result->num_rows = 0;
      }

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '<div class="col-lg-4 col-md-6 portfolio-item filter-dec">';
          echo '<div class="portfolio-wrap">';

          $imagemBLOB = base64_encode($row["foto"]);
          echo '<img src="data:image/jpeg;base64,' . $imagemBLOB . '" alt="Imagem da noticia" class="img-fluid w-100" style="object-fit: cover; height: 250px;">';
          echo '<div class="portfolio-info">';
          echo '<h4>' . $row["titulo"] . '</h4>';
          echo '<p>09 Dias | 09 Horas | 09 Minutos</p>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
      }
      ?>
    </div>

  </div>
</section>

<!-- End Events Section -->


<main id="main">

  <!-- ======= About Section ======= -->
  <!-- End About Section -->

  <!-- <div class="separador"></div> -->

<!-- ======= Iniciativas ======= -->

<section id="features" class="features">
  <div class="container" data-aos="fade-up">
    <div class="section-title mt-5">
      <h2>Iniciativas</h2>
      <p>Fortalecendo Mulheres</p>
    </div>
    <div class="row">
      <div class="image col-lg-6" style='background-image: url("assets/img/s2.jpg");' data-aos="fade-right">
      </div>
      <div class="col-lg-6" data-aos="fade-left" data-aos-delay="100">
        <div class="icon-box mt-5 mt-lg-0" data-aos="zoom-in" data-aos-delay="150">
          <i class="bx bx-book-reader"></i>
          <h4>Capacitação Profissional:</h4>
          <p>Oferecemos cursos e treinamentos para mulheres desenvolverem habilidades e conquistarem independência financeira.</p>
        </div>
        <div class="icon-box mt-5" data-aos="zoom-in" data-aos-delay="150">
          <i class="bx bx-group"></i>
          <h4>Apoio Psicológico:</h4>
          <p>Disponibilizamos atendimento psicológico individual e em grupo para mulheres lidarem com traumas e fortalecerem sua saúde mental.</p>
        </div>
        <div class="icon-box mt-5" data-aos="zoom-in" data-aos-delay="150">
          <i class="bx bx-briefcase-alt"></i>
          <h4>Assistência Jurídica:</h4>
          <p>Fornecemos orientação legal e acompanhamento processual para mulheres em situações de violência doméstica e discriminação de gênero.</p>
        </div>
      </div>
    </div>
  </div>
</section>

  <!-- FIM Iniciativas -->

  <!-- ======= Projectos ======= -->

  <section id="services" class="services">
  <div class="container" data-aos="fade-up">

    <div class="section-title">
      <h2>PROJECTOS</h2>
      <p>NOSSOS PROJECTOS</p>
    </div>

    <div class="row">

      <!-- Palestras e Workshops -->
      <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
        <a href="quem-somos.php" style="text-decoration: none; color: inherit;">
          <div class="icon-box">
            <div class="icon"><i class="bx bx-message-square-detail"></i></div>
            <h4>Palestras e Workshops</h4>
            <p>A Strong Woman irá exercer suas atividades de inspiração, mentoria, e motivação através do conhecimento científico, empírico e experiência pessoal.</p>
            <div class="row" data-aos="fade-up" data-aos-delay="100">
              <div class="col-lg-12 d-flex justify-content-center">
              </div>
            </div>
          </div>
        </a>
      </div>

      <!-- Conferências e Mega Eventos -->
      <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
        <a href="quem-somos.php" style="text-decoration: none; color: inherit;">
          <div class="icon-box">
            <div class="icon"><i class="bx bx-calendar-event"></i></div>
            <h4>Conferências e Mega Eventos</h4>
            <p>Os eventos serão conferências designadas Strong Woman Conference, que prevêem sua realização uma vez ao ano, com participação de mulheres nacionais e internacionais de impacto.</p>
            <div class="row" data-aos="fade-up" data-aos-delay="100">
              <div class="col-lg-12 d-flex justify-content-center">
              </div>
            </div>
          </div>
        </a>
      </div>

      <!-- Movimentos de Engajamento Social -->
      <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0" data-aos="zoom-in" data-aos-delay="300">
        <a href="quem-somos.php" style="text-decoration: none; color: inherit;">
          <div class="icon-box">
            <div class="icon"><i class="bx bx-network-chart"></i></div>
            <h4>Movimentos de Engajamento Social</h4>
            <p>Os movimentos serão designados Strong Woman Movement, promovendo intercâmbio entre mulheres com várias atividades nas áreas de cultura, saúde, empreendedorismo e mais.</p>
            <div class="row" data-aos="fade-up" data-aos-delay="100">
              <div class="col-lg-12 d-flex justify-content-center">
              </div>
            </div>
          </div>
        </a>
      </div>

    </div>

  </div>
</section>




  <!-- Fim dos Projectos da Strong Woman -->




  <!-- ======= Team Section ======= -->
  <section id="team" class="team">
    <div class="container py-5">
    <div class="section-title">
        <h2>CONHEÇA</h2>
        <p>FUNDADORA DA STRONG WOMAN</p>
      </div>
      <div class="row g-5 align-items-center">
        <div class="col-lg-4 wow fadeIn" data-wow-delay="0.1s">
          <div class="team-member text-center">
            <img class="img-fluid  mb-3" src="assets/img/a4.jpg" style="height: auto; width:157px;" alt="Team Member">
            <h3>PALMIRA MUCAVELE</h3>
            <p>Fundadora</p>
            <div class="social-icons">
              <!-- ícones de mídia social dos membros-->
              <a href="#"><i class="bi bi-twitter"></i></a>
              <a href="#"><i class="bi bi-facebook"></i></a>
              <a href="#"><i class="bi bi-linkedin"></i></a>
              <a href="#"><i class="bi bi-instagram"></i></a>
            </div>
          </div>
        </div>
        <div class="col-lg-8 wow fadeIn texto" data-wow-delay="0.5s">
          <h2 class="mb-4">Fundadora da Strong Woman MZ| ICC Certified Coach| Mentor| HR Specialist</h2>
          <p class="mb-4"> <b>Palmira Mucavele</b> é uma Profissional de Recursos Humanos com 18 anos de experiência, ocupando cargos de liderança há 10 anos em empresas multinacionais e Organizações Não Governamentais.
           <br>
            É formada em Gestão de Recursos Humanos e Certificada como Coach pela ICC (International Coaching Community), actuando como Coach de Vida. 
            <br> <b>Palmira</b> tem como lema “Pessoas Precisam de Pessoas”.</p>
          <a class="btn btn-primary py-3 px-5 mt-3" href="quem-somos.php">Ler Mais...</a>
        </div>
      </div>
    </div>
  </section>
  <!-- End Team Section -->



  <!-- ======= Venha ser parceiro ======= -->
  <section id="cta" class="cta">
    <div class="container" data-aos="zoom-in">
      <div class="text-center">
        <h3>SE PRETENDE ABRAÇAR A CAUSA SENDO MAIS UM DOADOR</h3>
        <p>"Com sua ajuda, podemos iluminar caminhos e transformar histórias. Junte-se a nós para fazer a diferença real na vida de quem mais precisa."
        </p>
        <a class="cta-btn" href="mailto: palmira.mucavele@strongwoman-mz.org">Contacte-nos p/ mais informações</a>
      </div>
    </div>
  </section>

  <!-- Venha ser parceiro  -->



  <!-- ======= Parceiros ======= -->



  <!-- Fim da Lista de Parceitos -->



</main>

<!-- Fim #main -->
<?php
include './components/footer.php';
?>