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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <!-- Theme Config Js -->
    <script src="../../assets/js/hyper-config.js"></script>

    <!-- Vendor css -->
    <link href="../../assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="../../assets/css/app-modern.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="../../../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <!-- Datatables css -->
    <link href="../../assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />

    <!-- SWEETALERT -->
    <script src="../../js/sweetalert2@11.js"></script>

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

        <?php $siteAdmin->getPetsInfoById($userid); ?>

            <!-- Modal -->
            <div class="modal fade" id="petModal" tabindex="-1" aria-labelledby="petModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="petModalLabel">Cadastrar Pet</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" id="form" name="form" role="form" method="POST" enctype="multipart/form-data" novalidate>

                                <!-- CAMPOS COMO VARIAVEIS -->
                                <input type="hidden" id="apartamento" name="apartamento" value="<?php echo $apartamentoSession; ?>"/>
                                <input type="hidden" id="idmorador" name="idmorador" value="<?php echo $userid; ?>"/>
                                <!-- CAMPOS COMO VARIAVEIS -->
                                <!-- Nome -->
                                <div class="mb-3">
                                    <label for="nome" class="form-label">NOME DO PET</label>
                                    <input type="text" class="form-control" id="nome" maxlength="25" name="nome" style="text-transform: uppercase;" required>
                                </div>

                                <!-- Raça -->
                                <div class="mb-3">
                                    <label for="raca" class="form-label">QUAL A RAÇA?</label>
                                    <input type="text" class="form-control" id="raca" name="raca" maxlength="25" style="text-transform: uppercase;" required>
                                </div>

                                <div class="mb-3">
                                    <label for="cor" class="form-label">QUAL A COR?</label>
                                    <select class="form-control" id="cor" name="cor" required>
                                        <option value="PRETO">PRETO</option>
                                        <option value="BRANCO">BRANCO</option>
                                        <option value="CARAMELO">CARAMELO</option>
                                        <option value="CINZA">CINZA</option>
                                    </select>
                                </div>

                                <!-- Tipo -->
                                <div class="mb-3">
                                    <label for="tipo" class="form-label">QUAL O TIPO?</label>
                                    <select class="form-control" id="tipo" name="tipo" required>
                                        <option value="CAO">CÃO</option>
                                        <option value="GATO">GATO</option>
                                        <option value="PASSARO">PÁSSARO</option>
                                    </select>
                                </div>

                                <!-- Foto -->
                                <div class="mb-3">
                                    <label for="foto" class="form-label">FOTO</label>
                                    <input type="file" class="form-control" id="foto" name="foto" accept="image/jpeg, image/jpg, image/png, image/gif" required>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                    <button class="btn btn-primary" type="button" id="botao" name="botao">Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        <!-- Modal -->
        <div class="modal fade" id="modalAnimais" tabindex="-1" aria-labelledby="modalAnimaisLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAnimaisLabel">PETS ENCONTRADOS</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="resultadoPesquisa">
                            <p>Carregando...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<!-- Modal para exibir a imagem em tamanho original -->
<div class="modal fade" id="imagemModal" tabindex="-1" aria-labelledby="imagemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imagemModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="imagemGrande" src="" class="img-fluid rounded" alt="Imagem ampliada">
            </div>
        </div>
    </div>
</div>

<!-- Script para atualizar a imagem no modal -->
<script>
function mostrarImagem(src) {
    document.getElementById("imagemGrande").src = src;
}
</script>

        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                </div>
                <!-- container -->
            </div>
            <!-- content -->

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                </div>
                                <h4 class="page-title"></h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="d-flex justify-content-center mt-4">
                       <div class="col-md-6">
                           <div class="card shadow-lg rounded-lg">
                               <div class="card-body text-center">
                                   <h4 class="header-title">Meus Pets</h4>
                                   <p class="text-muted font-14">
                                   🐾 Encontrou um Pet Perdido?
                                   Verifique se ele pode ser de um morador do condomínio e ajude a devolver ao lar! 😊
                                   </p>

   
                                        <div class="d-flex gap-2 align-items-center">
                                        <label for="raca" class="form-label">RAÇA</label>
                                        <input type="text" class="form-control" id="raca" maxlength="15" name="raca" style="text-transform: uppercase;">

                                            <select class="form-control" id="tipo" name="tipo" required style="width: 100px;">
                                                <option value="" disabled selected>TIPO</option>
                                                <option value="CAO">CÃO</option>
                                                <option value="GATO">GATO</option>
                                                <option value="PASSARO">PÁSSARO</option>
                                                <option value="">TODOS</option>
                                            </select>
                                            <select class="form-control" id="cor" name="cor" required style="width: 120px;">
                                                <option value="" disabled selected>COR</option>
                                                <option value="PRETO">PRETO</option>
                                                <option value="BRANCO">BRANCO</option>
                                                <option value="CARAMELO">CARAMELO</option>
                                                <option value="CINZA">CINZA</option>
                                                <option value="">TODOS</option>
                                            </select>
                                        </div>
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary">Procurar</button>
                                        </div>
                                    </form>
                               </div>

                               <script>
                                    document.getElementById("formProcurar").addEventListener("submit", function(event) {
                                        event.preventDefault();
                                    
                                        var formData = new FormData(this);
                                    
                                        fetch("pet_img_proc.php", {
                                            method: "POST",
                                            body: formData
                                        })
                                        .then(response => response.text()) 
                                        .then(data => {
                                            document.getElementById("resultadoPesquisa").innerHTML = data;
                                            var myModal = new bootstrap.Modal(document.getElementById("modalAnimais"));
                                            myModal.show();
                                        })
                                        .catch(error => console.error("Erro na requisição:", error));
                                    });
                                </script>


                               <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title"></h4>
                                    <p class="text-muted font-14">
                                    </p>
                                    <div class="tab-content">
                                        <div class="col-sm-5">  
                                        
                                        <div class="row justify-content-center align-items-center vh-100">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <img src="../../assets/images/svg/file-searching.svg" height="90" alt="File not found Image">

                                <h1 class="text-error mt-4">401</h1>
                                <h4 class="text-uppercase text-danger mt-3">Acesso não autorizado</h4>
                                <p class="text-muted mt-3">Você não tem permissão para acessar esta sessão. Se você acredita que isso é um erro, entre em contato com o suporte.</p>

                                <a class="btn btn-info mt-3" href="../inicial/index.php"><i class="mdi mdi-reply"></i> Retornar</a>
                            </div> <!-- end /.text-center-->
                        </div> <!-- end col-->
                    </div>


                                        </div>
                                    </div> <!-- end tab-content-->

                                </div> <!-- end card body-->
                            </div> <!-- end card -->





                           </div>
                       </div>
                    </div>

                    <!-- end row -->

                </div>
                <!-- container -->

            </div>
            <!-- content -->

            <?php include '../../src/footer_nav.php'; ?>

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
          title: 'Formulário de Pets',
          text: "Têm certeza que deseja cadastrar o Pet?",
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
              url: "insertPetProc.php", // URL para processamento
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












   <!-- ######################################################## --> 
    <!-- SWEETALERT 2 -->   

    <script>
function confirmDelete(event, id) {
    console.log(id);  // Verifica se o id está correto
    Swal.fire({
        title: 'Formulário de Pets',
        text: "Tem certeza que deseja excluir o pet?",  // Correção do erro de digitação
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
                url: "deletePetProc.php", // URL para processamento
                type: "POST",
                data: { 
                    id: id
                },
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
                        text: 'Erro ao excluir o Pet.',
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

    <!-- Vendor js -->
    <script src="../../assets/js/vendor.min.js"></script>

    <!-- Code Highlight js -->
    <script src="../../assets/vendor/highlightjs/highlight.pack.min.js"></script>
    <script src="../../assets/vendor/clipboard/clipboard.min.js"></script>
    <script src="../../assets/js/hyper-syntax.js"></script>

    <!-- Dropzone File Upload js -->
    <script src="../../assets/vendor/dropzone/dropzone-min.js"></script>

    <!-- File Upload Demo js -->
    <script src="../../assets/js/ui/component.fileupload.js"></script>

    <!-- App js -->
    <script src="../../assets/js/app.min.js"></script>

</body>

</html>