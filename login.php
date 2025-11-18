<link rel="stylesheet" type="text/css" href="styles.css">
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
    <style>
        body {
            background-color: #f9f9f9;
        }
        .login-container {
            max-width: 400px;
            margin: auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .logo {
            font-weight: bold;
            color: #198754;
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .form-label {
            font-weight: bold;
        }

    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <img src=".\imagens\logo.png" alt="Fertilizamais" id="title-image" />
        </div>
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
                <button type="submit" class="btn btn-custom">Entrar</button>
            </div>
            <!--<div class="mt-3">
                <a href="#" class="link-secondary">Esqueci minha senha</a>
                <br>
                <a href="#" class="link-secondary">Criar uma conta</a>
            </div>-->
        </form>
    </div>
</body>
</html>