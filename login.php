<?php
session_start();
$erro = $_SESSION['erro_login'] ?? null;
unset($_SESSION['erro_login']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Fertilizamais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9f9;
        }
        .login-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .logo {
            font-weight: bold;
            color: #198754;
            text-align: center;
            font-size: 1.8rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo mb-4">Fertilizamais</div>
        <form method="POST" action="auth.php">
            <div class="mb-3">
                <label class="form-label">Usuário</label>
                <input type="text" name="usuario" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Senha</label>
                <input type="password" name="senha" class="form-control" required>
            </div>
            <?php if ($erro): ?>
                <div class="alert alert-danger"><?php echo $erro; ?></div>
            <?php endif; ?>
            <div class="d-grid">
                <button type="submit" class="btn btn-success">Entrar</button>
            </div>
        </form>
    </div>
</body>
</html>
