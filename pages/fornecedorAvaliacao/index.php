<?php
    ini_set('display_errors', 1);  // Habilita a exibição de erros
    error_reporting(E_ALL);        // Reporta todos os erros
	include_once "../../objects/objects.php";
	
    $siteAdmin = new SITE_ADMIN();  
    $siteAdmin->getParameterInfo();

    foreach ($siteAdmin->ARRAY_PARAMETERINFO as $item) {
      if ($item['CFG_DCPARAMETRO'] == 'NOME_CONDOMINIO') {
          $nomeCondominio = $item['CFG_DCVALOR']; 
          break; 
      }
    }   
    
    $VIDRAÇARIA = $siteAdmin->getAvaliacoesByCategoria("VIDRAÇARIA");
    $PEDREIRO = $siteAdmin->getAvaliacoesByCategoria("PEDREIRO");
    $AR_CONDICIONADO = $siteAdmin->getAvaliacoesByCategoria("AR CONDICIONADO");

    $COMENTARIOS = $siteAdmin->getAvaliacoesByPrestador("1");

?>

<!DOCTYPE html>
<html lang="en" data-layout="topnav">

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

    <!-- App favicon -->
    <link rel="shortcut icon" href="../../assets/images/favicon.ico">

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

		<!-- Top bar Area -->
		<?php include '../../src/top_bar.php'; ?>
		<!-- End Top bar -->

		<!-- Menu Nav Area -->
		<?php include '../../src/menu_nav.php'; ?>
		<!-- End Menu Nav -->

        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                </div>
                <!-- container -->
            </div>
            <!-- content -->


                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Base UI</a></li>
                                        <li class="breadcrumb-item active">Accordions & Collapse</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Avaliação de Prestadores de Serviço</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Vidraçarias</h4>
                                    <p class="text-muted font-14 mb-3">Avaliar Empresa</p>
                                    <div class="tab-content">
                                    <div class="col-sm-5"  style="margin-bottom: 20px;">
                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#signup-modal">Adicionar Empresa</button>
                                        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#signup-modal">Avaliar Empresa</button>  
                                    </div>
                                        <div class="tab-pane show active" id="default-accordions-preview">
                                            <div class="accordion" id="accordionExample">
                                            <?php $aux = 0 ?>
                                            <?php foreach ($VIDRAÇARIA as $item): ?>
                                                <div class="accordion-item">                                                    
                                                    <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $aux; ?>" aria-expanded="true" aria-controls="collapse<?php echo $aux; ?>" style="display: flex; justify-content: space-between; align-items: center; text-align: left;">
                                                        <div style="display: flex; flex-direction: column;">
                                                            <strong><?= htmlspecialchars($item['PDS_DCNOME']); ?> - 36 avaliações</strong>
                                                            <span>Fone: <?= htmlspecialchars($item['PDS_DCTELEFONE']); ?> (<?= htmlspecialchars($item['PDS_DCCIDADE']); ?>)</span>
                                                        </div> 
                                                        <?php
                                                            $idPrestador = $item['PDS_IDPRESTADOR_SERVICO'];
                                                            $COMENTARIOS = $siteAdmin->getAvaliacoesNotasAVGByPrestador($idPrestador);                                                            
                                                        ?>                                   
                                                        <div class="rateit rateit-mdi" data-rateit-mode="font" data-rateit-icon="󰓒" data-rateit-value="<?= htmlspecialchars($COMENTARIOS['AVG']); ?>" data-rateit-ispreset="true" data-rateit-readonly="true" style="margin-left: auto;"></div>
                                                    </button>
                                                    </h2>
                                                        <?php                                                        
                                                            
                                                            $COMENTARIOS = $siteAdmin->getAvaliacoesByPrestador($idPrestador);
                                                        ?>
                                                    <?php foreach ($COMENTARIOS as $comentario_prestador): ?>
                                                        <?php 
                                                            $data = $comentario_prestador['APS_DTAVAL'];
                                                            $formattedDate = date('d/m/Y', strtotime($data));
                                                        ?>
                                                    <div id="collapse<?php echo $aux; ?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body" style="color:rgb(50, 92, 33);">
                                                            <?php  
                                                                if(isset($comentario_prestador['USU_DCNOME'])) 
                                                                {
                                                            ?>
                                                                    <strong><?= htmlspecialchars($comentario_prestador['USU_DCNOME']); ?></strong><div class="rateit rateit-mdi" data-rateit-mode="font" data-rateit-icon="󰓒" data-rateit-value="4" data-rateit-ispreset="true" data-rateit-readonly="true" style="margin-left: auto; font-size: 16px;"></div><br>
                                                                    <strong><?= htmlspecialchars($formattedDate); ?></strong> - <?= htmlspecialchars("AP ".$comentario_prestador['USU_DCAPARTAMENTO'])." BL ".htmlspecialchars($comentario_prestador['USU_DCBLOCO']); ?><br>
                                                                    <?= htmlspecialchars($comentario_prestador['APS_DCCOMENTARIO']); ?>
                                                            <?php
                                                                }
                                                                else
                                                                {
                                                                    echo "Não há comentários.";
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <?php endforeach; ?>
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
                                    <h4 class="header-title">Vidraçarias</h4>
                                    <p class="text-muted font-14 mb-3">Avaliar Empresa</p>
                                    <div class="tab-content">
                                    <div class="col-sm-5"  style="margin-bottom: 20px;">
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#signup-modal">Adicionar Empresa</button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#signup-modal">Avaliar Empresa</button>  
                                    </div>
                                        <div class="tab-pane show active" id="default-accordions-preview">
                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="display: flex; justify-content: space-between; align-items: center; text-align: left;">
                                    <div style="display: flex; flex-direction: column;">
                                        <strong>Vidraçaria ERK</strong>
                                        <span>Fone: 19-99275895 (Hortolândia)</span>
                                    </div>                                    
                                    <div class="rateit rateit-mdi" data-rateit-mode="font" data-rateit-icon="󰓒" data-rateit-value="2.5" data-rateit-ispreset="true" data-rateit-readonly="true" style="margin-left: auto;"></div>
                                </button>
                                                    </h2>
                                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                          Vidraçaria muito boa. Atendeu em dia e sem nenhum problema. Ótimo suporte.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->


                    </div>
                    <!-- end row-->
                </div> <!-- container -->

            </div> <!-- content -->

            <?php include '../../src/footer_nav.php'; ?>

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>

    <div id="signup-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                    <a href="index.html" class="text-success">
                        <span><img src="../../assets/images/logo-dark.png" alt="" height="18"></span>
                    </a>
                </div>

                <form class="ps-3 pe-3" action="#">

                    <div class="mb-3">
                        <label for="username" class="form-label">Name</label>
                        <input class="form-control" type="email" id="username" required="" placeholder="Michael Zenaty">
                    </div>

                    <div class="mb-3">
                        <label for="emailaddress" class="form-label">Email address</label>
                        <input class="form-control" type="email" id="emailaddress" required="" placeholder="john@deo.com">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input class="form-control" type="password" required="" id="password" placeholder="Enter your password">
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="customCheck1">
                            <label class="form-check-label" for="customCheck1">I accept <a href="#">Terms and Conditions</a></label>
                        </div> 
                    </div>

                    <div class="mb-3 text-center">
                        <button class="btn btn-primary" type="submit">Sign Up Free</button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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

    <!-- Rateit js -->
    <script src="../../assets/vendor/jquery.rateit/scripts/jquery.rateit.min.js"></script>

    <!-- Rateit Cemo  js -->
    <script src="../../assets/js/ui/component.rating.js"></script>

    <!-- Datatable Demo Aapp js -->
    <script src="../../assets/js/pages/demo.datatable-init.js?ver=<?php echo time(); ?>"></script>



</body>

</html>