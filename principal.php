<?php
session_start();

// Verifica se o usuário está logado
/*if (!isset($_SESSION['usuario_logado'])) {
    header("Location: login.php");
    exit();
}*/
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fertilizamais - Início</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- CSS Personalizado -->
    <style>
        :root {
            --primary-color: #198754;
            --secondary-color: #146c43;
            --light-bg: #f8f9fa;
        }
        
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: var(--light-bg);
            margin-left: 70px; /* Espaço para o sidebar */
            transition: margin-left 0.3s;
        }
        
        .sidebar {
            width: 60px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: var(--primary-color);
            color: white;
            transition: width 0.3s;
            overflow-x: hidden;
            z-index: 1000;
        }
        
        .sidebar.expanded {
            width: 200px;
        }
        
        .sidebar-menu {
            padding-top: 20px;
        }
        
        .sidebar-item {
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: background-color 0.3s;
        }
        
        .sidebar-item:hover {
            background-color: var(--secondary-color);
        }
        
        .sidebar-item i {
            margin-right: 10px;
            font-size: 1.2rem;
            min-width: 25px;
        }
        
        .sidebar-item span {
            display: none;
        }
        
        .sidebar.expanded .sidebar-item span {
            display: inline;
        }
        
        .toggle-btn {
            background: none;
            border: none;
            color: white;
            /*font-size: 1.5rem;*/
            padding: 10px;
            cursor: pointer;
            width: 100%;
            text-align: left;
        }
        
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('imagens/banner1.png');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
            margin-bottom: 40px;
        }
        
        .logo {
            font-size: 2.5rem;
            font-weight: bold;
            color: white;
            margin-bottom: 20px;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            margin-bottom: 20px;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-img-top {
            border-radius: 10px 10px 0 0;
            height: 200px;
            object-fit: cover;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
        }
        
        /* Carrossel */
        .carousel {
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 30px;
        }
        
        .carousel-item img {
            height: 550px;
            width: 1680px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-menu">
            <button class="toggle-btn" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
                <span>Menu</span>
            </button>
            
            <a href="principal.php" class="sidebar-item">
                <i class="bi bi-house"></i>
                <span>Início</span>
            </a>
            
            <a href="index.php" class="sidebar-item">
                <i class="bi bi-plus-circle"></i>
                <span>Nova Análise</span>
            </a>
            
            <a href="analises.php" class="sidebar-item">
                <i class="bi bi-clipboard-data"></i>
                <span>Análises</span>
            </a>
            
            <a href="#" class="sidebar-item" data-bs-toggle="modal" data-bs-target="#sobreModal">
                <i class="bi bi-info-circle"></i>
                <span>Sobre</span>
            </a>
        </div>
    </div>

    <!-- Modal Sobre -->
    <div class="modal fade" id="sobreModal" tabindex="-1" aria-labelledby="sobreModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sobreModalLabel">Sobre o Sistema</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Versão: 1.0.0</p>
                    <p>Desenvolvido por: [Thiago Bavaresco]</p>
                    <p>Contato: [thiagobavaresco@unochapeco.edu.br]</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <div class="container-fluid">
        <!-- Banner Rotativo -->
        <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="imagens/banner1.png" class="d-block w-100" alt="Banner 1">
                </div>
                <div class="carousel-item">
                    <img src="imagens/banner2.png" class="d-block w-100" alt="Banner 2">
                </div>
                <div class="carousel-item">
                    <img src="imagens/banner3.png" class="d-block w-100" alt="Banner 3">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Próximo</span>
            </button>
        </div>

        <!-- Seção Hero
        <div class="hero-section rounded">
            <div class="container">
                <h1 class="logo">fertilizamais</h1>
                <h2>ANALISAR O SEU PLANTIO PARA COLHER MAIS FRUTOS!</h2>
            </div>
        </div>-->

        <!-- Cards de Ação -->
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <img src="imagens/nova-analise.png" class="card-img-top" alt="Nova Análise">
                    <div class="card-body text-center">
                        <h5 class="card-title">CADASTRAR UMA NOVA ANÁLISE</h5>
                        <a href="index.php" class="btn btn-primary btn-lg">ACESSAR</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-5">
                <div class="card">
                    <img src="imagens/analises-existentes.png" class="card-img-top" alt="Análises Existentes">
                    <div class="card-body text-center">
                        <h5 class="card-title">ANÁLISES EXISTENTES</h5>
                        <a href="analises.php" class="btn btn-primary btn-lg">ACESSAR</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Função para alternar o sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('expanded');
            
            // Ajusta o margin-left do body
            if (sidebar.classList.contains('expanded')) {
                document.body.style.marginLeft = '200px';
            } else {
                document.body.style.marginLeft = '70px';
            }
        }
        
        // Inicializa o carrossel
        const carousel = new bootstrap.Carousel('#bannerCarousel', {
            interval: 3000, // Muda a cada 3 segundos
            ride: 'carousel'
        });
    </script>
</body>
</html>