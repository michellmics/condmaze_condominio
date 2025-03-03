<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
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



    $userId = $_GET['userId'];
    $siteAdmin->getMoradorByUserId($userId);
    $nomeMorador = ucwords(strtolower($siteAdmin->ARRAY_USERINFOBYID["USU_DCNOME"]));
    $apMorador = $siteAdmin->ARRAY_USERINFOBYID["USU_DCAPARTAMENTO"];

    
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
        <?php
                $siteAdmin->getListaInfoByMorador($userId);
        ?>     
        <div class="content-page">
            <div class="content">                
                <div class="container-fluid"><!-- INICIO CONTEUDO CONTAINER -->

                  
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                </div>
                                <h4 class="page-title">Lista de Convidados</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Convidados </h4>
                                    <p class="text-muted font-14">
                                        Lista de convidados do morador: <b><?php echo $nomeMorador; ?></b> apartamento <b><?php echo $apMorador; ?></b>.
                                    </p>
                                    <div class="tab-content">
                                    <div class="col-sm-5">
                                    <button class="btn" style="background-color: #aa2ed8; color: white;" onclick="window.history.back()" type="button">Voltar</button>
                                        </div>
                                        <div class="tab-pane show active" id="basic-datatable-preview">                                            
                                        <table class="table table-centered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>CPF / RG</th>
                                                    <th>Chegou?</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($siteAdmin->ARRAY_LISTAINFO as $index => $item): ?>
                                                    <tr>
                                                        <td style="cursor: pointer;"><?= htmlspecialchars($item['LIS_DCNOME']); ?></td>
                                                        <td style="cursor: pointer;"><?= htmlspecialchars($item['LIS_DCDOCUMENTO']); ?></td>
                                                        <td>
                                                            <!-- Switch -->
                                                            <div>
                                                                <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'PORTARIA'): ?>
                                                                <input 
                                                                    type="checkbox" 
                                                                    id="switch<?= $index; ?>" 
                                                                    data-switch="success" 
                                                                    data-id="<?= $item['LIS_IDLISTACONVIDADOS']; ?>" 
                                                                    <?= $item['LIS_STSTATUS'] === 'ATIVO' ? 'checked' : ''; ?> 
                                                                    onclick="event.stopPropagation();"
                                                                />
                                                                <label 
                                                                    for="switch<?= $index; ?>" 
                                                                    data-on-label="Sim" 
                                                                    data-off-label="Não" 
                                                                    class="mb-0 d-block">
                                                                </label>
                                                                <?php endif; ?> 
                                                            </div>
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
 
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const switches = document.querySelectorAll('input[type="checkbox"][data-switch="success"]');
        
        switches.forEach(switchElem => {
            switchElem.addEventListener('change', function () {
                const id = this.getAttribute('data-id');
                const status = this.checked ? 'ATIVO' : 'INATIVO';

                // Envia a alteração para o servidor
                fetch('updateStatusCheckbox.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id, status })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        //alert('Erro ao atualizar o status!');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    //alert('Erro ao comunicar com o servidor.');
                });
            });
        });
    });
</script>


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
    <script src="../../assets/js/pages/demo.datatable-init.js?ver=<?php echo time(); ?>"></script>

 

</body>

</html>