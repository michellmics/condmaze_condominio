<?php
    require "../../src/sessionStartShield.php";    
    include_once "../../objects/objects.php";
	
    $siteAdmin = new SITE_ADMIN();  
    $siteAdmin->getParameterInfo();

    foreach ($siteAdmin->ARRAY_PARAMETERINFO as $item) {
      if ($item['CFG_DCPARAMETRO'] == 'NOME_CONDOMINIO') {
          $nomeCondominio = $item['CFG_DCVALOR']; 
          break; 
      }
    }   
    

    $siteAdmin->getLogInfo();
    
?>
<!DOCTYPE html>
<html lang="en" data-topbar-color="dark" data-menu-color="dark" data-sidenav-user="true" data-bs-theme="dark">
<head>
    <meta charset="utf-8" />
    <title><?php echo $nomeCondominio; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- Datatables css -->
    <link href="../../assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <!-- Plugin css -->
    <link href="../../assets/vendor/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css">
    <link href="../../assets/vendor/jsvectormap/jsvectormap.min.css" rel="stylesheet" type="text/css">
    <!-- Theme Config Js -->
    <script src="../../assets/js/hyper-config.js"></script>
    <!-- Vendor css -->
    <link href="../../assets/css/vendor.min.css" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="../../assets/css/app-modern.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <!-- Icons css -->
    <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- PWA MOBILE CONF -->
	<?php include '../../src/pwa_conf.php'; ?>
	<!-- PWA MOBILE CONF -->

</head>

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
                                <h4 class="page-title">Auditoria</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    

                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Registro de Eventos do Sistema </h4>
                                    <p class="text-muted font-14">
                                        Aqui são listados todas as atividades realizadas no sistema.
                                    </p>
                                    <div class="tab-content">
                                        <div class="col-sm-5">
                                            
                                        </div>
                                        <br>
                                        <div class="tab-pane show active" id="basic-datatable-preview">
                                            <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th>DATA</th>
                                                        <th>USUÁRIO / NÍVEL</th>
                                                        <th>APTO</th>
                                                        <th>TIPO</th>
                                                        <th>COD</th>
                                                        <th>MSG</th>                                                         
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($siteAdmin->ARRAY_LOGINFO as $item): ?>

                                                        <?php                                                             
                                                     
                                                            $date = new DateTime($item['LOG_DTLOG']);
                                                            $dataFormatLog = $date->format('d/m/Y H:i');                                           

                                                            $colors = [
                                                                "LOGIN" => 'color:rgb(116, 177, 25);',
                                                                "ALERTA" => 'color: rgb(255, 100, 11);',
                                                                "ENCOMENDA" => 'color: rgb(47, 144, 255);',
                                                                "UPDATE" => 'color: rgb(255, 100, 11);',
                                                                "REC SENHA" => 'color: rgb(255, 100, 11);',
                                                                "LOGIN FAILED" => 'color: rgb(233, 20, 20);',
                                                                "CONFIGURAÇÃO" => 'color: rgb(255, 47, 47);',
                                                                "NOTIFICAÇÃO" => 'color: rgb(47, 179, 255);',
                                                                "ERRO" => 'color: rgb(255, 47, 47);'
                                                            ];
                                                            
                                                            $colorText = isset($colors[$item['LOG_DCTIPO']]) ? 'style="' . $colors[$item['LOG_DCTIPO']] . '"' : '';
                                                        ?>                                                        

                                                        <tr>
                                                            <td class="align-middle"><?= htmlspecialchars($dataFormatLog); ?></td>
                                                            <td class="align-middle"><?= htmlspecialchars($item['LOG_DCUSUARIO']); ?></td>
                                                            <td class="align-middle"><?= htmlspecialchars($item['LOG_DCAPARTAMENTO']); ?></td>
                                                            <td class="align-middle" <?php echo $colorText; ?>><?= htmlspecialchars($item['LOG_DCTIPO']); ?></td>
                                                            <td class="align-middle"><?= htmlspecialchars($item['LOG_DCCODIGO']); ?></td>
                                                            <td style="white-space: normal; word-wrap: break-word; overflow-wrap: break-word; word-break: break-word;" class="align-middle">
                                                                <?= nl2br(wordwrap(htmlspecialchars($item['LOG_DCMSG']), 50, "\n", true)); ?>
                                                            </td>
                                                                
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div> <!-- end preview-->


                                    </div> <!-- end tab-content-->

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div> <!-- end row-->   
                </div><!-- FIM CONTEUDO CONTAINER -->                

            <!-- content -->


    
        <!-- FOOTER -->
	    <?php include '../../src/modalTermos.php'; ?>
	    <!-- FOOTER -->   
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
    <script src="../../assets/js/pages/demo.dashboard.js"></script>

    <!-- App js -->
    <script src="../../assets/js/app.min.js"></script>

    <!-- Datatables js -->
    <script src="../../assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="../../assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="../../assets/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js"></script>
    <script src="../../assets/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../../assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../assets/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
    <script src="../../assets/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../../assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../../assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../../assets/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../../assets/vendor/datatables.net-select/js/dataTables.select.min.js"></script>

    <!-- Datatable Demo Aapp js -->
    <script src="../../assets/js/pages/demo.datatable-init-auditoria.js?ver=<?php echo time(); ?>"></script>

<script>
$(document).ready(function () {
    var table = $('#basic-datatable').DataTable();
    table.destroy(); // Destrói a instância existente antes de criar outra

    $('#basic-datatable').DataTable({
        pageLength: 50,  
        lengthMenu: [10, 25, 50, 100], 
        responsive: true, 
        order: [[3, 'desc']], 
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
        }
    });
});

</script>
<script src="../../assets/js/blockCode.js"></script>
</body>

</html>