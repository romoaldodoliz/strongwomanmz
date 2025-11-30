<?php
include './components/header.php';
include('config/conexao.php');

$sql = "SELECT * FROM galeria";
$result = $conn->query($sql);
?>

<main id="main">
    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
        <div class="container" data-aos="zoom-in">
            <div class="text-center">
                <h3>Galeria</h3>
                <p>Implementar programas sustentáveis ​​que melhorem o acesso mundial a investimentos, oportunidades.
                </p>
            </div>
        </div>
    </section><!-- End Cta Section -->
    <section id="portfolio" class="portfolio">
        <div class="container" data-aos="fade-up">

            <!-- ======= Testimonials Section ======= -->
            <!--<section id="services" class="services">-->
            <div class="row">
                <?php
                echo '<div class="section-title" style="margin-top:5rem;">';
                echo ' <h2>Videos da galeria</h2>';
                echo '</div>';
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if ($row['tipo'] === 'video') {
                            echo '<div class="col-lg-6" data-aos="zoom-in" data-aos-delay="100">';
                            echo '<div>';
                            echo '<div>';
                            echo '<iframe width="100%" height="530" src="' . $row['link'] . '" title="' . $row['titulo'] . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
                            echo '<h6 style="margin-top:1px; margin-bottom:1rem; font-weight:600">' . $row["titulo"] . '</h6>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }

                    // Reset do ponteiro do resultado para o início para exibir as imagens
                    $result->data_seek(0);
                    echo '<div class="section-title" style="padding-bottom: 10px !important; margin-top:1rem;">';
                    echo ' <h2>Imagens da galeria</h2>';
                    echo '</div>';
                    while ($row = $result->fetch_assoc()) {
                        if ($row['tipo'] === 'imagem') {
                            echo '<div class="col-lg-4 col-md-6 portfolio-item filter-dec">';
                            echo '<div class="portfolio-wrap">';
                            $imagemBLOB = base64_encode($row["foto"]);
                            echo '<img src="data:image/jpeg;base64,' . $imagemBLOB . '" alt="Imagem da noticia" class="img-fluid w-100" style="object-fit: cover; height: 250px;">';
                            echo '<div class="portfolio-info">';
                            echo '<h4>' . $row["titulo"] . '</h4>';
                            echo '<p>'. $row["created_date"] .'</p>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                } else {
                    echo 'Nenhuma imagem ou vídeo encontrados.';
                }

                $conn->close();
                ?>

            </div>
            <!--</section>-->






        </div>
        <!--<div class="swiper-pagination"></div>-->
    </section><!-- End Testimonials Section -->

    <section class="galeria">
        <style>
            .galeria {
                max-width: 100%;
                margin: auto;
                overflow: hidden;
                background-size: cover;

            }

            .foto img {
                width: 100%;
                height: auto;
                background-size: cover;
                padding: 40px;
                border-radius: 60px;
            }

            .slick-prev,
            .slick-next {
                font-size: 24px;
                color: #fff;
            }

            .slick-dots {
                bottom: 10px;
            }
        </style>
        <!--
        <div class="foto"><img src="assets/img/1.jpg" alt="Imagem 1"></div>
        <div class="foto"><img src="assets/img/2.jpg" alt="Imagem 2"></div>
        <div class="foto"><img src="assets/img/3.jpg" alt="Imagem 3"></div>
        <div class="foto"><img src="assets/img/4.jpg" alt="Imagem 4"></div>
        -->
    </section>

    <script>
        $(document).ready(function() {
            if ($(window).width() > 768) {
                $('.galeria').slick({
                    infinite: true,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    responsive: [{
                            breakpoint: 992,
                            settings: {
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2
                            }
                        }
                    ]
                });
            }
        });
    </script>


</main><!-- End #main -->

<?php
include './components/footer.php';
?>