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
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title" style="display: flex; align-items: center; color:rgb(129, 155, 170);"> <i class=" ri-customer-service-2-fill ri-2x" style="color:rgb(218, 5, 200); margin-right: 8px;"></i> Controle do Estacionamento de Visitantes</h4>
                                        <p class="text-muted font-14">
                                        Nesta seção são listados todas as vagas de veículo destinada aos visitantes do condomínio.<br>
                                        O controle de entrada e saída é realizado pela portaria, podendo um veículo permanecer por no máximo 48h.
                                        </p>
                                        <div class="tab-content">



<!-- -->
<div class="parking-lot">
                  <?php
                    $slots = json_decode(file_get_contents('vagas/slots.json'), true);

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
                            :  ($id > 40 ? 'Livre<br>Rotativa' : 'Livre');
                    
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
                    <input type="text" id="apartmentInput" maxlength="5" placeholder="Apartamento (máx. 5 caracteres)" oninput="this.value = this.value.replace(/\D/g, '')">
                    <input type="text" id="modelInput" maxlength="10" placeholder="Modelo do veículo (máx. 10 caracteres)" oninput="this.value = this.value.toUpperCase()">
                    <div class="modal-footer">
                      <button id="cancelButton" style="background-color:rgb(158, 22, 28); color: white; border: none; padding: 10px 20px; cursor: pointer;">Cancelar</button>
                      <button id="submitButton" style="background-color:rgb(7, 77, 143); color: white; border: none; padding: 10px 20px; cursor: pointer;">Confirmar</button>
                      <button id="freeButton" style="background-color:rgb(7, 143, 41); color: white; border: none; padding: 10px 20px; cursor: pointer;">Liberar Vaga</button>
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