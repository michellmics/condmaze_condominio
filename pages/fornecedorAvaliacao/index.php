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
    

    $siteAdmin->getListaMoradoresInfo();
    
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
                                    <h4 class="header-title">Moradores </h4>
                                    <p class="text-muted font-14">
                                        Nesta seção são listados todos os moradores do condomínio.
                                    </p>
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="default-accordions-preview">
                                            <div class="accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                            Accordion Item #1
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse
                                                            plugin adds the appropriate classes that we use to style each element. These classes control the overall
                                                            appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with
                                                            custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go
                                                            within the <code>.accordion-body</code>, though the transition does limit overflow.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                            Accordion Item #2
                                                        </button>
                                                    </h2>
                                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse
                                                            plugin adds the appropriate classes that we use to style each element. These classes control the overall
                                                            appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with
                                                            custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go
                                                            within the <code>.accordion-body</code>, though the transition does limit overflow.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingThree">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                            Accordion Item #3
                                                        </button>
                                                    </h2>
                                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse
                                                            plugin adds the appropriate classes that we use to style each element. These classes control the overall
                                                            appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with
                                                            custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go
                                                            within the <code>.accordion-body</code>, though the transition does limit overflow.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- end preview-->

                                        <div class="tab-pane code" id="default-accordions-code">
                                            <button class="btn-copy-clipboard" data-clipboard-action="copy">Copy</button>
                                            <pre class="mb-0">
                                                    <span class="html escape">
                                                        &lt;div class=&quot;accordion&quot; id=&quot;accordionExample&quot;&gt;
                                                            &lt;div class=&quot;accordion-item&quot;&gt;
                                                                &lt;h2 class=&quot;accordion-header&quot; id=&quot;headingOne&quot;&gt;
                                                                    &lt;button class=&quot;accordion-button&quot; type=&quot;button&quot; data-bs-toggle=&quot;collapse&quot; data-bs-target=&quot;#collapseOne&quot;
                                                                        aria-expanded=&quot;true&quot; aria-controls=&quot;collapseOne&quot;&gt;
                                                                        Accordion Item #1
                                                                    &lt;/button&gt;
                                                                &lt;/h2&gt;
                                                                &lt;div id=&quot;collapseOne&quot; class=&quot;accordion-collapse collapse show&quot; aria-labelledby=&quot;headingOne&quot;
                                                                    data-bs-parent=&quot;#accordionExample&quot;&gt;
                                                                    &lt;div class=&quot;accordion-body&quot;&gt;
                                                                        &lt;strong&gt;This is the first item's accordion body.&lt;/strong&gt; It is shown by default, until the collapse
                                                                        plugin adds the appropriate classes that we use to style each element. These classes control the overall
                                                                        appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with
                                                                        custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go
                                                                        within the &lt;code&gt;.accordion-body&lt;/code&gt;, though the transition does limit overflow.
                                                                    &lt;/div&gt;
                                                                &lt;/div&gt;
                                                            &lt;/div&gt;
                                                            &lt;div class=&quot;accordion-item&quot;&gt;
                                                                &lt;h2 class=&quot;accordion-header&quot; id=&quot;headingTwo&quot;&gt;
                                                                    &lt;button class=&quot;accordion-button collapsed&quot; type=&quot;button&quot; data-bs-toggle=&quot;collapse&quot;
                                                                        data-bs-target=&quot;#collapseTwo&quot; aria-expanded=&quot;false&quot; aria-controls=&quot;collapseTwo&quot;&gt;
                                                                        Accordion Item #2
                                                                    &lt;/button&gt;
                                                                &lt;/h2&gt;
                                                                &lt;div id=&quot;collapseTwo&quot; class=&quot;accordion-collapse collapse&quot; aria-labelledby=&quot;headingTwo&quot;
                                                                    data-bs-parent=&quot;#accordionExample&quot;&gt;
                                                                    &lt;div class=&quot;accordion-body&quot;&gt;
                                                                        &lt;strong&gt;This is the second item's accordion body.&lt;/strong&gt; It is hidden by default, until the collapse
                                                                        plugin adds the appropriate classes that we use to style each element. These classes control the overall
                                                                        appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with
                                                                        custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go
                                                                        within the &lt;code&gt;.accordion-body&lt;/code&gt;, though the transition does limit overflow.
                                                                    &lt;/div&gt;
                                                                &lt;/div&gt;
                                                            &lt;/div&gt;
                                                            &lt;div class=&quot;accordion-item&quot;&gt;
                                                                &lt;h2 class=&quot;accordion-header&quot; id=&quot;headingThree&quot;&gt;
                                                                    &lt;button class=&quot;accordion-button collapsed&quot; type=&quot;button&quot; data-bs-toggle=&quot;collapse&quot;
                                                                        data-bs-target=&quot;#collapseThree&quot; aria-expanded=&quot;false&quot; aria-controls=&quot;collapseThree&quot;&gt;
                                                                        Accordion Item #3
                                                                    &lt;/button&gt;
                                                                &lt;/h2&gt;
                                                                &lt;div id=&quot;collapseThree&quot; class=&quot;accordion-collapse collapse&quot; aria-labelledby=&quot;headingThree&quot;
                                                                    data-bs-parent=&quot;#accordionExample&quot;&gt;
                                                                    &lt;div class=&quot;accordion-body&quot;&gt;
                                                                        &lt;strong&gt;This is the third item's accordion body.&lt;/strong&gt; It is hidden by default, until the collapse
                                                                        plugin adds the appropriate classes that we use to style each element. These classes control the overall
                                                                        appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with
                                                                        custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go
                                                                        within the &lt;code&gt;.accordion-body&lt;/code&gt;, though the transition does limit overflow.
                                                                    &lt;/div&gt;
                                                                &lt;/div&gt;
                                                            &lt;/div&gt;
                                                        &lt;/div&gt;
                                                    </span>
                                                </pre> <!-- end highlight-->
                                        </div> <!-- end preview code-->
                                    </div> <!-- end tab-content-->

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div> <!-- end row-->

                </div> <!-- container -->

            </div> <!-- content -->

            <?php include '../../src/footer_nav.php'; ?>

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