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

    <!-- Estilos do Datatable e outros plugins -->
    <link href="../../assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />

    <script src="../../assets/js/hyper-config.js"></script>

    <!-- Vendor css -->
    <link href="../../assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="../../assets/css/app-modern.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    
    <?php include '../../src/pwa_conf.php'; ?>

</head>

<body>
    <div class="wrapper">

        <?php include '../../src/top_bar.php'; ?>
        <?php include '../../src/menu_nav.php'; ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Churrascômetro</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-7">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Organização de Evento </h4>
                                    <p class="text-muted font-14">Asadasdasdas</p>

                                    <form class="needs-validation" id="form" name="form" role="form" method="POST" enctype="multipart/form-data" novalidate>

                                        <!-- Campos do formulário -->
                                        <div class="row">
                                            <div class="col-3 mb-3">
                                                <label for="qtdehomem" class="form-label">Qtde Homens</label>
                                                <input class="form-control" id="qtdehomem" type="number" name="qtdehomem" step="1" min="0">
                                            </div>
                                            <div class="col-3 mb-3">
                                                <label for="qtdemulher" class="form-label">Qtde Mulheres</label>
                                                <input class="form-control" id="qtdemulher" type="number" name="qtdemulher" step="1" min="0">
                                            </div>
                                            <div class="col-3 mb-3">
                                                <label for="consumohomem" class="form-label">Fator C. Homem</label>
                                                <input readonly class="form-control" id="consumohomem" value="500g" type="text" name="consumohomem" style="background-color:rgb(209, 209, 209);">
                                            </div>
                                            <div class="col-3 mb-3">
                                                <label for="consumomulher" class="form-label">Fator C. Mulher</label>
                                                <input readonly class="form-control" id="consumomulher" value="350g" type="text" name="consumomulher" style="background-color:rgb(209, 209, 209);">
                                            </div>
                                        </div>

                                        <!-- Itens do Evento -->
                                        <div id="formulario-itens">
                                            <div class="row linha-item" style="background-color: #D3D3D3;">
                                                <div class="col-12" style="padding-bottom: 5px;">
                                                    <label for="descricao" class="form-label" style="font-size: 12px; margin-bottom: 2px;">Descrição do Item</label>
                                                    <input type="text" class="form-control descricao" name="descricao[]" placeholder="Descrição do Item">
                                                </div>
                                                <div class="row">
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
                                                        <input type="number" class="form-control valortotal" name="valortotal[]" step="0.01" min="0" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Botão para adicionar nova linha -->
                                        <button type="button" class="btn btn-primary" id="adicionar-item" onclick="adicionarItem()">Adicionar Item</button>

                                        <!-- Cálculos e demais campos -->
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label for="custoporpessoa" class="form-label">VALOR A PAGAR POR PESSOA</label>
                                                <input readonly class="form-control" id="custoporpessoa" type="number" name="custoporpessoa" style="background-color:rgb(112, 241, 86); color: #000000;">
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <?php include '../../src/footer_nav.php'; ?>

        </div>
    </div>

    <script src="../../assets/js/vendor.min.js"></script>
    <script src="../../assets/js/app.min.js"></script>

    <!-- Script para adicionar nova linha de itens -->
    <script>
        function adicionarItem() {
            var formularioItens = document.getElementById('formulario-itens');
            var novaLinha = formularioItens.querySelector('.linha-item').cloneNode(true);
            
            // Limpar os campos da nova linha para que fiquem vazios
            var inputs = novaLinha.querySelectorAll('input');
            inputs.forEach(function(input) {
                input.value = '';
            });

            // Adicionar a nova linha abaixo da última
            formularioItens.appendChild(novaLinha);
        }

        function calcularValorTotal(element) {
            var row = element.closest('.linha-item');
            var quantidade = row.querySelector('.quantidade').value;
            var valorUnitario = row.querySelector('.valorunitario').value;
            var valorTotal = row.querySelector('.valortotal');

            if (quantidade && valorUnitario) {
                valorTotal.value = (quantidade * valorUnitario).toFixed(2);
            }
        }
    </script>
</body>
</html>
