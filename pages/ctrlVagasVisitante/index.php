<?php
    ob_start();
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == NULL) {
      header("Location: ../login/index.php");
      exit();
  }

  if (!in_array(strtoupper($_SESSION['user_nivelacesso']), ["SINDICO", "SUPORTE", "PORTARIA","MORADOR"])) {
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

?>
<html lang="en" data-topbar-color="dark" data-menu-color="dark" data-sidenav-user="true" data-bs-theme="dark">
<head>
    <!-- HEAD META BASIC LOAD-->
	<?php include '../../src/headMeta.php'; ?>
	<!-- HEAD META BASIC LOAD -->
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
                <!-- INICIO CONTEUDO CONTAINER -->
                <div class="container-fluid">

                                    <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">

                                    </div>
                                    <h4 class="page-title">Bem vindo(a)</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title" style="display: flex; align-items: center; color:rgb(129, 155, 170);"> <i class=" ri-customer-service-2-fill ri-2x" style="color:rgb(218, 5, 200); margin-right: 8px;"></i> Andamento das Pendências</h4>
                                        <p class="text-muted font-14">
                                           Aqui são atualizados pelo sindico(a), os status das <strong>pendências</strong> do condomínio. Fique por dentro sobre o andamento das solicitações e projetos mais relevantes.
                                        </p>
                                        <div class="tab-content">


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                




                </div>
                <!-- FIM CONTEUDO CONTAINER -->
            </div> <!-- content -->
                
                <!-- FOOTER -->
	            <?php include '../../src/modalTermos.php'; ?>
	            <!-- FOOTER -->   
                <!-- FOOTER -->
	            <?php include '../../src/footerNav.php'; ?>
	            <!-- FOOTER --> 
        </div><!-- content-page -->
    </div>
    <!-- END wrapper -->

	
    <!-- Layout Configuration -->	
    <?php include '../../src/layoutConfig.php'; ?>
    <!-- Vendor js -->
    <script src="../../assets/js/vendor.min.js"></script>
    <!-- App js -->
    <script src="../../assets/js/app.min.js"></script>
</body>

</html>