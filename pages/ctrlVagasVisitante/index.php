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
<style>
    #promoPopup {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* Fundo escuro semi-transparente */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .popup-content {
        position: relative;
		background: transparent; /* Alterado para transparente */
        padding: 20px;
        border-radius: 10px;
        box-shadow: none;
        max-width: 90%;
        max-height: 90%;
        text-align: center;
    }

    .popup-content img {
        max-width: 100%;
        height: auto;
    }

    .close-btn {
		top: -20px; /* Move o botão para cima da imagem */
        right: -20px; /* Move o botão para a direita da imagem */
        position: absolute;
        background:rgb(0, 0, 0);
        color: white;
        border: none;
        font-size: 20px;
        padding: 5px 10px;
        border-radius: 50%;
        cursor: pointer;
    }

    .close-btn:hover {
        background: #cc0000;
    }
</style>
<!-- pop-up promoção CSS -->
<style>
    /* Estilo do corpo */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      text-align: center;
      background-color: #f4f7fa;
      margin: 0;
      padding: 0;
    }

    h1 {
      margin-top: 20px;
      font-size: 30px;
      color: #333;
    }

    /* Estilo do estacionamento */
    .parking-lot {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 15px;
      justify-content: center;
      margin-top: 40px;
      padding: 0 15px;
    }

    .slot-wrapper {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    /* Estilo das vagas */
    .slot {
      width: 150px;
      height: 150px;
      border: 2px solid #ddd;
      background-color: #e0f7fa;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      transition: 0.3s ease-in-out;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Vaga livre */
    .slot.free {
      background: linear-gradient(135deg,rgb(18, 100, 43),rgb(8, 105, 65));
      color: white;
    }

    /* Vaga ocupada */ 
    .slot.occupied {
      background: linear-gradient(135deg,rgb(5, 84, 129),rgb(10, 193, 199));
      color: white;
    }

    /* Vaga irregular*/ 
    .slot.alert {
      background: linear-gradient(135deg,rgb(252, 50, 0),rgb(167, 19, 19));
      color: white;
    }

    .slot:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
    }

    .slot-number {
      margin-top: 10px;
      font-size: 14px;
      color: #555;
      font-weight: bold;
    }
    .slot-status {
      margin-top: 2px;
      font-size: 10px;
      color: red;
      font-weight: italic;
    }

    /* Modal */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.3);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: white;
      padding: 25px;
      border-radius: 12px;
      width: 90%;
      max-width: 400px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
      font-size: 20px;
      margin-bottom: 15px;
      color: #333;
    }

    /* Estilo do botão */
    .modal-footer button {
      background-color:rgb(173, 62, 238);
      color: white;
      padding: 10px 15px;
      margin-left: 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .modal-footer button:hover {
      background-color:rgb(5, 170, 235);
    }

    input {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
    }

    input:focus {
      border-color: #00796b;
      outline: none;
    }
  </style>
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
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title" style="display: flex; align-items: center; color:rgb(129, 155, 170);"> <i class=" ri-customer-service-2-fill ri-2x" style="color:rgb(218, 5, 200); margin-right: 8px;"></i> Controle do Estacionamento de Visitantes</h4>
                                        <p class="text-muted font-14">
                                        Nesta seção são listados todas as vagas de veículo destinada aos visitantes do condomínio.<br>
                                        O controle de entrada e saída é realizado pela portaria, podendo um veículo permanecer por no máximo 48h.
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