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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários - Fertilizamais</title>

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
            width: 100vw;
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

<!-- Conteúdo -->
<div class="container-fluid">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('expanded');
            
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
