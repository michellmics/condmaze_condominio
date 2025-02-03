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
    
    $siteAdmin->getLogInfo(); 
    
?>

<!DOCTYPE html>
<html lang="en" data-layout="topnav">

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

        <?php 
            $metodo = "insert";
            $siteAdmin->getListEventById($userid); 
            if(count($siteAdmin->ARRAY_LISTAEVENTOSINFO) > 0)
            {
                $metodo = "update";   
            }       

            $carneNecessariaMulher = $siteAdmin->ARRAY_LISTAEVENTOSINFO["LEU_DCCONVIDADO_MULHER"] * 0.350;
            $carneNecessariaHomem = $siteAdmin->ARRAY_LISTAEVENTOSINFO["LEU_DCCONVIDADO_HOMEM"] * 0.500;
            $carneNecessaria = $carneNecessariaMulher + $carneNecessariaHomem;

        ?>

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
                                <h4 class="page-title">Churrascômetro</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-7">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Organização de Evento </h4>
                                    <p class="text-muted font-14">
                                        Asadasdasdas
                                    </p>
                                    <div class="tab-content">
                                        <div class="col-sm-5">                                            
                                        </div>

                <!-- Ini formulario--><form class="needs-validation" id="form" name="form" role="form" method="POST" action="churras_proc.php" enctype="multipart/form-data" novalidate>
                                                    <!-- CAMPOS COMO VARIAVEIS -->
                                                    <input type="hidden" id="idmorador" name="idmorador" value="<?php echo $userid; ?>"/>
                                                    <!-- CAMPOS COMO VARIAVEIS -->

                                        <div class="row">
                                            <div class="col-3 mb-3">
                                                <label for="qtdehomem" class="form-label">Qtde Homens</label>
                                                <input class="form-control" id="qtdehomem" type="number" value="<?php echo $siteAdmin->ARRAY_LISTAEVENTOSINFO["LEU_DCCONVIDADO_HOMEM"]; ?>" name="qtdehomem"  step="1" min="0">
                                            </div>
                                            <div class="col-3 mb-3">
                                                <label for="qtdemulher" class="form-label">Qtde Mulheres</label>
                                                <input class="form-control" id="qtdemulher" value="<?php echo $siteAdmin->ARRAY_LISTAEVENTOSINFO["LEU_DCCONVIDADO_MULHER"]; ?>" type="number" name="qtdemulher"  step="1" min="0">
                                            </div>
                                            <div class="col-3 mb-3">
                                                <label for="qtdehomem" class="form-label">Fator C. Homem</label>
                                                <input readonly class="form-control" id="consumohomem" value="500g" type="text" name="consumohomem" style="background-color:rgb(209, 209, 209);">
                                            </div>
                                            <div class="col-3 mb-3">
                                                <label for="qtdemulher" class="form-label">Fator C. Mulher</label>
                                                <input readonly class="form-control" id="consumomulher" value="350g" type="text" name="consumomulher" style="background-color:rgb(209, 209, 209);">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4 mb-3">
                                                <label for="qtdehomem" class="form-label">Carne Necessária</label> 
                                                <input readonly class="form-control" id="carnenecessaria" type="text" value="<?php echo $carneNecessaria."Kg"; ?>" name="carnenecessaria" style="background-color:rgb(10, 10, 10); color: white;">
                                            </div>
                                            <div class="col-4 mb-3">
                                                <label for="qtdemulher" class="form-label">Carne Calculada</label>
                                                <input readonly class="form-control" id="carnecalculada" type="number" name="carnecalculada" style="background-color:rgb(56, 4, 71); color: white;">
                                            </div>
                                            <div class="col-4 mb-3">
                                                <label for="custototal" class="form-label">Custo Total do Evento</label>
                                                <input readonly class="form-control" id="custototal" type="text" name="custototal" style="background-color:rgb(5, 89, 158); color: white;">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label for="custoporpessoa" class="form-label">VALOR A PAGAR POR PESSOA</label>
                                                <input readonly class="form-control" id="custoporpessoa" type="number" name="custoporpessoa" style="background-color:rgb(112, 241, 86); color: #000000;">
                                            </div>                                         
                                        </div>
                                        <div class="row">
                                        <div id="formulario-itens">
                                            <div class="row linha-item" style="background-color:#f3f1f1;">
                                                <div class="col-9" style="padding-bottom: 5px;">
                                                    <label for="valorunitario" class="form-label" style="font-size: 12px; margin-bottom: 2px;">Descrição do Item</label>
                                                    <input type="text" class="form-control descricao" name="descricao[]" placeholder="Descrição do Item" style="text-transform: uppercase;" >
                                                </div>
                                                <div class="col-3" style="padding-bottom: 5px;">
                                                    <label class="form-label" for="validationTooltip01">Carne?</label><br>
                                                    <input type="checkbox" id="carneCheckbox0" name="carneCheckbox[]" data-switch="bool"/>
                                                    <label for="carneCheckbox0" data-on-label="SIM" data-off-label="NÃO"></label>
                                                </div>
                                                <div class="row linha-item">
                                                    <div class="col-4" style="padding-bottom: 5px;">
                                                        <label for="valorunitario" class="form-label" style="font-size: 12px; margin-bottom: 2px;">Quantidade</label>
                                                        <input type="number" class="form-control quantidade" name="quantidade[]" step="1" min="0" onchange="calcularValorTotal(this)">
                                                    </div>
                                                    <div class="col-4" style="padding-bottom: 5px;">
                                                        <label for="valorunitario" class="form-label" style="font-size: 12px; margin-bottom: 2px;">Valor Unitário</label>
                                                        <input type="number" class="form-control valorunitario" name="valorunitario[]" step="0.01" min="0" onchange="calcularValorTotal(this)">
                                                    </div>
                                                    <div class="col-4" style="padding-bottom: 5px;">
                                                        <label for="valorunitario" class="form-label" style="font-size: 12px; margin-bottom: 2px;">Valor Total</label>
                                                        <input type="text" class="form-control valortotal" name="valortotal[]" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
<!-- Botão para adicionar nova linha -->
<button class="btn btn-primary" type="button" onclick="adicionarItem()">Adicionar Item</button><button type="submit" class="btn btn-success">SALVAR</button>
                                    </form>


<script>
    let index = 1;  // Variável para controlar os índices dos novos checkboxes
    // Função para adicionar uma nova linha de formulário
    function adicionarItem() {
    const formularioItens = document.getElementById('formulario-itens');
    const novaLinha = document.createElement('div');
    novaLinha.classList.add('row', 'linha-item');
    novaLinha.style.backgroundColor = '#f3f1f1';
    
    novaLinha.innerHTML = `
        <div style="background-color:rgb(255, 255, 255);">&nbsp;</div>
        <div class="col-9" style="padding-bottom: 5px;">
            <label for="descricao" class="form-label" style="font-size: 12px; margin-bottom: 2px;">Descrição do Item</label>
            <input type="text" class="form-control descricao" name="descricao[]" placeholder="Descrição do Item" style="text-transform: uppercase;" >
        </div>
        <div class="col-3" style="padding-bottom: 5px;">
            <label class="form-label" for="carneCheckbox${index}">Carne?</label><br>
            <input type="checkbox" id="carneCheckbox${index}" name="carneCheckbox[]" data-switch="bool"/>
            <label for="carneCheckbox${index}" data-on-label="SIM" data-off-label="NÃO"></label>
        </div>
        <div class="row linha-item">
            <div class="col-4" style="padding-bottom: 5px;">
                <label for="quantidade" class="form-label" style="font-size: 12px; margin-bottom: 2px;">Quantidade</label>
                <input type="number" class="form-control quantidade" name="quantidade[]" step="1" min="0" onchange="calcularValorTotal(this)">
            </div>
            <div class="col-4" style="padding-bottom: 5px;">
                <label for="valorunitario" class="form-label" style="font-size: 12px; margin-bottom: 2px;">Valor Unitário</label>
                <input type="number" class="form-control valorunitario" name="valorunitario[]" step="0.01" min="0" onchange="calcularValorTotal(this)">
            </div>
            <div class="col-4" style="padding-bottom: 5px;">
                <label for="valortotal" class="form-label" style="font-size: 12px; margin-bottom: 2px;">Valor Total</label>
                <input type="text" class="form-control valortotal" name="valortotal[]" readonly>
            </div>
        </div>
    `;
    formularioItens.appendChild(novaLinha);
    index++;  // Incrementa o índice para o próximo checkbox
}






    // Função de cálculo para os valores totais (se necessário)
    function calcularValorTotal(element) {
    const linhaItem = element.closest('.linha-item');
    const quantidade = linhaItem.querySelector('.quantidade').value;
    const valorUnitario = linhaItem.querySelector('.valorunitario').value;
    const valorTotal = linhaItem.querySelector('.valortotal');
    valorTotal.value = (quantidade * valorUnitario).toFixed(2);
}
</script>


                                        
                                        </div>




               <!-- Ini formulario--></form>
                                    </div> <!-- end tab-content-->

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
        $(document).ready(function () {
            $('#basic-datatable').DataTable({
                pageLength: 50, // Exibe 50 linhas por padrão
                lengthMenu: [10, 25, 50, 100], // Opções para alterar o número de linhas exibidas
                responsive: true, // Tabela responsiva
                order: [[6, 'desc']], // Ordena pela coluna "DATA" (índice 6)
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json' // Tradução para português
                }
            });
        });
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
    <script src="../../assets/js/pages/demo.datatable-init.js?ver=<?php echo time(); ?>"></script>



</body>

</html>