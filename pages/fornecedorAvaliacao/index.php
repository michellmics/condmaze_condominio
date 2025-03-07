<?php
    ini_set('display_errors', 1);  
    error_reporting(E_ALL);        

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
	
    $siteAdmin = new SITE_ADMIN();  
    $siteAdmin->getParameterInfo();

    foreach ($siteAdmin->ARRAY_PARAMETERINFO as $item) {
      if ($item['CFG_DCPARAMETRO'] == 'NOME_CONDOMINIO') {
          $nomeCondominio = $item['CFG_DCVALOR']; 
          break; 
      }
    }      
    
    $prestadoresAll = $siteAdmin->getAllPrestadores();
    
    $VIDRAÇARIA = $siteAdmin->getAvaliacoesByCategoria("VIDRACARIA");
    $ACADEMIA = $siteAdmin->getAvaliacoesByCategoria("ACADEMIA");
    $FASTFOOD = $siteAdmin->getAvaliacoesByCategoria("FASTFOOD");
    $PEDREIRO = $siteAdmin->getAvaliacoesByCategoria("PEDREIRO");
    $GESSO = $siteAdmin->getAvaliacoesByCategoria("GESSO");
    $PISO = $siteAdmin->getAvaliacoesByCategoria("PISO");
    $PIZZARIA = $siteAdmin->getAvaliacoesByCategoria("PIZZARIA");
    $MECANICA = $siteAdmin->getAvaliacoesByCategoria("MECANICA");
    $MARIDO = $siteAdmin->getAvaliacoesByCategoria("MARIDO");
    $OUTROS = $siteAdmin->getAvaliacoesByCategoria("OUTROS");
    $ELETRICISTA = $siteAdmin->getAvaliacoesByCategoria("ELETRICISTA");
    $AR_CONDICIONADO = $siteAdmin->getAvaliacoesByCategoria("ARCONDICIONADO");
    $MOVEIS_PLANEJADOS = $siteAdmin->getAvaliacoesByCategoria("MOVEIS_PLANEJADOS");
    $MATCONSTRUCAO = $siteAdmin->getAvaliacoesByCategoria("MATCONSTRUCAO");
    $BAR = $siteAdmin->getAvaliacoesByCategoria("BAR");
    $PRO = $siteAdmin->getAvaliacoesByCategoria("PRO");
    $SEMIPRO = $siteAdmin->getAvaliacoesByCategoria("SEMIPRO");

?>

<!DOCTYPE html>
<html lang="en" data-topbar-color="dark" data-menu-color="dark" data-sidenav-user="true" data-bs-theme="dark">
<head>
    <!-- HEAD META BASIC LOAD-->
	<?php include '../../src/headMeta.php'; ?>
	<!-- HEAD META BASIC LOAD -->

     <!-- Datatables css -->
    <link href="../../assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />

    <!-- Theme Config Js -->
    <script src="../../assets/js/hyper-config.js"></script>

    <!-- Vendor css -->
    <link href="../../assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="../../assets/css/app-modern.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <!-- SWEETALERT 2 --> 
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- ######################################################## -->
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- PWA MOBILE CONF -->
	<?php include '../../src/pwa_conf.php'; ?>
	<!-- PWA MOBILE CONF -->     

</head>
<style>
    @media (max-width: 768px) {
        .rateit-mdi {
            font-size: 15px; /* Diminui o tamanho do ícone */
            margin-left: auto; /* Ajusta o alinhamento se necessário */
        }
    }
</style>
<style>.accordion-button::after {display: none !important;}</style>
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
                                <!-- Alinhamento flexbox para título e botões -->
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                                    <h4 class="page-title mb-3 mb-md-0"><?php echo $translations['parceiro_beneficios']; ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title --> 

                    <!-- start page promotion Full 800x120 PREMIUM row -->
                    <?php if (isset($PRO[0]['PDS_DCIMGFILENAME'])): ?>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body" style="padding: 0; margin: 0;">                                    
                                    <div onclick="window.open('<?php echo $PRO[0]['PDS_DCURL']; ?>', '_blank');" style="display: flex; align-items: center; justify-content: center; background-color: <?php echo $PRO[0]['PDS_DCHEXCOLORBG']; ?>; width: 100%; height: 100%; padding: 0; margin: 0;">
                                        <img src="../../publicidade/<?php echo $PRO[0]['PDS_DCIMGFILENAME']; ?>" style="width: 100%; height: auto; display: block; padding: 0; margin: 0; border: none;">
                                    </div>   
                                </div> <!-- end card-body-->  
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>
                    <?php endif; ?>
                    <!-- end page promotion Full row -->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">                                    
                                    <h4 class="header-title" id="toggleAcademia" style="display: flex; align-items: center; cursor: pointer;"><i class="ri-heart-pulse-line ri-2x" style="color: #aa2ed8; margin-right: 8px;"></i>Academias</h4>
                                    <p class="text-muted font-14 mb-3"></p>
                                    <div class="tab-content">
                                    <div class="col-sm-5"  style="margin-bottom: 20px;">
                                    </div>
                                        <div class="tab-pane show active" style="display: none;" id="AcademiaContent"> <!-- id="default-accordions-preview" Display none q esta dando problema nas estrelas --> 
                                            <div class="accordion" id="accordionExample">
                                                <?php $aux = 0 ?>
                                                <?php foreach ($ACADEMIA as $item): 
                                                    $idPrestador = $item['PDS_IDPRESTADOR_SERVICO'];                                                       
                                                ?>
                                                <div class="accordion-item">                                                    
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" onclick="window.open('<?php echo $item['PDS_DCURL']; ?>', '_blank');" type="button" data-bs-toggle="collapse" data-bs-target="#academia<?php echo $aux; ?>" aria-expanded="true" aria-controls="collapse<?php echo $aux; ?>" style="display: flex; justify-content: space-between; align-items: center; text-align: left; width: 100%; padding: 0; min-height: 20%; margin-bottom: 5px; margin-bottom: 5px;">    
                                                            <div style="flex: 1; display: flex; align-items: center; justify-content: center; background-color: <?php echo $item['PDS_DCHEXCOLORBG']; ?>;">
                                                                <img src="../../publicidade/<?php echo $item['PDS_DCIMGFILENAME']; ?>"  
                                                                style="max-width: 100%; height: auto; display: block;">
                                                            </div>                                                                                                
                                                        </button>                                                        
                                                    </h2>
                                                </div>
                                                <?php $aux++; ?>
                                            <?php endforeach; ?>
                                            </div>
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title" id="toggleFastfood" style="display: flex; align-items: center; cursor: pointer;"><i class="ri-takeaway-line ri-2x" style="color: #aa2ed8; margin-right: 8px;"></i>Fast Food</h4>
                                    <p class="text-muted font-14 mb-3"></p>
                                    <div class="tab-content">
                                    <div class="col-sm-5"  style="margin-bottom: 20px;">
                                    </div>
                                    <div class="tab-pane show active" style="display: none;" id="fastfoodContent">
                                            <div class="accordion" id="accordionExample">
                                                <?php $aux = 0 ?>
                                                <?php foreach ($FASTFOOD as $item): 
                                                    $idPrestador = $item['PDS_IDPRESTADOR_SERVICO'];
                                                ?>
                                                <div class="accordion-item">                                                    
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" onclick="window.open('<?php echo $item['PDS_DCURL']; ?>', '_blank');" type="button" data-bs-toggle="collapse" data-bs-target="#fastfood<?php echo $aux; ?>" aria-expanded="true" aria-controls="collapse<?php echo $aux; ?>" style="display: flex; justify-content: space-between; align-items: center; text-align: left; width: 100%; padding: 0; min-height: 20%; margin-bottom: 5px;">    
                                                            <div style="flex: 1; display: flex; align-items: center; justify-content: center; background-color: <?php echo $item['PDS_DCHEXCOLORBG']; ?>;">
                                                                <img src="../../publicidade/<?php echo $item['PDS_DCIMGFILENAME']; ?>"  
                                                                style="max-width: 100%; height: auto; display: block;">
                                                            </div>                                                                                                
                                                        </button>
                                                    </h2>
                                                </div>
                                                <?php $aux++; ?>
                                            <?php endforeach; ?>
                                            </div>
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->


                    </div>
                    <!-- end row-->
                    
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">                                    
                                    <h4 class="header-title" id="toggleVidraca" style="display: flex; align-items: center; cursor: pointer;"><i class="ri-window-line ri-2x" style="color: #aa2ed8; margin-right: 8px;"></i>Vidraçarias</h4>
                                    <p class="text-muted font-14 mb-3"></p>
                                    <div class="tab-content">
                                    <div class="col-sm-5"  style="margin-bottom: 20px;">
                                    </div>
                                        <div class="tab-pane show active" style="display: none;" id="vidracaContent"> <!-- id="default-accordions-preview" Display none q esta dando problema nas estrelas --> 
                                            <div class="accordion" id="accordionExample">
                                                <?php $aux = 0 ?>
                                                <?php foreach ($VIDRAÇARIA as $item): 
                                                    $idPrestador = $item['PDS_IDPRESTADOR_SERVICO'];                                                       
                                                ?>
                                                <div class="accordion-item">                                                    
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" onclick="window.open('<?php echo $item['PDS_DCURL']; ?>', '_blank');" type="button" data-bs-toggle="collapse" data-bs-target="#vidracaria<?php echo $aux; ?>" aria-expanded="true" aria-controls="collapse<?php echo $aux; ?>" style="display: flex; justify-content: space-between; align-items: center; text-align: left; width: 100%; padding: 0; min-height: 20%; margin-bottom: 5px;">    
                                                            <div style="flex: 1; display: flex; align-items: center; justify-content: center; background-color: <?php echo $item['PDS_DCHEXCOLORBG']; ?>;">
                                                                <img src="../../publicidade/<?php echo $item['PDS_DCIMGFILENAME']; ?>"  
                                                                style="max-width: 100%; height: auto; display: block;">
                                                            </div>                                                                                                
                                                        </button>
                                                    </h2>
                                                </div>
                                                <?php $aux++; ?>
                                            <?php endforeach; ?>
                                            </div>
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title" id="togglePedreiro" style="display: flex; align-items: center; cursor: pointer;"><i class="ri-tools-line ri-2x" style="color: #aa2ed8; margin-right: 8px;"></i>Material de Construção</h4>
                                    <p class="text-muted font-14 mb-3"></p>
                                    <div class="tab-content">
                                    <div class="col-sm-5"  style="margin-bottom: 20px;">
                                    </div>
                                    <div class="tab-pane show active" style="display: none;" id="pedreiroContent">
                                            <div class="accordion" id="accordionExample">
                                                <?php $aux = 0 ?>
                                                <?php foreach ($MATCONSTRUCAO as $item): 
                                                    $idPrestador = $item['PDS_IDPRESTADOR_SERVICO'];
                                                ?>
                                                <div class="accordion-item">                                                    
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" onclick="window.open('<?php echo $item['PDS_DCURL']; ?>', '_blank');" type="button" data-bs-toggle="collapse" data-bs-target="#pedreiro<?php echo $aux; ?>" aria-expanded="true" aria-controls="collapse<?php echo $aux; ?>" style="display: flex; justify-content: space-between; align-items: center; text-align: left; width: 100%; padding: 0; min-height: 20%; margin-bottom: 5px;">    
                                                            <div style="flex: 1; display: flex; align-items: center; justify-content: center; background-color: <?php echo $item['PDS_DCHEXCOLORBG']; ?>;">
                                                                <img src="../../publicidade/<?php echo $item['PDS_DCIMGFILENAME']; ?>"  
                                                                style="max-width: 100%; height: auto; display: block;">
                                                            </div>                                                                                                
                                                        </button>
                                                    </h2>
                                                </div>
                                                <?php $aux++; ?>
                                            <?php endforeach; ?>
                                            </div>
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->


                    </div>
                    <!-- end row-->
                                        
                    <!-- start page promotion Full 800x80 PREMIUM row -->
                    <?php if (isset($SEMIPRO[0]['PDS_DCIMGFILENAME'])): ?>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body" style="padding: 0; margin: 0;">                                    
                                    <div onclick="window.open('<?php echo $SEMIPRO[0]['PDS_DCURL']; ?>', '_blank');" style="display: flex; align-items: center; justify-content: center; background-color: <?php echo $SEMIPRO[0]['PDS_DCHEXCOLORBG']; ?>; width: 100%; height: 100%; padding: 0; margin: 0;">
                                        <img src="../../publicidade/<?php echo $SEMIPRO[0]['PDS_DCIMGFILENAME']; ?>" style="width: 100%; height: auto; display: block; padding: 0; margin: 0; border: none;">
                                    </div>   
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>
                    <?php endif; ?>
                    <!-- end page promotion Full row -->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">                                    
                                    <h4 class="header-title" id="toggleGesso" style="display: flex; align-items: center; cursor: pointer;"><i class="ri-brush-line ri-2x" style="color: #aa2ed8; margin-right: 8px;"></i>Trabalhos com Gesso / Pintura</h4>
                                    <p class="text-muted font-14 mb-3"></p>
                                    <div class="tab-content">
                                    <div class="col-sm-5"  style="margin-bottom: 20px;">
                                    </div>
                                        <div class="tab-pane show active" style="display: none;" id="empresaContent">
                                            <div class="accordion" id="accordionExample">
                                                <?php $aux = 0 ?>
                                                <?php foreach ($GESSO as $item): 
                                                    $idPrestador = $item['PDS_IDPRESTADOR_SERVICO'];                                                       
                                                ?>
                                                <div class="accordion-item">                                                    
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" onclick="window.open('<?php echo $item['PDS_DCURL']; ?>', '_blank');" type="button" data-bs-toggle="collapse" data-bs-target="#gesso<?php echo $aux; ?>" aria-expanded="true" aria-controls="collapse<?php echo $aux; ?>" style="display: flex; justify-content: space-between; align-items: center; text-align: left; width: 100%; padding: 0; min-height: 20%; margin-bottom: 5px;">    
                                                            <div style="flex: 1; display: flex; align-items: center; justify-content: center; background-color: <?php echo $item['PDS_DCHEXCOLORBG']; ?>;">
                                                                <img src="../../publicidade/<?php echo $item['PDS_DCIMGFILENAME']; ?>"  
                                                                style="max-width: 100%; height: auto; display: block;">
                                                            </div>                                                                                                
                                                        </button>
                                                    </h2>
                                                </div>
                                                <?php $aux++; ?>
                                            <?php endforeach; ?>
                                            </div>
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <!-- Script para alternar a visibilidade -->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title" id="togglePiso" style="display: flex; align-items: center; cursor: pointer;"><i class="ri-grid-fill ri-2x" style="color: #aa2ed8; margin-right: 8px;"></i>Pisos / Laminados</h4>
                                    <p class="text-muted font-14 mb-3"></p>
                                    <div class="tab-content">
                                    <div class="col-sm-5"  style="margin-bottom: 20px;">
                                    </div>
                                    <div class="tab-pane show active" style="display: none;" id="pisoContent">
                                            <div class="accordion" id="accordionExample">
                                                <?php $aux = 0 ?>
                                                <?php foreach ($PISO as $item): 
                                                    $idPrestador = $item['PDS_IDPRESTADOR_SERVICO'];
                                                ?>
                                                <div class="accordion-item">                                                    
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" onclick="window.open('<?php echo $item['PDS_DCURL']; ?>', '_blank');" type="button" data-bs-toggle="collapse" data-bs-target="#piso<?php echo $aux; ?>" aria-expanded="true" aria-controls="collapse<?php echo $aux; ?>" style="display: flex; justify-content: space-between; align-items: center; text-align: left; width: 100%; padding: 0; min-height: 20%; margin-bottom: 5px;">    
                                                            <div style="flex: 1; display: flex; align-items: center; justify-content: center; background-color: <?php echo $item['PDS_DCHEXCOLORBG']; ?>;">
                                                                <img src="../../publicidade/<?php echo $item['PDS_DCIMGFILENAME']; ?>"  
                                                                style="max-width: 100%; height: auto; display: block;">
                                                            </div>                                                                                                
                                                        </button>
                                                    </h2>
                                                </div>
                                                <?php $aux++; ?>
                                            <?php endforeach; ?>
                                            </div>
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->


                    </div>
                    <!-- end row-->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">                                    
                                    <h4 class="header-title" id="togglePizzaria" style="display: flex; align-items: center; cursor: pointer;"><i class="ri-restaurant-2-line ri-2x" style="color: #aa2ed8; margin-right: 8px;"></i>Pizzarias / Restaurantes / Padarias</h4>
                                    <p class="text-muted font-14 mb-3"></p>
                                    <div class="tab-content">
                                    <div class="col-sm-5"  style="margin-bottom: 20px;">
                                    </div>
                                        <div class="tab-pane show active" style="display: none;" id="pizzariaContent">
                                            <div class="accordion" id="accordionExample">
                                                <?php $aux = 0 ?>
                                                <?php foreach ($PIZZARIA as $item): 
                                                    $idPrestador = $item['PDS_IDPRESTADOR_SERVICO'];                                                        
                                                ?>
                                                <div class="accordion-item">                                                    
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" onclick="window.open('<?php echo $item['PDS_DCURL']; ?>', '_blank');" type="button" data-bs-toggle="collapse" data-bs-target="#pizzaria<?php echo $aux; ?>" aria-expanded="true" aria-controls="collapse<?php echo $aux; ?>" style="display: flex; justify-content: space-between; align-items: center; text-align: left; width: 100%; padding: 0; min-height: 20%; margin-bottom: 5px;">    
                                                            <div style="flex: 1; display: flex; align-items: center; justify-content: center; background-color: <?php echo $item['PDS_DCHEXCOLORBG']; ?>;">
                                                                <img src="../../publicidade/<?php echo $item['PDS_DCIMGFILENAME']; ?>"  
                                                                style="max-width: 100%; height: auto; display: block;">
                                                            </div>                                                                                                
                                                        </button>
                                                    </h2>
                                                </div>
                                                <?php $aux++; ?>
                                            <?php endforeach; ?>
                                            </div>
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title" id="toggleMecanica" style="display: flex; align-items: center; cursor: pointer;"><i class="ri-car-line ri-2x" style="color: #aa2ed8; margin-right: 8px;"></i>Mecânica / Lava-rápido</h4>
                                    <p class="text-muted font-14 mb-3"></p>
                                    <div class="tab-content">
                                    <div class="col-sm-5"  style="margin-bottom: 20px;">
                                    </div>
                                    <div class="tab-pane show active" style="display: none;" id="mecanicaContent">
                                            <div class="accordion" id="accordionExample">
                                                <?php $aux = 0 ?>
                                                <?php foreach ($MECANICA as $item): 
                                                    $idPrestador = $item['PDS_IDPRESTADOR_SERVICO'];
                                                ?>
                                                <div class="accordion-item">                                                    
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" onclick="window.open('<?php echo $item['PDS_DCURL']; ?>', '_blank');" type="button" data-bs-toggle="collapse" data-bs-target="#mecanica<?php echo $aux; ?>" aria-expanded="true" aria-controls="collapse<?php echo $aux; ?>" style="display: flex; justify-content: space-between; align-items: center; text-align: left; width: 100%; padding: 0; min-height: 20%; margin-bottom: 5px;">    
                                                            <div style="flex: 1; display: flex; align-items: center; justify-content: center; background-color: <?php echo $item['PDS_DCHEXCOLORBG']; ?>;">
                                                                <img src="../../publicidade/<?php echo $item['PDS_DCIMGFILENAME']; ?>"  
                                                                style="max-width: 100%; height: auto; display: block;">
                                                            </div>                                                                                                
                                                        </button>
                                                    </h2>
                                                </div>
                                                <?php $aux++; ?>
                                            <?php endforeach; ?>
                                            </div>
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->


                    </div>
                    <!-- end row-->
                                      
                    <!-- start page promotion Full 800x80 PREMIUM row -->
                    <?php if (isset($SEMIPRO[1]['PDS_DCIMGFILENAME'])): ?>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body" style="padding: 0; margin: 0;">                                    
                                    <div onclick="window.open('<?php echo $SEMIPRO[1]['PDS_DCURL']; ?>', '_blank');" style="display: flex; align-items: center; justify-content: center; background-color: <?php echo $SEMIPRO[1]['PDS_DCHEXCOLORBG']; ?>; width: 100%; height: 100%; padding: 0; margin: 0;">
                                        <img src="../../publicidade/<?php echo $SEMIPRO[1]['PDS_DCIMGFILENAME']; ?>" style="width: 100%; height: auto; display: block; padding: 0; margin: 0; border: none;">
                                    </div>  
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>
                    <?php endif; ?>
                    <!-- end page promotion Full row -->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">                                    
                                    <h4 class="header-title" id="toggleEletricista" style="display: flex; align-items: center; cursor: pointer;"><i class="ri-flashlight-line ri-2x" style="color: #aa2ed8; margin-right: 8px;"></i>Eletricista</h4>
                                    <p class="text-muted font-14 mb-3"></p>
                                    <div class="tab-content">
                                    <div class="col-sm-5"  style="margin-bottom: 20px;">
                                    </div>
                                        <div class="tab-pane show active" style="display: none;" id="eletricistaContent">
                                            <div class="accordion" id="accordionExample">
                                                <?php $aux = 0 ?>
                                                <?php foreach ($ELETRICISTA as $item): 
                                                    $idPrestador = $item['PDS_IDPRESTADOR_SERVICO'];                                                       
                                                ?>
                                                <div class="accordion-item">                                                    
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" onclick="window.open('<?php echo $item['PDS_DCURL']; ?>', '_blank');" type="button" data-bs-toggle="collapse" data-bs-target="#eletricista<?php echo $aux; ?>" aria-expanded="true" aria-controls="collapse<?php echo $aux; ?>" style="display: flex; justify-content: space-between; align-items: center; text-align: left; width: 100%; padding: 0; min-height: 20%; margin-bottom: 5px;">    
                                                            <div style="flex: 1; display: flex; align-items: center; justify-content: center; background-color: <?php echo $item['PDS_DCHEXCOLORBG']; ?>;">
                                                                <img src="../../publicidade/<?php echo $item['PDS_DCIMGFILENAME']; ?>"  
                                                                style="max-width: 100%; height: auto; display: block;">
                                                            </div>                                                                                                
                                                        </button>
                                                    </h2>
                                                </div>
                                                <?php $aux++; ?>
                                            <?php endforeach; ?>
                                            </div>
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title" id="toggleAr" style="display: flex; align-items: center; cursor: pointer;"><i class="ri-windy-line ri-2x" style="color: #aa2ed8; margin-right: 8px;"></i>Ar Condicionado</h4>
                                    <p class="text-muted font-14 mb-3"></p>
                                    <div class="tab-content">
                                    <div class="col-sm-5"  style="margin-bottom: 20px;">
                                    </div>
                                    <div class="tab-pane show active" style="display: none;" id="arContent">
                                            <div class="accordion" id="accordionExample">
                                                <?php $aux = 0 ?>
                                                <?php foreach ($AR_CONDICIONADO as $item): 
                                                    $idPrestador = $item['PDS_IDPRESTADOR_SERVICO'];
                                                ?>
                                                <div class="accordion-item">                                                    
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" onclick="window.open('<?php echo $item['PDS_DCURL']; ?>', '_blank');" type="button" data-bs-toggle="collapse" data-bs-target="#ar<?php echo $aux; ?>" aria-expanded="true" aria-controls="collapse<?php echo $aux; ?>" style="display: flex; justify-content: space-between; align-items: center; text-align: left; width: 100%; padding: 0; min-height: 20%; margin-bottom: 5px;">    
                                                            <div style="flex: 1; display: flex; align-items: center; justify-content: center; background-color: <?php echo $item['PDS_DCHEXCOLORBG']; ?>;">
                                                                <img src="../../publicidade/<?php echo $item['PDS_DCIMGFILENAME']; ?>"  
                                                                style="max-width: 100%; height: auto; display: block;">
                                                            </div>                                                                                                
                                                        </button>
                                                    </h2>
                                                </div>
                                                <?php $aux++; ?>
                                            <?php endforeach; ?>
                                            </div>
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->


                    </div>
                    <!-- end row-->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">                                    
                                    <h4 class="header-title" id="toggleMoveis" style="display: flex; align-items: center; cursor: pointer;"><i class="ri-layout-2-line ri-2x" style="color: #aa2ed8; margin-right: 8px;"></i>Móveis Planejados / Marceneiro</h4>
                                    <p class="text-muted font-14 mb-3"></p>
                                    <div class="tab-content">
                                    <div class="col-sm-5"  style="margin-bottom: 20px;">
                                    </div>
                                        <div class="tab-pane show active" style="display: none;" id="moveisContent">
                                            <div class="accordion" id="accordionExample">
                                                <?php $aux = 0 ?>
                                                <?php foreach ($MOVEIS_PLANEJADOS as $item): 
                                                    $idPrestador = $item['PDS_IDPRESTADOR_SERVICO'];                                                      
                                                ?>
                                                <div class="accordion-item">                                                    
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" onclick="window.open('<?php echo $item['PDS_DCURL']; ?>', '_blank');" type="button" data-bs-toggle="collapse" data-bs-target="#moveis<?php echo $aux; ?>" aria-expanded="true" aria-controls="collapse<?php echo $aux; ?>" style="display: flex; justify-content: space-between; align-items: center; text-align: left; width: 100%; padding: 0; min-height: 20%; margin-bottom: 5px;">    
                                                            <div style="flex: 1; display: flex; align-items: center; justify-content: center; background-color: <?php echo $item['PDS_DCHEXCOLORBG']; ?>;">
                                                                <img src="../../publicidade/<?php echo $item['PDS_DCIMGFILENAME']; ?>"  
                                                                style="max-width: 100%; height: auto; display: block;">
                                                            </div>                                                                                                
                                                        </button>
                                                    </h2>
                                                </div>
                                                <?php $aux++; ?>
                                            <?php endforeach; ?>
                                            </div>
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title" id="toggleBar" style="display: flex; align-items: center; cursor: pointer;"><i class="ri-stack-line ri-2x" style="color: #aa2ed8; margin-right: 8px;"></i>Bar / Pub</h4>
                                    <p class="text-muted font-14 mb-3"></p>
                                    <div class="tab-content">
                                    <div class="col-sm-5"  style="margin-bottom: 20px;">
                                    </div>
                                    <div class="tab-pane show active" style="display: none;" id="barContent">
                                            <div class="accordion" id="accordionExample">
                                                <?php $aux = 0 ?>
                                                <?php foreach ($BAR as $item): 
                                                    $idPrestador = $item['PDS_IDPRESTADOR_SERVICO'];
                                                ?>
                                                <div class="accordion-item">                                                    
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" onclick="window.open('<?php echo $item['PDS_DCURL']; ?>', '_blank');" type="button" data-bs-toggle="collapse" data-bs-target="#bar<?php echo $aux; ?>" aria-expanded="true" aria-controls="collapse<?php echo $aux; ?>" style="display: flex; justify-content: space-between; align-items: center; text-align: left; width: 100%; padding: 0; min-height: 20%; margin-bottom: 5px;">    
                                                            <div style="flex: 1; display: flex; align-items: center; justify-content: center; background-color: <?php echo $item['PDS_DCHEXCOLORBG']; ?>;">
                                                                <img src="../../publicidade/<?php echo $item['PDS_DCIMGFILENAME']; ?>"  
                                                                style="max-width: 100%; height: auto; display: block;">
                                                            </div>                                                                                                
                                                        </button>
                                                    </h2>
                                                </div>
                                                <?php $aux++; ?>
                                            <?php endforeach; ?>
                                            </div>
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->


                    </div>
                    <!-- end row-->
                                      
                    <!-- start page promotion Full 800x80 PREMIUM row -->
                    
                    <?php if (isset($SEMIPRO[2]['PDS_DCIMGFILENAME'])): ?>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body" style="padding: 0; margin: 0;">                                    
                                    <div onclick="window.open('<?php echo $SEMIPRO[2]['PDS_DCURL']; ?>', '_blank');" style="display: flex; align-items: center; justify-content: center; background-color: <?php echo $SEMIPRO[2]['PDS_DCHEXCOLORBG']; ?>; width: 100%; height: 100%; padding: 0; margin: 0;">
                                        <img src="../../publicidade/<?php echo $SEMIPRO[2]['PDS_DCIMGFILENAME']; ?>" style="width: 100%; height: auto; display: block; padding: 0; margin: 0; border: none;">
                                    </div>  
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>
                    <?php endif; ?>
                    <!-- end page promotion Full row -->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">                                    
                                    <h4 class="header-title" id="toggleMarido" style="display: flex; align-items: center; cursor: pointer;"><i class="ri-settings-2-line ri-2x" style="color: #aa2ed8; margin-right: 8px;"></i>Marido de Aluguel</h4>
                                    <p class="text-muted font-14 mb-3"></p>
                                    <div class="tab-content">
                                    <div class="col-sm-5"  style="margin-bottom: 20px;">
                                    </div>
                                        <div class="tab-pane show active" style="display: none;" id="maridoContent">
                                            <div class="accordion" id="accordionExample">
                                                <?php $aux = 0 ?>
                                                <?php foreach ($MARIDO as $item): 
                                                    $idPrestador = $item['PDS_IDPRESTADOR_SERVICO'];                                                        
                                                ?>
                                                <div class="accordion-item">                                                    
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" onclick="window.open('<?php echo $item['PDS_DCURL']; ?>', '_blank');" type="button" data-bs-toggle="collapse" data-bs-target="#marido<?php echo $aux; ?>" aria-expanded="true" aria-controls="collapse<?php echo $aux; ?>" style="display: flex; justify-content: space-between; align-items: center; text-align: left; width: 100%; padding: 0; min-height: 20%; margin-bottom: 5px;">    
                                                            <div style="flex: 1; display: flex; align-items: center; justify-content: center; background-color: <?php echo $item['PDS_DCHEXCOLORBG']; ?>;">
                                                                <img src="../../publicidade/<?php echo $item['PDS_DCIMGFILENAME']; ?>"  
                                                                style="max-width: 100%; height: auto; display: block;">
                                                            </div>                                                                                                
                                                        </button>
                                                    </h2>
                                                </div>
                                                <?php $aux++; ?>
                                            <?php endforeach; ?>
                                            </div>
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title" id="toggleOutros" style="display: flex; align-items: center; cursor: pointer;"><i class="ri-stack-line ri-2x" style="color: #aa2ed8; margin-right: 8px;"></i>Outros Serviços</h4>
                                    <p class="text-muted font-14 mb-3"></p>
                                    <div class="tab-content">
                                    <div class="col-sm-5"  style="margin-bottom: 20px;">
                                    </div>
                                    <div class="tab-pane show active" style="display: none;" id="outrosContent">
                                            <div class="accordion" id="accordionExample">
                                                <?php $aux = 0 ?>
                                                <?php foreach ($OUTROS as $item): 
                                                    $idPrestador = $item['PDS_IDPRESTADOR_SERVICO'];
                                                ?>
                                                <div class="accordion-item">                                                    
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" onclick="window.open('<?php echo $item['PDS_DCURL']; ?>', '_blank');" type="button" data-bs-toggle="collapse" data-bs-target="#outros<?php echo $aux; ?>" aria-expanded="true" aria-controls="collapse<?php echo $aux; ?>" style="display: flex; justify-content: space-between; align-items: center; text-align: left; width: 100%; padding: 0; min-height: 20%; margin-bottom: 5px;">    
                                                            <div style="flex: 1; display: flex; align-items: center; justify-content: center; background-color: <?php echo $item['PDS_DCHEXCOLORBG']; ?>;">
                                                                <img src="../../publicidade/<?php echo $item['PDS_DCIMGFILENAME']; ?>"  
                                                                style="max-width: 100%; height: auto; display: block;">
                                                            </div>                                                                                                
                                                        </button>
                                                    </h2>
                                                </div>
                                                <?php $aux++; ?>
                                            <?php endforeach; ?>
                                            </div>
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->


                    </div>
                    <!-- end row-->
                                
                </div><!-- FIM CONTEUDO CONTAINER -->                

            <!-- content -->
        <!-- FOOTER -->
	    <?php include '../../src/modalTermos.php'; ?>
	    <!-- FOOTER -->   
        <!-- FOOTER -->
	    <?php include '../../src/footerNav.php'; ?>
	    <!-- FOOTER --> 
       

    </div><!-- END wrapper -->

    <div id="cadastrar-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="text-center mt-2 mb-4">
                        <a href="index.html" class="text-success">
                            <span><img src="../../img/logo_128x32_white.png" alt="" height="40"></span>
                        </a>
                    </div>

                    <form class="ps-3 pe-3" id="formInsert" name="form" role="formInsert" method="POST" enctype="multipart/form-data" novalidate> 

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome do Prestador de Serviço</label>
                            <input class="form-control" maxlength="20" minlength="3" type="text" name="nome" id="nome" required="" placeholder="" pattern="[A-Za-z0-9]+" style="text-transform: uppercase;">
                        </div>

                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoria</label>
                            <select class="form-control" name="categoria" id="categoria" required>
                                    <option value="" disabled selected>Selecione uma Categoria</option>
                                    <option value="ARCONDICIONADO">AR CONDICIONADO</option>
                                    <option value="BAR">BAR / PUB</option>
                                    <option value="ELETRICISTA">ELETRICISTA</option>                                         
                                    <option value="GESSO">TRABALHOS COM GESSO E PINTURA</option>
                                    <option value="MECANICA">MECÂNICA / LAVA-RÁPIDO</option>
                                    <option value="MARIDO">MARIDO DE ALUGUEL</option>
                                    <option value="MOVEIS_PLANEJADOS">MÓVEIS PLANEJADOS / MARCENEIRO</option>
                                    <option value="PEDREIRO">PEDREIRO</option>
                                    <option value="PISO">PISOS / LAMINADOS</option>
                                    <option value="PIZZARIA">PIZZARIAS / RESTAURANTES / PADARIAS</option>
                                    <option value="VIDRACARIA">VIDRAÇARIA</option>
                                    <option value="OUTROS">OUTROS SERVIÇOS</option>                                         
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone (DDD+Telefone)</label>
                            <input class="form-control" type="text" name="telefone" id="telefone" maxlength="11" required="" placeholder="" pattern="\d{11}" oninput="this.value = this.value.replace(/\D/g, '')">
                        </div>

                        <div class="mb-3">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input class="form-control" type="text" name="cidade" id="cidade" minlength="3" maxlength="15" required="" placeholder="" style="text-transform: uppercase;">
                        </div>

                        <div class="mb-3 text-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>           
                            <button class="btn btn-primary" type="button" id="botaoInsert" name="botaoInsert">Cadastrar</button>
                        </div>

                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="avaliar-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                                                                    
                <div class="modal-body">
                    <div class="text-center mt-2 mb-4">
                        <a href="index.html" class="text-success">
                            <span><img src="../../img/logo_128x32_white.png" alt="" height="40"></span>
                        </a>
                    </div>
                                                                    
                    <form class="ps-3 pe-3" id="form" name="form" role="form" method="POST" enctype="multipart/form-data" novalidate>                                      
                        
                        <!-- CAMPOS COMO VARIAVEIS -->
                        <input type="hidden" id="idmorador" name="idmorador" value="<?php echo $userid; ?>"/>
                        <!-- CAMPOS COMO VARIAVEIS -->

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome do Prestador de Serviço</label>
                            <select class="form-control" name="idprestador" id="idprestador" required>
                                <option value="" disabled selected>Selecione um Prestador</option>
                                <?php foreach ($prestadoresAll as $item): ?>
                                    <option value="<?php echo htmlspecialchars($item['PDS_IDPRESTADOR_SERVICO']); ?>">
                                        <?php echo htmlspecialchars($item['PDS_DCNOME'] . " - " . $item['PDS_DCCATEGORIA']); ?>
                                    </option>
                                <?php endforeach; ?> 
                            </select>
                        </div>
                                                                    
                        <div class="mb-3">
                            <label for="nota" class="form-label">Nota</label>
                            <input type="text" id="nota" name="nota" data-plugin="range-slider" data-type="single" data-grid="true" data-min="1" data-max="5" data-from="0" /> </div>                                                                   
                        
                        <div class="mb-3">
                            <label for="comentario" class="form-label">Comentário (opcional)</label>
                            <textarea class="form-control" name="comentario" id="comentario" placeholder="Digite seu comentário (máximo 300 caracteres)" rows="5" oninput="limitCharacters(this, 300)"></textarea>
                                <script>
                                function limitCharacters(textarea, maxLength) {
                                    if (textarea.value.length > maxLength) {
                                        textarea.value = textarea.value.substring(0, maxLength);
                                    }
                                }
                                </script>
                        </div>
                                                                                                                                       
                        <div class="mb-3 text-center">                            
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>           
                            <button class="btn btn-primary" type="button" id="botao" name="botao">Cadastrar</button>
                        </div>
                                                                    
                    </form>
                                                                    
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

        <!-- ######################################################## --> 
    <!-- SWEETALERT 2 -->   
    <script>
            function validarFormulario1() {
                const telefone = document.querySelector('input[name="telefone"]').value.trim();
                const categoria = document.querySelector('select[name="categoria"]').value.trim();
                const nome = document.querySelector('input[name="nome"]').value.trim();
                const cidade = document.querySelector('input[name="cidade"]').value.trim();

                if (!nome || !telefone || !categoria || !cidade) {
                    alert("Todos os campos devem ser preenchidos.");
                    return false;
                }
                if (telefone.length !== 11) {
                    alert('O número de telefone deve ter exatamente 11 dígitos.');
                    return false;
                }

                return true;              
        }

       function confirmAndSubmitInsert(event) {   
        const isValid = validarFormulario1();
        if (!isValid) {
            return;
        }
          event.preventDefault(); // Impede o envio padrão do formulário
        Swal.fire({
          title: 'Formulário de Avaliação',
          text: "Tem certeza que deseja cadastrar o Prestador de Serviço?",
          showDenyButton: true,
          confirmButtonText: 'CONFIRMAR',
          denyButtonText: `CANCELAR`,
          confirmButtonColor: "#536de6",
          denyButtonColor: "#ff5b5b",
          width: '400px', // Largura do alerta
          icon: 'warning',
          customClass: {
            title: 'swal-title', // Classe para o título
            content: 'swal-content', // Classe para o conteúdo (texto)
            confirmButton: 'swal-confirm-btn',
            denyButton: 'swal-deny-btn',
            htmlContainer: 'swal-text'
          }
        }).then((result) => {
          if (result.isConfirmed) {
            // Capturar os dados do formulário
            var formData = new FormData($("#formInsert")[0]); // Usa o FormData para enviar arquivos
            // Fazer a requisição AJAX
            $.ajax({
              url: "insertEmpresaProc.php", // URL para processamento 
              type: "POST",
              data: formData,
              processData: false, // Impede o jQuery de processar os dados
              contentType: false, // Impede o jQuery de definir o tipo de conteúdo
              success: function (response) {
                Swal.fire({
              title: 'Atenção',
              text: `${response}`,
              icon: 'success',
              width: '400px', // Largura do alerta
              confirmButtonColor: "#536de6",
              customClass: {
                title: 'swal-title', // Aplicando a mesma classe do título
                content: 'swal-content', // Aplicando a mesma classe do texto
                htmlContainer: 'swal-text',
                confirmButton: 'swal-confirm-btn'
              }
            }).then(() => {
                  // Redirecionar ou atualizar a página, se necessário
                   window.location.href = "index.php";
                });
              },
              error: function (xhr, status, error) {
                Swal.fire({
              title: 'Erro!',
              text: 'Erro ao atualizar o convidado.'.error,
              icon: 'error',
              width: '400px', // Largura do alerta
              confirmButtonColor: "#536de6",
              customClass: {
                title: 'swal-title', // Aplicando a mesma classe do título
                content: 'swal-content', // Aplicando a mesma classe do texto
                htmlContainer: 'swal-text',
                confirmButton: 'swal-confirm-btn'
              }
            });
              },
            });
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire('Cancelado', 'Nenhuma alteração foi salva.', 'info');
          }
        });
      }
      // Associar a função ao botão de submit
      $(document).ready(function () {
        $("#botaoInsert").on("click", confirmAndSubmitInsert);
      });
</script> 
<style>
  /* Estilos para aumentar o tamanho da fonte */
  .swal-title {
    font-size: 25px !important; /* Tamanho maior para o título */
  }

  .swal-text {
    font-size: 16px !important; /* Tamanho maior para o conteúdo */
  }

  /* Aumentar o tamanho dos textos dos botões */
  .swal-confirm-btn,
  .swal-deny-btn,
  .swal-cancel-btn {
    font-size: 16px !important; /* Tamanho maior para os textos dos botões */
    padding: 8px 8px !important; /* Aumenta o espaço ao redor do texto */
  }
</style>
<!-- ######################################################## --> 
<!-- SWEETALERT 2 -->   

    <!-- ######################################################## --> 
    <!-- SWEETALERT 2 -->   
    <script>
        function validarFormulario2() {
            const idprestador = document.querySelector('select[name="idprestador"]').value.trim();
            if (!idprestador) {
                alert("Escolha um prestador de serviços.");
                return false;
            }
            return true;              
        }

       function confirmAndSubmit(event) {   
        const isValid = validarFormulario2();
        if (!isValid) {
            return;
        }
          event.preventDefault(); // Impede o envio padrão do formulário
        Swal.fire({
          title: 'Formulário de Avaliação',
          text: "Tem certeza que deseja avaliar o prestador de serviço selecionado?",
          showDenyButton: true,
          confirmButtonText: 'CONFIRMAR',
          denyButtonText: `CANCELAR`,
          confirmButtonColor: "#536de6",
          denyButtonColor: "#ff5b5b",
          width: '400px', // Largura do alerta
          icon: 'warning',
          customClass: {
            title: 'swal-title', // Classe para o título
            content: 'swal-content', // Classe para o conteúdo (texto)
            confirmButton: 'swal-confirm-btn',
            denyButton: 'swal-deny-btn',
            htmlContainer: 'swal-text'
          }
        }).then((result) => {
          if (result.isConfirmed) {
            // Capturar os dados do formulário
            var formData = new FormData($("#form")[0]); // Usa o FormData para enviar arquivos
            // Fazer a requisição AJAX
            $.ajax({
              url: "insertAvaliacaoProc.php", // URL para processamento 
              type: "POST",
              data: formData,
              processData: false, // Impede o jQuery de processar os dados
              contentType: false, // Impede o jQuery de definir o tipo de conteúdo
              success: function (response) {
                Swal.fire({
              title: 'Atenção',
              text: `${response}`,
              icon: 'success',
              width: '400px', // Largura do alerta
              confirmButtonColor: "#536de6",
              customClass: {
                title: 'swal-title', // Aplicando a mesma classe do título
                content: 'swal-content', // Aplicando a mesma classe do texto
                htmlContainer: 'swal-text',
                confirmButton: 'swal-confirm-btn'
              }
            }).then(() => {
                  // Redirecionar ou atualizar a página, se necessário
                   window.location.href = "index.php";
                });
              },
              error: function (xhr, status, error) {
                Swal.fire({
              title: 'Erro!',
              text: 'Erro ao atualizar o convidado.'.error,
              icon: 'error',
              width: '400px', // Largura do alerta
              confirmButtonColor: "#536de6",
              customClass: {
                title: 'swal-title', // Aplicando a mesma classe do título
                content: 'swal-content', // Aplicando a mesma classe do texto
                htmlContainer: 'swal-text',
                confirmButton: 'swal-confirm-btn'
              }
            });
              },
            });
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire('Cancelado', 'Nenhuma alteração foi salva.', 'info');
          }
        });
      }
      // Associar a função ao botão de submit
      $(document).ready(function () {
        $("#botao").on("click", confirmAndSubmit);
      });
</script> 
<style>
  /* Estilos para aumentar o tamanho da fonte */
  .swal-title {
    font-size: 25px !important; /* Tamanho maior para o título */
  }

  .swal-text {
    font-size: 16px !important; /* Tamanho maior para o conteúdo */
  }

  /* Aumentar o tamanho dos textos dos botões */
  .swal-confirm-btn,
  .swal-deny-btn,
  .swal-cancel-btn {
    font-size: 16px !important; /* Tamanho maior para os textos dos botões */
    padding: 8px 8px !important; /* Aumenta o espaço ao redor do texto */
  }
</style>
<!-- ######################################################## --> 
<!-- SWEETALERT 2 -->   

   <!-- ######################################################## --> 
    <!-- SWEETALERT 2 -->   

    <script>
function confirmDelete(event, id) {
    console.log(id);  // Verifica se o id está correto
    Swal.fire({
        title: 'Formulário de Avaliação',
        text: "Tem certeza que deseja exluir a avaliação?",
        showDenyButton: true,
        confirmButtonText: 'CONFIRMAR',
        denyButtonText: `CANCELAR`,
        confirmButtonColor: "#536de6",
        denyButtonColor: "#ff5b5b",
        width: '400px', // Largura do alerta
        icon: 'warning',
        customClass: {
            title: 'swal-title', // Classe para o título
            content: 'swal-content', // Classe para o conteúdo (texto)
            confirmButton: 'swal-confirm-btn',
            denyButton: 'swal-deny-btn',
            htmlContainer: 'swal-text'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Fazer a requisição AJAX
            $.ajax({
                url: "deleteAvaliacaoProc.php", // URL para processamento
                type: "POST",
                data: { id: id },  // Enviando o ID via POST
                success: function (response) {
                    Swal.fire({
                        title: 'Atenção',
                        text: `${response}`,
                        icon: 'success',
                        width: '400px', // Largura do alerta
                        confirmButtonColor: "#536de6",
                        customClass: {
                            title: 'swal-title', // Aplicando a mesma classe do título
                            content: 'swal-content', // Aplicando a mesma classe do texto
                            htmlContainer: 'swal-text',
                            confirmButton: 'swal-confirm-btn'
                        }
                    }).then(() => {
                        // Redirecionar ou atualizar a página, se necessário
                        window.location.href = "index.php";
                    });
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        title: 'Erro!',
                        text: 'Erro ao excluir a avaliação.',
                        icon: 'error',
                        width: '400px', // Largura do alerta
                        confirmButtonColor: "#536de6",
                        customClass: {
                            title: 'swal-title', // Aplicando a mesma classe do título
                            content: 'swal-content', // Aplicando a mesma classe do texto
                            htmlContainer: 'swal-text',
                            confirmButton: 'swal-confirm-btn'
                        }
                    });
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire('Cancelado', 'Nenhuma alteração foi salva.', 'info');
        }
    });
}

$(document).ready(function () {
    // Não é necessário associar a função ao botão de submit, pois ela já está sendo chamada no clique do ícone.
});
</script>
<style>
  /* Estilos para aumentar o tamanho da fonte */
  .swal-title {
    font-size: 25px !important; /* Tamanho maior para o título */
  }

  .swal-text {
    font-size: 16px !important; /* Tamanho maior para o conteúdo */
  }

  /* Aumentar o tamanho dos textos dos botões */
  .swal-confirm-btn,
  .swal-deny-btn,
  .swal-cancel-btn {
    font-size: 16px !important; /* Tamanho maior para os textos dos botões */
    padding: 8px 8px !important; /* Aumenta o espaço ao redor do texto */
  }
</style>
<!-- ######################################################## --> 
<!-- SWEETALERT 2 -->   

   <!-- ######################################################## --> 
    <!-- SWEETALERT 2 -->   

    <script>
function confirmDeletePrestador(event, id) {
    console.log(id);  // Verifica se o id está correto
    Swal.fire({
        title: 'Formulário de Avaliação',
        text: "Tem certeza que deseja exluir o Prestador de Serviço?",
        showDenyButton: true,
        confirmButtonText: 'CONFIRMAR',
        denyButtonText: `CANCELAR`,
        confirmButtonColor: "#536de6",
        denyButtonColor: "#ff5b5b",
        width: '400px', // Largura do alerta
        icon: 'warning',
        customClass: {
            title: 'swal-title', // Classe para o título
            content: 'swal-content', // Classe para o conteúdo (texto)
            confirmButton: 'swal-confirm-btn',
            denyButton: 'swal-deny-btn',
            htmlContainer: 'swal-text'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Fazer a requisição AJAX
            $.ajax({
                url: "deletePrestadorProc.php", // URL para processamento
                type: "POST",
                data: { id: id },  // Enviando o ID via POST
                success: function (response) {
                    Swal.fire({
                        title: 'Atenção',
                        text: `${response}`,
                        icon: 'success',
                        width: '400px', // Largura do alerta
                        confirmButtonColor: "#536de6",
                        customClass: {
                            title: 'swal-title', // Aplicando a mesma classe do título
                            content: 'swal-content', // Aplicando a mesma classe do texto
                            htmlContainer: 'swal-text',
                            confirmButton: 'swal-confirm-btn'
                        }
                    }).then(() => {
                        // Redirecionar ou atualizar a página, se necessário
                        window.location.href = "index.php";
                    });
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        title: 'Erro!',
                        text: 'Erro ao excluir a avaliação.',
                        icon: 'error',
                        width: '400px', // Largura do alerta
                        confirmButtonColor: "#536de6",
                        customClass: {
                            title: 'swal-title', // Aplicando a mesma classe do título
                            content: 'swal-content', // Aplicando a mesma classe do texto
                            htmlContainer: 'swal-text',
                            confirmButton: 'swal-confirm-btn'
                        }
                    });
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire('Cancelado', 'Nenhuma alteração foi salva.', 'info');
        }
    });
}

$(document).ready(function () {
    // Não é necessário associar a função ao botão de submit, pois ela já está sendo chamada no clique do ícone.
});
</script>
<style>
  /* Estilos para aumentar o tamanho da fonte */
  .swal-title {
    font-size: 25px !important; /* Tamanho maior para o título */
  }

  .swal-text {
    font-size: 16px !important; /* Tamanho maior para o conteúdo */
  }

  /* Aumentar o tamanho dos textos dos botões */
  .swal-confirm-btn,
  .swal-deny-btn,
  .swal-cancel-btn {
    font-size: 16px !important; /* Tamanho maior para os textos dos botões */
    padding: 8px 8px !important; /* Aumenta o espaço ao redor do texto */
  }
</style>
<!-- ######################################################## --> 
<!-- SWEETALERT 2 -->  


<script>
    document.getElementById("toggleGesso").addEventListener("click", function() {
        var content = document.getElementById("empresaContent");
        // Alterna a visibilidade do conteúdo
        if (content.style.display === "none" || content.style.display === "") {
            content.style.display = "block"; // Exibe o conteúdo
        } else {
            content.style.display = "none"; // Oculta o conteúdo
        }
    });

    document.getElementById("toggleFastfood").addEventListener("click", function() {
        var content = document.getElementById("fastfoodContent");
        // Alterna a visibilidade do conteúdo
        if (content.style.display === "none" || content.style.display === "") {
            content.style.display = "block"; // Exibe o conteúdo
        } else {
            content.style.display = "none"; // Oculta o conteúdo
        }
    });

    document.getElementById("toggleAcademia").addEventListener("click", function() {
        var content = document.getElementById("AcademiaContent");
        // Alterna a visibilidade do conteúdo
        if (content.style.display === "none" || content.style.display === "") {
            content.style.display = "block"; // Exibe o conteúdo
        } else {
            content.style.display = "none"; // Oculta o conteúdo
        }
    });

    document.getElementById("toggleVidraca").addEventListener("click", function() {
        var content = document.getElementById("vidracaContent");
        // Alterna a visibilidade do conteúdo
        if (content.style.display === "none" || content.style.display === "") {
            content.style.display = "block"; // Exibe o conteúdo
        } else {
            content.style.display = "none"; // Oculta o conteúdo
        }
    });

    document.getElementById("togglePiso").addEventListener("click", function() {
        var content = document.getElementById("pisoContent");
        // Alterna a visibilidade do conteúdo
        if (content.style.display === "none" || content.style.display === "") {
            content.style.display = "block"; // Exibe o conteúdo
        } else {
            content.style.display = "none"; // Oculta o conteúdo
        }
    });

    document.getElementById("togglePizzaria").addEventListener("click", function() {
        var content = document.getElementById("pizzariaContent");
        // Alterna a visibilidade do conteúdo
        if (content.style.display === "none" || content.style.display === "") {
            content.style.display = "block"; // Exibe o conteúdo
        } else {
            content.style.display = "none"; // Oculta o conteúdo
        }
    });

    document.getElementById("toggleMecanica").addEventListener("click", function() {
        var content = document.getElementById("mecanicaContent");
        // Alterna a visibilidade do conteúdo
        if (content.style.display === "none" || content.style.display === "") {
            content.style.display = "block"; // Exibe o conteúdo
        } else {
            content.style.display = "none"; // Oculta o conteúdo
        }
    });

    document.getElementById("toggleEletricista").addEventListener("click", function() {
        var content = document.getElementById("eletricistaContent");
        // Alterna a visibilidade do conteúdo
        if (content.style.display === "none" || content.style.display === "") {
            content.style.display = "block"; // Exibe o conteúdo
        } else {
            content.style.display = "none"; // Oculta o conteúdo
        }
    });

    document.getElementById("toggleAr").addEventListener("click", function() {
        var content = document.getElementById("arContent");
        // Alterna a visibilidade do conteúdo
        if (content.style.display === "none" || content.style.display === "") {
            content.style.display = "block"; // Exibe o conteúdo
        } else {
            content.style.display = "none"; // Oculta o conteúdo
        }
    });

    document.getElementById("togglePedreiro").addEventListener("click", function() {
        var content = document.getElementById("pedreiroContent");
        // Alterna a visibilidade do conteúdo
        if (content.style.display === "none" || content.style.display === "") {
            content.style.display = "block"; // Exibe o conteúdo
        } else {
            content.style.display = "none"; // Oculta o conteúdo
        }
    });

    document.getElementById("toggleMoveis").addEventListener("click", function() {
        var content = document.getElementById("moveisContent");
        // Alterna a visibilidade do conteúdo
        if (content.style.display === "none" || content.style.display === "") {
            content.style.display = "block"; // Exibe o conteúdo
        } else {
            content.style.display = "none"; // Oculta o conteúdo
        }
    });

    document.getElementById("toggleBar").addEventListener("click", function() {
        var content = document.getElementById("barContent");
        // Alterna a visibilidade do conteúdo
        if (content.style.display === "none" || content.style.display === "") {
            content.style.display = "block"; // Exibe o conteúdo
        } else {
            content.style.display = "none"; // Oculta o conteúdo
        }
    });

    document.getElementById("toggleMarido").addEventListener("click", function() {
        var content = document.getElementById("maridoContent");
        // Alterna a visibilidade do conteúdo
        if (content.style.display === "none" || content.style.display === "") {
            content.style.display = "block"; // Exibe o conteúdo
        } else {
            content.style.display = "none"; // Oculta o conteúdo
        }
    });

    document.getElementById("toggleOutros").addEventListener("click", function() {
        var content = document.getElementById("outrosContent");
        // Alterna a visibilidade do conteúdo
        if (content.style.display === "none" || content.style.display === "") {
            content.style.display = "block"; // Exibe o conteúdo
        } else {
            content.style.display = "none"; // Oculta o conteúdo
        }
    });

    
</script>


    <!-- Vendor js -->
    <script src="../../assets/js/vendor.min.js"></script>

    <!-- Apex Charts js -->
    <script src="../../assets/vendor/apexcharts/apexcharts.min.js"></script>

    <!-- Dashboard App js -->
    <script src="../../assets/js/pages/demo.dashboard.js"></script>

    <!-- App js -->
    <script src="../../assets/js/app.min.js"></script>

    <!-- Plgins only -->
    <script src="../../assets/vendor/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
    <script src="../../assets/js/ui/component.range-slider.js"></script>

    <!-- Rateit js -->
    <script src="../../assets/vendor/jquery.rateit/scripts/jquery.rateit.min.js"></script>

    <!-- Rateit Cemo  js -->
    <script src="../../assets/js/ui/component.rating.js"></script>

    <!-- Datatable Demo Aapp js -->
    <script src="../../assets/js/pages/demo.datatable-init.js?ver=<?php echo time(); ?>"></script>


    
    <script src="../../assets/js/blockCode.js"></script>
</body>

</html>