<?php
$page_title = "Documentos - Strong Woman";
include 'config/conexao.php';

// Incrementar download se houver
if (isset($_GET['download']) && isset($_GET['id'])) {
    $doc_id = intval($_GET['id']);
    $stmt = $conn->prepare("UPDATE documentos SET downloads = downloads + 1 WHERE id = ?");
    $stmt->bind_param("i", $doc_id);
    $stmt->execute();
    $stmt->close();
}

// Buscar documentos publicados
$categoria_filtro = isset($_GET['categoria']) ? $_GET['categoria'] : '';

if ($categoria_filtro) {
    $stmt = $conn->prepare("SELECT * FROM documentos WHERE status = 'publicado' AND categoria = ? ORDER BY created_at DESC");
    $stmt->bind_param("s", $categoria_filtro);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    $result = $conn->query("SELECT * FROM documentos WHERE status = 'publicado' ORDER BY created_at DESC");
}

// Buscar categorias disponíveis
$categorias = $conn->query("SELECT DISTINCT categoria FROM documentos WHERE status = 'publicado' ORDER BY categoria");

include 'includes/navbar.php';
?>

<style>
    .documentos-page {
        padding: 120px 0 60px;
        background: linear-gradient(135deg, #f7f8fa 0%, #fff 100%);
        min-height: 100vh;
    }
    
    .page-header {
        text-align: center;
        margin-bottom: 50px;
    }
    
    .page-title {
        font-size: 48px;
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 15px;
    }
    
    .page-subtitle {
        font-size: 18px;
        color: #666;
    }
    
    .filter-bar {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 40px;
        flex-wrap: wrap;
    }
    
    .filter-btn {
        padding: 10px 25px;
        border: 2px solid #e0e0e0;
        background: white;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: 600;
        color: #666;
        text-decoration: none;
    }
    
    .filter-btn:hover,
    .filter-btn.active {
        border-color: var(--primary-color);
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(251, 10, 10, 0.3);
    }
    
    .documents-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
    }
    
    .document-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s;
        cursor: pointer;
    }
    
    .document-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(251, 10, 10, 0.15);
    }
    
    .document-icon {
        background: linear-gradient(135deg, var(--primary-color) 0%, #d00909 100%);
        padding: 40px;
        text-align: center;
        position: relative;
    }
    
    .document-icon i {
        font-size: 80px;
        color: white;
        opacity: 0.9;
    }
    
    .document-category {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255,255,255,0.25);
        backdrop-filter: blur(10px);
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 12px;
        color: white;
        font-weight: 600;
    }
    
    .document-body {
        padding: 25px;
    }
    
    .document-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 10px;
        min-height: 50px;
    }
    
    .document-description {
        color: #666;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 20px;
        min-height: 60px;
    }
    
    .document-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid #f0f0f0;
    }
    
    .document-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        color: #999;
    }
    
    .document-actions {
        display: flex;
        gap: 10px;
    }
    
    .btn-view, .btn-download {
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .btn-view {
        background: var(--primary-color);
        color: white;
    }
    
    .btn-view:hover {
        background: #d00909;
        color: white;
        transform: scale(1.05);
    }
    
    .btn-download {
        background: var(--secondary-color);
        color: white;
    }
    
    .btn-download:hover {
        background: #000;
        color: white;
        transform: scale(1.05);
    }
    
    @media (max-width: 768px) {
        .documentos-page {
            padding: 100px 0 40px;
        }
        
        .page-title {
            font-size: 32px;
        }
        
        .documents-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .filter-bar {
            flex-direction: column;
            align-items: stretch;
        }
        
        .filter-btn {
            text-align: center;
        }
    }
</style>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<section class="documentos-page">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Documentos</h1>
            <p class="page-subtitle">Acesse relatórios, políticas e projetos da Strong Woman</p>
        </div>

        <!-- Filtros -->
        <div class="filter-bar">
            <a href="documentos.php" class="filter-btn <?php echo !$categoria_filtro ? 'active' : ''; ?>">
                <i class="bi bi-grid-3x3-gap"></i> Todos
            </a>
            <?php while ($cat = $categorias->fetch_assoc()): ?>
                <a href="?categoria=<?php echo urlencode($cat['categoria']); ?>" 
                   class="filter-btn <?php echo $categoria_filtro === $cat['categoria'] ? 'active' : ''; ?>">
                    <?php echo htmlspecialchars($cat['categoria']); ?>
                </a>
            <?php endwhile; ?>
        </div>

        <!-- Grid de Documentos -->
        <div class="documents-grid">
            <?php while ($doc = $result->fetch_assoc()): ?>
                <div class="document-card">
                    <div class="document-icon">
                        <i class="bi bi-file-earmark-pdf-fill"></i>
                        <span class="document-category"><?php echo htmlspecialchars($doc['categoria']); ?></span>
                    </div>
                    <div class="document-body">
                        <h3 class="document-title"><?php echo htmlspecialchars($doc['titulo']); ?></h3>
                        <p class="document-description">
                            <?php 
                            echo $doc['descricao'] 
                                ? htmlspecialchars(substr($doc['descricao'], 0, 100)) . (strlen($doc['descricao']) > 100 ? '...' : '')
                                : 'Sem descrição disponível';
                            ?>
                        </p>
                        <div class="document-meta">
                            <span><i class="bi bi-download"></i> <?php echo $doc['downloads']; ?> downloads</span>
                            <span><i class="bi bi-calendar3"></i> <?php echo date('d/m/Y', strtotime($doc['created_at'])); ?></span>
                        </div>
                        <div class="document-actions mt-3">
                            <a href="<?php echo $doc['arquivo']; ?>" target="_blank" class="btn-view">
                                <i class="bi bi-eye"></i> Visualizar
                            </a>
                            <a href="<?php echo $doc['arquivo']; ?>?download=1&id=<?php echo $doc['id']; ?>" download class="btn-download">
                                <i class="bi bi-download"></i> Download
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <?php if ($result->num_rows === 0): ?>
            <div style="text-align: center; padding: 60px 20px;">
                <i class="bi bi-inbox" style="font-size: 80px; color: #ddd;"></i>
                <p style="font-size: 18px; color: #999; margin-top: 20px;">Nenhum documento encontrado nesta categoria.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
include 'includes/footer.php';
$conn->close();
?>
