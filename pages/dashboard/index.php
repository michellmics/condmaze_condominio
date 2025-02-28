<?php
    ob_start();
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == NULL) {
        header("Location: ../login/index.php");
        exit();
    }

    if (!in_array(strtoupper($_SESSION['user_nivelacesso']), ["SINDICO", "SUPORTE", "MORADOR"])) {
        header("Location: ../errors/index.php");
        exit();
      }

	include_once "../../objects/objects.php";
	include_once '../../objects/objects_chart.php'; 

    $mesUsu = isset($_GET['data-mes']) ? strval($_GET['data-mes']) : "dezembro"; 
    $anoUsu = isset($_GET['data-ano']) ? strval($_GET['data-ano']) : "2024"; 

    //buscar dados charts
    $chartValor = new SITE_CHARTS(); 
    $totalRecebido = $chartValor->getReceitasValor($mesUsu, $anoUsu);
    if($totalRecebido != null){$totalRecebido = number_format($totalRecebido, 2, ',', '.');}
    $totalFundoReserva = $chartValor->getFundoReservaValor($mesUsu, $anoUsu);
	if($totalFundoReserva != null){$totalFundoReserva = number_format($totalFundoReserva, 2, ',', '.');}
	$totalDespesa = $chartValor->getDespesaValor($mesUsu, $anoUsu);
	if($totalDespesa != null){$totalDespesa = number_format($totalDespesa, 2, ',', '.');}
    $totalInadimplencia = $chartValor->getInadimplenciaFull($mesUsu, $anoUsu);
    $totalInadimplencia = number_format($totalInadimplencia, 2, ',', '.');
    if($totalInadimplencia == "100,00"){$totalInadimplencia = "Sem Dados";}else{$totalInadimplencia = $totalInadimplencia."%";}
    //--------------------

    $chartValor->getPendenciaByMesFull();
    $chartValor->getDespesaTableValor($mesUsu, $anoUsu);  

    $siteAdmin = new SITE_ADMIN();
    $siteAdmin->getParameterInfo();

    foreach ($siteAdmin->ARRAY_PARAMETERINFO as $item) {
      if ($item['CFG_DCPARAMETRO'] == 'NOME_CONDOMINIO') {
          $nomeCondominio = $item['CFG_DCVALOR']; 
          break; 
      }
    }   
    
?>
<!DOCTYPE html>
<html lang="en" data-topbar-color="dark" data-menu-color="dark" data-sidenav-user="true" data-bs-theme="dark">
<head>
    <!-- HEAD META BASIC LOAD-->
	<?php include '../../src/headMeta.php'; ?>
	<!-- HEAD META BASIC LOAD -->
</head>
<style>
    @media (max-width: 768px) {
        .page-title-box {
            display: flex;
            flex-direction: column; /* Alinha itens verticalmente */
        }
    
        .page-title {
            order: -1; /* Move o título para aparecer primeiro */
            margin-bottom: 15px; /* Adiciona espaçamento inferior */
        }
    
        .page-title-right {
            display: flex !important;
            flex-wrap: wrap; /* Permite quebra de linha */
            margin-top: 10px; /* Adiciona espaçamento superior */
        }
    
        .page-title-right select {
            flex: 1 1 100%; /* Os selects ocupam toda a largura */
            margin-bottom: 10px; /* Espaçamento inferior entre selects */
        }
    }
</style>
<body>
    <!-- Begin page -->
    <div class="wrapper">
        <!-- TOP BAR -->
	    <?php include '../../src/topBar.php'; ?>
	    <!-- TOP BAR -->
        <!-- MENU LEFT -->
	    <?php include '../../src/menuLeft.php'; ?>
	    <!-- MENU LEFT -->      
        <div class="content-page">
            <div class="content">                
                <div class="container-fluid"><!-- INICIO CONTEUDO CONTAINER -->

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">

                                </div>
                                <h4 class="page-title">Indicadores</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <form class="d-flex">
                                    <div class="input-group d-flex align-items-center gap-2">
                                        <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'PARCEIRO' || $nivelAcesso == 'SUPORTE'): ?>
                                            <div class="col-sm-4">
                                                <a href="../uploadRelatorio/index.php" class="btn" style="background-color: #aa2ed8; color: white;"><i class="mdi mdi-plus-circle me-2"></i> Upload</a>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- Combobox para selecionar o mês -->
                                        <select class="form-control form-control-light" id="data-mes" name="data-mes">
                                            <option value="" disabled selected>Mês</option>
                                            <option value="janeiro">Janeiro</option>
                                            <option value="fevereiro02">Fevereiro</option>
                                            <option value="março">Março</option>
                                            <option value="abril">Abril</option>
                                            <option value="maio">Maio</option>
                                            <option value="junho">Junho</option>
                                            <option value="julho">Julho</option>
                                            <option value="agosto">Agosto</option>
                                            <option value="setembro">Setembro</option>
                                            <option value="outubro">Outubro</option>
                                            <option value="novembro">Novembro</option>
                                            <option value="dezembro">Dezembro</option>
                                        </select>
                                        
                                        <!-- Combobox para selecionar o ano -->
                                        <select class="form-control form-control-light" id="data-ano" name="data-ano">
                                            <option value="" disabled selected>Ano</option>
                                            <?php
                                            $currentYear = date("Y");
                                            $startYear = $currentYear - 2;
                                            $endYear = $currentYear + 10;
                                            for ($year = $startYear; $year <= $endYear; $year++) { 
                                                echo "<option value='$year'>$year</option>";
                                            }
                                            ?>
                                        </select>
                                        
                                        <span class="input-group-text bg-primary border-primary text-white" style="cursor: pointer; background-color: #20fead;" id="calendar-icon">
                                            <i class="mdi mdi-send font-12"></i>
                                        </span>
                                    </div>

                                    </form>
                                        <script>
                                            // Captura o evento de clique no ícone do calendário
                                            document.getElementById("calendar-icon").addEventListener("click", function() {
                                                // Captura os valores dos campos mês e ano
                                                var mes = document.getElementById("data-mes").value;
                                                var ano = document.getElementById("data-ano").value;
                                            
                                                // Verifica se os valores de mês e ano foram selecionados
                                                if (mes && ano) {
                                                    // Construa a URL com os parâmetros GET
                                                    var url = "index.php?data-mes=" + encodeURIComponent(mes) + "&data-ano=" + encodeURIComponent(ano);
                                                
                                                    // Redireciona para a URL
                                                    window.location.href = url;
                                                } else {
                                                    alert("Por favor, selecione o mês e o ano.");
                                                }
                                            });
                                        </script>
                                </div>
                                <h4 class="page-title">Métrica Financeira Mensal - <?php echo ucwords($mesUsu)."/". $anoUsu; ?></h4> 
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-5 col-lg-6">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card widget-flat">
                                        <div class="card-body">
                                            <div class="float-end">
                                                <i class="mdi mdi-currency-usd widget-icon bg-success-lighten text-success"></i>
                                            </div>
                                            <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Receita</h5>
                                            <h3 class="mt-3 mb-3">R$<?php echo $totalRecebido; ?></h3> 
                                            <p class="mb-0 text-muted">
                                                <span class="text-nowrap">Receitas do Mês de <?php $mesDef = ucfirst($mesUsu); echo $mesDef; ?></span>
                                            </p>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->

                                <div class="col-sm-6">
                                    <div class="card widget-flat">
                                        <div class="card-body">
                                            <div class="float-end">
                                            <i class="mdi mdi-currency-usd widget-icon bg-danger-lighten text-danger"></i>
                                            </div>
                                            <h5 class="text-muted fw-normal mt-0" title="Number of Orders">Despesas</h5>
                                            <h3 class="mt-3 mb-3">R$<?php echo $totalDespesa; ?></h3>
                                            <p class="mb-0 text-muted">
                                                <span class="text-nowrap">Despesas Pagas</span>
                                            </p>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->
                            </div> <!-- end row -->

                            <div class="row">
                                <div class="col-sm-6"> 
                                    <div class="card widget-flat">
                                        <div class="card-body">
                                            <div class="float-end">
                                                <i class="mdi mdi-pulse widget-icon"></i>
                                            </div>
                                            <h5 class="text-muted fw-normal mt-0" title="Average Revenue">Fundo de Reserva</h5>
                                            <h3 class="mt-3 mb-3">R$<?php echo $totalFundoReserva; ?></h3>
                                            <p class="mb-0 text-muted">                                               
                                                <span class="text-nowrap">Total em Caixa</span>
                                            </p>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->

                                <div class="col-sm-6">
                                    <div class="card widget-flat">
                                        <div class="card-body">
                                            <div class="float-end">
                                                <i class="mdi mdi-account-multiple widget-icon"></i>
                                            </div>
                                            <h5 class="text-muted fw-normal mt-0" title="Growth">Inadimplência</h5>
                                            <h3 class="mt-3 mb-3"><?php echo $totalInadimplencia; ?></h3> 
                                            <p class="mb-0 text-muted">
                                                <span class="text-nowrap">% de Apartamentos </span>
                                            </p>
                                        </div> <!-- end card-body-->
                                    </div> <!-- end card-->
                                </div> <!-- end col-->
                            </div> <!-- end row -->

                        </div> <!-- end col -->

                        <div class="col-xl-7 col-lg-6">
                            <div class="card card-h-100">
                                <div class="d-flex card-header justify-content-between align-items-center">
                                    <h4 class="header-title">Evolução Inadimplência</h4>                                                                        
                                </div>
                                <div class="card-body pt-0">
                                    <div dir="ltr">
                                        <div id="codemaze_bar_chart" class="apex-charts" data-colors="#727cf5,#91a6bd40"></div>
                                    </div>

                                </div> <!-- end card-body-->
                            </div> <!-- end card-->

                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->                                                    
                </div><!-- FIM CONTEUDO CONTAINER -->              
            <!-- content -->
        <!-- FOOTER -->
	    <?php include '../../src/footerNav.php'; ?>
	    <!-- FOOTER --> 
       

    <!-- END wrapper -->

	
    <!-- Layout Configuration -->	
    <?php include '../../src/layoutConfig.php'; ?>
    <!-- Vendor js -->
    <script src="../../assets/js/vendor.min.js"></script>

    <!-- Daterangepicker js -->
    <script src="../../assets/vendor/daterangepicker/moment.min.js"></script>
    <script src="../../assets/vendor/daterangepicker/daterangepicker.js"></script>

    <!-- Apex Charts js -->
    <script src="../../assets/vendor/apexcharts/apexcharts.min.js"></script>

    <!-- Vector Map js -->
    <script src="../../assets/vendor/jsvectormap/jsvectormap.min.js"></script>
    <script src="../../assets/vendor/jsvectormap/maps/world-merc.js"></script>
    <script src="../../assets/vendor/jsvectormap/maps/world.js"></script>
    <!-- Dashboard App js -->
    <script src="dashboard.js?ver=<?php echo time(); ?>"></script>

    <!-- App js -->
    <script src="../../assets/js/app.min.js"></script>
</body>

</html>