<?php
// Incluir helper de autenticação
require_once(__DIR__ . '/helpers/auth.php');

// Verificar se usuário está autenticado
requireAuth();

// Verificar timeout de sessão
checkSessionTimeout();

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Strong Woman - Admin Panel</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>
    <script src="assets/js/config.js"></script>

    <!-- Custom Styles -->
    <style>
      :root {
        --admin-primary: #fb0a0a;
        --admin-secondary: #ff4444;
        --admin-bg: #151515;
        --admin-text: #e8e8e8;
        --admin-card-bg: #ffffff;
        --admin-shadow: rgba(0, 0, 0, 0.08);
      }
      
      /* Sidebar container */
      #layout-menu.layout-menu {
        background: linear-gradient(180deg, #151515 0%, #1b1b1b 100%);
        border-right: 1px solid rgba(255,255,255,0.06);
      }
      
      /* Brand area */
      #layout-menu .app-brand {
        padding: 18px 16px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        background: rgba(251, 10, 10, 0.03);
        position: relative;
        z-index: 100;
      }
      
      #layout-menu .app-brand-link {
        display: flex;
        align-items: center;
        justify-content: center;
      }
      
      #layout-menu .app-brand-link img {
        filter: drop-shadow(0 2px 8px rgba(251, 10, 10, 0.25));
        transition: transform 0.3s ease;
      }
      
      #layout-menu .app-brand-link:hover img {
        transform: scale(1.05);
      }
      
      /* Section header */
      #layout-menu .menu-header-text {
        color: #9aa0a6 !important;
        letter-spacing: .04em;
        font-weight: 700;
        font-size: 11px;
        margin: 16px 14px 6px;
        padding-left: 10px;
        position: relative;
        text-transform: uppercase;
      }
      
      #layout-menu .menu-header-text::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background: var(--admin-primary);
        transform: translateY(-50%);
        opacity: .9;
      }
      
      /* Menu list spacing */
      #layout-menu .menu-inner { padding: 12px 8px; }
      
      /* Links */
      #layout-menu .menu-item > .menu-link {
        border-radius: 10px;
        margin: 6px 8px;
        padding: 10px 12px;
        color: #d3d3d3 !important;
        transition: all .20s ease;
      }
      
      #layout-menu .menu-item > .menu-link .menu-icon {
        color: #b8b8b8;
        font-size: 1.1rem;
        transition: inherit;
      }
      
      #layout-menu .menu-item:hover > .menu-link {
        background: rgba(255,255,255,.05);
        color: #ffffff !important;
        transform: translateX(2px);
      }
      
      #layout-menu .menu-item:hover > .menu-link .menu-icon { 
        color: var(--admin-primary); 
      }
      
      /* Active state */
      #layout-menu .menu-item.active > .menu-link {
        background: rgba(251, 10, 10, .12);
        color: #ffffff !important;
        box-shadow: inset 0 0 0 1px rgba(251,10,10,.18);
        position: relative;
      }
      
      #layout-menu .menu-item.active > .menu-link::before {
        content: '';
        position: absolute;
        left: -8px;
        top: 8px;
        bottom: 8px;
        width: 4px;
        background: linear-gradient(180deg, var(--admin-primary) 0%, rgba(251,10,10,0.5) 100%);
        border-radius: 4px;
        box-shadow: 0 0 8px rgba(251, 10, 10, 0.4);
      }
      
      #layout-menu .menu-item.active > .menu-link .menu-icon {
        color: var(--admin-primary);
      }
      
      /* Scrollbar */
      .ps__thumb-y { background: rgba(255,255,255,.25) !important; }
      
      /* Mobile menu toggle */
      .layout-menu-toggle .bx-menu { color: var(--admin-primary) !important; }
      
      /* Enhanced Navbar Styles */
      .layout-navbar { 
        background: #ffffff !important;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        border-bottom: 1px solid #e9ecef;
        padding: 0.75rem 0;
      }
      
      .navbar-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
      }
      
      .welcome-section {
        display: flex;
        align-items: center;
        gap: 1rem;
      }
      
      .welcome-text {
        color: #495057;
        font-weight: 500;
        font-size: 1.1rem;
        margin: 0;
      }
      
      .welcome-name {
        color: var(--admin-primary);
        font-weight: 600;
      }
      
      .user-section {
        display: flex;
        align-items: center;
        gap: 1rem;
      }
      
      /* Notification Bell */
      .notification-bell {
        position: relative;
        padding: 0.5rem;
        border-radius: 50%;
        transition: all 0.3s ease;
      }
      
      .notification-bell:hover {
        background: rgba(251, 10, 10, 0.1);
      }
      
      .notification-badge {
        position: absolute;
        top: 0;
        right: 0;
        background: var(--admin-primary);
        color: white;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        font-size: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        border: 2px solid #ffffff;
      }
      
      /* User Avatar */
      .user-avatar {
        position: relative;
        cursor: pointer;
        padding: 0.25rem;
        border-radius: 50%;
        transition: all 0.3s ease;
      }
      
      .user-avatar:hover {
        background: rgba(251, 10, 10, 0.1);
      }
      
      .user-avatar img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid transparent;
        transition: all 0.3s ease;
      }
      
      .user-avatar:hover img {
        border-color: var(--admin-primary);
      }
      
      .status-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #28a745;
        border: 2px solid #ffffff;
      }
      
      /* Enhanced Dropdown */
      .dropdown-menu {
        border: none;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
        border-radius: 12px;
        overflow: hidden;
        margin-top: 0.5rem;
      }
      
      .dropdown-header {
        background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-secondary) 100%);
        color: white;
        padding: 1rem;
        text-align: center;
      }
      
      .dropdown-item {
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
        border-bottom: 1px solid #f8f9fa;
      }
      
      .dropdown-item:last-child {
        border-bottom: none;
      }
      
      .dropdown-item:hover {
        background: linear-gradient(90deg, rgba(251, 10, 10, 0.08) 0%, transparent 100%);
        color: var(--admin-primary);
      }
      
      .dropdown-divider {
        margin: 0.5rem 0;
        opacity: 0.5;
      }
      
      /* Mobile Improvements */
      @media (max-width: 1199.98px) {
        .navbar-content {
          flex-direction: column;
          gap: 1rem;
        }
        
        .welcome-section {
          justify-content: center;
          text-align: center;
        }
        
        .user-section {
          justify-content: center;
        }
        
        .welcome-text {
          font-size: 1rem;
        }
      }
      
      @media (min-width: 1200px) {
        .navbar-content {
          flex-direction: row;
        }
      }
    </style>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="dashboard.php" class="app-brand-link">
                        <img src="assets/logo.png" width="170" style="height:auto; width: 80px;" alt="logo">
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <li class="menu-item <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
                        <a href="dashboard.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Pagina inicial</span>
                    </li>
                    <li class="menu-item <?php echo ($current_page == 'configuracoes.php') ? 'active' : ''; ?>">
                        <a href="configuracoes.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-bullseye"></i>
                            <div data-i18n="Account Settings">Missão</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo ($current_page == 'homepagehero.php') ? 'active' : ''; ?>">
                        <a href="homepagehero.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-image-alt"></i>
                            <div data-i18n="Account Settings">Banner Principal</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo ($current_page == 'noticias.php') ? 'active' : ''; ?>">
                        <a href="noticias.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-news"></i>
                            <div data-i18n="Account Settings">Noticias</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo ($current_page == 'eventos.php') ? 'active' : ''; ?>">
                        <a href="eventos.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-calendar-event"></i>
                            <div data-i18n="Account Settings">Eventos</div>
                        </a>
                    </li>
                    <li class="menu-item <?php echo ($current_page == 'utilizadores.php') ? 'active' : ''; ?>">
                        <a href="utilizadores.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-user-circle"></i>
                            <div data-i18n="Account Settings">Utilizadores</div>
                        </a>
                    </li>
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Nossas Abordagens</span>
                    </li>
                    
                    <li class="menu-item <?php echo ($current_page == 'comunitarias.php') ? 'active' : ''; ?>">
                        <a href="comunitarias.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-group"></i>
                            <div data-i18n="Account Settings">Comunitarias</div>
                        </a>
                    </li>
                    
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Multimedia</span>
                    </li>

                    <li class="menu-item <?php echo ($current_page == 'documentos.php') ? 'active' : ''; ?>">
                        <a href="documentos.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-file-blank"></i>
                            <div data-i18n="Account Settings">Documentos</div>
                        </a>
                    </li>
                    
                    <li class="menu-item <?php echo ($current_page == 'galeria.php') ? 'active' : ''; ?>">
                        <a href="galeria.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-photo-album"></i>
                            <div data-i18n="Account Settings">Galeria</div>
                        </a>
                    </li>
                    
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Blog & Doações</span>
                    </li>
                    
                    <li class="menu-item <?php echo ($current_page == 'movimentos.php') ? 'active' : ''; ?>">
                        <a href="movimentos.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-chat"></i>
                            <div data-i18n="Account Settings">Nossos Movimentos</div>
                        </a>
                    </li>
                    
                    <li class="menu-item <?php echo ($current_page == 'configuracoes-doacoes.php') ? 'active' : ''; ?>">
                        <a href="configuracoes-doacoes.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-cog"></i>
                            <div data-i18n="Account Settings">Configurações de Doação</div>
                        </a>
                    </li>
                    
                    <li class="menu-item <?php echo ($current_page == 'doadores.php') ? 'active' : ''; ?>">
                        <a href="doadores.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-donate-heart"></i>
                            <div data-i18n="Account Settings">Lista de Doadores</div>
                        </a>
                    </li>
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Clean Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-content">
                        <!-- Welcome Section -->
                        <div class="welcome-section">
                            <h5 class="welcome-text">
                                Olá, <span class="welcome-name"><?php echo htmlspecialchars($_SESSION["usuario_nome"]); ?></span>
                            </h5>
                        </div>

                        <!-- User Section -->
                        <div class="user-section">
                            <!-- Notifications -->
                            <div class="nav-item dropdown">
                                <a class="nav-link notification-bell position-relative" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <i class="bx bx-bell bx-sm"></i>
                                    <span class="notification-badge">3</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div class="dropdown-header">
                                        <h6 class="mb-0 text-white">Notificações</h6>
                                        <small class="text-white-50">Você tem 3 notificações</small>
                                    </div>
                                    <a class="dropdown-item" href="#">
                                        <small>✅ Novo doador registrado</small>
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <small>📅 Evento próximo</small>
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <small>💬 Nova mensagem</small>
                                    </a>
                                </div>
                            </div>

                            <!-- User Menu -->
                            <div class="nav-item dropdown">
                                <a class="nav-link user-avatar" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar position-relative">
                                        <img src="https://static.vecteezy.com/system/resources/previews/007/296/443/large_2x/user-icon-person-icon-client-symbol-profile-icon-vector.jpg" alt="User Avatar" />
                                        <span class="status-indicator"></span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <div class="dropdown-header">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar me-3">
                                                    <img src="https://static.vecteezy.com/system/resources/previews/007/296/443/large_2x/user-icon-person-icon-client-symbol-profile-icon-vector.jpg" alt="User Avatar" class="w-px-40 h-auto rounded-circle" />
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block text-white"><?php echo htmlspecialchars($_SESSION["usuario_nome"]); ?></span>
                                                    <small class="text-white-50">Administrador</small>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li><div class="dropdown-divider"></div></li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bx-user me-2"></i>
                                            <span>Meu Perfil</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bx-cog me-2"></i>
                                            <span>Configurações</span>
                                        </a>
                                    </li>
                                    <li><div class="dropdown-divider"></div></li>
                                    <li>
                                        <a class="dropdown-item" href="logout.php">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span>Sair do Sistema</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- / Navbar -->