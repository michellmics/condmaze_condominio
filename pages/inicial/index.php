<?php
    ini_set('display_errors', 1);  // Habilita a exibição de erros
    error_reporting(E_ALL);        // Reporta todos os erros

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $baseUrl = $protocol . "://" . $host;
    $webmailUrl = $baseUrl . "/api//";

	include_once "../../objects/objects.php";
	
    $siteAdmin = new SITE_ADMIN();  
    $siteAdmin->getPopupImagePublish(); 
    $siteAdmin->getParameterInfo();
  

    

    foreach ($siteAdmin->ARRAY_PARAMETERINFO as $item) {
      if ($item['CFG_DCPARAMETRO'] == 'NOME_CONDOMINIO') {
          $nomeCondominio = $item['CFG_DCVALOR']; 
          break; 
      }
    }   
    
    $qtdePubli = count($siteAdmin->ARRAY_POPUPPUBLISHINFO);
    if($qtdePubli != 0)
    {
        $num = rand(0, $qtdePubli -1);
        $publiImage = $webmailUrl.$siteAdmin->ARRAY_POPUPPUBLISHINFO[$num]["PUB_DCIMG"];

        if($siteAdmin->ARRAY_POPUPPUBLISHINFO[$num]["PUB_DCLINK"] != "")
        {
            $publiImageLink = 'href="' . $siteAdmin->ARRAY_POPUPPUBLISHINFO[$num]["PUB_DCLINK"] . '" target="_blank"';
        }
        else
            {
                $publiImageLink = "";
            }        
    }
    else
        {
            $publiImageLink = "";
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
</head>

<!-- pop-up promoção CSS -->
<style>
    #promoPopup {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* Fundo escuro semi-transparente */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .popup-content {
        position: relative;
		background: transparent; /* Alterado para transparente */
        padding: 20px;
        border-radius: 10px;
        box-shadow: none;
        max-width: 90%;
        max-height: 90%;
        text-align: center;
    }

    .popup-content img {
        max-width: 100%;
        height: auto;
    }

    .close-btn {
		top: -20px; /* Move o botão para cima da imagem */
        right: -20px; /* Move o botão para a direita da imagem */
        position: absolute;
        background:rgb(0, 0, 0);
        color: white;
        border: none;
        font-size: 20px;
        padding: 5px 10px;
        border-radius: 50%;
        cursor: pointer;
    }

    .close-btn:hover {
        background: #cc0000;
    }
</style>
<!-- pop-up promoção CSS -->

<body>
    <!-- Begin page -->
    <div class="wrapper">

		<!-- Top bar Area -->
		<?php include '../../src/top_bar.php'; ?>
		<!-- End Top bar -->

        <?php $siteAdmin->getEncomendaMoradorInfo($userid);?>

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


            		<!--  Pop-up publicidade-->
                    <div id="promoPopup" style="display: none;">
                        <div class="popup-content">
                            <button class="close-btn" onclick="closePopup()">×</button>
                            <a <?php echo $publiImageLink; ?>>
                                <img src="<?php echo $publiImage; ?>" alt="Promoção" style="max-width: 100%; height: auto;">
                            </a>
                        </div>
                    </div>
		            <!--  Pop-up publicidade-->

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
                                <h4 class="page-title">Bem vindo ao <?php echo $nomeCondominio; ?></h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="header-title">Entregas Disponíveis Para Retirada</h4>
                                    <p class="text-muted font-14">
                                    Os pacotes marcados como SIM na coluna <b>RECEBER?</b> da tabela abaixo, devem ser retirados na portaria dentro de um prazo máximo de 30 minutos.
                                    O pacote só será liberado pela portaria se o status da coluna <b>RECEBER?</b> estiver marcado como <b>SIM</b>.
                                    </p>
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="basic-example-preview">
                                            <div class="table-responsive-sm">
                                                <table class="table table-centered mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>AP</th>
                                                            <th>ENTRADA</th>
                                                            <th>RECEBER?</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>



                                                  
                                                <?php foreach ($siteAdmin->ARRAY_ENCOMENDAINFO as $index => $item): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($item['ENC_IDENCOMENDA']); ?></td>
                                                        <td><?= htmlspecialchars($item['USU_DCAPARTAMENTO']); ?></td>
                                                        <td><?= htmlspecialchars($item['ENC_DTENTREGA_PORTARIA']); ?></td>
                                                        <td>
                                                            <!-- Switch -->
                                                            <div>
                                                                <input 
                                                                    type="checkbox" 
                                                                    id="switch<?= $index; ?>" 
                                                                    data-switch="success" 
                                                                    data-id="<?= $item['ENC_IDENCOMENDA']; ?>" 
                                                                    <?= $item['ENC_STENTREGA_MORADOR'] === 'A RETIRAR' ? 'checked' : ''; ?> 
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
                                                    </tr>
                                                <?php endforeach; ?>
                                           



                                                    </tbody>
                                                </table>
                                            </div> <!-- end table-responsive-->
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="header-title">Comunicados</h4>
                                    <p class="text-muted font-14">
                                        Os Últimos avisos serão publicados aqui.
                                    </p>

                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="basic-example-preview">
                                            <div class="table-responsive-sm">


                                            conteudo aqui





                                            </div> <!-- end table-responsive-->
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->
                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div>
                    <!-- end row-->

                    <div class="row">
                    <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="header-title">Comunicados</h4>
                                    <p class="text-muted font-14">
                                        Os Últimos avisos serão publicados aqui.
                                    </p>

                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="basic-example-preview">
                                            <div class="table-responsive-sm">


                                            conteudo aqui





                                            </div> <!-- end table-responsive-->
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->
                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="header-title">Sugestões / Reclamações</h4>
                                    <p class="text-muted font-14">
                                        Compartilhe sua sugestão ou reclamação!
                                        Sua opinião é importante para construirmos juntos um condomínio mais harmonioso e agradável para todos.
                                        <br><b>Atenção:</b> Os recados aqui publicados não são moderados pelo síndico. Por isso, vamos manter o respeito e a cordialidade em nossas mensagens.                                     
                                    </p>

                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="basic-example-preview">
                                            <div class="table-responsive-sm">

                                
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h4 class="mt-0 mb-3">Deixe sua reclamação ou sugestão de forma anônima.</h4>

                                                        <textarea class="form-control form-control-light mb-2" placeholder="Escreva aqui sua mensagem." id="example-textarea" rows="3"></textarea>
                                                        <div class="text-end">
                                                            <div class="btn-group mb-2">
                                                            </div>
                                                            <div class="btn-group mb-2 ms-2">
                                                                <button type="button" class="btn btn-primary btn-sm">Enviar</button>
                                                            </div>
                                                        </div>

                                                        <div class="d-flex align-items-start mt-2">
                                                            <div class="w-100 overflow-hidden">
                                                                <h5 class="mt-0">22/01/2025 13:00:12</h5>
                                                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in
                                                                vulputate at  tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate
                                                                <BR>
                                                                <BR>
                                                                <BR>
                                                                <h5 class="mt-0">22/01/2025 13:00:12</h5>
                                                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in
                                                                vulputate at  tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate
                                                                <BR>
                                                                <BR>
                                                                <BR>
                                                                <h5 class="mt-0">22/01/2025 13:00:12</h5>
                                                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in
                                                                vulputate at  tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate
                                                                <BR>
                                                                <BR>
                                                                <BR>
                                                                <h5 class="mt-0">22/01/2025 13:00:12</h5>
                                                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in
                                                                vulputate at  tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate
                                                                <BR>
                                                                <BR>
                                                                <BR>
                                                                <h5 class="mt-0">22/01/2025 13:00:12</h5>
                                                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in
                                                                vulputate at  tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate
                                                                <BR>
                                                                <BR>
                                                                <BR>
                                                                <h5 class="mt-0">22/01/2025 13:00:12</h5>
                                                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in
                                                                vulputate at  tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate
                                                            </div>

                                                            
                                                        </div>

                                                        <div class="text-center mt-2">
                                                            <a href="javascript:void(0);" class="text-danger">Ler mais </a>
                                                        </div>
                                                    </div> <!-- end card-body-->
                                                </div>
                                                <!-- end card-->





                                            </div> <!-- end table-responsive-->
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

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const switches = document.querySelectorAll('input[type="checkbox"][data-switch="success"]');
        
        switches.forEach(switchElem => {
            switchElem.addEventListener('change', function () {
                const id = this.getAttribute('data-id');
                const status = this.checked ? 'A RETIRAR' : 'PENDENTE';

                // Envia a alteração para o servidor
                fetch('updateStatusCheckbox.php', {
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

</body>

</html>