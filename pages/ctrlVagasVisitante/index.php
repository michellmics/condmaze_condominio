<?php
    ob_start();
    session_start();

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $baseUrl = $protocol . "://" . $host;
    $webmailUrl = $baseUrl . "/api//";

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

<!-- pop-up promoção CSS -->
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
      background: linear-gradient(135deg,rgb(44, 85, 139),rgb(72, 118, 172));
      color: white;
    }

    /* Vaga ocupada */ 
    .slot.occupied {
      background: linear-gradient(135deg,rgb(5, 129, 57),rgb(19, 90, 1));
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



                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Controle do Estacionamento de Visitantes</h4>
                                    <p class="text-muted font-14">
                                        Nesta seção são listados todas as vagas de veículo destinada aos visitantes do condomínio.<br>
                                        O controle de entrada e saída é realizado pela portaria, podendo um veículo permanecer por no máximo 48h.
                                    </p>
                                    <div class="tab-content">


    		    
            
                <div class="parking-lot">
                  <?php
                    $slots = json_decode(file_get_contents('slots.json'), true);

                    foreach ($slots as $id => $slot) {
                        $irregular="";
                        $statusClass = $slot['status'] === 'occupied' ? 'occupied' : 'free';

                        if($slot['alarm'] === 'alarmed')
                        {
                            $statusClass = 'alert';
                            $irregular = "IRREGULAR";
                        } 
                        
                        
                        
                        $displayText = $slot['status'] === 'occupied' 
                            ? '<div><b>' . htmlspecialchars(strtoupper($slot['plate'])) . '</b></div>' . 
                              '<div>' . htmlspecialchars(strtoupper($slot['vehicle_model'])) . '</div>' . 
                              '<div>AP: ' . htmlspecialchars($slot['apartment']) . '</div>' . 
                              '<div style="font-size: 10px; color:rgb(214, 214, 214);">' . htmlspecialchars($slot['entry_time']) . '</div>'
                            : 'Livre';
                    
                        echo '<div class="slot-wrapper">
                                <div class="slot ' . $statusClass . '" data-id="' . $id . '">' . $displayText . '</div>
                                <span class="slot-status">' . $irregular . '</span>
                                <span class="slot-number">ID ' . $id . '</span>
                              </div>';
                    }
                  ?>
                </div>
                <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'PORTARIA'): ?>        
                <!-- Modal -->
                <div class="modal" id="inputModal">
                  <div class="modal-content">
                    <div class="modal-header">Preencha os dados do veículo</div>
                    <input type="text" id="plateInput" maxlength="7" placeholder="Placa (máx. 7 caracteres)" oninput="this.value = this.value.toUpperCase()">
                    <input type="text" id="apartmentInput" maxlength="5" placeholder="Apartamento (máx. 5 caracteres)">
                    <input type="text" id="modelInput" maxlength="10" placeholder="Modelo do veículo (máx. 10 caracteres)" oninput="this.value = this.value.toUpperCase()">
                    <div class="modal-footer">
                      <button id="cancelButton">Cancelar</button>
                      <button id="submitButton">Confirmar</button>
                      <button id="freeButton">Liberar Vaga</button>
                    </div>
                  </div>
                </div>
                <?php endif; ?> 
                
                <script>
                  const modal = document.getElementById('inputModal');
                  const plateInput = document.getElementById('plateInput');
                  const apartmentInput = document.getElementById('apartmentInput');
                  const modelInput = document.getElementById('modelInput');
                  let currentSlotId = null;
                
                  // Abre o modal
                  function openModal(slotId) {
                    currentSlotId = slotId;
                    plateInput.value = '';
                    apartmentInput.value = '';
                    modelInput.value = '';
                    modal.style.display = 'flex';
                  }
              
                  // Fecha o modal
                  function closeModal() {
                    modal.style.display = 'none';
                    currentSlotId = null;
                  }
              
                  document.querySelectorAll('.slot').forEach(slot => {
                    slot.addEventListener('click', () => openModal(slot.dataset.id));
                  });
              
                  document.getElementById('cancelButton').addEventListener('click', closeModal);
              
                  document.getElementById('submitButton').addEventListener('click', () => {
                    const plate = plateInput.value.trim();
                    const apartment = apartmentInput.value.trim();
                    const model = modelInput.value.trim();

                    if (!/^[A-Z0-9]{1,7}$/.test(plate)) {
                      alert("Placa inválida! Use apenas letras e números (máximo 7 caracteres).");
                      return;
                    }
                
                    if (!/^\d{1,5}$/.test(apartment)) {
                      alert("Apartamento inválido! Use apenas números (máximo 5 caracteres).");
                      return;
                    }
                
                    if (model.length === 0 || model.length > 10) {
                      alert("Modelo inválido! Máximo de 10 caracteres.");
                      return;
                    }
                
                    fetch('update_slot.php', {
                      method: 'POST',
                      headers: { 'Content-Type': 'application/json' },
                      body: JSON.stringify({
                        id: currentSlotId,
                        plate: plate,
                        apartment: apartment,
                        vehicle_model: model,
                        entry_time: new Date().toLocaleString('pt-BR')
                      })
                    })
                    .then(() => {
                      closeModal();
                      location.reload();
                    });
                  });
              
                  document.getElementById('freeButton').addEventListener('click', () => {
                    if (confirm("Tem certeza de que deseja liberar esta vaga?")) {
                      fetch('update_slot.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                          id: currentSlotId,
                          status: 'free',
                          plate: '',
                          apartment: '',
                          vehicle_model: '',
                          entry_time: ''
                        })
                      })
                      .then(() => {
                        closeModal();
                        location.reload();
                      });
                    }
                  });
                </script>








</div>
</div>
</div>
</div>
</div>




		



 


		<!-- Menu Nav Area -->
		<?php include '../../src/footer_nav.php'; ?>
		<!-- End Menu Nav -->
        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

   



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

    <script>
    // Função para realizar o refresh da página após 30 minutos
    setInterval(function() {
        location.reload(); // Recarrega a página
    }, 300000); // 5 minutos em milissegundos 
    </script>

</body>

</html>