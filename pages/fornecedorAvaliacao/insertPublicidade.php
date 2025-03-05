<?php
    ob_start();
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

    foreach ($siteAdmin->ARRAY_PARAMETERINFO as $item) {
      if ($item['CFG_DCPARAMETRO'] == 'NOME_CONDOMINIO') {
          $nomeCondominio = $item['CFG_DCVALOR']; 
          break; 
      }
    }   

    $ARRAY_CATEGORIA = $siteAdmin->getCategoriasPublicidadeInfo();
?>
<!DOCTYPE html>
<html lang="en" data-topbar-color="dark" data-menu-color="dark" data-sidenav-user="true" data-bs-theme="dark">
<head>
    <meta charset="utf-8" />
    <title><?php echo $nomeCondominio; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Codemaze" name="description" />
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
                                <h4 class="page-title">Cadastro de Publicidade</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Banner Publicitário</h4>
                                    <p class="text-muted font-14">Nesta seção você pode cadastrar os banners publicitários.<br>
                                    <strong>Atenção aos tamanhos</strong> <br>
                                    <strong>Categoria PRO (Topo):</strong> 800px X 120px <br>
                                    <strong>Categoria SEMIPRO:</strong> 800px X 80px <br>
                                    <strong>Demais Categorias:</strong> 420px X 54px <br><br>
                                    São aceitas imagens PNG, JPG e GIF.
                                    </p>

                                    <div class="tab-content">
                                      <div class="tab-pane show active" id="tooltips-validation-preview">
                                          <form class="needs-validation" id="form" name="form" role="form" method="POST" enctype="multipart/form-data" novalidate>

                                              <!-- ID Publicidade Categoria -->
                                              <div class="position-relative mb-3">
                                                 <label class="form-label" for="categoria">Categoria Publicidade</label>
                                                 <select id="categoria" name="categoria" class="form-control" required>
                                                     <?php 

                                                     // Preenchendo o select com as categorias
                                                     foreach ($ARRAY_CATEGORIA as $categoria) {
                                                         echo '<option value="' . $categoria["PUC_IDPUBLICIDADE_CATEGORIA"] . '">' . $categoria["PUC_DCNOME"] . '</option>';
                                                     }
                                                     ?>
                                                 </select>
                                                 <div class="valid-tooltip">
                                                     Validado!
                                                 </div>
                                                 <div class="invalid-tooltip">
                                                     Por favor, escolha uma categoria de publicidade.
                                                 </div>
                                              </div>

                                              <!-- Nome do Prestador -->
                                              <div class="position-relative mb-3">
                                                  <label class="form-label" for="nomeprestador">Nome do Prestador</label>
                                                  <input id="nomeprestador" name="nomeprestador" type="text" class="form-control" placeholder="Nome do Prestador" style="text-transform: uppercase;" required />
                                                  <div class="valid-tooltip">Validado!</div>
                                                  <div class="invalid-tooltip">Por favor, preencha o nome do prestador de serviço.</div>
                                              </div>

                                              <!-- Campanha -->
                                              <div class="position-relative mb-3">
                                                  <label class="form-label" for="campanha">Campanha</label>
                                                  <input id="campanha" name="campanha" type="text" class="form-control" placeholder="Nome da Campanha" style="text-transform: uppercase;" required />
                                                  <div class="valid-tooltip">Validado!</div>
                                                  <div class="invalid-tooltip">Por favor, preencha o nome da campanha.</div>
                                              </div>

                                              <!-- Data Início da Publicidade -->
                                              <div class="position-relative mb-3">
                                                  <label class="form-label" for="datapubini">Data Início</label>
                                                  <input id="datapubini" name="datapubini" type="datetime-local" class="form-control" required />
                                                  <div class="valid-tooltip">Validado!</div>
                                                  <div class="invalid-tooltip">Por favor, preencha a data de início da publicidade.</div>
                                              </div>

                                              <!-- Data Fim da Publicidade -->
                                              <div class="position-relative mb-3">
                                                  <label class="form-label" for="datapubfim">Data Fim</label>
                                                  <input id="datapubfim" name="datapubfim" type="datetime-local" class="form-control" required />
                                                  <div class="valid-tooltip">Validado!</div>
                                                  <div class="invalid-tooltip">Por favor, preencha a data de fim da publicidade.</div>
                                              </div>

                                              <!-- Nome do Arquivo da Imagem -->
                                              <div class="position-relative mb-3">
                                                  <label class="form-label" for="imagem">Nome Arquivo Imagem</label>
                                                  <input id="imagem" name="imagem" type="file" class="form-control" required />
                                                  <div class="valid-tooltip">Validado!</div>
                                                  <div class="invalid-tooltip">Por favor, selecione uma imagem.</div>
                                              </div>

                                              <!-- Ordem -->
                                              <div class="position-relative mb-3">
                                                  <label class="form-label" for="ordem">Ordem</label>
                                                  <input id="ordem" name="ordem" type="number" class="form-control" placeholder="Ordem" min="1" required oninput="if(this.value < 1) this.value = 1" />
                                                  <div class="valid-tooltip">Validado!</div>
                                                  <div class="invalid-tooltip">Por favor, preencha a ordem.</div>
                                              </div>

                                              <!-- URL -->
                                              <div class="position-relative mb-3">
                                                  <label class="form-label" for="url">URL</label>
                                                  <input id="url" name="url" type="url" class="form-control" placeholder="URL da campanha" required />
                                                  <div class="valid-tooltip">Validado!</div>
                                                  <div class="invalid-tooltip">Por favor, preencha a URL.</div>
                                              </div>

                                              <!-- Cor de Fundo Hexadecimal -->
                                              <div class="position-relative mb-3">
                                                  <label class="form-label" for="hexcolorbg">Cor de Fundo Hex</label>
                                                  <input id="hexcolorbg" name="hexcolorbg" type="text" class="form-control" maxlength="7" placeholder="Código Hexadecimal da Cor" style="text-transform: uppercase;" required />
                                                  <div class="valid-tooltip">Validado!</div>
                                                  <div class="invalid-tooltip">Por favor, preencha o código hexadecimal da cor de fundo.</div>
                                              </div>

                                              <!-- Observações -->
                                              <div class="position-relative mb-3">
                                                  <label class="form-label" for="observacoes">Observações</label>
                                                  <textarea id="observacoes" name="observacoes" class="form-control" placeholder="Observações sobre a campanha" required></textarea>
                                                  <div class="valid-tooltip">Validado!</div>
                                                  <div class="invalid-tooltip">Por favor, preencha as observações.</div>
                                              </div>

                                              <button class="btn" style="background-color: #aa2ed8; color: white;" type="button" onclick="window.history.back()">Voltar</button>
                                              <button class="btn" style="background-color: #21feae; color: black;" type="submit" name="submit">Salvar</button>

                                          </form>
                                      </div> <!-- end preview-->
                                  </div> <!-- end tab-content-->

                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>                     
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('form').addEventListener('submit', function(event) {
    event.preventDefault();  // Previne o envio padrão do formulário

    // Criar FormData com os dados do formulário
    var formData = new FormData(this);

    // Enviar os dados usando AJAX
    fetch('insertPublicidadeProc.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Exibe um SweetAlert baseado no retorno do PHP
        if (data.success) {
            // Caso o envio seja bem-sucedido
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: data.message,
            }).then(() => {
                // Redireciona ou limpa o formulário
                window.location.reload();
            });
        } else {
            // Caso ocorra um erro
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: data.message,
            });
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: 'Não foi possível se conectar ao servidor.',
        });
    });
});
</script>

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
    <script src="../../assets/js/blockCode.js"></script>

</body>

</html>