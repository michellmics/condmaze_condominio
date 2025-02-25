<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == NULL) {
        header("Location: ../login/index.php");
        exit();
    }

    if (!in_array(strtoupper($_SESSION['user_nivelacesso']), ["SINDICO", "SUPORTE", "MORADOR"])) {
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
        $siteAdmin->getArtigosInfo();    
?>

<!DOCTYPE html>
<html lang="en" data-topbar-color="dark" data-menu-color="dark" data-sidenav-user="true" data-bs-theme="dark">
<head>
    <meta charset="utf-8" />
    <title><?php echo $nomeCondominio; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- Datatables css -->
    <link href="../../assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
        <!-- MODAL -->
        <?php include '../../src/modalScroll.php'; ?>
	    <!-- MODAL -->   

        <script>
            document.querySelectorAll('.list-group-item').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('scrollableModalTitle').textContent = this.getAttribute('data-title');
                    document.getElementById('modal-body-content').innerHTML = this.getAttribute('data-content');
                
                            // Recebe o arquivo (se houver) e cria o link de download
                            var fileUrl = this.getAttribute('data-file'); // Obtém o nome do arqui
                
                            if (fileUrl) {
                                // Cria o link para download
                                var downloadLink = '<a href="https://parquedashortensias.codemaze.com.br/pages/instrucoesAdequacoes/uploads/' + fileUrl + '" download class="btn btn-primary">Baixar Anexo</a>';
                                document.getElementById('modal-file-link').innerHTML = downloadLink; // Insere o link no modal
                            } else {
                                document.getElementById('modal-file-link').innerHTML = '<p><br><br></p>';
                            }
                });
            });
        </script>

        <div class="content-page">
            <div class="content">                
                <div class="container-fluid"><!-- INICIO CONTEUDO CONTAINER -->

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                </div>
                                <h4 class="page-title">Informativos</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Procedimentos / Comunicados </h4>

                                    <p class="text-muted font-14">
                                        Aqui são listados alguns procedimentos e comunicados disponibilizados pela gestão do condomínio.
                                    </p>
                                        <div class="col-sm-5">
                                            <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'SUPORTE'): ?>  
                                            <a href="insertArtigo.php" class="btn btn-danger mb-2"><i class="mdi mdi-plus-circle me-2"></i> Adicionar Comunicado</a>
                                            <?php endif; ?>  
                                        </div>
                                    <div class="tab-content">
                                        <div class="col-sm-5">
                                            
                                        </div>
                                        <br>
                                        <div class="tab-pane show active" id="basic-datatable-preview">
                                            <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                                <thead>
                                                    <tr>  
                                                        <th>TÍTULO</th>  
                                                        <th>ORDEM</th>     
                                                        <th>DT CADASTRO</th>                                                                
                                                        <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'SUPORTE'): ?>
                                                        <th></th>   
                                                        <th></th> 
                                                        <?php endif; ?>                                                    
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($siteAdmin->ARRAY_ARTIGOSINFO as $item): ?>
                                                        <?php
                                                            $date = new DateTime($item['INA_DTDATA_INSERT']);
                                                            $dataFormatCad = $date->format('d/m/Y H:i');  
                                                        ?>
                                                        <tr>
                                                            <td class="align-middle" 
                                                                style="cursor: pointer; color: rgb(0, 151, 197); text-decoration: underline;" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#scrollable-modal"
                                                                data-title="<?= htmlspecialchars($item['INA_DCTITULO']); ?>"
                                                                data-content="<?= htmlspecialchars($item['INA_DCTEXT']); ?>"
                                                                data-file="<?php echo basename($item['INA_DCFILEURL']); ?>"
                                                                onclick="openModal(this)">
                                                                <?= htmlspecialchars(strtoupper($item['INA_DCTITULO'])); ?>
                                                            </td> 
                                                            <td class="align-middle"><?= htmlspecialchars($item['INA_DCORDEM']); ?>º</td>   
                                                            <td class="align-middle"><?= htmlspecialchars($dataFormatCad); ?></td>                                                          
                                                    
                                                            <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'SUPORTE'): ?> 
                                                            <td class="align-middle">
                                                                <a href="https://parquedashortensias.codemaze.com.br/pages/instrucoesAdequacoes/insertArtigo.php?id=<?= htmlspecialchars($item['INA_IDINSTRUCOES_ADEQUACOES'], ENT_QUOTES, 'UTF-8'); ?>" class="text-success">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            </td>       
                                                            <td class="align-middle">
                                                                <a class="text-danger" onclick="confirmDelete(event, '<?= htmlspecialchars($item['INA_IDINSTRUCOES_ADEQUACOES'], ENT_QUOTES, 'UTF-8'); ?>')">
                                                                    <i class="mdi mdi-delete" title="Excluir artigo" style="cursor: pointer; font-size: 24px;"></i>
                                                                </a>
                                                            </td>
                                                            <?php endif; ?>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div> <!-- end preview-->


                                    </div> <!-- end tab-content-->

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

    <!-- ######################################################## --> 
    <!-- SWEETALERT 2 -->   

    <script>
function confirmDelete(event, id) {
    console.log(id);  // Verifica se o id está correto
    Swal.fire({
        title: 'Formulário de Comunicados',
        text: "Tem certeza que deseja exluir o comunicado?",
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
                url: "deleteArtigoProc.php", // URL para processamento
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
                        text: 'Erro ao excluir o artigo.',
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
    <script src="../../assets/js/pages/demo.datatable-init-auditoria.js?ver=<?php echo time(); ?>"></script>

<script>
$(document).ready(function () {
    var table = $('#basic-datatable').DataTable();
    table.destroy(); // Destrói a instância existente antes de criar outra

    $('#basic-datatable').DataTable({
        pageLength: 50, 
        lengthMenu: [10, 25, 50, 100], 
        responsive: true, 
        order: [[1, 'asc']], 
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
        }
    });
});

</script>

 

</body>

</html>