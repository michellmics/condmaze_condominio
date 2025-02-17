<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
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
                                                                                            
                                                  <div class="position-relative mb-3">
                                                    <label class="form-label" for="nomeCondominio">Nome do Condomínio</label>
                                                    <input value="<?php echo "teste"; ?>" id="nomeCondominio" name="nomeCondominio" type="text" class="form-control" id="inputWarning" placeholder="" maxlength="28" required/>
                                                    <div class="valid-tooltip">
                                                        Validado!
                                                    </div>
                                                    <div class="invalid-tooltip">
                                                        Por favor, preencha o nome do condominio.
                                                    </div>
                                                </div>
                                                <div class="position-relative mb-3">
                                                    <label class="form-label" for="qtdeUnidades">Quantidade de Unidades</label>
                                                    <input value="<?php echo "teste"; ?>" id="qtdeUnidades" name="qtdeUnidades" style="text-transform: uppercase;" type="text" class="form-control" placeholder="" maxlength="4" oninput="this.value = this.value.replace(/[^A-Za-z0-9._@-]/g, '')" required />
                                                    <div class="valid-tooltip">
                                                        Validado!
                                                    </div>
                                                    <div class="invalid-tooltip">
                                                    Por favor, preencha a quantidade de unidades.
                                                    </div>
                                                </div>
                                                <div class="position-relative mb-3">
                                                    <label class="form-label" for="email">E-mail para Notificações</label>
                                                    <input value="<?php echo "teste"; ?>" id="email" name="email" style="text-transform: uppercase;" type="text" class="form-control" placeholder="" maxlength="50" oninput="this.value = this.value.replace(/[^A-Za-z0-9._@-]/g, '')" required />
                                                    <div class="valid-tooltip">
                                                        Validado!
                                                    </div>
                                                    <div class="invalid-tooltip">
                                                    Por favor, preencha o E-mail.
                                                    </div>
                                                </div>
                                                <div class="position-relative mb-3">
                                                    <label class="form-label" for="whatsStatus">Whatsapp Status</label>
                                                    <input value="<?php echo "teste"; ?>" id="whatsStatus" name="whatsStatus" type="text" class="form-control" placeholder="" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />
                                                    <div class="valid-tooltip">
                                                        Validado!
                                                    </div>
                                                    <div class="invalid-tooltip">
                                                    Por favor, preencha o Whatsapp Status.
                                                    </div>
                                                </div>
                                                <div class="position-relative mb-3">
                                                    <label class="form-label" for="whatsSender">Whatsapp Telelefone Sender</label>
                                                    <input value="<?php echo "teste"; ?>" id="whatsSender" name="whatsSender" type="text" class="form-control" placeholder="" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />
                                                    <div class="valid-tooltip">
                                                        Validado!
                                                    </div>
                                                    <div class="invalid-tooltip">
                                                    Por favor, preencha o Telelefone Sender.
                                                    </div>
                                                </div>
                                                <div class="position-relative mb-3">
                                                    <label class="form-label" for="whatsSid">Whatsapp SID</label>
                                                    <input value="<?php echo "teste"; ?>" id="whatsSid" name="whatsSid" type="text" class="form-control" placeholder="" required />
                                                    <div class="valid-tooltip"> 
                                                        Validado!
                                                    </div>
                                                    <div class="invalid-tooltip">
                                                    Por favor, preencha o Whatsapp SID.
                                                    </div>
                                                </div> 
                                                <div class="position-relative mb-3">
                                                    <label class="form-label">Whatsapp Token</label>
                                                    <input value="<?php echo "teste"; ?>" id="whatsToken" name="whatsToken" type="text" class="form-control" placeholder="Ex.: 11982734359" pattern="^\d{11}$"  minlength="11" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required />
                                                    <div class="valid-tooltip">
                                                        Validado!
                                                    </div>
                                                    <div class="invalid-tooltip">
                                                    Por favor, preencha o Whatsapp Token.
                                                    </div>
                                                </div> 
                                                <div class="position-relative mb-3">
                                                    <label class="form-label" for="validationTooltip02">Endereço IP PC Portaria</label>
                                                    <input value="<?php echo "teste"; ?>" id="ipPortaria" name="ipPortaria" type="text" class="form-control" placeholder="" required />
                                                    <div class="valid-tooltip">
                                                        Validado!
                                                    </div>
                                                    <div class="invalid-tooltip">
                                                    Por favor, Endereço IP do PC Portaria.
                                                    </div>
                                                </div>                
                                                <br>

                                                <button class="btn btn-danger" onclick="window.history.back()" type="button">Voltar</button>             
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

            if (telefone.length !== 11) {
                alert('O número de telefone deve ter exatamente 11 dígitos.');
                return false;
            }

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