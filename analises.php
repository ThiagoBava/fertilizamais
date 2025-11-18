<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$db = new PDO("sqlite:fertilizaMais.db");
$usuario = $_SESSION['usuario'];

// Excluir analise
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $db->prepare("DELETE FROM analises WHERE id = ? AND usuario = ?");
    $stmt->execute([$id, $usuario]);
    header("Location: analises.php");
    exit;
}

// Buscar análises
$stmt = $db->prepare("SELECT id, periodo, anoAgricola, talhao, tipoCultura, grid, dataAnalise, numTratamentos, numRepeticoes, numParcelas FROM analises WHERE usuario = ? ORDER BY id DESC");
$stmt->execute([$usuario]);
$analises = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Análises - Fertilizamais</title>
    
    <!-- Bootstrap CSS e Icones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #198754;
            --secondary-color: #146c43;
            --light-bg: #f8f9fa;
        }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: var(--light-bg);
            margin-left: 70px;
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
            font-size: 1.5rem;
            padding: 10px;
            cursor: pointer;
            width: 100%;
            text-align: left;
        }
        .logo {
            font-weight: bold;
            color: green;
            font-size: 24px;
        }
        footer {
            position: fixed;
            left: 0px;
            bottom: 0px;
            text-align: center;
            padding: 10px;
            background-color: #198754;
            color: #fff;
            font-size: 1rem;
            width: 100vw;
        }
        container-fluid {
            max-width: 100vw;
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-menu">
            <button class="toggle-btn" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
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

            <a href="usuarios.php" class="sidebar-item">
                <i class="bi bi-person-fill"></i>
                <span>Usuários</span>
            </a>
            
            <a href="#" class="sidebar-item" data-bs-toggle="modal" data-bs-target="#sobreModal">
                <i class="bi bi-info-circle"></i>
                <span>Sobre</span>
            </a>
        </div>
    </div>

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

<div class="container-fluid">
    <div class="py-3">
        <h4 class="logo">fertilizamais</h4>
        <h5 class="mb-3">Minhas Análises</h5>

        <?php if (count($analises) > 0): ?>
            <div class="table-responsive">
                 <table class="table table-bordered table-striped text-center align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>ID</th>
                            <th>Período</th>
                            <th>Ano Agrícola</th>
                            <th>Talhão</th>
                            <th>Grid</th>
                            <th>Data</th>
                            <th>Tipo de Cultura</th>
                            <th>Trat.</th>
                            <th>Repet.</th>
                            <th>Parcelas</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($analises as $a): ?>
                            <tr>
                                <td><?php echo $a['id']; ?></td>
                                <td><?php echo htmlspecialchars($a['periodo']); ?></td>
                                <td><?php echo htmlspecialchars($a['anoAgricola']); ?></td>
                                <td><?php echo htmlspecialchars($a['talhao']); ?></td>
                                <td><?php echo htmlspecialchars($a['grid']); ?></td>
                                <td><?php echo !empty($a['dataAnalise']) ? date('d/m/Y', strtotime($a['dataAnalise'])) : 'N/A'; ?></td>
                                <td><?php echo htmlspecialchars($a['tipoCultura']); ?></td>
                                <td><?php echo $a['numTratamentos']; ?></td>
                                <td><?php echo $a['numRepeticoes']; ?></td>
                                <td><?php echo $a['numParcelas']; ?></td>
                                <td class="text-center">
                                <a href="ver_analise.php?id=<?php echo $a['id']; ?>" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-bar-chart-line"></i> Visualizar
                                </a>
                                <a href="analises.php?delete=<?php echo $a['id']; ?>" class="btn btn-outline-danger btn-sm"
                                onclick="return confirm('Tem certeza que deseja excluir esta análise?');">
                                <i class="bi bi-trash"></i> Excluir
                                </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Nenhuma análise cadastrada ainda.</div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
</script>

<footer>
    <p>fertilizamais © 2025 - Sistema de Gestão de Análises de Solo</p>
</footer>

</body>
</html>
