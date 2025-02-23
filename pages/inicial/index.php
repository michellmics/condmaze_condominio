<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == NULL) {
        header("Location: ../login/index.php");
        exit();
    }
	include_once "../../objects/objects.php";
	
    $siteAdmin = new SITE_ADMIN();  
    $siteAdmin->getPopupImagePublish(); 
    $siteAdmin->getParameterInfo();
    $siteAdmin->getListaMensagensSugestoesInfo();  
    $siteAdmin->getArtigosInfoInicial();   
    $siteAdmin->getPendenciasInicialInfo();     

    

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
<html lang="en">
<head>
    <!-- HEAD META BASIC LOAD-->
	<?php include '../../src/headMeta.php'; ?>
	<!-- HEAD META BASIC LOAD -->
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


                </div><!-- FIM CONTEUDO CONTAINER -->                
            </div>
            <!-- content -->
        <!-- FOOTER -->
	    <?php include '../../src/modalTermos.php'; ?>
	    <!-- FOOTER -->   
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
    <!-- SWEETALERT 2 --> 

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

    <script>
        function confirmDelete(event, id) {
            console.log(id);  // Verifica se o id está correto
            Swal.fire({
                title: 'Formulário de Comentários',
                text: "Tem certeza que deseja exluir o comentário?",
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
                        url: "deleteReclamacaoProc.php", // URL para processamento
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
                                text: 'Erro ao excluir o pendência.',
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
 

</body>

</html>