<?php
session_start();

if (!isset($_SESSION['usuario']) || !isset($_SESSION['dados_formulario'])) {
    http_response_code(403);
    echo "Acesso negado.";
    exit;
}

$db = new PDO("sqlite:fertilizaMais.db");

// Verifica se a tabela existe (opcional, segurança extra)
$db->exec("CREATE TABLE IF NOT EXISTS analises (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    usuario TEXT,
    periodo TEXT,
    anoAgricola TEXT,
    talhao TEXT,
    grid TEXT,
    dataAnalise TEXT,
    tipoCultura TEXT,
    numTratamentos INTEGER,
    numRepeticoes INTEGER,
    numParcelas INTEGER,
    -- Solo Antes
    argilaAntes TEXT,
    phH2OAntes TEXT,
    smpAntes TEXT,
    moAntes TEXT,
    pAntes TEXT,
    kAntes TEXT,
    mgAntes TEXT,
    alValorAntes TEXT,
    alAntes TEXT,
    caAntes TEXT,
    ctcAntes TEXT,
    mgkAntes TEXT,
    halAntes TEXT,
    camgAntes TEXT,
    cakAntes TEXT,
    cuAntes TEXT,
    sAntes TEXT,
    znAntes TEXT,
    mnAntes TEXT,
    bAntes TEXT,
    feAntes TEXT,
    ceAntes TEXT,
    -- Solo Depois
    argilaDepois TEXT,
    phH2ODepois TEXT,
    smpDepois TEXT,
    moDepois TEXT,
    pDepois TEXT,
    kDepois TEXT,
    mgDepois TEXT,
    alValorDepois TEXT,
    alDepois TEXT,
    caDepois TEXT,
    ctcDepois TEXT,
    mgkDepois TEXT,
    halDepois TEXT,
    camgDepois TEXT,
    cakDepois TEXT,
    cuDepois TEXT,
    sDepois TEXT,
    znDepois TEXT,
    mnDepois TEXT,
    bDepois TEXT,
    feDepois TEXT,
    ceDepois TEXT
)");

$dados = $_SESSION['dados_formulario'];
$usuario = $_SESSION['usuario'];

$campos = array_merge(['usuario' => $usuario], $dados);
$colunas = implode(", ", array_keys($campos));
$placeholders = implode(", ", array_fill(0, count($campos), "?"));
$valores = array_values($campos);

// Preparar e inserir
$stmt = $db->prepare("INSERT INTO analises ($colunas) VALUES ($placeholders)");
$success = $stmt->execute($valores);

if ($success) {
    echo "Dados salvos com sucesso!";
} else {
    http_response_code(500);
    echo "Erro ao salvar os dados.";
}
