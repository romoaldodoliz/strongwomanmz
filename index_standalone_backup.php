<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strong Woman - Estamos Focados no Futuro das Mulheres</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    
    <style>
        :root {
            --primary-color: #fb0a0a;
            --secondary-color: #151515;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 70px;
        }

        /* Navbar */
        .navbar {
            background: white;
            box-shadow: 0 3px 15px rgba(0,0,0,0.1);
            border-bottom: 3px solid var(--primary-color);
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color) !important;
        }

        .nav-link {
            color: var(--secondary-color) !important;
            font-weight: 500;
            transition: color 0.3s;
            margin: 0 10px;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        /* Swiper Hero Slider */
        .swiper-container {
            width: 100%;
            height: 100vh;
        }

        .swiper-slide {
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .swiper-slide::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(21, 21, 21, 0.4);
        }

        .swiper-slide h2 {
            position: relative;
            z-index: 1;
            color: white;
            font-size: 48px;
            font-weight: 800;
            text-shadow: 3px 3px 8px rgba(0,0,0,0.7);
            padding: 0 20px;
            text-align: center;
        }

        .swiper-button-prev,
        .swiper-button-next {
            color: var(--primary-color) !important;
            background: rgba(255,255,255,0.9);
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .swiper-button-prev::after,
        .swiper-button-next::after {
            font-size: 20px;
        }

        .swiper-pagination-bullet-active {
            background: var(--primary-color) !important;
        }

        /* Section Titles */
        .section-title {
            text-align: center;
            margin: 70px 0 50px;
        }

        .section-title h2 {
            font-size: 42px;
            font-weight: 800;
            color: var(--secondary-color);
            position: relative;
            display: inline-block;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), #c70808);
            border-radius: 2px;
        }

        .section-title p {
            font-size: 20px;
            color: #666;
            margin-top: 25px;
            font-weight: 300;
        }

        /* Cards */
        .card {
            border: none;
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 15px;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-15px);
            box-shadow: 0 15px 40px rgba(251, 10, 10, 0.2);
        }

        .card img {
            transition: transform 0.4s;
        }

        .card:hover img {
            transform: scale(1.05);
        }

        /* Icon Boxes */
        .icon-box {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }

        .icon-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(251, 10, 10, 0.2);
        }

        .icon-box i {
            font-size: 48px;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .icon-box h4 {
            font-size: 20px;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 15px;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, #c70808 100%);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 30px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(251, 10, 10, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(251, 10, 10, 0.4);
            background: linear-gradient(135deg, #c70808 0%, var(--primary-color) 100%);
        }

        /* News Carousel */
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: var(--primary-color);
            border-radius: 50%;
            padding: 20px;
        }

        /* CTA Section */
        .cta {
            background: linear-gradient(135deg, var(--primary-color) 0%, #c70808 50%, var(--secondary-color) 100%);
            padding: 80px 0;
            color: white;
        }

        .cta h3 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .cta-btn {
            background: white;
            color: var(--primary-color);
            padding: 15px 40px;
            border-radius: 30px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: all 0.3s;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }

        .cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            color: var(--primary-color);
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #000 100%);
            color: white;
            padding: 50px 0 30px;
            margin-top: 80px;
            border-top: 4px solid var(--primary-color);
        }

        .footer a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer a:hover {
            color: var(--primary-color) !important;
        }

        .services {
            background: #f9f9f9;
            padding: 80px 0;
        }

        .features {
            padding: 80px 0;
        }

        .social-icons a {
            color: var(--secondary-color);
            font-size: 20px;
            margin: 0 10px;
            transition: color 0.3s;
            text-decoration: none;
        }

        .social-icons a:hover {
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .swiper-slide h2 {
                font-size: 32px;
            }
            .section-title h2 {
                font-size: 32px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <strong>Strong Woman</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="quem-somos.php">Quem Somos</a></li>
                    <li class="nav-item"><a class="nav-link" href="noticias.php">Notícias</a></li>
                    <li class="nav-item"><a class="nav-link" href="eventos.php">Eventos</a></li>
                    <li class="nav-item"><a class="nav-link" href="movimentos.php">Nossos Movimentos</a></li>
                    <li class="nav-item"><a class="nav-link" href="doacoes.php">Doações</a></li>
                    <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Slider com Swiper -->
    <div class="swiper-container main-slider">
        <div class="swiper-wrapper">
            <?php
            include('config/conexao.php');

            $sql = "SELECT * FROM homepagehero ORDER BY id ASC LIMIT 3";
            $resultado = @$conn->query($sql);

            if (!$resultado) {
                $resultado = new stdClass();
                $resultado->num_rows = 0;
            }

            if ($resultado->num_rows > 0) {
                $i = 0;
                while ($row = $resultado->fetch_assoc()) {
                    $imagemBlob = $row['foto'];
                    $imagemBase64 = base64_encode($imagemBlob);

                    echo '<div class="swiper-slide" style="background:url(data:image/jpeg;base64,' . $imagemBase64 . ') center center; background-size: cover;">';
                    if ($i > 0 && !empty($row['descricao'])) {
                        echo '<h2>' . htmlspecialchars($row['descricao']) . '</h2>';
                    }
                    echo '</div>';

                    $i++;
                }
            } else {
                echo '<div class="swiper-slide" style="background:url(\'https://cdn.pixabay.com/photo/2017/08/07/14/02/people-2604149_960_720.jpg\') center center; background-size: cover;">';
                echo '<h2>Strong Woman - Empoderamento Feminino</h2>';
                echo '</div>';
            }
            ?>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>

    <!-- Últimas Notícias com Carrossel -->
    <section id="noticias" class="py-5">
        <div class="container">
            <div class="section-title">
                <h2>ÚLTIMAS</h2>
                <p>Notícias</p>
            </div>

            <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $sql = "SELECT * FROM noticias ORDER BY id DESC";
                    $result = @$conn->query($sql);

                    if (!$result) {
                        $result = new stdClass();
                        $result->num_rows = 0;
                    }

                    if ($result->num_rows > 0) {
                        $chunks = array_chunk($result->fetch_all(MYSQLI_ASSOC), 3);

                        $activeClass = 'active';
                        foreach ($chunks as $chunk) {
                            echo '<div class="carousel-item ' . $activeClass . '">';
                            echo '<div class="row justify-content-center">';

                            foreach ($chunk as $row) {
                                echo '<div class="col-lg-4 col-md-6 mb-4">';
                                echo '<div class="card h-100">';
                                echo '<a href="noticias.php?id=' . $row["id"] . '" style="text-decoration:none; color:inherit;">';
                                $imagemBLOB = base64_encode($row["foto"]);
                                echo '<img src="data:image/jpeg;base64,' . $imagemBLOB . '" alt="Notícia" class="card-img-top" style="object-fit: cover; height: 250px;">';
                                echo '<div class="card-body">';
                                echo '<h4 class="card-title">' . htmlspecialchars($row["titulo"]) . '</h4>';
                                echo '<p class="card-text">' . htmlspecialchars(substr($row["descricao"], 0, 100)) . '...</p>';
                                echo '</div>';
                                echo '</a>';
                                echo '</div>';
                                echo '</div>';
                            }

                            echo '</div>';
                            echo '</div>';
                            $activeClass = '';
                        }
                    } else {
                        echo '<p class="text-center">Nenhuma notícia encontrada.</p>';
                    }
                    ?>
                </div>

                <?php if ($result && $result->num_rows > 3): ?>
                <a class="carousel-control-prev" href="#newsCarousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </a>
                <a class="carousel-control-next" href="#newsCarousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Próximo</span>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Eventos -->
    <section id="eventos" class="py-5 bg-light">
        <div class="container">
            <div class="section-title">
                <h2>Eventos</h2>
                <p>NOSSOS EVENTOS</p>
            </div>

            <div class="row">
                <?php
                $sql = "SELECT * FROM eventos ORDER BY id DESC LIMIT 6";
                $result = @$conn->query($sql);

                if (!$result) {
                    $result = new stdClass();
                    $result->num_rows = 0;
                }

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-lg-4 col-md-6 mb-4">';
                        echo '<div class="card">';
                        $imagemBLOB = base64_encode($row["foto"]);
                        echo '<img src="data:image/jpeg;base64,' . $imagemBLOB . '" alt="Evento" class="card-img-top" style="object-fit: cover; height: 250px;">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . htmlspecialchars($row["titulo"]) . '</h5>';
                        echo '<p class="card-text">' . htmlspecialchars(substr($row["descricao"], 0, 100)) . '...</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p class="text-center col-12">Nenhum evento disponível.</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Iniciativas -->
    <section id="features" class="features">
        <div class="container">
            <div class="section-title">
                <h2>Iniciativas</h2>
                <p>Fortalecendo Mulheres</p>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4">
                    <img src="assets/img/s2.jpg" alt="Iniciativas" class="img-fluid rounded shadow" style="width:100%; height:400px; object-fit:cover;">
                </div>
                <div class="col-lg-6">
                    <div class="icon-box mb-4">
                        <i class="bi bi-book"></i>
                        <h4>Capacitação Profissional</h4>
                        <p>Oferecemos cursos e treinamentos para mulheres desenvolverem habilidades e conquistarem independência financeira.</p>
                    </div>
                    <div class="icon-box mb-4">
                        <i class="bi bi-people"></i>
                        <h4>Apoio Psicológico</h4>
                        <p>Disponibilizamos atendimento psicológico individual e em grupo para mulheres lidarem com traumas e fortalecerem sua saúde mental.</p>
                    </div>
                    <div class="icon-box">
                        <i class="bi bi-briefcase"></i>
                        <h4>Assistência Jurídica</h4>
                        <p>Fornecemos orientação legal e acompanhamento processual para mulheres em situações de violência doméstica e discriminação de gênero.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Projetos -->
    <section id="services" class="services">
        <div class="container">
            <div class="section-title">
                <h2>PROJECTOS</h2>
                <p>NOSSOS PROJECTOS</p>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="quem-somos.php" style="text-decoration: none; color: inherit;">
                        <div class="icon-box text-center h-100">
                            <div class="icon"><i class="bi bi-chat-dots"></i></div>
                            <h4>Palestras e Workshops</h4>
                            <p>A Strong Woman irá exercer suas atividades de inspiração, mentoria, e motivação através do conhecimento científico, empírico e experiência pessoal.</p>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="quem-somos.php" style="text-decoration: none; color: inherit;">
                        <div class="icon-box text-center h-100">
                            <div class="icon"><i class="bi bi-calendar-event"></i></div>
                            <h4>Conferências e Mega Eventos</h4>
                            <p>Os eventos serão conferências designadas Strong Woman Conference, que prevêem sua realização uma vez ao ano, com participação de mulheres nacionais e internacionais de impacto.</p>
                        </div>
                    </a>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="quem-somos.php" style="text-decoration: none; color: inherit;">
                        <div class="icon-box text-center h-100">
                            <div class="icon"><i class="bi bi-diagram-3"></i></div>
                            <h4>Movimentos de Engajamento Social</h4>
                            <p>Os movimentos serão designados Strong Woman Movement, promovendo intercâmbio entre mulheres com várias atividades nas áreas de cultura, saúde, empreendedorismo e mais.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Team - Fundadora -->
    <section id="team" class="py-5">
        <div class="container">
            <div class="section-title">
                <h2>CONHEÇA</h2>
                <p>FUNDADORA DA STRONG WOMAN</p>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-4 text-center mb-4">
                    <div class="team-member">
                        <img class="img-fluid mb-3 rounded shadow" src="assets/img/a4.jpg" style="height: auto; width:200px;" alt="Palmira Mucavele">
                        <h3>PALMIRA MUCAVELE</h3>
                        <p>Fundadora</p>
                        <div class="social-icons">
                            <a href="#"><i class="bi bi-twitter"></i></a>
                            <a href="#"><i class="bi bi-facebook"></i></a>
                            <a href="#"><i class="bi bi-linkedin"></i></a>
                            <a href="#"><i class="bi bi-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <h2 class="mb-4">Fundadora da Strong Woman MZ| ICC Certified Coach| Mentor| HR Specialist</h2>
                    <p class="mb-4"><b>Palmira Mucavele</b> é uma Profissional de Recursos Humanos com 18 anos de experiência, ocupando cargos de liderança há 10 anos em empresas multinacionais e Organizações Não Governamentais.</p>
                    <p class="mb-4">É formada em Gestão de Recursos Humanos e Certificada como Coach pela ICC (International Coaching Community), actuando como Coach de Vida.</p>
                    <p><b>Palmira</b> tem como lema "Pessoas Precisam de Pessoas".</p>
                    <a class="btn btn-primary py-3 px-5 mt-3" href="quem-somos.php">Ler Mais...</a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section id="cta" class="cta">
        <div class="container">
            <div class="text-center">
                <h3>SE PRETENDE ABRAÇAR A CAUSA SENDO MAIS UM DOADOR</h3>
                <p>"Com sua ajuda, podemos iluminar caminhos e transformar histórias. Junte-se a nós para fazer a diferença real na vida de quem mais precisa."</p>
                <a class="cta-btn" href="mailto:palmira.mucavele@strongwoman-mz.org">Contacte-nos p/ mais informações</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h4>Strong Woman</h4>
                    <p><strong>Local:</strong> Maputo</p>
                    <p><strong>Telefone:</strong> <a href="tel:+25884768523">(+258) 84768523</a></p>
                    <p><strong>Contacto:</strong> <a href="tel:+258828372810">(+258) 828372810</a></p>
                    <p><strong>E-mail:</strong> palmira.mucavele@strongwoman-mz.org</p>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <h4>Links Rápidos</h4>
                    <p><a href="index.php">Início</a></p>
                    <p><a href="quem-somos.php">Quem Somos</a></p>
                    <p><a href="eventos.php">Eventos</a></p>
                    <p><a href="doacoes.php">Doações</a></p>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <h4>Redes Sociais</h4>
                    <div class="d-flex gap-3">
                        <a href="#" class="fs-4"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="fs-4"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="fs-4"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="fs-4"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.2);">
            <div class="text-center">
                <p>&copy; 2023 - <?php echo date("Y"); ?>. Todos Direitos Reservados <strong>STRONG WOMAN</strong>.</p>
                <p><a href="admin/">Admin</a></p>
            </div>
        </div>
    </footer>

    <?php $conn->close(); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script>
        // Inicializar Swiper
        var swiper = new Swiper('.swiper-container', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>
</body>
</html>
