<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['dados_formulario'])) {
    header("Location: index.php");
    exit;
}

$dados = $_SESSION['dados_formulario'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Comparativo de Análise - Fertilizamais</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #198754;
            --secondary-color: #146c43;
            --accent-color: #20c997;
            --light-bg: #f8f9fa;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --antes-color: #3498db;
            --depois-color: #e74c3c;
        }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: var(--light-bg);
            color: #333;
            line-height: 1.6;
        }
        .header {
            background-color: white;
            box-shadow: var(--card-shadow);
            margin-bottom: 2rem;
        }
        .logo {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.8rem;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            margin-bottom: 2rem;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 1rem 1.5rem;
            font-weight: 600;
        }
        .chart-container {
            position: relative;
            height: 350px;
            width: 100%;
        }
        .comparativo-legend {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }
        .legend-item {
            display: flex;
            align-items: center;
            margin: 0 15px;
        }
        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 3px;
            margin-right: 8px;
        }
        .antes-color {
            background-color: var(--antes-color);
        }
        .depois-color {
            background-color: var(--depois-color);
        }
        .diferenca-positiva {
            color: var(--primary-color);
            font-weight: bold;
        }
        .diferenca-negativa {
            color: var(--depois-color);
            font-weight: bold;
        }
        .btn-voltar {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .btn-voltar:hover {
            background-color: var(--secondary-color);
            color: white;
        }
        .dados-experimento {
            max-width: 900px;
            margin: 0 auto;
        }
        .info-item {
            border: 1px solid #dee2e6;
            transition: all 0.3s ease;
        }
        .info-item:hover {
            background-color: #e9ecef !important;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        footer {
            bottom: 0px;
            text-align: center;
            padding: 10px;
            background-color: #198754;
            color: #fff;
            font-size: 1rem;
            width: 100%;
        }

    </style>
</head>
<body>
    <div class="container py-4">
<div class="d-flex justify-content-end gap-2 mb-4">
    <a href="index.php" class="btn btn-outline-secondary">
        <i class="bi bi-pencil-square me-1"></i> Novo Formulário
    </a>
    <a href="analises.php" class="btn btn-outline-secondary">
        <i class="bi bi-table me-1"></i> Minhas Análises
    </a>
    <a href="logout.php" class="btn btn-outline-danger">
        <i class="bi bi-box-arrow-right me-1"></i> Sair
    </a>
</div>
        
<!-- Cabeçalho -->
<div class="text-center mb-5">
    <h1 class="logo mb-2">Fertilizamais</h1>
    <h2>Comparativo de Análise do Solo</h2>
    <p class="text-muted">Antes e depois do tratamento</p>
    
    <div class="dados-experimento mt-4">
        <div class="row justify-content-center">
            <div class="col-md-3 col-6 mb-2">
                <div class="info-item bg-light p-2 rounded">
                    <strong>Periodo:</strong> <?php echo htmlspecialchars($dados['periodo'] ?? 'N/A'); ?>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="info-item bg-light p-2 rounded">
                    <strong>Ano Agrícola:</strong> <?php echo htmlspecialchars($dados['anoAgricola'] ?? 'N/A'); ?>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="info-item bg-light p-2 rounded">
                    <strong>Talhão:</strong> <?php echo htmlspecialchars($dados['talhao'] ?? 'N/A'); ?>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="info-item bg-light p-2 rounded">
                    <strong>Grid:</strong> <?php echo htmlspecialchars($dados['grid'] ?? 'N/A'); ?>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-2">
            <div class="col-md-3 col-6 mb-2">
                <div class="info-item bg-light p-2 rounded">
                    <strong>Data:</strong> <?php echo !empty($dados['dataAnalise']) ? date('d/m/Y', strtotime($dados['dataAnalise'])) : 'N/A'; ?>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="info-item bg-light p-2 rounded">
                    <strong>Tratamentos:</strong> <?php echo htmlspecialchars($dados['numTratamentos'] ?? 'N/A'); ?>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="info-item bg-light p-2 rounded">
                    <strong>Repetições:</strong> <?php echo htmlspecialchars($dados['numRepeticoes'] ?? 'N/A'); ?>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <div class="info-item bg-light p-2 rounded">
                    <strong>Parcelas:</strong> <?php echo htmlspecialchars($dados['numParcelas'] ?? 'N/A'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
        
        <!-- Seção de Gráficos Comparativos -->
        <div class="row">
            <!-- pH da Água -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-droplet me-2"></i> pH da Água
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="graficoPh"></canvas>
                        </div>
                        <div class="comparativo-legend">
                            <div class="legend-item">
                                <div class="legend-color antes-color"></div>
                                <span>Antes: <?php echo $dados['phH2OAntes'] ?? 'N/A'; ?></span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color depois-color"></div>
                                <span>Depois: <?php echo $dados['phH2ODepois'] ?? 'N/A'; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Matéria Orgânica -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-tree me-2"></i> Matéria Orgânica (%)
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="graficoMo"></canvas>
                        </div>
                        <div class="comparativo-legend">
                            <div class="legend-item">
                                <div class="legend-color antes-color"></div>
                                <span>Antes: <?php echo $dados['moAntes'] ?? 'N/A'; ?></span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color depois-color"></div>
                                <span>Depois: <?php echo $dados['moDepois'] ?? 'N/A'; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Fósforo (P) -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-flower1 me-2"></i> Fósforo (P) - mg/dm³
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="graficoP"></canvas>
                        </div>
                        <div class="comparativo-legend">
                            <div class="legend-item">
                                <div class="legend-color antes-color"></div>
                                <span>Antes: <?php echo $dados['pAntes'] ?? 'N/A'; ?></span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color depois-color"></div>
                                <span>Depois: <?php echo $dados['pDepois'] ?? 'N/A'; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Potássio (K) -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-lightning-charge me-2"></i> Potássio (K) - mg/dm³
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="graficoK"></canvas>
                        </div>
                        <div class="comparativo-legend">
                            <div class="legend-item">
                                <div class="legend-color antes-color"></div>
                                <span>Antes: <?php echo $dados['kAntes'] ?? 'N/A'; ?></span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color depois-color"></div>
                                <span>Depois: <?php echo $dados['kDepois'] ?? 'N/A'; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Cálcio (Ca) -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-gem me-2"></i> Cálcio (Ca) - cmol/dm³
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="graficoCa"></canvas>
                        </div>
                        <div class="comparativo-legend">
                            <div class="legend-item">
                                <div class="legend-color antes-color"></div>
                                <span>Antes: <?php echo $dados['caAntes'] ?? 'N/A'; ?></span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color depois-color"></div>
                                <span>Depois: <?php echo $dados['caDepois'] ?? 'N/A'; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Magnésio (Mg) -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-magnet me-2"></i> Magnésio (Mg) - cmol/dm³
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="graficoMg"></canvas>
                        </div>
                        <div class="comparativo-legend">
                            <div class="legend-item">
                                <div class="legend-color antes-color"></div>
                                <span>Antes: <?php echo $dados['mgAntes'] ?? 'N/A'; ?></span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-color depois-color"></div>
                                <span>Depois: <?php echo $dados['mgDepois'] ?? 'N/A'; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botão Salvar Dados -->
<button class="btn btn-success ms-2" onclick="salvarAnalise()">
    <i class="bi bi-save me-1"></i> Salvar Análise
</button>

<div id="resultado-salvar" class="mt-2"></div>
        
        <!-- Tabela Comparativa -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="bi bi-table me-2"></i> Tabela Comparativa Completa
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Parâmetro</th>
                                <th>Antes</th>
                                <th>Depois</th>
                                <th>Diferença</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $parametros = [
                                'Argila' => ['unidade' => '%', 'antes' => 'argilaAntes', 'depois' => 'argilaDepois'],
                                'pH H2O' => ['unidade' => '', 'antes' => 'phH2OAntes', 'depois' => 'phH2ODepois'],
                                'Matéria Orgânica' => ['unidade' => '%', 'antes' => 'moAntes', 'depois' => 'moDepois'],
                                'Fósforo (P)' => ['unidade' => 'mg/dm³', 'antes' => 'pAntes', 'depois' => 'pDepois'],
                                'Potássio (K)' => ['unidade' => 'mg/dm³', 'antes' => 'kAntes', 'depois' => 'kDepois'],
                                'Cálcio (Ca)' => ['unidade' => 'cmol/dm³', 'antes' => 'caAntes', 'depois' => 'caDepois'],
                                'Magnésio (Mg)' => ['unidade' => 'cmol/dm³', 'antes' => 'mgAntes', 'depois' => 'mgDepois'],
                                'Alumínio (Al)' => ['unidade' => 'cmol/dm³', 'antes' => 'alAntes', 'depois' => 'alDepois'],
                                'CTC' => ['unidade' => 'cmol/dm³', 'antes' => 'ctcAntes', 'depois' => 'ctcDepois'],
                                'Zinco (Zn)' => ['unidade' => 'mg/dm³', 'antes' => 'znAntes', 'depois' => 'znDepois'],
                                'Cobre (Cu)' => ['unidade' => 'mg/dm³', 'antes' => 'cuAntes', 'depois' => 'cuDepois'],
                                'Boro (B)' => ['unidade' => 'mg/dm³', 'antes' => 'bAntes', 'depois' => 'bDepois'],
                                'Enxofre (S)' => ['unidade' => 'mg/dm³', 'antes' => 'sAntes', 'depois' => 'sDepois'],
                                'Manganês (Mn)' => ['unidade' => 'mg/dm³', 'antes' => 'mnAntes', 'depois' => 'mnDepois'],
                                'Ferro (Fe)' => ['unidade' => 'mg/dm³', 'antes' => 'feAntes', 'depois' => 'feDepois'],
                                'Condutividade Elétrica' => ['unidade' => 'mS/cm', 'antes' => 'ceAntes', 'depois' => 'ceDepois']
                            ];
                            
                            foreach ($parametros as $nome => $dadosParam) {
                                $antes = $dados[$dadosParam['antes']] ?? null;
                                $depois = $dados[$dadosParam['depois']] ?? null;
                                $unidade = $dadosParam['unidade'];
                                
                                // Calcular diferença se ambos valores existirem
                                $diferenca = null;
                                $classeDiferenca = '';
                                
                                if (is_numeric($antes) && is_numeric($depois)) {
                                    $diferenca = $depois - $antes;
                                    $classeDiferenca = $diferenca >= 0 ? 'diferenca-positiva' : 'diferenca-negativa';
                                }
                                
                                echo "<tr>
                                    <td><strong>{$nome}</strong></td>
                                    <td>".($antes !== null ? $antes.' '.$unidade : 'N/A')."</td>
                                    <td>".($depois !== null ? $depois.' '.$unidade : 'N/A')."</td>
                                    <td class='{$classeDiferenca}'>";
                                
                                if ($diferenca !== null) {
                                    echo ($diferenca >= 0 ? '+' : '').number_format($diferenca, 2).' '.$unidade;
                                } else {
                                    echo 'N/A';
                                }
                                
                                echo "</td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        const dados = <?php echo json_encode($dados); ?>;
        
    // Função para converter valores brasileiros (vírgula para ponto)
    function parseBrazilianNumber(value) {
    if (value === null || value === '' || value === undefined) return null;
    if (typeof value === 'number') return value;
    
    const strValue = value.toString().trim();
    
    // Verifica se é um número válido (com ou sem vírgula)
    if (/^-?\d+([,.]\d+)?$/.test(strValue)) {
        return parseFloat(strValue.replace(',', '.'));
    }

    return null;
}

// Função para formatar números brasileiros (ponto para vírgula)
function formatBrazilianNumber(value, decimals = 2) {
    if (value === null) return 'N/A';
    return value.toFixed(decimals).replace('.', ',');
}

function criarGraficoComparativo(id, titulo, antes, depois, unidade = '') {
    const ctx = document.getElementById(id).getContext('2d');
    
    // Converter valores para o formato numérico
    const valorAntes = parseBrazilianNumber(antes);
    const valorDepois = parseBrazilianNumber(depois);
    
    // Debug: Mostra os valores convertidos no console
    console.log(`Gráfico ${titulo}:`, {
        antes: { original: antes, convertido: valorAntes },
        depois: { original: depois, convertido: valorDepois }
    });
    
    const temAntes = valorAntes !== null;
    const temDepois = valorDepois !== null;
    
    // Configuração do eixo Y para começar em um valor mínimo adequado
    const minValue = Math.min(
        temAntes ? valorAntes : Infinity,
        temDepois ? valorDepois : Infinity
    );
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Antes', 'Depois'],
            datasets: [{
                label: titulo,
                data: [
                    temAntes ? valorAntes : null,
                    temDepois ? valorDepois : null
                ],
                backgroundColor: [
                    temAntes ? 'rgba(52, 152, 219, 0.7)' : 'rgba(200, 200, 200, 0.5)',
                    temDepois ? 'rgba(231, 76, 60, 0.7)' : 'rgba(200, 200, 200, 0.5)'
                ],
                borderColor: [
                    temAntes ? 'rgba(52, 152, 219, 1)' : 'rgba(200, 200, 200, 1)',
                    temDepois ? 'rgba(231, 76, 60, 1)' : 'rgba(200, 200, 200, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const valor = context.raw;
                            return `${context.dataset.label}: ${valor !== null ? formatBrazilianNumber(valor) : 'N/A'} ${unidade}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    min: minValue !== Infinity ? Math.floor(minValue * 0.9) : undefined,
                    ticks: {
                        callback: function(value) {
                            return formatBrazilianNumber(value);
                        }
                    }
                }
            }
        }
    });
}

// Criar gráficos individuais
if (dados.phH2OAntes || dados.phH2ODepois) {
    criarGraficoComparativo('graficoPh', 'pH da Água', dados.phH2OAntes, dados.phH2ODepois);
}

if (dados.moAntes || dados.moDepois) {
    criarGraficoComparativo('graficoMo', 'Matéria Orgânica', dados.moAntes, dados.moDepois, '%');
}

if (dados.pAntes || dados.pDepois) {
    criarGraficoComparativo('graficoP', 'Fósforo (P)', dados.pAntes, dados.pDepois, 'mg/dm³');
}

if (dados.kAntes || dados.kDepois) {
    criarGraficoComparativo('graficoK', 'Potássio (K)', dados.kAntes, dados.kDepois, 'mg/dm³');
}

if (dados.caAntes || dados.caDepois) {
    criarGraficoComparativo('graficoCa', 'Cálcio (Ca)', dados.caAntes, dados.caDepois, 'cmol/dm³');
}

if (dados.mgAntes || dados.mgDepois) {
    criarGraficoComparativo('graficoMg', 'Magnésio (Mg)', dados.mgAntes, dados.mgDepois, 'cmol/dm³');
}

function salvarAnalise() {
    fetch('salvar_analise.php', {
        method: 'POST',
    })
    .then(res => res.text())
    .then(msg => {
        document.getElementById('resultado-salvar').innerHTML =
            `<div class="alert alert-success">${msg}</div>`;
    })
    .catch(err => {
        document.getElementById('resultado-salvar').innerHTML =
            `<div class="alert alert-danger">Erro ao salvar.</div>`;
    });
}
    </script>

<footer>
    <p>fertilizamais © 2025 - Sistema de Gestão de Análises de Solo</p>
</footer>

</body>
</html>