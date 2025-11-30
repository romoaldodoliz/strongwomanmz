<?php
$page_title = "Strong Woman - Quem Somos";
include 'config/conexao.php';

// Buscar missão, visão e valores do banco de dados
$config_query = $conn->query("SELECT * FROM config LIMIT 1");
$config = $config_query->fetch_assoc();

include 'includes/navbar.php';
?>

<style>
    .team-member img {
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        transition: transform 0.3s;
    }

    .team-member img:hover {
        transform: scale(1.05);
    }

    .social-icons {
        margin-top: 20px;
    }

    .social-icons a {
        display: inline-block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        text-align: center;
        border-radius: 50%;
        background: var(--secondary-color);
        color: white;
        margin: 0 5px;
        transition: all 0.3s;
    }

    .social-icons a:hover {
        background: var(--primary-color);
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(251, 10, 10, 0.3);
    }

    .about-card {
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }

    .about-card h3 {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 20px;
    }
</style>

<section class="py-5">
    <div class="container">
        <div class="section-title">
            <h2>QUEM SOMOS</h2>
            <p>Strong Woman Moçambique</p>
        </div>
        
        <div class="row mb-5">
            <div class="col-lg-10 mx-auto">
                <div class="about-card">
                    <p class="lead">Fundada por Palmira Mucavele, Strong Woman é um Projecto no ramo de desenvolvimento pessoal e profissional que visa motivar, inspirar e prover ferramentas educativas para as mulheres num contexto social de estigmatização, descriminação de gênero, exclusão social, e violência doméstica.</p>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-lg-6 mb-4">
                <div class="about-card">
                    <h3><i class="bi bi-bullseye text-danger"></i> Nossa Missão</h3>
                    <p><?php echo $config ? nl2br(htmlspecialchars($config['missao'])) : 'Empoderar mulheres através de capacitação profissional, apoio psicológico e assistência jurídica, promovendo igualdade de gênero e autonomia feminina em Moçambique.'; ?></p>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="about-card">
                    <h3><i class="bi bi-eye text-danger"></i> Nossa Visão</h3>
                    <p><?php echo $config ? nl2br(htmlspecialchars($config['visao'])) : 'Ser referência em empoderamento feminino em Moçambique, criando uma sociedade mais justa e igualitária onde todas as mulheres possam realizar seu potencial.'; ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Fundadora -->
<section id="team" class="team py-5" style="background: #f9f9f9;">
    <div class="container">
        <div class="section-title">
            <h2>CONHEÇA</h2>
            <p>FUNDADORA DA STRONG WOMAN</p>
        </div>
        <div class="row g-5 align-items-center">
            <div class="col-lg-4 text-center">
                <div class="team-member">
                    <img class="img-fluid mb-3" src="assets/img/palm.jpg" style="height: auto; width:200px;" alt="Palmira Mucavele">
                    <h3 style="color: var(--secondary-color); font-weight: 700;">PALMIRA MUCAVELE</h3>
                    <p style="color: var(--primary-color); font-weight: 600;">Fundadora</p>
                    <div class="social-icons">
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <h2 class="mb-4" style="color: var(--secondary-color); font-weight: 700;">Fundadora da Strong Woman MZ | ICC Certified Coach | Mentor | HR Specialist</h2>
                <p class="mb-3"><b>Palmira Mucavele</b> é uma Profissional de Recursos Humanos com 18 anos de experiência, ocupando cargos de liderança há 10 anos em empresas multinacionais e Organizações Não Governamentais.</p>
                <p class="mb-3">É formada em Gestão de Recursos Humanos e Certificada como Coach pela ICC (International Coaching Community), actuando como Coach de Vida.</p>
                <p class="mb-4"><b>Palmira</b> tem como lema <span style="color: var(--primary-color); font-weight: 600;">"Pessoas Precisam de Pessoas"</span>.</p>
                <a class="btn btn-primary py-3 px-5" href="contacto.php"><i class="bi bi-envelope me-2"></i>Entre em Contacto</a>
            </div>
        </div>
    </div>
</section>

<!-- Valores -->
<section class="py-5">
    <div class="container">
        <div class="section-title">
            <h2>NOSSOS VALORES</h2>
            <p>O que nos guia</p>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="icon-box text-center">
                    <i class="bi bi-heart" style="font-size: 48px; color: var(--primary-color);"></i>
                    <h4 class="mt-3">Empatia</h4>
                    <p>Compreendemos e acolhemos cada história</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="icon-box text-center">
                    <i class="bi bi-award" style="font-size: 48px; color: var(--primary-color);"></i>
                    <h4 class="mt-3">Excelência</h4>
                    <p>Comprometimento com qualidade em tudo</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="icon-box text-center">
                    <i class="bi bi-people" style="font-size: 48px; color: var(--primary-color);"></i>
                    <h4 class="mt-3">Comunidade</h4>
                    <p>Juntas somos mais fortes</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="icon-box text-center">
                    <i class="bi bi-shield-check" style="font-size: 48px; color: var(--primary-color);"></i>
                    <h4 class="mt-3">Integridade</h4>
                    <p>Transparência e ética sempre</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
include 'includes/footer.php';
$conn->close();
?>
