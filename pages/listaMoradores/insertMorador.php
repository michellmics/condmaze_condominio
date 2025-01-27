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

    $metodo = "insert";

        //if edição de morador
        if(isset($_GET['apartamento']))
        {
          $apartamento = $_GET['apartamento'];

          $readonly = "readonly style='border: 2px solid red;'";
    
          $siteAdmin->getMoradorById($apartamento);

          $nome = $siteAdmin->ARRAY_USERINFOBYID["USU_DCNOME"];
          $apartamento = $siteAdmin->ARRAY_USERINFOBYID["USU_DCAPARTAMENTO"];
          $bloco = $siteAdmin->ARRAY_USERINFOBYID["USU_DCBLOCO"];
          $telefone = $siteAdmin->ARRAY_USERINFOBYID["USU_DCTELEFONE"];
          $email = $siteAdmin->ARRAY_USERINFOBYID["USU_DCEMAIL"];
          $nivelMorador = ($siteAdmin->ARRAY_USERINFOBYID["USU_DCNIVEL"] == 'MORADOR') ? 'checked' : '';
          $nivelSindico = ($siteAdmin->ARRAY_USERINFOBYID["USU_DCNIVEL"] == 'SINDICO') ? 'checked' : '';
          $nivelPortaria = ($siteAdmin->ARRAY_USERINFOBYID["USU_DCNIVEL"] == 'PORTARIA') ? 'checked' : '';
    
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
                                <h4 class="page-title">Cadastro de Morador</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Morador</h4>
                                    <p class="text-muted font-14">Nesta seção você pode cadastrar um novo morador para ter acesso ao sistema.
                                    </p>

                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="tooltips-validation-preview">
                                            <form class="needs-validation" id="form" name="form" role="form" method="POST" enctype="multipart/form-data" novalidate>
                                                
                                                    <!-- CAMPOS COMO VARIAVEIS -->
                                                    <input type="hidden" id="metodo" name="metodo" value="<?php echo $metodo; ?>"/>
                                                    <input type="hidden" id="idmorador" name="idmorador" value="<?php echo $idmorador; ?>"/>
                                                    <!-- CAMPOS COMO VARIAVEIS -->
                                            
                                                  <div class="position-relative mb-3">
                                                    <label class="form-label" for="validationTooltip01">Nome Completo</label>
                                                    <input value="<?php if(isset($nome)){echo $nome;} ?>" id="nome" name="nome" style="text-transform: uppercase;" type="text" class="form-control" id="inputWarning" placeholder="ENTER..." maxlength="28" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '')" required/>
                                                    <div class="valid-tooltip">
                                                        Validado!
                                                    </div>
                                                    <div class="invalid-tooltip">
                                                        Por favor, preencha o nome completo.
                                                    </div>
                                                </div>
                                                <div class="position-relative mb-3">
                                                    <label class="form-label" for="validationTooltip02">E-mail</label>
                                                    <input value="<?php if(isset($email)){echo $email;} ?>" id="email" name="email" style="text-transform: uppercase;" type="text" class="form-control" placeholder="ENTER..." maxlength="50" oninput="this.value = this.value.replace(/[^A-Za-z0-9._@-]/g, '')" required />
                                                    <div class="valid-tooltip">
                                                        Validado!
                                                    </div>
                                                    <div class="invalid-tooltip">
                                                    Por favor, preencha o e-mail do morador.
                                                    </div>
                                                </div>
                                                <div class="position-relative mb-3">
                                                    <label class="form-label" for="validationTooltip02">Bloco</label>
                                                    <input value="<?php if(isset($bloco)){echo $bloco;} ?>" id="bloco" name="bloco" type="text" class="form-control" placeholder="" maxlength="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required <?php if(isset($readonly)){echo $readonly;} ?>/>
                                                    <div class="valid-tooltip">
                                                        Validado!
                                                    </div>
                                                    <div class="invalid-tooltip">
                                                    Por favor, preencha o número do bloco.
                                                    </div>
                                                </div>
                                                <div class="position-relative mb-3">
                                                    <label class="form-label" for="validationTooltip02">Apartamento</label>
                                                    <input value="<?php if(isset($apartamento)){echo $apartamento;} ?>" id="apartamento" name="apartamento" type="text" class="form-control" placeholder="" maxlength="4" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required <?php if(isset($readonly)){echo $readonly;} ?>/>
                                                    <div class="valid-tooltip"> 
                                                        Validado!
                                                    </div>
                                                    <div class="invalid-tooltip">
                                                    Por favor, preencha o número do apartamento.
                                                    </div>
                                                </div> 
                                                <div class="position-relative mb-3">
                                                    <label class="form-label">DDD + Telefone (Whatsapp)</label>
                                                    <input value="<?php if(isset($telefone)){echo $telefone;} ?>" id="telefone" name="telefone" type="text" class="form-control" placeholder="Ex.: 11982734359" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />
                                                    <div class="valid-tooltip">
                                                        Validado!
                                                    </div>
                                                    <div class="invalid-tooltip">
                                                    Por favor, preencha o número do telefone.
                                                    </div>
                                                </div> 
                                                <div class="position-relative mb-3">
                                                    <label class="form-label" for="validationTooltip02">Senha</label>
                                                    <input value="<?php if(isset($senha)){echo $senha;} ?>" id="senha" name="senha" type="password" class="form-control" placeholder="" minlength="8" maxlength="10" required />
                                                    <div class="valid-tooltip">
                                                        Validado!
                                                    </div>
                                                    <div class="invalid-tooltip">
                                                    Por favor, preencha a senha de acesso.
                                                    </div>
                                                </div> 
                                                <h6 class="font-15 mt-3">Nível de Acesso</h6>
                                                <div class="mt-2">
                                                    <div class="form-check form-check-inline form-radio-info mb-2">
                                                        <input value="MORADOR" type="radio" id="nivel" name="nivel" class="form-check-input" <?php if(isset($nivelMorador)){echo $nivelMorador;} ?>>
                                                        <label class="form-check-label" for="customRadio3">Morador</label>
                                                    </div>
                                                    <div class="form-check form-check-inline form-radio-warning mb-2">
                                                        <input value="PORTARIA" type="radio" id="nivel" name="nivel" class="form-check-input" <?php if(isset($nivelPortaria)){echo $nivelPortaria;} ?>>
                                                        <label class="form-check-label" for="customRadio4">Portaria</label>
                                                    </div>
                                                    <div class="form-check form-check-inline form-radio-danger mb-2">
                                                        <input value="SINDICO" type="radio" id="nivel" name="nivel" class="form-check-input" <?php if(isset($nivelSindico)){echo $nivelSindico;} ?>>
                                                        <label class="form-check-label" for="customRadio4">Síndico</label>
                                                    </div>
                                                </div>
                                                <br>

                                                <button class="btn btn-danger" onclick="window.history.back()" type="button">Cancelar</button>             
                                                <button class="btn btn-primary" type="button" id="botao" name="botao">Salvar</button>
                                            </form>
                                        </div> <!-- end preview-->                                        
                                    </div> <!-- end tab-content-->
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>
                    <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->



 


		<!-- Menu Nav Area -->
		<?php include '../../src/footer_nav.php'; ?>
		<!-- End Menu Nav -->
        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

   <!-- ######################################################## --> 
    <!-- SWEETALERT 2 -->   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>

        function validarFormulario() {
            const nome = document.querySelector('input[name="nome"]').value.trim();
            const email = document.querySelector('input[name="email"]').value.trim();
            const bloco = document.querySelector('input[name="bloco"]').value.trim();
            const apartamento = document.querySelector('input[name="apartamento"]').value.trim();
            const senha = document.querySelector('input[name="senha"]').value.trim();
            const telefone = document.querySelector('input[name="telefone"]').value.trim();
            const metodo = document.querySelector('input[name="metodo"]').value.trim();

            if(metodo != "update")
            {
              if (!nome || !email || !bloco || !apartamento || !senha || !telefone) {
                  alert("Todos os campos devem ser preenchidos.");
                  return false;
              }
              return true;
            }
            if(metodo == "update")
            {
              if (!nome || !email || !bloco || !apartamento || !telefone) {
                  alert("Todos os campos devem ser preenchidos.");
                  return false;
              }
              return true;
            }
        }



       function confirmAndSubmit(event) {
       
        const isValid = validarFormulario();
        const metodo = document.querySelector('input[name="metodo"]').value.trim();

        let msgBox = "";

        if(metodo == 'insert')
        {
          msgBox = "Têm certeza que deseja inserir o morador?";
        }
        else
          {
            msgBox = "Têm certeza que deseja atualizar o morador?";
          }

        if (!isValid) {
            return;
        }

        event.preventDefault(); // Impede o envio padrão do formulário
        Swal.fire({
          title: 'Formulário de Moradores',
          text: msgBox,
          showDenyButton: true,
          confirmButtonText: 'CONFIRMAR',
          denyButtonText: `CANCELAR`,
          confirmButtonColor: "#536de6",
          denyButtonColor: "#ff5b5b",
          width: '400px', // Largura do alerta
          icon: 'warning',
          customClass: {
            title: 'swal-title', // Classe para o título
            content: 'swal-content', // Classe para o conteúdo (texto)
            confirmButton: 'swal-confirm-btn',
            denyButton: 'swal-deny-btn',
            htmlContainer: 'swal-text'
          }
        }).then((result) => {
          if (result.isConfirmed) {
            // Capturar os dados do formulário
            var formData = new FormData($("#form")[0]); // Usa o FormData para enviar arquivos
            // Fazer a requisição AJAX
            $.ajax({
              url: "insertMoradorProc.php", // URL para processamento
              type: "POST",
              data: formData,
              processData: false, // Impede o jQuery de processar os dados
              contentType: false, // Impede o jQuery de definir o tipo de conteúdo
              success: function (response) {
                Swal.fire({
              title: 'Atenção',
              text: `${response}`,
              icon: 'success',
              width: '400px', // Largura do alerta
              confirmButtonColor: "#536de6",
              customClass: {
                title: 'swal-title', // Aplicando a mesma classe do título
                content: 'swal-content', // Aplicando a mesma classe do texto
                htmlContainer: 'swal-text',
                confirmButton: 'swal-confirm-btn'
              }
            }).then(() => {
                  // Redirecionar ou atualizar a página, se necessário
                   window.location.href = "index.php";
                });
              },
              error: function (xhr, status, error) {
                Swal.fire({
              title: 'Erro!',
              text: 'Erro ao atualizar o convidado.'.error,
              icon: 'error',
              width: '400px', // Largura do alerta
              confirmButtonColor: "#536de6",
              customClass: {
                title: 'swal-title', // Aplicando a mesma classe do título
                content: 'swal-content', // Aplicando a mesma classe do texto
                htmlContainer: 'swal-text',
                confirmButton: 'swal-confirm-btn'
              }
            });
              },
            });
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire('Cancelado', 'Nenhuma alteração foi salva.', 'info');
          }
        });
      }
      // Associar a função ao botão de submit
      $(document).ready(function () {
        $("#botao").on("click", confirmAndSubmit);
      });
</script> 
<style>
  /* Estilos para aumentar o tamanho da fonte */
  .swal-title {
    font-size: 25px !important; /* Tamanho maior para o título */
  }

  .swal-text {
    font-size: 16px !important; /* Tamanho maior para o conteúdo */
  }

  /* Aumentar o tamanho dos textos dos botões */
  .swal-confirm-btn,
  .swal-deny-btn,
  .swal-cancel-btn {
    font-size: 16px !important; /* Tamanho maior para os textos dos botões */
    padding: 8px 8px !important; /* Aumenta o espaço ao redor do texto */
  }
</style>
<!-- ######################################################## --> 
<!-- SWEETALERT 2 -->   

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