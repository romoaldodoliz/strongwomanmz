<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos - Strong Woman</title>
    
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
        
        .event-card {
            border: none;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s;
            margin-bottom: 30px;
            overflow: hidden;
            border-radius: 15px;
        }
        
        .event-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(244, 137, 36, 0.2);
        }
        
        .event-card img {
            height: 250px;
            object-fit: cover;
            width: 100%;
        }
        
        .event-card .card-body {
            padding: 25px;
        }
        
        .event-date {
            background: #f48924;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            display: inline-block;
            margin-bottom: 15px;
            font-weight: 600;
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
                    <li class="nav-item"><a class="nav-link active" href="eventos.php">Eventos</a></li>
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
            <h1>Nossos Eventos</h1>
            <p class="lead">Acompanhe as atividades e iniciativas da Strong Woman</p>
        </div>
    </div>

    <!-- Events Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <?php
                include('config/conexao.php');
                $sql = "SELECT * FROM eventos ORDER BY data DESC";
                $result = @$conn->query($sql);
                
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $imagemBLOB = base64_encode($row["foto"]);
                        
                        echo '<div class="col-lg-4 col-md-6">';
                        echo '<div class="event-card card">';
                        echo '<img src="data:image/jpeg;base64,' . $imagemBLOB . '" class="card-img-top" alt="' . htmlspecialchars($row["titulo"]) . '">';
                        echo '<div class="card-body">';
                        
                        if (!empty($row["data"])) {
                            $data_formatada = date('d/m/Y', strtotime($row["data"]));
                            echo '<span class="event-date"><i class="bi bi-calendar3"></i> ' . $data_formatada . '</span>';
                        }
                        
                        echo '<h4 class="card-title mt-2">' . htmlspecialchars($row["titulo"]) . '</h4>';
                        
                        if (!empty($row["descricao"])) {
                            echo '<p class="card-text">' . htmlspecialchars(substr($row["descricao"], 0, 150)) . '...</p>';
                        }
                        
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="col-12">';
                    echo '<div class="alert alert-info text-center">';
                    echo '<i class="bi bi-info-circle me-2"></i>';
                    echo 'Nenhum evento disponível no momento. Volte em breve!';
                    echo '</div>';
                    echo '</div>';
                }
                
                $conn->close();
                ?>
            </div>
            
            <!-- Call to Action -->
            <div class="row mt-5">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #f48924 0%, #e67610 100%); color: white; padding: 40px;">
                        <h3>Quer participar dos nossos eventos?</h3>
                        <p class="lead">Entre em contacto connosco para mais informações!</p>
                        <a href="contacto.php" class="btn btn-light btn-lg mt-3">
                            <i class="bi bi-envelope"></i> Contactar
                        </a>
                    </div>
                </div>
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
