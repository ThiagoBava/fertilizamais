<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['form_submitted'] ?? '0') === '1') {
    // Coleta todos os dados do formulário
    $_SESSION['dados_formulario'] = [
        // Dados básicos
        'periodo' => $_POST['periodo'] ?? null,
        'anoAgricola' => $_POST['anoAgricola'] ?? null,
        'talhao' => $_POST['talhao'] ?? null,
        'grid' => $_POST['grid'] ?? null,
        'dataAnalise' => $_POST['dataAnalise'] ?? null,
        'tipoCultura' => $_POST['tipoCultura'] ?? null,
        
        // Delineamento Experimental
        'numTratamentos' => $_POST['numTratamentos'] ?? null,
        'numRepeticoes' => $_POST['numRepeticoes'] ?? null,
        'numParcelas' => $_POST['numParcelas'] ?? null,
        
        // Análise do Solo (Antes)
        'argilaAntes' => $_POST['argilaAntes'] ?? null,
        'phH2OAntes' => $_POST['phH2OAntes'] ?? null,
        'smpAntes' => $_POST['smpAntes'] ?? null,
        'moAntes' => $_POST['moAntes'] ?? null,
        'pAntes' => $_POST['pAntes'] ?? null,
        'kAntes' => $_POST['kAntes'] ?? null,
        'mgAntes' => $_POST['mgAntes'] ?? null,
        'alValorAntes' => $_POST['alValorAntes'] ?? null,
        'alAntes' => $_POST['alAntes'] ?? null,
        'caAntes' => $_POST['caAntes'] ?? null,
        'ctcAntes' => $_POST['ctcAntes'] ?? null,
        'mgkAntes' => $_POST['mgkAntes'] ?? null,
        'halAntes' => $_POST['halAntes'] ?? null,
        'camgAntes' => $_POST['camgAntes'] ?? null,
        'cakAntes' => $_POST['cakAntes'] ?? null,
        'cuAntes' => $_POST['cuAntes'] ?? null,
        'sAntes' => $_POST['sAntes'] ?? null,
        'znAntes' => $_POST['znAntes'] ?? null,
        'mnAntes' => $_POST['mnAntes'] ?? null,
        'bAntes' => $_POST['bAntes'] ?? null,
        'feAntes' => $_POST['feAntes'] ?? null,
        'ceAntes' => $_POST['ceAntes'] ?? null,
        
        // Análise do Solo (Depois)
        'argilaDepois' => $_POST['argilaDepois'] ?? null,
        'phH2ODepois' => $_POST['phH2ODepois'] ?? null,
        'smpDepois' => $_POST['smpDepois'] ?? null,
        'moDepois' => $_POST['moDepois'] ?? null,
        'pDepois' => $_POST['pDepois'] ?? null,
        'kDepois' => $_POST['kDepois'] ?? null,
        'mgDepois' => $_POST['mgDepois'] ?? null,
        'alValorDepois' => $_POST['alValorDepois'] ?? null,
        'alDepois' => $_POST['alDepois'] ?? null,
        'caDepois' => $_POST['caDepois'] ?? null,
        'ctcDepois' => $_POST['ctcDepois'] ?? null,
        'mgkDepois' => $_POST['mgkDepois'] ?? null,
        'halDepois' => $_POST['halDepois'] ?? null,
        'camgDepois' => $_POST['camgDepois'] ?? null,
        'cakDepois' => $_POST['cakDepois'] ?? null,
        'cuDepois' => $_POST['cuDepois'] ?? null,
        'sDepois' => $_POST['sDepois'] ?? null,
        'znDepois' => $_POST['znDepois'] ?? null,
        'mnDepois' => $_POST['mnDepois'] ?? null,
        'bDepois' => $_POST['bDepois'] ?? null,
        'feDepois' => $_POST['feDepois'] ?? null,
        'ceDepois' => $_POST['ceDepois'] ?? null
    ];

    // Validação básica - verifica se pelo menos um campo de análise foi preenchido
    /*  $camposAnalise = [
        'argilaAntes', 'phH2OAntes', 'moAntes', 'pAntes', 'argilaDepois', 'phH2ODepois', 'moDepois'
    ];
    
    $algumCampoPreenchido = false;
    foreach ($camposAnalise as $campo) {
        if (!empty($_POST[$campo])) {
           $algumCampoPreenchido = true;
            break;
        }
    }
    
    if (!$algumCampoPreenchido) {
        $_SESSION['erro'] = "Por favor, preencha pelo menos um campo de análise do solo";
        header("Location: index.php");
        exit();
    }*/

    header("Location: graficos.php");
    exit();
}

// Exibir erro se existir
$erro = $_SESSION['erro'] ?? null;
unset($_SESSION['erro']);
?>

<!DOCTYPE html>
<html lang="pt-br">
   <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Fertilizamais</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
         .tab-button {
            border: none;
            padding: 0.5rem 1rem;
            background-color: #ddd;
            margin-right: 0.5rem;
            cursor: pointer;
         }
         .tab-button.active {
            background-color: #3f51b5;
            color: white;
         }
         .tab-content {
            display: none;
         }
         .tab-content.active {
            display: block;
         }
         .form-narrow {
            max-width: 300px;
         }
         .card {
            background-color: #fff;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }
        container-fluid {
            max-width: 100vw;
        }

      </style>
   </head>
   <body>
        <!-- Sidebar -->
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

      <!-- Main Content -->
      <div class="container-fluid">
         <div class="py-3">
            <h4 class="logo">fertilizamais</h4>
         </div>
         <!-- Form Container -->
         <div class="container">
            <div class="row justify-content-start">
               <div class="col-md-10 col-lg-10 bg-white p-4 rounded shadow-sm mb-3">
<form id="formAnalise" name="formAnalise" method="post">
   <h5>Cadastrar Análises</h5>
   <div class="row mb-2">
      <div class="col-md-4 mb-2"><input type="text" class="form-control" name="periodo" placeholder="Período" required></div>
      <div class="col-md-4 mb-2"><input type="text" class="form-control" name="anoAgricola" placeholder="Ano Agrícola" required></div>
      <div class="col-md-4 mb-2"><input type="text" class="form-control" name="talhao" placeholder="Talhão" required></div>
      <div class="col-md-4 mb-2"><input type="text" class="form-control" name="grid" placeholder="Grid" required></div>
      <div class="col-md-4 mb-2"><input type="date" class="form-control" name="dataAnalise" placeholder="Data Análise" required></div>
      <div class="col-md-4 mb-2"><input type="text" class="form-control" id="tipoCultura" name="tipoCultura" placeholder="Cultura" required></div>
</div>
   <h5>Delineamento Experimental</h5>
   <div class="row mb-3">
      <div class="col-md-4"><input type="text" class="form-control" name="numTratamentos" placeholder="Número de Tratamentos" required></div>
      <div class="col-md-4"><input type="text" class="form-control" name="numRepeticoes" placeholder="Número de Repetições" required></div>
      <div class="col-md-4"><input type="text" class="form-control" name="numParcelas" placeholder="Número de Parcelas" required></div>
   </div>

   <!-- Tabs -->
   <div class="mb-3">
      <button type="button" class="tab-button active" onclick="showTab('solo-antes', event)">Análise do Solo (Antes)</button>
      <button type="button" class="tab-button" onclick="showTab('solo-depois', event)">Análise do Solo (Depois)</button>
   </div>

   <!-- Solo Antes -->
   <div id="solo-antes" class="tab-content active">
      <div class="row">
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="argilaAntes" placeholder="Argila %"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="phH2OAntes" placeholder="pH H2O"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="smpAntes" placeholder="SMP"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="moAntes" placeholder="MO %"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="pAntes" placeholder="P mg/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="kAntes" placeholder="K mg/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="mgAntes" placeholder="Mg cmol/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="alValorAntes" placeholder="Al (Valor m)"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="alAntes" placeholder="Al cmol/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="caAntes" placeholder="Ca cmol/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="ctcAntes" placeholder="CTC pH 7,0 cmol/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="mgkAntes" placeholder="Mg/K"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="halAntes" placeholder="H + Al cmol/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="camgAntes" placeholder="Ca/Mg"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="cakAntes" placeholder="Ca/K"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="cuAntes" placeholder="Cu mg/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="sAntes" placeholder="S mg/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="znAntes" placeholder="Zn mg/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="mnAntes" placeholder="Mn mg/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="bAntes" placeholder="B mg/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="feAntes" placeholder="Fe mg/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="ceAntes" placeholder="CE mS/cm"></div>
      </div>
   </div>

   <!-- Solo Depois -->
   <div id="solo-depois" class="tab-content">
      <div class="row">
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="argilaDepois" placeholder="Argila %"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="phH2ODepois" placeholder="pH H2O"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="smpDepois" placeholder="SMP"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="moDepois" placeholder="MO %"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="pDepois" placeholder="P mg/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="kDepois" placeholder="K mg/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="mgDepois" placeholder="Mg cmol/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="alValorDepois" placeholder="Al (Valor m)"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="alDepois" placeholder="Al cmol/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="caDepois" placeholder="Ca cmol/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="ctcDepois" placeholder="CTC pH 7,0 cmol/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="mgkDepois" placeholder="Mg/K"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="halDepois" placeholder="H + Al cmol/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="camgDepois" placeholder="Ca/Mg"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="cakDepois" placeholder="Ca/K"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="cuDepois" placeholder="Cu mg/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="sDepois" placeholder="S mg/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="znDepois" placeholder="Zn mg/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="mnDepois" placeholder="Mn mg/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="bDepois" placeholder="B mg/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="feDepois" placeholder="Fe mg/dm³"></div>
         <div class="col-md-4 mb-2"><input type="number" step="0.01" class="form-control form-narrow" name="ceDepois" placeholder="CE mS/cm"></div>
      </div>
   </div>

<input type="hidden" name="form_submitted" value="0" id="form-submitted">

<div class="text-end mt-1">
    <button type="button" class="btn btn-primary" onclick="submitForm()">GERAR RELATÓRIO</button>
</div>
</form>
    </div>
        </div>
            </div>
         </div>
      </div>
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

function submitForm() {
    // Marca o formulário como para ser submetido
    document.getElementById('form-submitted').value = '1';
    // Submete o formulário
    document.getElementById('formAnalise').submit();
}

    function showTab(tabId, event) {
        event.preventDefault();
        const tabs = document.querySelectorAll('.tab-content');
        tabs.forEach(tab => tab.classList.remove('active'));
        document.getElementById(tabId).classList.add('active');
        
        const buttons = document.querySelectorAll('.tab-button');
        buttons.forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
        return false;
    }
         document.getElementById('toggleMenu').addEventListener('click', function () {
         document.getElementById('sidebar').classList.toggle('expanded');
         });
         
         document.getElementById('toggleSubmenu').addEventListener('click', function (e) {
         e.preventDefault();
         const submenu = document.getElementById('submenuCadastro');
         submenu.classList.toggle('show');
         });
         
         // Opcional: clicar fora fecha o submenu
         document.addEventListener('click', function (event) {
         const sidebar = document.getElementById('sidebar');
         const submenu = document.getElementById('submenuCadastro');
         const toggle = document.getElementById('toggleSubmenu');
         
         if (!sidebar.contains(event.target) && submenu.classList.contains('show')) {
           submenu.classList.remove('show');
         }
         });
         
      </script>
   </body>
</html>