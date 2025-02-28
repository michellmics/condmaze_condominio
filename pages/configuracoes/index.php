<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == NULL) {
    header("Location: ../login/index.php");
    exit();
}

if (!in_array(strtoupper($_SESSION['user_nivelacesso']), ["SINDICO", "SUPORTE"])) {
    header("Location: ../errors/index.php");
    exit();
}

	include_once "../../objects/objects.php";
	
    $siteAdmin = new SITE_ADMIN();  
    $siteAdmin->getParameterInfo();

    foreach ($siteAdmin->ARRAY_PARAMETERINFO as $item) {
      if (trim($item['CFG_DCPARAMETRO'] == 'NOME_CONDOMINIO')) {$nomeCondominio = $item['CFG_DCVALOR'];}
      if (trim($item['CFG_DCPARAMETRO'] == 'QTDE_APARTAMENTOS')) {$qtdeUnidades = $item['CFG_DCVALOR'];} 

      if (trim($item['CFG_DCPARAMETRO'] == 'EMAIL_ALERTAS')) {$email = $item['CFG_DCVALOR'];}
      if (trim($item['CFG_DCPARAMETRO'] == 'WHATSAPP_STATUS')) {$whatsStatus = $item['CFG_DCVALOR'];} 

      if (trim($item['CFG_DCPARAMETRO'] == 'WHATSAPP_SENDER')) {$whatsSender = $item['CFG_DCVALOR'];}
      if (trim($item['CFG_DCPARAMETRO'] == 'WHATSAPP_SID')) {$whatsSid = $item['CFG_DCVALOR'];} 

      if (trim($item['CFG_DCPARAMETRO'] == 'WHATSAPP_TOKEN')) {$whatsToken = $item['CFG_DCVALOR'];}
      if (trim($item['CFG_DCPARAMETRO'] == 'IP_PORTARIA')) {$ipPortaria = $item['CFG_DCVALOR'];} 
      if (trim($item['CFG_DCPARAMETRO'] == 'TELEFONE_SINDICO')) {$whatsSindico = $item['CFG_DCVALOR'];} 
      
      if (trim($item['CFG_DCPARAMETRO'] == 'MAIL_SMTP_PASS')) {$MAIL_SMTP_PASS = $item['CFG_DCVALOR'];}  
      if (trim($item['CFG_DCPARAMETRO'] == 'MAIL_SMTP_USER')) {$MAIL_SMTP_USER = $item['CFG_DCVALOR'];} 
      if (trim($item['CFG_DCPARAMETRO'] == 'MAIL_SMTP_PORT')) {$MAIL_SMTP_PORT = $item['CFG_DCVALOR'];}  
      if (trim($item['CFG_DCPARAMETRO'] == 'MAIL_SMTP_HOST')) {$MAIL_SMTP_HOST = $item['CFG_DCVALOR'];}
      if (trim($item['CFG_DCPARAMETRO'] == 'IDIOMA_APP')) {$IDIOMA_APP = $item['CFG_DCVALOR'];}

    }   

?>
<!DOCTYPE html>
<html lang="en" data-topbar-color="dark" data-menu-color="dark" data-sidenav-user="true" data-bs-theme="dark">
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

    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!-- ######################################################## --> 
    <!-- SWEETALERT 2 --> 
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
    <!-- ######################################################## --> 

    <!-- PWA MOBILE CONF -->
	<?php include '../../src/pwa_conf.php'; ?>
	<!-- PWA MOBILE CONF -->

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
                <div class="container-fluid"><!-- INICIO CONTEUDO CONTAINER -->
                    <!-- start page title -->

                                        <!-- start page title -->
                                        <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                </div>
                                <h4 class="page-title">Configuração do Sistema</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Configurações</h4>
                                    <p class="text-muted font-14">Nesta seção estão os dados de configuração, importantes para o sistema funcionar corretamente.
                                    </p>

                                    <div class="tab-content">
                                      <div class="tab-pane show active" id="tooltips-validation-preview">
                                          <form class="needs-validation" id="form" name="form" role="form" method="POST" enctype="multipart/form-data" novalidate>
                                              
                                              <?php 
                                              $fields = [
                                                  "nomeCondominio" => ["label" => "Nome do Condomínio", "pattern" => ".*", "maxlength" => "50", "value" => $nomeCondominio],
                                                  "qtdeUnidades" => ["label" => "Quantidade de Unidades", "pattern" => "^[0-9]{1,4}$", "maxlength" => "4", "value" => $qtdeUnidades],
                                                  "email" => ["label" => "E-mail para Notificações", "pattern" => ".*", "maxlength" => "50", "value" => $email],
                                                  "whatsStatus" => ["label" => "Whatsapp Status (ATIVO INATIVO)", "pattern" => "^[0-9]*$", "maxlength" => "10", "value" => $whatsStatus],
                                                  "whatsSindico" => ["label" => "Whatsapp Telefone Síndico", "pattern" => ".*", "maxlength" => "20", "value" => $whatsSindico],
                                                  "whatsSender" => ["label" => "Whatsapp Telefone Sender", "pattern" => ".*", "maxlength" => "20", "value" => $whatsSender],
                                                  "whatsSid" => ["label" => "Whatsapp SID", "pattern" => ".*", "maxlength" => "50", "value" => $whatsSid],
                                                  "whatsToken" => ["label" => "Whatsapp Token", "pattern" => ".*", "maxlength" => "50", "value" => $whatsToken],
                                                    
                                                    "idioma" => [
                                                        "label" => "Idioma do App",
                                                        "type" => "select",
                                                        "options" => [
                                                            "pt" => "Português",
                                                            "en" => "English",
                                                            "sp" => "Spanish",
                                                            "ar" => "العربية" 
                                                        ],
                                                        "value" => $IDIOMA_APP
                                                    ],

                                                  "EMAIL_SMTP_SENHA" => ["label" => "E-mail SMTP Senha", "pattern" => ".*", "maxlength" => "50", "value" => $MAIL_SMTP_PASS],
                                                  "EMAIL_SMTP_USUÁRIO" => ["label" => "E-mail SMTP Usuário", "pattern" => ".*", "maxlength" => "50", "value" => $MAIL_SMTP_USER],
                                                  "EMAIL_SMTP_PORTA" => ["label" => "E-mail SMTP Porta", "pattern" => ".*", "maxlength" => "50", "value" => $MAIL_SMTP_PORT],
                                                  "EMAIL_SMTP_HOST" => ["label" => "E-mail SMTP Host", "pattern" => ".*", "maxlength" => "50", "value" => $MAIL_SMTP_HOST],
                                                  "ipPortaria" => ["label" => "Endereço IP PC Portaria", "pattern" => "^\d{1,3}(\.\d{1,3}){3}$", "maxlength" => "50", "value" => $ipPortaria]
                                              ];
                                              
                                              foreach ($fields as $id => $data) : ?>
                                                  <div class="row g-2 align-items-end mb-3">
                                                      <div class="col-8 col-md-10"> 
                                                          <label class="form-label" for="<?= $id; ?>"><?= $data['label']; ?></label>
                                                          <input 
                                                              value="<?php echo $data['value']; ?>" 
                                                              id="<?= $id; ?>" 
                                                              name="<?= $id; ?>" 
                                                              type="text" 
                                                              class="form-control"
                                                              pattern="<?= $data['pattern']; ?>" 
                                                              maxlength="<?= $data['maxlength']; ?>" 
                                                              oninput="
                                                                  <?php if ($id === 'whatsSender' || $id === 'whatsToken') : ?>
                                                                      this.value = this.value.replace(/[^0-9]/g, '');
                                                                  <?php elseif ($id === 'qtdeUnidades') : ?>
                                                                      this.value = this.value.replace(/[^0-9]/g, '').slice(0,4);
                                                                  <?php elseif ($id === 'ipPortaria') : ?>
                                                                      this.value = this.value.replace(/[^0-9.]/g, '');
                                                                  <?php endif; ?>
                                                              " 
                                                              required 
                                                          />
                                                          <div class="valid-tooltip">Validado!</div>
                                                          <div class="invalid-tooltip">Por favor, preencha o <?= strtolower($data['label']); ?> corretamente.</div>
                                                      </div>
                                                      <div class="col-4 col-md-2 d-flex align-items-end">
                                                          <button type="button" class="btn btn-warning w-70 update-btn" data-input="<?= $id; ?>">EDIT</button>
                                                      </div>
                                                  </div>
                                              <?php endforeach; ?>
                                                                  
                                              <br>
                                              <button class="btn btn-danger" onclick="window.history.back()" type="button">Voltar</button>             
                                                                  
                                          </form>
                                      </div> <!-- end preview-->                                        
                                  </div> <!-- end tab-content-->

                                              
                                  <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        document.querySelectorAll(".update-btn").forEach(button => {
                                            button.addEventListener("click", function() {
                                                let inputId = this.getAttribute("data-input");
                                                let inputValue = document.getElementById(inputId).value;
                                            
                                                if (inputValue.trim() === "") {
                                                    Swal.fire({
                                                        icon: 'warning',
                                                        title: 'Atenção',
                                                        text: 'Por favor, preencha o campo antes de atualizar.'
                                                    });
                                                    return;
                                                }
                                              
                                                fetch("updateConfigProc.php", {
                                                    method: "POST",
                                                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                                                    body: `campo=${encodeURIComponent(inputId)}&valor=${encodeURIComponent(inputValue)}`
                                                })
                                                .then(response => response.json())
                                                .then(result => {
                                                    if (result.status === "success") {
                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Sucesso!',
                                                            text: result.message
                                                        });
                                                        
                                                    } else {
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Erro!',
                                                            text: result.message
                                                        });
                                                    }
                                                })
                                                .catch(error => {
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Erro!',
                                                        text: 'Erro ao atualizar.'
                                                    });
                                                    console.error("Erro:", error);
                                                });
                                            });
                                        });
                                    });
                                    </script>


                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>
                    <!-- end row -->

                                                    
                </div><!-- FIM CONTEUDO CONTAINER -->                

            <!-- content -->
        <!-- FOOTER -->
	    <?php include '../../src/modalTermos.php'; ?>
	    <!-- FOOTER -->   
        <!-- FOOTER -->
	    <?php include '../../src/footerNav.php'; ?>
	    <!-- FOOTER --> 
       

    <!-- END wrapper -->

	
<!-- Layout Configuration -->	
<?php include '../../src/layoutConfig.php'; ?>
    
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


</body>

</html>