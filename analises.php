<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$db = new PDO("sqlite:fertilizaMais.db");
$usuario = $_SESSION['usuario'];

$stmt = $db->prepare("SELECT id, periodo, anoAgricola, talhao, grid, dataAnalise, numTratamentos, numRepeticoes, numParcelas FROM analises WHERE usuario = ? ORDER BY id DESC");
$stmt->execute([$usuario]);
$analises = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minhas Análises - Fertilizamais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9f9;
        }
        .sidebar {
            width: 60px;
            transition: width 0.3s;
            overflow-x: hidden;
            position: relative;
            overflow: visible;
            background-color: #198754;
            color: white;
        }
        .sidebar.expanded {
            width: 200px;
        }
        .sidebar i {
            margin: 1rem 0;
            font-size: 20px;
            cursor: pointer;
            color: white;
        }
        .logo {
            font-weight: bold;
            color: green;
            font-size: 24px;
        }
        #submenuCadastro {
            position: absolute;
            top: 60px;
            left: 60px;
            min-width: 200px;
            z-index: 1000;
            display: none;
            background-color: #198754;
            color: white;
            border-radius: 0 0.375rem 0.375rem 0;
        }
        #submenuCadastro.show {
            display: block;
        }
        #submenuCadastro a {
            color: white !important;
        }
        #submenuCadastro a:hover {
            background-color: #145c32;
            color: white !important;
        }
        .btn.btn-light {
            background-color: #198754;
            color: white;
            border: none;
        }
        .btn.btn-light:hover, .btn.btn-light:focus {
            background-color: #145c32;
            color: white;
            box-shadow: none;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div id="sidebar" class="sidebar d-flex flex-column align-items-start py-3">
    <button class="btn btn-light mb-4" title="Menu" data-bs-toggle="collapse" data-bs-target="#submenuCadastro" aria-expanded="false" aria-controls="submenuCadastro">
        <i class="bi bi-list" style="font-size: 1.5rem;"></i>
    </button>
    <div class="collapse rounded" id="submenuCadastro" style="width: 100%;">
        <div class="d-flex flex-column ps-3">
            <a href="index.php" class="mb-2 text-dark d-flex align-items-center">
                <i class="bi bi-pencil-square me-2"></i> <span>Cadastrar Análises</span>
            </a>
            <a href="analises.php" class="mb-2 text-dark d-flex align-items-center">
                <i class="bi bi-list-columns-reverse me-2"></i> <span>Minhas Análises</span>
            </a>
            <a href="logout.php" class="mb-2 text-dark d-flex align-items-center">
                <i class="bi bi-box-arrow-right me-2"></i> <span>Sair</span>
            </a>
            <a href="#" class="mb-2 text-dark d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#infoModal">
                <i class="bi bi-info-circle me-2"></i> <span>Sobre o Sistema</span>
            </a>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Informações do Sistema</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Versão: 1.0.0</p>
                <p>Desenvolvido por: Thiago Mathias Bavaresco</p>
                <p>Contato: thiagobavaresco@unochapeco.edu.br</p>
            </div>
        </div>
    </div>
</div>

<!-- Conteúdo -->
<div class="container-fluid" style="margin-left: 70px;">
    <div class="py-3">
        <h4 class="logo">fertilizamais</h4>
        <h5 class="mb-3">Minhas Análises</h5>

        <?php if (count($analises) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>ID</th>
                            <th>Período</th>
                            <th>Ano Agrícola</th>
                            <th>Talhão</th>
                            <th>Grid</th>
                            <th>Data</th>
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
                                <td><?php echo $a['numTratamentos']; ?></td>
                                <td><?php echo $a['numRepeticoes']; ?></td>
                                <td><?php echo $a['numParcelas']; ?></td>
                                <td class="text-center">
                                <a href="ver_analise.php?id=<?php echo $a['id']; ?>" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-bar-chart-line"></i> Visualizar
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
    document.getElementById('toggleMenu')?.addEventListener('click', function () {
        document.getElementById('sidebar').classList.toggle('expanded');
    });

    document.addEventListener('click', function (event) {
        const sidebar = document.getElementById('sidebar');
        const submenu = document.getElementById('submenuCadastro');
        if (!sidebar.contains(event.target) && submenu.classList.contains('show')) {
            submenu.classList.remove('show');
        }
    });
</script>
</body>
</html>
