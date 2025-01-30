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

                    <div class="d-flex align-items-center justify-content-center vh-100">
    <div class="col-md-6">
        <div class="card shadow-lg rounded-lg">
            <div class="card-body text-center">
                <h4 class="header-title">Processamento de Relatório</h4>
                <p class="text-muted font-14">
                    Aqui você pode fazer o upload do arquivo da administradora (receita ou despesa) para geração do relatório aos moradores.
                </p>

                <form action="form_relatorio_proc.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input name="arquivo" id="arquivo" type="file" class="form-control" />
                    </div>

                    <div class="d-flex gap-2">
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

                        <select class="form-control" id="ano" name="ano" required>
                            <option value="" disabled selected>Ano de Referência</option>
                            <?php for ($i = 2024; $i <= 2040; $i++) {
                                echo "<option value='$i'>$i</option>";
                            } ?>
                        </select>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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