<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == NULL) {
        header("Location: ../login/index.php");
        exit();
    }

    if (!in_array(strtoupper($_SESSION['user_nivelacesso']), ["SINDICO", "SUPORTE", "PORTARIA"])) {
        header("Location: ../errors/index.php");
        exit();
      }

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Datatables css -->
    <link href="../../assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />

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

        <!-- SWEETALERT 2 --> 
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- ######################################################## -->
    
    <!-- PWA MOBILE CONF -->
	<?php include '../../src/pwa_conf.php'; ?>
	<!-- PWA MOBILE CONF -->

</head>
<!-- estilo para os botões de entrega e disponivel -->
<style> 
/* Azul quando está desligado (OFF) */
    input[type="checkbox"][data-switch="success"] + label {
        background-color:rgb(24, 19, 68) !important; /* Azul */
        border-color:rgb(24, 19, 68) !important;
        color: white !important;
    }

    /* Verde quando ativado (ON) */
    input[type="checkbox"][data-switch="success"]:checked + label {
        background-color: #28a745 !important; /* Verde */
        border-color: #28a745 !important;
    }

    /* Cinza quando está desativado (readonly ou disabled) */
    input[type="checkbox"][data-switch="success"]:disabled + label {
        background-color: #6c757d !important; /* Cinza */
        border-color: #6c757d !important;
        cursor: not-allowed;
        opacity: 0.6;
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
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Controle de Encomendas</h4>
                                    <p class="text-muted font-14">
                                    Nesta seção, você pode controlar o recebimento de encomendas do condomínio. Ao receber uma encomenda, cadastre o item no sistema e 
                                    marque o status <b>DISPONÍVEL</b> como <b>SIM</b>, indicando que está pronta para retirada. O morador, por sua vez, deve marcar o 
                                    status <b>RETIRAR?</b> como <b>SIM</b> para liberar o botão <b>ENTREGUE?</b>, permitindo que a portaria confirme a entrega.
                                    </p>
                                    <?php if ($nivelAcesso == 'SINDICO'): ?>
                                    <p class="text-muted font-14">
                                    <i class="fa fa-whatsapp" style="color: #25D366; font-size: 20px; margin-right: 8px;"></i>

                                    </p>
                                    <?php endif; ?>      
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#signup-modal">Cadastrar </button>
                                    <button type="button" class="btn btn-primary" onclick="window.location.href='entregues.php';">Entregues</button>
                                    <button type="button" class="btn btn-success float-end" onclick="location.reload()">Refresh</button>                                    
                                    <br><br>
 
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="basic-datatable-preview">
                                            <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                                <thead>
                                                    <tr>        
                                                        <th>DT ENTRADA</th>
                                                        <th>ID</th>
                                                        <th>AP</th>
                                                        <th>NOME</th>
                                                        <th>TELEFONE</th> 
                                                        <th>DT ENTREGA</th>
                                                        <th>OBS</th>
                                                        <th></th> 
                                                        <th>DISPONIVEL?</th>
                                                        <th>ENTREGUE?</th>                                                         
                                                        <th></th> 
                                                        <th></th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($siteAdmin->ARRAY_ENCOMENDAINFO as $index => $item): ?>
                                                    <?php
                                                        $statusEnt = $item['ENC_STENTREGA_MORADOR'];
                                                        $obs = substr($item['ENC_DCOBSERVACAO'],0,13);
                                                        $nome = $item['USU_DCNOME'];
                                                        $telefone = $item['USU_DCTELEFONE'];   
                                                        $email = $item['USU_DCEMAIL'];                                                      
                                                        
                                                        if($item['ENC_STENCOMENDA'] == "DISPONIVEL")
                                                        {
                                                            $whatsColor = "#30ec6f";
                                                            $telefone = '+55' . $item['USU_DCTELEFONE']; 
                                                            $nomeWhats = $item['USU_DCNOME'];
                                                            $linkEncomendaWhats = "https://parquedashortensias.codemaze.com.br/pages/login/index.php";
                                                            $idEncomendaWhats = $item['ENC_IDENCOMENDA'];
    
                                                            $mensagem = "Olá $nomeWhats,\nSua entrega está disponível para retirada.\n\nLocal: Condomínio Parque das Hortênsias.\nID da Encomenda: $idEncomendaWhats\n\nAo chegar na portaria, acesse o link abaixo para liberar a entrega da sua encomenda.\nLiberar Entrega: $linkEncomendaWhats";   
                                                            $mensagem_codificada = urlencode($mensagem);
                                                            $linkWhats = "https://wa.me/$telefone?text=$mensagem_codificada";
                                                        }
                                                        else
                                                        {
                                                            $whatsColor = "#484b49";
                                                            $linkWhats = "";
                                                        }

                                                        if(($item['ENC_STENTREGA_MORADOR'] != "A RETIRAR" && $item['ENC_STENTREGA_MORADOR'] != "ENTREGUE") 
                                                            || $item['ENC_STENCOMENDA'] != "DISPONIVEL")
                                                        {
                                                            $fieldPortaria = "disabled";
                                                        }
                                                        else
                                                            {
                                                                $fieldPortaria = "";                                                                
                                                            }

                                                        if($item['ENC_STENTREGA_MORADOR'] == "ENTREGUE") 
                                                        {
                                                            $fieldPortaria = "disabled";
                                                            $fieldMorador = "disabled";                                                            
                                                        }
                                                        else
                                                            {
                                                                $fieldMorador = "";
                                                            }

                                                        $date = new DateTime($item['ENC_DTENTREGA_PORTARIA']);
                                                        $dataPortaria = $date->format('d/m/Y H:i');

                                                        $date = new DateTime($item['ENC_DTENTREGA_MORADOR']);
                                                        $dataMorador = $date->format('d/m/Y H:i');                                                                                                             
                                                        
                                                    ?>
                                                    <tr>    
                                                        <td hidden class="align-middle" email="<?= htmlspecialchars($item['USU_DCEMAIL']); ?>"style="font-size: 12px;"></td>
                                                        <td class="align-middle" style="font-size: 12px;"><?= htmlspecialchars($dataPortaria); ?></td>
                                                        <td class="align-middle" style="font-size: 12px;"><?= htmlspecialchars($item['ENC_IDENCOMENDA']); ?></td>
                                                        <td class="align-middle" style="font-size: 12px;"><?= htmlspecialchars($item['USU_DCAPARTAMENTO']); ?></td>
                                                        <td class="align-middle" nome="<?= htmlspecialchars($item['USU_DCNOME']); ?>" style="font-size: 12px; word-wrap: break-word;"><?= htmlspecialchars(substr($item['USU_DCNOME'],0,21)."..."); ?></td>    
                                                        <td class="align-middle" telefone="<?= htmlspecialchars($item['USU_DCTELEFONE']); ?>" style="font-size: 12px;"><?= htmlspecialchars($item['USU_DCTELEFONE']); ?></td>     
                                                        <td class="align-middle" style="font-size: 12px;"><?= htmlspecialchars($dataMorador); ?></td>
                                                        <td class="align-middle" style="font-size: 12px;"><?= htmlspecialchars($obs); ?></td> 
                                                        <td class="align-middle" style="font-size: 12px;">
                                                            <a <?= empty($linkWhats) ? 'style="pointer-events: none; cursor: default;"' : 'href="'.htmlspecialchars($linkWhats).'" target="_blank"' ?>>
                                                                <i class="fab fa-whatsapp" style="font-size: 24px; color: <?= $whatsColor; ?>;"></i>
                                                            </a>
                                                        </td>

                                                        <td class="align-middle">
                                                            <!-- Switch -->
                                                            <div>
                                                                <input 
                                                                    type="checkbox" 
                                                                    id="switch<?= $index; ?>" 
                                                                    data-switch="success" 
                                                                    data-id="<?= $item['ENC_IDENCOMENDA']; ?>" 
                                                                    <?= $item['ENC_STENCOMENDA'] === 'DISPONIVEL' ? 'checked' : ''; ?> 
                                                                    onclick="event.stopPropagation();"
                                                                    <?= htmlspecialchars($fieldMorador); ?>
                                                                />
                                                                <label 
                                                                    for="switch<?= $index; ?>" 
                                                                    data-on-label="Sim" 
                                                                    data-off-label="Não" 
                                                                    class="mb-0 d-block">
                                                                </label>
                                                            </div>
                                                        </td>

                                                        <td class="align-middle">
                                                            <!-- Switch -->
                                                            <div>
                                                                <input 
                                                                    type="checkbox" 
                                                                    id="switch1<?= $index; ?>" 
                                                                    data-switch="success" 
                                                                    data-id1="<?= $item['ENC_IDENCOMENDA']; ?>" 
                                                                    <?= $item['ENC_STENTREGA_MORADOR'] === 'ENTREGUE' ? 'checked' : ''; ?> 
                                                                    onclick="event.stopPropagation();"
                                                                    <?= htmlspecialchars($fieldPortaria); ?>
                                                                />
                                                                <label 
                                                                    for="switch1<?= $index; ?>" 
                                                                    data-on-label="Sim" 
                                                                    data-off-label="Não" 
                                                                    class="mb-0 d-block">
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td class="align-middle" hash="<?= htmlspecialchars($item['ENC_DCHASHENTREGA']); ?>" style="font-size: 12px; display: none;"></td> 
                                                        <td class="align-middle">
                                                            <?php 
                                                                if($item['ENC_STENTREGA_MORADOR'] != 'ENTREGUE')
                                                                {
                                                                    echo '<i class="mdi mdi-delete" title="Excluir encomenda" style="cursor: pointer; font-size: 24px;" onclick="confirmDelete(event, \'' . htmlspecialchars($item['ENC_IDENCOMENDA'], ENT_QUOTES, 'UTF-8') . '\')"></i>';
                                                                }
                                                            ?>
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
                    </div><!-- end row-->
                </div> <!-- container -->
            </div> <!-- content -->
        
		    <!-- Menu Nav Area -->
		    <?php include '../../src/footer_nav.php'; ?>
		    <!-- End Menu Nav -->
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
        </div>                                                           
    </div>
    <!-- END wrapper -->


<!-- cadastrar pacote modal-->
<div id="signup-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                    <a href="index.html" class="text-success">
                        <span>Cadastro de Pacote</span>
                    </a>
                </div>

                <form class="needs-validation" novalidate id="form" role="form" method="POST">

                    <div class="mb-3">
                        <label for="apartamento" class="form-label">Apartamento</label>
                        <input class="form-control" type="number" name="apartamento" id="apartamento" maxlength="4" required="" placeholder="Digite o número do apartamento">
                    </div>

                    <div class="mb-3">
                        <label for="observacao" class="form-label">Observacao</label>
                        <input class="form-control" type="text" id="observacao" name="observacao" required="" maxlength="50" placeholder="Digite algo que ajude a identificar o pacote" style="text-transform: uppercase;">
                    </div>

                    <div class="mb-3 text-center">
                        <button class="btn btn-primary" id="botao" type="button">Cadastrar Pacote</button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


   <!-- ######################################################## --> 
    <!-- SWEETALERT 2 -->   

    <script>
function confirmDelete(event, id) {
    console.log(id);  // Verifica se o id está correto
    Swal.fire({
        title: 'Formulário Encomendas',
        text: "Tem certeza que deseja exluir a encomenda?",
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
            // Fazer a requisição AJAX
            $.ajax({
                url: "deleteEncomendaProc.php", // URL para processamento
                type: "POST",
                data: { id: id },  // Enviando o ID via POST
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
                        text: 'Erro ao excluir a avaliação.',
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
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire('Cancelado', 'Nenhuma alteração foi salva.', 'info');
        }
    });
}

$(document).ready(function () {
    // Não é necessário associar a função ao botão de submit, pois ela já está sendo chamada no clique do ícone.
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






     

      <!-- ######################################################## --> 
    <!-- SWEETALERT 2 -->   
    <script src="../../js/jquery-3.5.1.min.js"></script>
    <script>

      function confirmAndSubmit(event) {

        event.preventDefault(); // Impede o envio padrão do formulário
        Swal.fire({
          title: 'Cadastro de Pacote',
          text: "Tem certeza que deseja cadastrar um pacote?",
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
              url: "insertPacoteProc.php", // URL para processamento
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
                const td = document.querySelector('td[nome]');
                const tdTelefone = document.querySelector('td[telefone]');
                const nome = td.getAttribute('nome');
                const telefone = tdTelefone.getAttribute('telefone');            
                const tdHash = document.querySelector('td[hash]');
                const hash = tdHash.getAttribute('hash');
                const tdEmail = document.querySelector('td[email]');
                const email = tdEmail.getAttribute('email');

                // Envia a alteração para o servidor
                fetch('updateStatusCheckboxDisponivel.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id, status, nome, telefone, hash, email })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        //alert('Erro ao atualizar o status!');
                    }
                    window.location.href = "index.php";
                })
                .catch(error => {
                    console.error('Erro:', error);
                    //alert('Erro ao comunicar com o servidor.');
                });
            });
        });
    });
    </script>

<script> 
    document.addEventListener('DOMContentLoaded', function () {
        const switches = document.querySelectorAll('input[type="checkbox"][data-switch="success"]');
        
        switches.forEach(switchElem => {
            switchElem.addEventListener('change', function () {
                const id = this.getAttribute('data-id1');
                const status = this.checked ? 'ENTREGUE' : 'PENDENTE';
                const td = document.querySelector('td[nome]');
                const tdTelefone = document.querySelector('td[telefone]');
                const nome = td.getAttribute('nome');
                const telefone = tdTelefone.getAttribute('telefone');       

                // Envia a alteração para o servidor
                fetch('updateStatusCheckboxEntregar.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id, status, nome, telefone })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        //alert('Erro ao atualizar o status!');
                    }
                    window.location.href = "index.php";
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao comunicar com o servidor.');
                });
            });
        });
    });
    </script>



    <!-- Vendor js -->
    <script src="../../assets/js/vendor.min.js"></script>

    <!-- Code Highlight js -->
    <script src="../../assets/vendor/highlightjs/highlight.pack.min.js"></script>
    <script src="../../assets/vendor/clipboard/clipboard.min.js"></script>
    <script src="../../assets/js/hyper-syntax.js"></script>

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

    <!-- App js -->
    <script src="../../assets/js/app.min.js"></script>

</body>

</html>