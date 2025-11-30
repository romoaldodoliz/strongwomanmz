<?php
include './components/header.php';
include('config/conexao.php');
?>

<style>
    .movimentos-page {
        padding: 100px 0 50px;
        background: #f7f8fa;
    }
    
    .movimento-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s;
        margin-bottom: 30px;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .movimento-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(244, 137, 36, 0.2);
    }
    
    .movimento-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        position: relative;
    }
    
    .movimento-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(244, 137, 36, 0.95);
        color: white;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }
    
    .movimento-content {
        padding: 25px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .movimento-title {
        font-size: 22px;
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
        line-height: 1.3;
    }
    
    .movimento-meta {
        color: #666;
        font-size: 14px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }
    
    .movimento-meta i {
        color: #f48924;
    }
    
    .movimento-description {
        color: #666;
        font-size: 15px;
        line-height: 1.6;
        margin-bottom: 20px;
        flex-grow: 1;
    }
    
    .btn-ver-mais {
        background: linear-gradient(135deg, #f48924 0%, #e67610 100%);
        color: white;
        padding: 12px 30px;
        border-radius: 25px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s;
        border: none;
        font-weight: 600;
    }
    
    .btn-ver-mais:hover {
        transform: scale(1.05);
        color: white;
        box-shadow: 0 5px 15px rgba(244, 137, 36, 0.3);
    }
    
    .section-title-movimentos {
        text-align: center;
        margin-bottom: 50px;
    }
    
    .section-title-movimentos h2 {
        font-size: 42px;
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
    }
    
    .section-title-movimentos p {
        font-size: 18px;
        color: #666;
    }
    
    @media (max-width: 768px) {
        .movimentos-page {
            padding: 80px 0 30px;
        }
        
        .section-title-movimentos h2 {
            font-size: 32px;
        }
        
        .movimento-image {
            height: 200px;
        }
    }
</style>

<section class="movimentos-page">
    <div class="container">
        <div class="section-title-movimentos" data-aos="fade-up">
            <h2>Nossos Movimentos</h2>
            <p>Acompanhe as ações e eventos da Strong Woman</p>
        </div>

        <div class="row">
            <?php
            $sql = "SELECT * FROM movimentos WHERE status = 'publicado' ORDER BY data_evento DESC, created_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">';
                    echo '<div class="movimento-card">';
                    
                    // Imagem
                    echo '<div style="position: relative;">';
                    if ($row['imagem_principal']) {
                        echo '<img src="' . htmlspecialchars($row['imagem_principal']) . '" alt="' . htmlspecialchars($row['titulo']) . '" class="movimento-image">';
                    } else {
                        echo '<div class="movimento-image" style="background: linear-gradient(135deg, #f48924 0%, #e67610 100%); display: flex; align-items: center; justify-content: center;">';
                        echo '<i class="bi bi-image" style="font-size: 48px; color: white;"></i>';
                        echo '</div>';
                    }
                    
                    // Badge de tema
                    if ($row['tema']) {
                        echo '<div class="movimento-badge">' . htmlspecialchars($row['tema']) . '</div>';
                    }
                    echo '</div>';
                    
                    // Conteúdo
                    echo '<div class="movimento-content">';
                    echo '<h3 class="movimento-title">' . htmlspecialchars($row['titulo']) . '</h3>';
                    
                    // Meta informações
                    echo '<div class="movimento-meta">';
                    if ($row['data_evento']) {
                        echo '<span><i class="bi bi-calendar3"></i> ' . date('d/m/Y', strtotime($row['data_evento'])) . '</span>';
                    }
                    if ($row['local']) {
                        echo '<span><i class="bi bi-geo-alt"></i> ' . htmlspecialchars($row['local']) . '</span>';
                    }
                    echo '</div>';
                    
                    // Descrição (resumo)
                    $descricao_resumo = mb_substr(strip_tags($row['descricao']), 0, 150);
                    if (strlen($row['descricao']) > 150) {
                        $descricao_resumo .= '...';
                    }
                    echo '<p class="movimento-description">' . htmlspecialchars($descricao_resumo) . '</p>';
                    
                    // Botão
                    echo '<a href="movimento-detalhes.php?id=' . $row['id'] . '" class="btn-ver-mais">';
                    echo '<i class="bi bi-arrow-right-circle me-1"></i> Ver Detalhes';
                    echo '</a>';
                    
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="col-12">';
                echo '<div class="alert alert-info text-center">';
                echo '<i class="bi bi-info-circle me-2"></i>';
                echo 'Nenhum movimento publicado ainda. Volte em breve!';
                echo '</div>';
                echo '</div>';
            }
            
            $conn->close();
            ?>
        </div>
    </div>
</section>

<!-- Vendor JS Files -->
<script src="assets/assets/vendor/aos/aos.js"></script>
<script src="assets/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/assets/vendor/swiper/swiper-bundle.min.js"></script>

<!-- Template Main JS File -->
<script src="assets/assets/js/main.js"></script>

<!-- Initialize AOS -->
<script>
    AOS.init({
        duration: 1000,
        once: true
    });
</script>

</body>
</html>
