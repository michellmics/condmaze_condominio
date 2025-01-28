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
                <!-- Alinhamento flexbox para título e botões -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <h4 class="page-title mb-3 mb-md-0">Avaliação de Prestadores de Serviço</h4>
                    <div class="d-flex gap-2 flex-wrap justify-content-start justify-content-md-end" style="margin-bottom: 10px;">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#cadastrar-modal">Adicionar Empresa</button>
                        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#avaliar-modal">Avaliar Empresa</button>
                    </div>
                </div>
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
                                    </div>
                                        <div class="tab-pane show active" id="default-accordions-preview">
                                            <div class="accordion" id="accordionExample">
                                                <?php $aux = 0 ?>
                                                <?php foreach ($VIDRAÇARIA as $item): 
                                                    $idPrestador = $item['PDS_IDPRESTADOR_SERVICO'];
                                                    $NOTASAVG = $siteAdmin->getAvaliacoesNotasAVGByPrestador($idPrestador); 
                                                    $COMENTARIOS = $siteAdmin->getAvaliacoesByPrestador($idPrestador);                                                         
                                                ?>
                                                <div class="accordion-item">                                                    
                                                    <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#vidracaria<?php echo $aux; ?>" aria-expanded="true" aria-controls="collapse<?php echo $aux; ?>" style="display: flex; justify-content: space-between; align-items: center; text-align: left;">
                                                        <div style="display: flex; flex-direction: column;">
                                                            <strong><?= htmlspecialchars($item['PDS_DCNOME']); ?></strong>
                                                            <span>Fone: <?= htmlspecialchars($item['PDS_DCTELEFONE']); ?> (<?= htmlspecialchars($item['PDS_DCCIDADE']); ?>)</span>
                                                        </div>                                
                                                        <div class="rateit rateit-mdi" data-rateit-mode="font" data-rateit-icon="󰓒" data-rateit-value="<?= htmlspecialchars($NOTASAVG['AVG']); ?>" data-rateit-ispreset="true" data-rateit-readonly="true" style="margin-left: auto;"></div>
                                                    </button>
                                                    </h2>
                                                    <?php foreach ($COMENTARIOS as $comentario_prestador): ?>
                                                        <?php 
                                                            $data = $comentario_prestador['APS_DTAVAL'];
                                                            $formattedDate = date('d/m/Y', strtotime($data));
                                                        ?>
                                                    <div id="vidracaria<?php echo $aux; ?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body" style="color:rgb(40, 53, 83);">
                                                            <?php  
                                                                if(isset($comentario_prestador['USU_DCNOME'])) 
                                                                {
                                                            ?>
                                                                    &nbsp;&nbsp;&nbsp;<strong><?= substr(htmlspecialchars($comentario_prestador['USU_DCNOME']),0,20)."..."; ?></strong>                                                                    
                                                                    <?php $nota = $comentario_prestador['APS_NMNOTA']; for($aux1 = 0; $aux1 < $nota; $aux1++){echo "<span class='text-success mdi mdi-star'></span>";}?>                                                                 
                                                                    <br>
                                                                    &nbsp;&nbsp;&nbsp;<strong><?= htmlspecialchars($formattedDate); ?></strong> - <?= htmlspecialchars("AP ".$comentario_prestador['USU_DCAPARTAMENTO'])." BL ".htmlspecialchars($comentario_prestador['USU_DCBLOCO']); ?><br>
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
                                    <h4 class="header-title">Pedreiro</h4>
                                    <p class="text-muted font-14 mb-3">Avaliar Empresa</p>
                                    <div class="tab-content">
                                    <div class="col-sm-5"  style="margin-bottom: 20px;">
                                    </div>
                                    <div class="tab-pane show active" id="default-accordions-preview">
                                            <div class="accordion" id="accordionExample">
                                                <?php $aux = 0 ?>
                                                <?php foreach ($PEDREIRO as $item): 
                                                    $idPrestador = $item['PDS_IDPRESTADOR_SERVICO'];
                                                    $NOTASAVG = $siteAdmin->getAvaliacoesNotasAVGByPrestador($idPrestador); 
                                                    $COMENTARIOS = $siteAdmin->getAvaliacoesByPrestador($idPrestador);                                                         
                                                    $countAval = count($COMENTARIOS);
                                                ?>
                                                <div class="accordion-item">                                                    
                                                    <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#pedreiro<?php echo $aux; ?>" aria-expanded="true" aria-controls="collapse<?php echo $aux; ?>" style="display: flex; justify-content: space-between; align-items: center; text-align: left;">
                                                        <div style="display: flex; flex-direction: column;">
                                                            <strong><?= htmlspecialchars($item['PDS_DCNOME']); ?></strong>
                                                            <span>Fone: <?= htmlspecialchars($item['PDS_DCTELEFONE']); ?> (<?= htmlspecialchars($item['PDS_DCCIDADE']); ?>)</span>
                                                        </div>                                
                                                        <div class="rateit rateit-mdi" data-rateit-mode="font" data-rateit-icon="󰓒" data-rateit-value="<?= htmlspecialchars($NOTASAVG['AVG']); ?>" data-rateit-ispreset="true" data-rateit-readonly="true" style="margin-left: auto;"></div>
                                                    </button>
                                                    </h2>
                                                    <?php foreach ($COMENTARIOS as $comentario_prestador): ?>
                                                        <?php 
                                                            $data = $comentario_prestador['APS_DTAVAL'];
                                                            $formattedDate = date('d/m/Y', strtotime($data));
                                                        ?>
                                                    <div id="pedreiro<?php echo $aux; ?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body" style="color:rgb(40, 53, 83);">
                                                            <?php  
                                                                if(isset($comentario_prestador['USU_DCNOME'])) 
                                                                {
                                                            ?>
                                                                    &nbsp;&nbsp;&nbsp;<strong><?= substr(htmlspecialchars($comentario_prestador['USU_DCNOME']),0,20)."..."; ?></strong>                                                                    
                                                                    <?php $nota = $comentario_prestador['APS_NMNOTA']; for($aux1 = 0; $aux1 < $nota; $aux1++){echo "<span class='text-success mdi mdi-star'></span>";}?>                                                                 
                                                                    <br>
                                                                    &nbsp;&nbsp;&nbsp;<strong><?= htmlspecialchars($formattedDate); ?></strong> - <?= htmlspecialchars("AP ".$comentario_prestador['USU_DCAPARTAMENTO'])." BL ".htmlspecialchars($comentario_prestador['USU_DCBLOCO']); ?><br>
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

    <div id="cadastrar-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="text-center mt-2 mb-4">
                        <a href="index.html" class="text-success">
                            <span><img src="../../img/logo_128x32_black.png" alt="" height="40"></span>
                        </a>
                    </div>

                    <form class="ps-3 pe-3" action="#">

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome do Prestador de Serviço</label>
                            <input class="form-control" type="text" name="nome" id="nome" minlength="3" maxlength="17" required="" placeholder="">
                        </div>

                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoria</label>
                            <input class="form-control" type="text" name="categoria" id="categoria" required="" placeholder="">
                        </div>

                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone (DDD+Telefone)</label>
                            <input class="form-control" type="text" name="telefone" id="telefone" minlength="11" maxlength="11" required="" placeholder="">
                        </div>

                        <div class="mb-3">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input class="form-control" type="text" name="cidade" id="cidade" minlength="3" maxlength="15" required="" placeholder="">
                        </div>

                        <div class="mb-3 text-center">
                            <button class="btn btn-primary" type="submit">Cadastrar</button>
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
                            <span><img src="../../img/logo_128x32_black.png" alt="" height="40"></span>
                        </a>
                    </div>
                                                                    
                    <form class="ps-3 pe-3" action="#">
                                                                    
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome do Prestador de Serviço</label>
                            <input class="form-control" type="text" name="nome" id="nome" required="" placeholder="">
                        </div>
                                                                    
                        <div class="mb-3">
                            <label for="nota" class="form-label">Nota</label>
                            <select class="form-control" name="nota" id="nota" required>
                                <option value="" disabled selected>Selecione uma nota</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                                                                    
                        <div class="mb-3">
                            <label for="comentario" class="form-label">Comentário (opcional)</label>
                            <input class="form-control" type="text" name="comentario" id="comentario" maxlength="299" placeholder="">
                        </div>
                                                                                                                                       
                        <div class="mb-3 text-center">
                            <button class="btn btn-primary" type="submit">Cadastrar</button>
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