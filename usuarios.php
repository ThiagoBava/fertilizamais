<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$db = new PDO("sqlite:fertilizaMais.db");

// Adicionar novo usuário
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['novo_usuario'])) {
    $usuario = trim($_POST['usuario']);
    $senha = password_hash(trim($_POST['senha']), PASSWORD_DEFAULT);

    if ($usuario && $_POST['senha']) {
        $stmt = $db->prepare("INSERT INTO usuarios (usuario, senha) VALUES (?, ?)");
        $stmt->execute([$usuario, $senha]);
        header("Location: usuarios.php");
        exit;
    }
}

// Excluir usuário
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $db->prepare("DELETE FROM usuarios WHERE id = ?")->execute([$id]);
    header("Location: usuarios.php");
    exit;
}

$usuarios = $db->query("SELECT id, usuario FROM usuarios ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Usuários - Fertilizamais</title>
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
        .logo {
            font-weight: bold;
            color: green;
            font-size: 24px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div id="sidebar" class="sidebar d-flex flex-column align-items-start py-3">
    <button id="toggleMenu" class="btn btn-light mb-4" title="Menu" data-bs-toggle="collapse" data-bs-target="#submenuCadastro" aria-expanded="false" aria-controls="submenuCadastro">
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
            <a href="usuarios.php" class="mb-2 text-dark d-flex align-items-center">
                <i class="bi bi-person-gear me-2"></i> <span>Usuários</span>
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
                <p>Desenvolvido por: Seu Nome ou Empresa</p>
                <p>Contato: email@exemplo.com</p>
            </div>
        </div>
    </div>
</div>

<!-- Conteúdo -->
<div class="container-fluid" style="margin-left: 70px;">
    <div class="py-3">
        <h4 class="logo mb-4">Gestão de Usuários</h4>

        <form method="POST" class="row g-3 mb-4">
            <input type="hidden" name="novo_usuario" value="1">
            <div class="col-md-4">
                <input type="text" name="usuario" class="form-control" placeholder="Novo usuário" required>
            </div>
            <div class="col-md-4">
                <input type="password" name="senha" class="form-control" placeholder="Senha" required>
            </div>
            
            <div class="col-md-4">
                <button type="submit" class="btn btn-success w-100">
                    <i class="bi bi-person-plus me-1"></i> Adicionar
                </button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-success">
                    <tr>
                        <th>ID</th>
                        <th>Usuário</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?php echo $u['id']; ?></td>
                        <td><?php echo htmlspecialchars($u['usuario']); ?></td>
                        <td>
                            <a href="usuarios.php?delete=<?php echo $u['id']; ?>" class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Deseja realmente excluir este usuário?')">
                                <i class="bi bi-trash"></i> Excluir
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($usuarios)): ?>
                    <tr><td colspan="3" class="text-center">Nenhum usuário cadastrado.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('toggleMenu')?.addEventListener('click', function () {
        document.getElementById('sidebar').classList.toggle('expanded');
    });

    document.addEventListener('click', function (event) {
        const sidebar = document.getElementById('sidebar');
        const submenu = document.getElementById('submenuCadastro');
        const toggle = document.getElementById('toggleMenu');

        if (!sidebar.contains(event.target) && submenu.classList.contains('show')) {
            submenu.classList.remove('show');
        }
    });
</script>
</body>
</html>
