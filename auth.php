<?php
session_start();

$dbFile = __DIR__ . '/fertilizaMais.db';
$criarNovo = !file_exists($dbFile);

// Conectar ao SQLite
$db = new PDO("sqlite:$dbFile");

// Criar tabela se não existir
if ($criarNovo) {
    $db->exec("CREATE TABLE usuarios (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        usuario TEXT NOT NULL UNIQUE,
        senha TEXT NOT NULL
    )");

    // Criar um usuário padrão: admin / senha: 1234
    $senhaHash = password_hash('1234', PASSWORD_DEFAULT);
    $db->prepare("INSERT INTO usuarios (usuario, senha) VALUES (?, ?)")
       ->execute(['admin', $senhaHash]);
}

$usuario = $_POST['usuario'] ?? '';
$senha = $_POST['senha'] ?? '';

// Buscar usuário
$stmt = $db->prepare("SELECT * FROM usuarios WHERE usuario = ?");
$stmt->execute([$usuario]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($senha, $user['senha'])) {
    $_SESSION['usuario'] = $usuario;
    header("Location: principal.php");
    exit;
} else {
    $_SESSION['erro_login'] = "Usuário ou senha inválidos!";
    header("Location: login.php");
    exit;
}
