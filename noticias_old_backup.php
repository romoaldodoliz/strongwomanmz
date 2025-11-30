<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notícias - Strong Woman</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding-top: 80px;
        }
        
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .page-header {
            background: linear-gradient(135deg, #f48924 0%, #e67610 100%);
            color: white;
            padding: 80px 0 60px;
            text-align: center;
        }
        
        .page-header h1 {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        
        .news-card {
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s;
            margin-bottom: 30px;
            overflow: hidden;
            border-radius: 15px;
            height: 100%;
        }
        
        .news-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(244, 137, 36, 0.2);
        }
        
        .news-card img {
            height: 250px;
            object-fit: cover;
            width: 100%;
        }
        
        .news-card .card-body {
            padding: 25px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #f48924 0%, #e67610 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
        }
        
        .btn-primary:hover {
            transform: scale(1.05);
        }
        
        .footer {
            background: #333;
            color: white;
            padding: 40px 0;
            margin-top: 60px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <strong style="color: #f48924;">Strong Woman</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="quem-somos.php">Quem Somos</a></li>
                    <li class="nav-item"><a class="nav-link active" href="noticias.php">Notícias</a></li>
                    <li class="nav-item"><a class="nav-link" href="eventos.php">Eventos</a></li>
                    <li class="nav-item"><a class="nav-link" href="movimentos.php">Nossos Movimentos</a></li>
                    <li class="nav-item"><a class="nav-link" href="doacoes.php">Doações</a></li>
                    <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1>Notícias</h1>
            <p class="lead">Fique por dentro das últimas novidades da Strong Woman</p>
        </div>
    </div>

    <!-- News Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <?php
                include('config/conexao.php');
                
                // Verificar se é detalhes de uma notícia específica
                if (isset($_GET['id'])) {
                    $id = intval($_GET['id']);
                    $sql = "SELECT * FROM noticias WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0) {
                        $noticia = $result->fetch_assoc();
                        $imagemBLOB = base64_encode($noticia["foto"]);
                        
                        echo '<div class="col-12">';
                        echo '<article>';
                        echo '<img src="data:image/jpeg;base64,' . $imagemBLOB . '" class="img-fluid mb-4" style="width: 100%; max-height: 500px; object-fit: cover; border-radius: 15px;" alt="' . htmlspecialchars($noticia["titulo"]) . '">';
                        echo '<h2 class="mb-3">' . htmlspecialchars($noticia["titulo"]) . '</h2>';
                        echo '<div class="mb-4" style="white-space: pre-line; line-height: 1.8;">' . htmlspecialchars($noticia["descricao"]) . '</div>';
                        echo '<a href="noticias.php" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Voltar para Notícias</a>';
                        echo '</article>';
                        echo '</div>';
                    } else {
                        echo '<div class="col-12"><div class="alert alert-warning">Notícia não encontrada.</div></div>';
                    }
                    $stmt->close();
                } else {
                    // Listar todas as notícias
                    $sql = "SELECT * FROM noticias ORDER BY id DESC";
                    $result = @$conn->query($sql);
                    
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $imagemBLOB = base64_encode($row["foto"]);
                            
                            echo '<div class="col-lg-4 col-md-6">';
                            echo '<div class="news-card card">';
                            echo '<img src="data:image/jpeg;base64,' . $imagemBLOB . '" class="card-img-top" alt="' . htmlspecialchars($row["titulo"]) . '">';
                            echo '<div class="card-body">';
                            echo '<h4 class="card-title">' . htmlspecialchars($row["titulo"]) . '</h4>';
                            echo '<p class="card-text">' . htmlspecialchars(substr($row["descricao"], 0, 150)) . '...</p>';
                            echo '<a href="noticias.php?id=' . $row["id"] . '" class="btn btn-primary">Ler Mais <i class="bi bi-arrow-right"></i></a>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="col-12">';
                        echo '<div class="alert alert-info text-center">';
                        echo '<i class="bi bi-info-circle me-2"></i>';
                        echo 'Nenhuma notícia disponível no momento.';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                
                $conn->close();
                ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p>&copy; 2024 Strong Woman. Todos os direitos reservados.</p>
            <p>
                <a href="admin/" class="text-white me-3"><i class="bi bi-lock"></i> Admin</a>
                <a href="https://facebook.com" class="text-white me-3"><i class="bi bi-facebook"></i></a>
                <a href="https://instagram.com" class="text-white"><i class="bi bi-instagram"></i></a>
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
