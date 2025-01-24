<?php
    ini_set('display_errors', 1);  // Habilita a exibição de erros
    error_reporting(E_ALL);        // Reporta todos os erros

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $baseUrl = $protocol . "://" . $host;
    $webmailUrl = $baseUrl . "/api//";

	include_once "../../objects/objects.php";
	
    $siteAdmin = new SITE_ADMIN();  
    $siteAdmin->getParameterInfo();
    $siteAdmin->getEncomendaPortariaInfo();

    

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

    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Datatables css -->
    <link href="../../assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />
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
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                        <li class="breadcrumb-item active">Basic Tables</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Bem vindo(a)</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">

                    <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Basic Data Table</h4>
                                    <p class="text-muted font-14">
                                        DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction
                                        function:
                                        <code>$().DataTable();</code>. KeyTable provides Excel like cell navigation on any table. Events (focus, blur, action etc) can be assigned to individual
                                        cells, columns, rows or all cells.
                                    </p>

                                    <ul class="nav nav-tabs nav-bordered mb-3">
                                        <li class="nav-item">
                                            <a href="#basic-datatable-preview" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                                Preview
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#basic-datatable-code" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                                Code
                                            </a>
                                        </li>
                                    </ul> <!-- end nav--> 
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="basic-datatable-preview">
                                            <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>APARTAMENTO</th>
                                                        <th>TITULAR APARTAMENTO</th>
                                                        <th>DT ENTRADA</th>
                                                        <th>DT ENTREGA</th>
                                                        <th>OBS</th>
                                                        <th>DISPONIVEL?</th>
                                                        <th>ENTREGUE?</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                <?php foreach ($siteAdmin->ARRAY_ENCOMENDAINFO as $index => $item): ?>
                                                    <?php
                                                        if($item['ENC_STENTREGA_MORADOR'] != "A RETIRAR")
                                                        {
                                                            $field = "disabled";
                                                        }
                                                    ?>
                                                    <tr>
                                                        <td style="font-size: 12px;"><?= htmlspecialchars($item['ENC_IDENCOMENDA']); ?></td>
                                                        <td style="font-size: 12px;"><?= htmlspecialchars($item['USU_DCAPARTAMENTO']); ?></td>
                                                        <td style="font-size: 12px;"><?= htmlspecialchars($item['USU_DCNOME']); ?></td>
                                                        <td style="font-size: 12px;"><?= htmlspecialchars($item['ENC_DTENTREGA_PORTARIA']); ?></td>
                                                        <td style="font-size: 12px;"><?= htmlspecialchars($item['ENC_DTENTREGA_MORADOR']); ?></td>
                                                        <td style="font-size: 12px;"><?= htmlspecialchars($item['ENC_DCOBSERVACAO']); ?></td>
                                                        <td>
                                                            <!-- Switch -->
                                                            <div>
                                                                <input 
                                                                    type="checkbox" 
                                                                    id="switch<?= $index; ?>" 
                                                                    data-switch="success" 
                                                                    data-id="<?= $item['ENC_IDENCOMENDA']; ?>" 
                                                                    <?= $item['ENC_STENCOMENDA'] === 'DISPONIVEL' ? 'checked' : ''; ?> 
                                                                    onclick="event.stopPropagation();"
                                                                />
                                                                <label 
                                                                    for="switch<?= $index; ?>" 
                                                                    data-on-label="Sim" 
                                                                    data-off-label="Não" 
                                                                    class="mb-0 d-block">
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <!-- Switch -->
                                                            <div>
                                                                <input 
                                                                    type="checkbox" 
                                                                    id="switch1<?= $index; ?>" 
                                                                    data-switch="success" 
                                                                    data-id1="<?= $item['ENC_IDENCOMENDA']; ?>" 
                                                                    <?= $item['ENC_STENTREGA_MORADOR'] === 'ENTREGUE' ? 'checked' : ''; ?> 
                                                                    onclick="event.stopPropagation();"
                                                                    <?= htmlspecialchars($field); ?>
                                                                />
                                                                <label 
                                                                    for="switch1<?= $index; ?>" 
                                                                    data-on-label="Sim" 
                                                                    data-off-label="Não" 
                                                                    class="mb-0 d-block">
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                 <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    





                    </div>
                    <!-- end row-->
                </div> <!-- container -->



 


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

      function confirmAndSubmit(event) {

        event.preventDefault(); // Impede o envio padrão do formulário
        Swal.fire({
          title: 'Envio de Sugestão ou Reclamação',
          text: "Tem certeza que deseja enviar a mensagem?",
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
              url: "sendMsgProc.php", // URL para processamento
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

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const switches = document.querySelectorAll('input[type="checkbox"][data-switch="success"]');
        
        switches.forEach(switchElem => {
            switchElem.addEventListener('change', function () {
                const id = this.getAttribute('data-id');
                const status = this.checked ? 'DISPONIVEL' : 'INDISPONIVEL';

                // Envia a alteração para o servidor
                fetch('updateStatusCheckboxDisponivel.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id, status })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        alert('Erro ao atualizar o status!');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao comunicar com o servidor.');
                });
            });
        });
    });
</script>

    <!-- Controle do pop-up de promoção -->
    <script>
        // Função para abrir o pop-up
        function openPopup() {
            document.getElementById('promoPopup').style.display = 'flex';
        }
    
        // Função para fechar o pop-up
        function closePopup() {
            document.getElementById('promoPopup').style.display = 'none';
        }
    
        // Fecha o pop-up ao clicar fora do quadrante
        document.addEventListener('click', function(event) {
            const popup = document.getElementById('promoPopup');
            const popupContent = document.querySelector('.popup-content');
            
            if (popup.style.display === 'flex' && !popupContent.contains(event.target)) {
                closePopup();
            }
        });
    
        // Abra o pop-up automaticamente após 1,5 segundos
        window.onload = function() {
            setTimeout(openPopup, 1500);
        };
    </script>

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
    <script src="../../assets/js/pages/demo.datatable-init.js"></script>

</body>

</html>