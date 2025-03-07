<?php
ini_set('upload_max_filesize', '50M');
ini_set('post_max_size', '50M');
ini_set('memory_limit', '256M');
ini_set('max_execution_time', '300');

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
      if ($item['CFG_DCPARAMETRO'] == 'NOME_CONDOMINIO') {
          $nomeCondominio = $item['CFG_DCVALOR']; 
          break; 
      }
    }  
    
    $metodo = "insert";
    
    $titulo = "";
    $evol = "";
    $lastUpdate = "";
    $obs = "";
    $id = "";

    if(isset($_GET['id']))
    {
      $id = $_GET['id'];
      $siteAdmin->getPendenciaInfoById($id);
      $titulo = $siteAdmin->ARRAY_PENDENCIAINFO["EPE_DCTITULO"];
      $evol = $siteAdmin->ARRAY_PENDENCIAINFO["EPE_DCEVOL"];
      $obs = $siteAdmin->ARRAY_PENDENCIAINFO["EPE_DCOBS"];
      $lastUpdate = $siteAdmin->ARRAY_PENDENCIAINFO["EPE_DTLASTUPDATE"];

      $metodo = "update";
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

<!-- App favicon -->
<link rel="shortcut icon" href="../../assets/images/favicon.ico">

<!-- SimpleMDE css -->
<link href="../../assets/vendor/simplemde/simplemde.min.css" rel="stylesheet" type="text/css" />

<!-- Quill css -->
<link href="../../assets/vendor/quill/quill.core.css" rel="stylesheet" type="text/css" />
<link href="../../assets/vendor/quill/quill.snow.css" rel="stylesheet" type="text/css" />
<link href="../../assets/vendor/quill/quill.bubble.css" rel="stylesheet" type="text/css" />
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<!-- Theme Config Js -->
<script src="../../assets/js/hyper-config.js"></script>

<!-- Vendor css -->
<link href="../../assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

<!-- App css -->
<link href="../../assets/css/app-modern.min.css" rel="stylesheet" type="text/css" id="app-style" />

<!-- Icons css -->
<link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

                <!-- Barra de progresso -->
                <div id="progress-container" style="display: none; width: 100%; background: #aa2ed8; border-radius: 5px; margin-top: 10px;">
                    <div id="progress-bar" style="width: 0%; height: 5px; background: #21ffae; border-radius: 5px;"></div>
                </div>

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                </div>
                                <h4 class="page-title">Projetos e Pendências </h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Acompanhamento do Condomínio </h4>
                                    <p class="text-muted font-14">
                                        Os projetos ou pendências cadastrados aqui são publicados na seção inicial do sistema.
                                    </p>
                                    <div class="tab-content">
                                    <form class="needs-validation" id="form" name="form" role="form" method="POST" enctype="multipart/form-data" novalidate>
                                        <div class="row mb-3"> <!-- Adicionando margem entre as linhas -->

                                                    <!-- CAMPOS COMO VARIAVEIS -->
                                                    <input type="hidden" id="metodo" name="metodo" value="<?php echo $metodo; ?>"/>   
                                                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>"/>                                                  
                                                    <!-- CAMPOS COMO VARIAVEIS -->

                                            <!-- Campo Título 1 -->
                                            <div class="position-relative col-lg-6">
                                                <label class="form-label" for="titulo">Título</label>
                                                <input id="titulo" name="titulo" type="text" class="form-control" 
                                                       style="text-transform: uppercase;" 
                                                       maxlength="40" 
                                                       value = "<?php echo $titulo; ?>"
                                                       required/>
                                                <div class="valid-tooltip">Validado!</div>
                                                <div class="invalid-tooltip">Por favor, preencha o título.</div>
                                            </div>

                                            <div class="row mt-4 mb-3">
                                                <div class="position-relative col-lg-6">
                                                    <label for="evol" class="form-label">Evolução(%)</label>
                                                    <input type="text" id="evol" name="evol" data-plugin="range-slider" data-type="single" data-grid="true" data-min="10" data-max="100" data-from="<?php echo $evol; ?>" /> 
                                                </div>   
                                            </div>

    
                                        <div class="row mb-3">
                                            <div class="col-lg-8">
                                                <div class="tab-pane show active" id="hint-emoji-preview">
                                                    <!-- Editor Quill -->
                                                    <div style="height: 300px;" id="snow-editor"><?php echo $obs; ?></div>
                                                    <textarea hidden type="hidden" id="obs" name="obs"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                                               
                                        <div class="d-flex gap-2">
                                            <button class="btn" style="background-color: #aa2ed8; color: white;" onclick="window.history.back()" type="button">Voltar</button>             
                                            <button class="btn" style="background-color: #21ffae; color: black;" type="button" id="botao" name="botao">Salvar</button>  
                                        </div>                                        
                                       
                                    </form>
                                    </div> <!-- end tab-content -->

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div> <!-- end row-->                 
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
    
<script>
    document.getElementById("botao").addEventListener("click", function() {
        let form = document.getElementById("form");

        let obs = quill.root.innerHTML; 
        document.getElementById("obs").value = obs;  

        let formData = new FormData(form);

        if (form.checkValidity()) {
            Swal.fire({
                title: "Tem certeza?",
                text: "Você deseja salvar os dados?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim, salvar!",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "insertPendenciaProc.php", true);


                    let progressContainer = document.getElementById("progress-container");
                    let progressBar = document.getElementById("progress-bar");
                    progressContainer.style.display = "block";
                    progressBar.style.width = "0%";

 
                    let progress = 0;
                    let progressInterval = setInterval(() => {
                        if (progress < 95) {
                            progress += 5;
                            progressBar.style.width = progress + "%";
                        }
                    }, 200);

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4) {
                            clearInterval(progressInterval); 
                            progressBar.style.width = "100%"; 

                            setTimeout(() => {
                                progressContainer.style.display = "none"; 
                            }, 500);

                            if (xhr.status === 200) {
                                let response = xhr.responseText;
                                Swal.fire({
                                    title: 'Sucesso!',
                                    text: response, 
                                    icon: 'success'
                                }).then(() => {
                                    form.reset();
                                    window.history.back();
                                });
                            }
                        }
                    };
                    xhr.send(formData);
                }
            });
        } else {
            form.classList.add("was-validated"); 
        }
    });
</script>


    <!-- Vendor js -->
    <script src="../../assets/js/vendor.min.js"></script>

    <!-- Code Highlight js -->
    <script src="../../assets/vendor/highlightjs/highlight.pack.min.js"></script>
    <script src="../../assets/vendor/clipboard/clipboard.min.js"></script>
    <script src="../../assets/js/hyper-syntax.js"></script>

    <!-- Quill Editor js -->
    <script src="../../assets/vendor/quill/quill.js"></script>

    <!-- Quill Demo js -->
    <script src="../../assets/js/pages/demo.quilljs.js"></script>

    <!-- Simplemde Editor js -->
    <script src="../../assets/vendor/simplemde/simplemde.min.js"></script>

    <!-- Simplemde Demo js -->
    <script src="../../assets/js/pages/demo.simplemde.js"></script>

    <!-- App js -->
    <script src="../../assets/js/app.min.js"></script>

    <!-- Plgins only -->
    <script src="../../assets/vendor/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
    <script src="../../assets/js/ui/component.range-slider.js"></script>

    <!-- Rateit js -->
    <script src="../../assets/vendor/jquery.rateit/scripts/jquery.rateit.min.js"></script>

    <!-- Rateit Cemo  js -->
    <script src="../../assets/js/ui/component.rating.js"></script>
    <script src="../../assets/js/blockCode.js"></script>


</body>

</html>