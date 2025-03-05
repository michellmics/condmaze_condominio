<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == NULL) {
        header("Location: ../login/index.php");
        exit();
    }

    if (!in_array(strtoupper($_SESSION['user_nivelacesso']), ["SUPORTE"])) {
        header("Location: ../errors/index.php");
        exit();
      }

	include_once "../../objects/objects.php";
	
    $siteAdmin = new SITE_ADMIN();  
    $siteAdmin->getParameterInfo();
    $siteAdmin->getPubInfo();
  
    foreach ($siteAdmin->ARRAY_PARAMETERINFO as $item) {
      if ($item['CFG_DCPARAMETRO'] == 'NOME_CONDOMINIO') {
          $nomeCondominio = $item['CFG_DCVALOR']; 
      }
      if ($item['CFG_DCPARAMETRO'] == 'DOMINIO') {
        $dominio = $item['CFG_DCVALOR']; 
    }
    }   

?>
<!DOCTYPE html>
<html lang="en" data-topbar-color="dark" data-menu-color="dark" data-sidenav-user="true" data-bs-theme="dark">
<head>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const isMobile = /Mobi|Android|iPhone|iPad|iPod/i.test(navigator.userAgent); 
        if (isMobile && window.innerWidth < 800) { 
            alert("Esta seção não está disponível para dispositivos móveis.");
            window.location.href = "../inicial/index.php"; 
        }
    });
</script>

    <!-- HEAD META BASIC LOAD-->
	<?php include '../../src/headMeta.php'; ?>
	<!-- HEAD META BASIC LOAD -->

    <!-- Theme Config Js --> 
    <script src="../../assets/js/hyper-config.js"></script>

    <!-- Vendor css -->
    <link href="../../assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="../../assets/css/app-modern.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Datatables css -->
    <link href="../../assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />

</head>
<!-- estilo para os botões de entrega e disponivel -->
<style> 

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
                                    <h4 class="header-title">Controle de Publicidade</h4>
                                    <p class="text-muted font-14">
                                    Nesta seção é realizado o controle de publicação das tarjas dos parceiros do condomínio.
                                    </p>
                                    <?php if ($nivelAcesso == 'SINDICO'): ?>
                                    <p class="text-muted font-14">                                    

                                    </p>
                                    <?php endif; ?>      
                                    <button type="button" class="btn" style="background-color: #aa2ed8; color: white;" onclick="window.location.href='insertPublicidade.php';">
                                    <button type="button" class="btn float-end" style="background-color: #20ffad; color: black;" onclick="location.reload()">Refresh</button>                                    
                                    <br><br>
 
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="basic-datatable-preview">
                                            <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                                <thead>
                                                    <tr>        
                                                        <th>EMPRESA</th>
                                                        <th>CAMPANHA</th>
                                                        <th>DATA INI</th>
                                                        <th>DATA FIM</th>
                                                        <th>CATEGORIA</th> 
                                                        <th>ORDEM</th>
                                                        <th>IMG</th>                                                   
                                                        <th>STATUS</th> 
                                                        <th></th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($siteAdmin->ARRAY_PUBINFO as $index => $item): ?>
                                                    <?php
                                                     
                                                        $date = new DateTime($item['PDS_DTPUB_INI']);
                                                        $dataIni = $date->format('d/m/Y H:i');

                                                        $date = new DateTime($item['PDS_DTPUB_FIM']);
                                                        $dataFim = $date->format('d/m/Y H:i');

                                                        $imgUrl = "https://$dominio/publicidade/".$item['PDS_DCIMGFILENAME']; 
                                                        
                                                        if($item['PDS_STONAIR'] == "SIM")
                                                        {
                                                            $colorText = "#20ad41";
                                                        }
                                                        else
                                                            {
                                                                $colorText ="#ff0404";
                                                            }
                                                        
                                                    ?>
                                                    <tr>    
                                                        <td class="align-middle" style="color: <?= htmlspecialchars($colorText); ?>; font-size: 12px; word-wrap: break-word;"><?= htmlspecialchars($item['PDS_DCNOME_PRESTADOR']); ?></td>
                                                        <td class="align-middle" style="color: <?= htmlspecialchars($colorText); ?> font-size: 12px;"><?= htmlspecialchars($item['PDS_DCCAMPANHA']); ?></td>
                                                        <td class="align-middle" style="color: <?= htmlspecialchars($colorText); ?> font-size: 12px;"><?= htmlspecialchars($dataIni); ?></td>
                                                        <td class="align-middle" style="color: <?= htmlspecialchars($colorText); ?> font-size: 12px;"><?= htmlspecialchars($dataFim); ?></td>
                                                        <td class="align-middle" style="color: <?= htmlspecialchars($colorText); ?> font-size: 12px;"><?= htmlspecialchars($item['PUC_DCNOME']); ?></td>    
                                                        <td class="align-middle" style="color: <?= htmlspecialchars($colorText); ?> font-size: 12px;"><?= htmlspecialchars($item['PDS_DCORDEM']); ?></td>  
                                                        <td class="align-middle" style="font-size: 12px;"><img src="<?= htmlspecialchars($imgUrl); ?>" height="30" /></td> 

                                                        <td class="align-middle">
                                                            <!-- Switch -->
                                                            <div>
                                                            <input 
                                                                    type="checkbox" 
                                                                    id="switch<?= $index; ?>" 
                                                                    data-switch="PUBLICADO" 
                                                                    data-id="<?= $item['PDS_IDPRESTADOR_SERVICO']; ?>" 
                                                                    <?= $item['PDS_STSTATUS'] === 'PUBLICADO' ? 'checked' : ''; ?> 
                                                                    onclick="event.stopPropagation(); changeStatus(<?= $item['PDS_IDPRESTADOR_SERVICO']; ?>, this)" 
                                                                    <?= htmlspecialchars('PUBLICADO'); ?>
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
                                                            <?php 
                                                                if($item['PDS_STSTATUS'] != 'PUBLICADO')
                                                                {
                                                                    echo '<i class="mdi mdi-delete" title="Excluir encomenda" style="cursor: pointer; font-size: 24px;" onclick="confirmDelete(event, \'' . htmlspecialchars($item['PDS_IDPRESTADOR_SERVICO'], ENT_QUOTES, 'UTF-8') . '\')"></i>';
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
                </div><!-- FIM CONTEUDO CONTAINER -->                
            </div>
            <!-- content -->
	        <?php include '../../src/modalTermos.php'; ?>
            <!-- FOOTER -->
	        <?php include '../../src/footerNav.php'; ?>
	        <!-- FOOTER --> 
        </div>
    </div>
    <!-- END wrapper -->


<!-- Layout Configuration -->	
<?php include '../../src/layoutConfig.php'; ?>
<!-- Vendor js -->
<script src="../../assets/js/vendor.min.js"></script>
<!-- App js -->
<script src="../../assets/js/app.min.js"></script>
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
<!-- SWEETALERT 2 -->   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- App js -->
<script src="../../assets/js/app.min.js"></script>


<!-- SWEETALERT 2 -->   

<script>
function confirmDelete(event, id) {
    console.log(id);  // Verifica se o id está correto
    Swal.fire({
        title: 'Formulário de Publicidade',
        text: "Tem certeza que deseja exluir a campanha?",
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
                url: "deleteCampanhaProc.php", // URL para processamento
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
                        window.location.href = "listaPublicacao.php";
                    });
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        title: 'Erro!',
                        text: 'Erro ao excluir a campanha.',
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

<script>
    function changeStatus(id, checkbox) {
        // Exibe SweetAlert para confirmar a mudança
        Swal.fire({
            title: 'Você tem certeza?',
            text: "Deseja mudar o status deste item?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, mudar!',
        }).then((result) => {
            if (result.isConfirmed) {
                // Define o novo status baseado no estado do checkbox
                const status = checkbox.checked ? 'PUB' : 'UNPUB';
                
                // Envia a requisição AJAX
                $.ajax({
                    url: 'updateStatusCheckboxPub.php',  // Arquivo PHP que processa a alteração
                    type: 'POST',
                    data: {
                        id: id,
                        status: status,  // Envia PUB ou UNPUB
                    },
                    success: function(response) {
                        if (response === 'success') {
                            // Atualiza o texto e o status visual do item
                            const newColor = (status === 'PUB') ? '#20ad41' : '#ff0404';
                            checkbox.closest('tr').querySelectorAll('td').forEach((td) => {
                                td.style.color = newColor;
                            });
                            // Exibe uma mensagem de sucesso
                            Swal.fire(
                                'Sucesso!',
                                'O status foi alterado com sucesso.',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Erro!',
                                'Houve um erro ao tentar alterar o status.',
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Erro!',
                            'Houve um erro de comunicação com o servidor.',
                            'error'
                        );
                    }
                });
            } else {
                // Se o usuário cancelar, desmarcar o checkbox
                checkbox.checked = !checkbox.checked;
            }
        });
    }
</script>



<script src="../../js/jquery-3.5.1.min.js"></script>


</body>
</html>