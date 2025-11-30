#!/bin/bash

# Criar noticias.php
cat > /Applications/MAMP/htdocs/strongwoman/noticias_new.php << 'EOFNOTICIAS'
<?php
$page_title = "Strong Woman - Notícias";
include 'includes/navbar.php';
?>

<section class="py-5" style="min-height: 70vh;">
    <div class="container">
        <div class="section-title">
            <h2>NOTÍCIAS</h2>
            <p>Últimas Notícias Strong Woman</p>
        </div>
        <div class="row">
            <?php
            include('config/conexao.php');
            $sql = "SELECT * FROM noticias ORDER BY id DESC";
            $result = @$conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $imagemBLOB = base64_encode($row["foto"]);
                    echo '<div class="col-lg-4 col-md-6 mb-4">';
                    echo '<div class="card h-100">';
                    echo '<img src="data:image/jpeg;base64,' . $imagemBLOB . '" class="card-img-top" style="height:250px; object-fit:cover;">';
                    echo '<div class="card-body">';
                    echo '<h5>' . htmlspecialchars($row["titulo"]) . '</h5>';
                    echo '<p>' . htmlspecialchars(substr($row["descricao"], 0, 150)) . '...</p>';
                    echo '</div></div></div>';
                }
            } else {
                echo '<div class="col-12 text-center py-5"><h4>Nenhuma notícia disponível</h4></div>';
            }
            $conn->close();
            ?>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
EOFNOTICIAS

# Criar movimentos.php
cat > /Applications/MAMP/htdocs/strongwoman/movimentos_new.php << 'EOFMOV'
<?php
$page_title = "Strong Woman - Nossos Movimentos";
include 'includes/navbar.php';
?>

<section class="py-5" style="min-height: 70vh;">
    <div class="container">
        <div class="section-title">
            <h2>NOSSOS MOVIMENTOS</h2>
            <p>Strong Woman Movement</p>
        </div>
        <div class="row">
            <?php
            include('config/conexao.php');
            $sql = "SELECT * FROM movimentos ORDER BY id DESC";
            $result = @$conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-lg-4 col-md-6 mb-4">';
                    echo '<div class="card h-100">';
                    if (!empty($row["imagem_principal"])) {
                        echo '<img src="' . htmlspecialchars($row["imagem_principal"]) . '" class="card-img-top" style="height:250px; object-fit:cover;">';
                    }
                    echo '<div class="card-body">';
                    echo '<h5>' . htmlspecialchars($row["titulo"]) . '</h5>';
                    echo '<p class="text-muted">' . htmlspecialchars($row["tema"]) . '</p>';
                    echo '<p>' . htmlspecialchars(substr($row["descricao"], 0, 100)) . '...</p>';
                    echo '<a href="movimento-detalhes.php?id=' . $row["id"] . '" class="btn btn-primary">Ver Detalhes</a>';
                    echo '</div></div></div>';
                }
            } else {
                echo '<div class="col-12 text-center py-5"><h4>Nenhum movimento disponível</h4></div>';
            }
            $conn->close();
            ?>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
EOFMOV

# Criar quem-somos.php
cat > /Applications/MAMP/htdocs/strongwoman/quem-somos_new.php << 'EOFQUEM'
<?php
$page_title = "Strong Woman - Quem Somos";
include 'includes/navbar.php';
?>

<section class="py-5" style="min-height: 70vh;">
    <div class="container">
        <div class="section-title">
            <h2>QUEM SOMOS</h2>
            <p>Strong Woman Moçambique</p>
        </div>
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <p class="lead">Fundada por Palmira Mucavele, Strong Woman é um Projecto no ramo de desenvolvimento pessoal e profissional que visa motivar, inspirar e prover ferramentas educativas para as mulheres num contexto social de estigmatização, descriminação de gênero, exclusão social, e violência doméstica.</p>
                <h3 class="mt-5">Nossa Missão</h3>
                <p>Empoderar mulheres através de capacitação profissional, apoio psicológico e assistência jurídica.</p>
                <h3 class="mt-4">Nossa Visão</h3>
                <p>Ser referência em empoderamento feminino em Moçambique.</p>
            </div>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
EOFQUEM

# Criar contacto.php
cat > /Applications/MAMP/htdocs/strongwoman/contacto_new.php << 'EOFCONTACTO'
<?php
$page_title = "Strong Woman - Contacto";
include 'includes/navbar.php';
?>

<section class="py-5" style="min-height: 70vh;">
    <div class="container">
        <div class="section-title">
            <h2>CONTACTE-NOS</h2>
            <p>Entre em contacto connosco</p>
        </div>
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="icon-box">
                    <i class="bi bi-geo-alt"></i>
                    <h4>Localização</h4>
                    <p>Maputo, Moçambique</p>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="icon-box">
                    <i class="bi bi-envelope"></i>
                    <h4>Email</h4>
                    <p>palmira.mucavele@strongwoman-mz.org</p>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="icon-box">
                    <i class="bi bi-phone"></i>
                    <h4>Telefone</h4>
                    <p>(+258) 84768523</p>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="icon-box">
                    <i class="bi bi-whatsapp"></i>
                    <h4>WhatsApp</h4>
                    <p>(+258) 828372810</p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
EOFCONTACTO

# Criar páginas vazias para as que ainda não existem
for page in massmedia capacitacoes galeria; do
cat > /Applications/MAMP/htdocs/strongwoman/${page}_new.php << EOFPAGE
<?php
\$page_title = "Strong Woman - " . ucfirst("$page");
include 'includes/navbar.php';
?>

<section class="py-5" style="min-height: 70vh;">
    <div class="container">
        <div class="section-title">
            <h2>$(echo $page | tr '[:lower:]' '[:upper:]')</h2>
            <p>Em breve</p>
        </div>
        <div class="row">
            <div class="col-12 text-center py-5">
                <i class="bi bi-hourglass-split" style="font-size: 64px; color: var(--primary-color);"></i>
                <h4 class="mt-3">Página em construção</h4>
                <p>Estamos trabalhando para trazer novidades!</p>
                <a href="index.php" class="btn btn-primary mt-3">Voltar ao Início</a>
            </div>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
EOFPAGE
done

echo "Todas as páginas criadas com sucesso!"
