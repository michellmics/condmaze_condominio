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
    $ordem = "";
    $texto = "";
    $fileUrl = "";
    $id = "";

    if(isset($_GET['id']))
    {
      $id = $_GET['id'];
      $siteAdmin->getArtigosInfoById($id);
      $titulo = $siteAdmin->ARRAY_ARTIGOSINFO["INA_DCTITULO"];
      $ordem = $siteAdmin->ARRAY_ARTIGOSINFO["INA_DCORDEM"];
      $texto = $siteAdmin->ARRAY_ARTIGOSINFO["INA_DCTEXT"];
      $fileUrl = $siteAdmin->ARRAY_ARTIGOSINFO["INA_DCFILEURL"];

      $metodo = "update";
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
                                <h4 class="page-title">Procedimentos e Comunicados</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Informativo aos Moradores </h4>
                                    <p class="text-muted font-14">
                                        Os artigos cadastrados aqui são publicados na seção inicial do sistema..
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
                                                       maxlength="28" 
                                                       value = "<?php echo $titulo; ?>"
                                                       required/>
                                                <div class="valid-tooltip">Validado!</div>
                                                <div class="invalid-tooltip">Por favor, preencha o título.</div>
                                            </div>

                                            <!-- Campo ordem 2 -->
                                            <div class="position-relative col-lg-2">
                                                <label class="form-label" for="ordem">Ordem de Exibição</label>
                                                <input id="ordem" name="ordem" type="text" class="form-control" 
                                                       style="text-transform: uppercase;" 
                                                       maxlength="2" 
                                                       pattern="[0-9]+"
                                                       value = "<?php echo $ordem; ?>"
                                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')"                                                                                                          
                                                       required/>
                                                <div class="valid-tooltip">Validado!</div>
                                                <div class="invalid-tooltip">Por favor, preencha a ordem (somente números)</div>
                                            </div>                                            
                                        </div>

                                            <!-- Campo de Upload -->
                                            <div class="row mb-3">
                                                <div class="col-lg-6">
                                                    <label class="form-label" for="arquivo">Anexar Arquivo</label>                                                                                                     
                                                    <input id="arquivo" name="arquivo" type="file" class="form-control">

                                                    <small class="text-muted">Formatos permitidos: PDF, DOCX, JPG, PNG</small>
                                                </div>
                                            </div>

                                        <div class="row mb-3">
                                            <div class="col-lg-8">
                                                <div class="tab-pane show active" id="hint-emoji-preview">
                                                    <!-- Editor Quill -->
                                                    <div style="height: 300px;" id="snow-editor"><?php echo $texto; ?></div>
                                                    <textarea hidden type="hidden" id="artigo" name="artigo"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                                               
                                            <button class="btn btn-danger col-lg-1" onclick="window.history.back()" type="button">Voltar</button>             
                                            <button class="btn btn-primary col-lg-1" type="button" id="botao" name="botao">Salvar</button>                                          
                                       
                                    </form>
                                    </div> <!-- end tab-content -->

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

    <script>
    document.getElementById("botao").addEventListener("click", function() {
        let form = document.getElementById("form");

        // Pega o conteúdo do editor e define no campo 'artigo'
        let artigoContent = quill.root.innerHTML; // Pega o conteúdo do Quill
        document.getElementById("artigo").value = artigoContent;  // Define no campo hidden ou textarea

        let formData = new FormData(form);

        // Verifica a validade do formulário
        if (form.checkValidity()) {
            // Exibe o alerta de confirmação
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
                    // Envia os dados via AJAX
                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "insertArtigoProc.php", true);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            // Resposta do servidor
                            let response = xhr.responseText;

                            // Exibe a resposta no SweetAlert
                            Swal.fire({
                                title: 'Sucesso!',
                                text: response, // Mostra a resposta do servidor
                                icon: 'success'
                            }).then(() => {
                                // Você pode realizar ações adicionais após o sucesso, como limpar o formulário ou redirecionar
                                form.reset();
                            });
                        }
                    };
                    xhr.send(formData); // Envia os dados do formulário
                }
            });
        } else {
            form.classList.add("was-validated"); // Exibe os erros de validação
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



</body>

</html>