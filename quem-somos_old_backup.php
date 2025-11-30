<?php
include './components/header.php';
include('config/conexao.php');
?>
 <main id="main">
  <!-- ======= Cta Section ======= -->
  <section id="cta" class="cta">
    <div class="container" data-aos="zoom-in">
      <div class="text-center">
        <br>
        <h3>STRONG WOMAN – ESTAMOS FOCADOS NO FUTURO DAS MULHERES</h3>
      </div>
    </div>
  </section><!-- End Cta Section -->

  <section id="counts" class="counts">
  <div class="container-xxl py-5">
    <div class="container">
      <div class="row g-5 align-items-center">
        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
          <div class="about-img position-relative overflow-hidden p-5 pe-0">
            <img class="img-fluid w-100" src="assets/img/s2.jpg" alt="Imagem representativa do projeto Strong Woman">
          </div>
        </div>
        <div class="col-lg-6 wow fadeIn texto" data-wow-delay="0.5s">
          <p class="mb-4">
            <strong>Strong Woman</strong> é um projeto no ramo de desenvolvimento pessoal e profissional que visa inspirar, motivar, mentorar e prover ferramentas educativas para as mulheres em um contexto social de estigmatização, discriminação de gênero, exclusão social e violência doméstica. 
            <br> Trata-se de um movimento social que tem como causa:
          </p>
          <ul class="mb-4">
            <li>Inspirar e elevar a autoestima da mulher;</li>
            <li>Prover ferramentas de empoderamento social e profissional para as mulheres;</li>
            <li>Gerar diálogos e oferecer treinamentos técnicos de motivação para a vida pessoal e profissional das mulheres;</li>
            <li>Mentorar as mulheres no acesso a emprego e oportunidades econômicas;</li>
            <li>Motivar e apoiar as mulheres viúvas e mães solteiras em seu processo de resiliência.</li>
          </ul>
          <p>
            Nós estamos comprometidos em fazer a diferença real na vida das mulheres, capacitando-as e fortalecendo suas comunidades.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>


    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-6 order-1 order-lg-2 my-auto" data-aos="fade-left" data-aos-delay="100">
            <img src="assets/img/s3.jpg" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-right" data-aos-delay="100">
                <div class="row">
                    <?php
                        // Consulta SELECT
                        $sql = "SELECT * FROM config Where id=1";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<h3>PÚBLICO-ALVO.</h3>';
                                echo '<p class="fst-italic">' . $row["missao"] . '</p>';
                                echo '<h3>OBJECTIVO</h3>';
                                echo '<p class="fst-italic">' . $row["visao"] . '</p>';
                                echo '<h3>NATUREZA DO PROJECTO.</h3>';
                                echo '<p class="fst-italic">' . $row["visao"] . '</p>';
                            }
                        }
                    ?>
                </div>

          </div>
        </div>

      </div>
    </section>
  </main><!-- End #main -->

<?php
include './components/footer.php';
?>