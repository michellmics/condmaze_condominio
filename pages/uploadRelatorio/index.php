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
    
?>

<!DOCTYPE html>
<html lang="en" data-layout="topnav">

<head>
    <meta charset="utf-8" />
    <title><?php echo $nomeCondominio; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- Theme Config Js -->
    <script src="../../assets/js/hyper-config.js"></script>

    <!-- Vendor css -->
    <link href="../../assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="../../assets/css/app-modern.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="../../../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />

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
            <?php
                $siteAdmin->getListaInfo($userid);
            ?>

        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                </div>
                <!-- container -->
            </div>
            <!-- content -->

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                </div>
                                <h4 class="page-title">Enviar Arquivo</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Processamento de Relatório</h4>
                                    <p class="text-muted font-14">
                                        Aqui você pode fazer o upload do arquivo da administradora (receita ou despesa) para geração do relatório aos moradores.
                                    </p>
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="file-upload-preview">
                                        <form action="form_relatorio_proc.php" method="POST" enctype="multipart/form-data">
                                                <div class="fallback">
                                                    <input name="file" type="file" multiple />
                                                </div>

                                                <div class="form-row" style="margin-bottom: 10px; margin: 10px; display: flex; gap: 10px;">
                                                    <div style="flex: 1;">
                                                        <select class="form-control" id="mes" name="mes" required>
                                                            <option value="" disabled selected>Mês de Referência</option>
                                                            <option value="janeiro">Janeiro</option>
                                                            <option value="fevereiro">Fevereiro</option>
                                                            <option value="marco">Março</option>
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
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <select class="form-control" id="ano" name="ano" required>
                                                            <option value="" disabled selected>Ano de Referência</option>
                                                            <option value="2024">2024</option>
                                                            <option value="2025">2025</option>
                                                            <option value="2026">2026</option>
                                                            <option value="2027">2027</option>
                                                            <option value="2028">2028</option>
                                                            <option value="2029">2029</option>
                                                            <option value="2030">2030</option>
                                                            <option value="2031">2031</option>
                                                            <option value="2032">2032</option>
                                                            <option value="2033">2033</option>
                                                            <option value="2034">2034</option>
                                                            <option value="2035">2035</option>
                                                            <option value="2036">2036</option>
                                                            <option value="2037">2037</option>
                                                            <option value="2038">2038</option>
                                                            <option value="2039">2039</option>
                                                            <option value="2040">2040</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <h6 class="font-15 mt-3">Tipo de dados</h6>
                                                <div class="mt-2">
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" id="customRadio3" name="customRadio1" class="form-check-input">
                                                        <label class="form-check-label" for="customRadio3">Receita</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" id="customRadio4" name="customRadio1" class="form-check-input">
                                                        <label class="form-check-label" for="customRadio4">Despesa</label>
                                                    </div>
                                                </div>

                                            </form>
                                           

                                            <!-- Preview -->
                                            <div class="dropzone-previews mt-3" id="file-previews"></div>
                                        </div> <!-- end preview-->
                                        <button type="submit" class="btn btn-primary">Enviar</button>


                                        <div class="tab-pane code" id="file-upload-code">
                                        </div> <!-- end preview code-->
                                    </div> <!-- end tab-content-->


                                </div>
                                <!-- end card-body -->
                            </div>
                            <!-- end card-->
                        </div>
                        <!-- end col-->
                    </div>
                    <!-- end row -->

                </div>
                <!-- container -->

            </div>
            <!-- content -->

            <?php include '../../src/footer_nav.php'; ?>

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->



    

    <!-- Vendor js -->
    <script src="../../assets/js/vendor.min.js"></script>

    <!-- Code Highlight js -->
    <script src="../../assets/vendor/highlightjs/highlight.pack.min.js"></script>
    <script src="../../assets/vendor/clipboard/clipboard.min.js"></script>
    <script src="../../assets/js/hyper-syntax.js"></script>

    <!-- Dropzone File Upload js -->
    <script src="../../assets/vendor/dropzone/dropzone-min.js"></script>

    <!-- File Upload Demo js -->
    <script src="../../assets/js/ui/component.fileupload.js"></script>

    <!-- App js -->
    <script src="../../assets/js/app.min.js"></script>

</body>

</html>