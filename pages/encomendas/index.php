<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == NULL) {
        header("Location: ../login/index.php");
        exit();
    }

    if (!in_array(strtoupper($_SESSION['user_nivelacesso']), ["SINDICO", "SUPORTE", "PORTARIA"])) {
        header("Location: ../errors/index.php");
        exit();
      }

	include_once "../../objects/objects.php";
	
    $siteAdmin = new SITE_ADMIN();  
    $siteAdmin->getParameterInfo();
    $siteAdmin->getEncomendaPortariaInfo();
  
    foreach ($siteAdmin->ARRAY_PARAMETERINFO as $item) {
      if ($item['CFG_DCPARAMETRO'] == 'NOME_CONDOMINIO') {
          $nomeCondominio = $item['CFG_DCVALOR']; 
          break; 
      }
    }   

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
	<?php include '../../src/pwaConf.php'; ?>
	<!-- PWA MOBILE CONF -->
</head>

<style> 
/* Azul quando está desligado (OFF) */
    input[type="checkbox"][data-switch="success"] + label {
        background-color:rgb(24, 19, 68) !important; /* Azul */
        border-color:rgb(24, 19, 68) !important;
        color: white !important;
    }

    /* Verde quando ativado (ON) */
    input[type="checkbox"][data-switch="success"]:checked + label {
        background-color: #28a745 !important; /* Verde */
        border-color: #28a745 !important;
    }

    /* Cinza quando está desativado (readonly ou disabled) */
    input[type="checkbox"][data-switch="success"]:disabled + label {
        background-color: #6c757d !important; /* Cinza */
        border-color: #6c757d !important;
        cursor: not-allowed;
        opacity: 0.6;
    }

</style>

<body>
    <!-- Begin page -->
    <div class="wrapper">

		<!-- Top bar Area -->
		<?php include '../../src/topBar.php'; ?>
		<!-- End Top bar -->

		<!-- Menu Nav Area -->
		<?php include '../../src/menuLeft.php'; ?>
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
                                </div>
                                <h4 class="page-title">Lista de Moradores</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Controle de Encomendas</h4>
                                    <p class="text-muted font-14">
                                    Nesta seção, você pode controlar o recebimento de encomendas do condomínio. Ao receber uma encomenda, cadastre o item no sistema e 
                                    marque o status <b>DISPONÍVEL</b> como <b>SIM</b>, indicando que está pronta para retirada. O morador, por sua vez, deve marcar o 
                                    status <b>RETIRAR?</b> como <b>SIM</b> para liberar o botão <b>ENTREGUE?</b>, permitindo que a portaria confirme a entrega.
                                    </p>
                                    <?php if ($nivelAcesso == 'SINDICO'): ?>
                                    <p class="text-muted font-14">
                                    <i class="fa fa-whatsapp" style="color: #25D366; font-size: 20px; margin-right: 8px;"></i>

                                    </p>
                                    <?php endif; ?>      
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#signup-modal">Cadastrar </button>
                                    <button type="button" class="btn btn-primary" onclick="window.location.href='entregues.php';">Entregues</button>
                                    <button type="button" class="btn btn-success float-end" onclick="location.reload()">Refresh</button>                                    
                                    <br><br>
 
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="basic-datatable-preview">
                                            <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                                <thead>
                                                    <tr>        
                                                        <th>DT ENTRADA</th>
                                                        <th>ID</th>
                                                        <th>AP</th>
                                                        <th>NOME</th>
                                                        <th>TELEFONE</th> 
                                                        <th>DT ENTREGA</th>
                                                        <th>OBS</th>
                                                        <th></th> 
                                                        <th>DISPONIVEL?</th>
                                                        <th>ENTREGUE?</th>                                                         
                                                        <th></th> 
                                                        <th></th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($siteAdmin->ARRAY_ENCOMENDAINFO as $index => $item): ?>
                                                    <?php
                                                        $statusEnt = $item['ENC_STENTREGA_MORADOR'];
                                                        $obs = substr($item['ENC_DCOBSERVACAO'],0,13);
                                                        $nome = $item['USU_DCNOME'];
                                                        $telefone = $item['USU_DCTELEFONE'];   
                                                        $email = $item['USU_DCEMAIL'];                                                      
                                                        
                                                        if($item['ENC_STENCOMENDA'] == "DISPONIVEL")
                                                        {
                                                            $whatsColor = "#30ec6f";
                                                            $telefone = '+55' . $item['USU_DCTELEFONE']; 
                                                            $nomeWhats = $item['USU_DCNOME'];
                                                            $linkEncomendaWhats = "https://parquedashortensias.codemaze.com.br/pages/login/index.php";
                                                            $idEncomendaWhats = $item['ENC_IDENCOMENDA'];
    
                                                            $mensagem = "Olá $nomeWhats,\nSua entrega está disponível para retirada.\n\nLocal: Condomínio Parque das Hortênsias.\nID da Encomenda: $idEncomendaWhats\n\nAo chegar na portaria, acesse o link abaixo para liberar a entrega da sua encomenda.\nLiberar Entrega: $linkEncomendaWhats";   
                                                            $mensagem_codificada = urlencode($mensagem);
                                                            $linkWhats = "https://wa.me/$telefone?text=$mensagem_codificada";
                                                        }
                                                        else
                                                        {
                                                            $whatsColor = "#484b49";
                                                            $linkWhats = "";
                                                        }

                                                        if(($item['ENC_STENTREGA_MORADOR'] != "A RETIRAR" && $item['ENC_STENTREGA_MORADOR'] != "ENTREGUE") 
                                                            || $item['ENC_STENCOMENDA'] != "DISPONIVEL")
                                                        {
                                                            $fieldPortaria = "disabled";
                                                        }
                                                        else
                                                            {
                                                                $fieldPortaria = "";                                                                
                                                            }

                                                        if($item['ENC_STENTREGA_MORADOR'] == "ENTREGUE") 
                                                        {
                                                            $fieldPortaria = "disabled";
                                                            $fieldMorador = "disabled";                                                            
                                                        }
                                                        else
                                                            {
                                                                $fieldMorador = "";
                                                            }

                                                        $date = new DateTime($item['ENC_DTENTREGA_PORTARIA']);
                                                        $dataPortaria = $date->format('d/m/Y H:i');

                                                        $date = new DateTime($item['ENC_DTENTREGA_MORADOR']);
                                                        $dataMorador = $date->format('d/m/Y H:i');                                                                                                             
                                                        
                                                    ?>
                                                    <tr>    
                                                        <td hidden class="align-middle" email="<?= htmlspecialchars($item['USU_DCEMAIL']); ?>"style="font-size: 12px;"></td>
                                                        <td class="align-middle" style="font-size: 12px;"><?= htmlspecialchars($dataPortaria); ?></td>
                                                        <td class="align-middle" style="font-size: 12px;"><?= htmlspecialchars($item['ENC_IDENCOMENDA']); ?></td>
                                                        <td class="align-middle" style="font-size: 12px;"><?= htmlspecialchars($item['USU_DCAPARTAMENTO']); ?></td>
                                                        <td class="align-middle" nome="<?= htmlspecialchars($item['USU_DCNOME']); ?>" style="font-size: 12px; word-wrap: break-word;"><?= htmlspecialchars(substr($item['USU_DCNOME'],0,21)."..."); ?></td>    
                                                        <td class="align-middle" telefone="<?= htmlspecialchars($item['USU_DCTELEFONE']); ?>" style="font-size: 12px;"><?= htmlspecialchars($item['USU_DCTELEFONE']); ?></td>     
                                                        <td class="align-middle" style="font-size: 12px;"><?= htmlspecialchars($dataMorador); ?></td>
                                                        <td class="align-middle" style="font-size: 12px;"><?= htmlspecialchars($obs); ?></td> 
                                                        <td class="align-middle" style="font-size: 12px;">
                                                            <a <?= empty($linkWhats) ? 'style="pointer-events: none; cursor: default;"' : 'href="'.htmlspecialchars($linkWhats).'" target="_blank"' ?>>
                                                                <i class="fab fa-whatsapp" style="font-size: 24px; color: <?= $whatsColor; ?>;"></i>
                                                            </a>
                                                        </td>

                                                        <td class="align-middle">
                                                            <!-- Switch -->
                                                            <div>
                                                                <input 
                                                                    type="checkbox" 
                                                                    id="switch<?= $index; ?>" 
                                                                    data-switch="success" 
                                                                    data-id="<?= $item['ENC_IDENCOMENDA']; ?>" 
                                                                    <?= $item['ENC_STENCOMENDA'] === 'DISPONIVEL' ? 'checked' : ''; ?> 
                                                                    onclick="event.stopPropagation();"
                                                                    <?= htmlspecialchars($fieldMorador); ?>
                                                                />
                                                                <label 
                                                                    for="switch<?= $index; ?>" 
                                                                    data-on-label="Sim" 
                                                                    data-off-label="Não" 
                                                                    class="mb-0 d-block">
                                                                </label>
                                                            </div>
                                                        </td>

                                                        <td class="align-middle">
                                                            <!-- Switch -->
                                                            <div>
                                                                <input 
                                                                    type="checkbox" 
                                                                    id="switch1<?= $index; ?>" 
                                                                    data-switch="success" 
                                                                    data-id1="<?= $item['ENC_IDENCOMENDA']; ?>" 
                                                                    <?= $item['ENC_STENTREGA_MORADOR'] === 'ENTREGUE' ? 'checked' : ''; ?> 
                                                                    onclick="event.stopPropagation();"
                                                                    <?= htmlspecialchars($fieldPortaria); ?>
                                                                />
                                                                <label 
                                                                    for="switch1<?= $index; ?>" 
                                                                    data-on-label="Sim" 
                                                                    data-off-label="Não" 
                                                                    class="mb-0 d-block">
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td class="align-middle" hash="<?= htmlspecialchars($item['ENC_DCHASHENTREGA']); ?>" style="font-size: 12px; display: none;"></td> 
                                                        <td class="align-middle">
                                                            <?php 
                                                                if($item['ENC_STENTREGA_MORADOR'] != 'ENTREGUE')
                                                                {
                                                                    echo '<i class="mdi mdi-delete" title="Excluir encomenda" style="cursor: pointer; font-size: 24px;" onclick="confirmDelete(event, \'' . htmlspecialchars($item['ENC_IDENCOMENDA'], ENT_QUOTES, 'UTF-8') . '\')"></i>';
                                                                }
                                                            ?>
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
                    </div><!-- end row-->

                </div> <!-- container -->

            </div> <!-- content -->

            <?php include '../../src/footerNav.php'; ?>
            <!-- cadastrar pacote modal-->
<div id="signup-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                    <a href="index.html" class="text-success">
                        <span>Cadastro de Pacote</span>
                    </a>
                </div>

                <form class="needs-validation" novalidate id="form" role="form" method="POST">

                    <div class="mb-3">
                        <label for="apartamento" class="form-label">Apartamento</label>
                        <input class="form-control" type="number" name="apartamento" id="apartamento" maxlength="4" required="" placeholder="Digite o número do apartamento">
                    </div>

                    <div class="mb-3">
                        <label for="observacao" class="form-label">Observacao</label>
                        <input class="form-control" type="text" id="observacao" name="observacao" required="" maxlength="50" placeholder="Digite algo que ajude a identificar o pacote" style="text-transform: uppercase;">
                    </div>

                    <div class="mb-3 text-center">
                        <button class="btn btn-primary" id="botao" type="button">Cadastrar Pacote</button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>

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