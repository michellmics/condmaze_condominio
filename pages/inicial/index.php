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
<html lang="en" data-topbar-color="dark" data-menu-color="dark" data-sidenav-user="true">
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

                    <?php  //modal do termo de privacidade
                        $termoCheck = $siteAdmin->checkTermoPrivacidade($userid); 
                        if ($termoCheck["USU_STTERMO_PRIVACIDADE"] != "ACEITO") { include '../termoPrivacidade/termos.php'; } 
                        $siteAdmin->getEncomendaMoradorInfo($userid);

                        //Pop-up publicidade
                        if ($publiImageLink != null) {?>
                        <div id="promoPopup" style="display: none;">
                            <div class="popup-content">
                                <button class="close-btn" onclick="closePopup()">×</button>
                                <a <?php echo $publiImageLink; ?>>
                                    <img src="<?php echo $publiImage; ?>" alt="Promoção" style="max-width: 100%; height: auto;">
                                </a>
                            </div>
                        </div>
                        <?php }
                    ?>

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">

                                </div>
                                <h4 class="page-title">Bem vindo(a)</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    
                    <div class="row">
                        <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title" style="display: flex; align-items: center; color:rgb(129, 155, 170);"> <i class=" ri-customer-service-2-fill ri-2x" style="color:rgb(218, 5, 200); margin-right: 8px;"></i> Andamento das Pendências</h4>
                                        <p class="text-muted font-14">
                                           Aqui são atualizados pelo sindico(a), os status das <strong>pendências</strong> do condomínio. Fique por dentro sobre o andamento das solicitações e projetos mais relevantes.
                                        </p>
                                        <div class="tab-content">
                                            <div class="tab-pane show active" id="basic-example-preview">
                                                <div class="table-responsive-sm">                                            
                                                    <?php foreach ($siteAdmin->ARRAY_PENDENCIAINFO as $item): ?>
                                                        <?php
                                                            if($item["EPE_DCEVOL"] < 30) {
                                                                $color = "color:rgb(253, 89, 39)";
                                                                $bg = "danger";
                                                            }
                                                            if($item["EPE_DCEVOL"] >= 30 && $item["EPE_DCEVOL"] < 50) {
                                                                $color = "color:rgb(158, 148, 1)";
                                                                $bg = "warning";
                                                            }
                                                            if($item["EPE_DCEVOL"] >= 50 && $item["EPE_DCEVOL"] < 80) {
                                                                $color = "color:rgb(69, 93, 230)";
                                                                $bg = "primary";
                                                            }
                                                            if($item["EPE_DCEVOL"] >= 80) {
                                                                $color = "color:rgb(15, 185, 9)";
                                                                $bg = "success";
                                                            }

                                                            $data_atual = new DateTime();
                                                            $data_item = new DateTime($item["EPE_DTLASTUPDATE"]);
                                                            $diferenca = $data_atual->diff($data_item);

                                                            if ($diferenca->days <= 5 && $data_atual > $data_item) { 
                                                                $atualizado = "RECEM ATUALIZADO";
                                                            } else {
                                                                $atualizado = "";
                                                            }
                                                        ?>

                                                        <!-- inicio barra -->                                            
                                                        <p style="font-size: 11px; margin-bottom: 2px;"><span style="<?php echo $color; ?>; font-weight: bold;"><?php echo $item["EPE_DCEVOL"]; ?>%</span> <?php echo $item["EPE_DCTITULO"]; ?></p>                                            
                                                        <div class="progress col-xl-10" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#scrollable-modal" 
                                                            style="cursor: pointer; margin-bottom: 5px;"
                                                            data-title="<?php echo $item["EPE_DCTITULO"]; ?>"
                                                            data-content="<?php echo $item["EPE_DCOBS"]; ?>"
                                                            >
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-<?php echo $bg; ?>" 
                                                                 role="progressbar" 
                                                                 aria-valuenow="<?php echo $item["EPE_DCEVOL"]; ?>" 
                                                                 aria-valuemin="0" 
                                                                 aria-valuemax="100" 
                                                                 style="width: <?php echo $item["EPE_DCEVOL"]; ?>%;">
                                                            </div>
                                                        </div>
                                                        <p style="color:rgb(106, 131, 177); font-size: 8px; margin-top: 2px;"><?php echo $atualizado; ?></p>                                            
                                                        
                                                    <!-- Fim barra -->
                                                    <?php endforeach; ?>
                                                </div> <!-- end table-responsive-->
                                            </div> <!-- end preview-->
                                        </div> <!-- end tab-content-->
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->

                            <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        var modal = document.getElementById("scrollable-modal");

                                    
                                        modal.addEventListener("show.bs.modal", function (event) {
                                            var triggerElement = event.relatedTarget; // Elemento que acionou o modal
                                            var modalTitle = modal.querySelector(".modal-title");
                                            var modalBodyContent = modal.querySelector("#modal-body-content");
                                        
                                            // Pegando os atributos do botão clicado
                                            var title = triggerElement.getAttribute("data-title");
                                            var content = triggerElement.getAttribute("data-content");
                                            document.getElementById('modal-file-link').innerHTML = '<p><br><br></p>';
                                        
                                            // Inserindo os valores no modal
                                            if (modalTitle) {
                                                modalTitle.textContent = title;
                                            }
                                            if (modalBodyContent) {
                                                //modalBodyContent.textContent = content;
                                                modalBodyContent.innerHTML = content;
                                            }
                                        });
                                    });
                            </script>


                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="header-title" style="display: flex; align-items: center; color:rgb(129, 155, 170);"> <i class="ri-stack-line ri-2x" style="color:rgb(218, 5, 200); margin-right: 8px;"></i> PROCEDIMENTOS / COMUNICADOS</h4>
                                    <p class="text-muted font-14">
                                    Aqui você encontra o <strong>TOP 10</strong> comunicados, procedimentos e dicas importantes para a harmonia e o bem-estar no condomínio. Para ver todos os comunicados, <a href="../instrucoesAdequacoes/index.php">clique aqui.</a>
                                    </p>
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="basic-example-preview">
                                            <div class="table-responsive-sm">
                                                <div class="list-group">
                                                    <?php foreach ($siteAdmin->ARRAY_ARTIGOSINFO as $item): ?>                                            
                                                        <button type="button" class="list-group-item list-group-item-action d-flex align-items-center"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#scrollable-modal"
                                                                data-title="<?= htmlspecialchars($item['INA_DCTITULO']); ?>"
                                                                data-content="<?= htmlspecialchars($item['INA_DCTEXT']); ?>"
                                                                data-file="<?php

                                                                    $file = basename($item['INA_DCFILEURL']);
                                                                    echo $file;

                                                                     ?>"> <!-- Aqui passa o arquivo para o modal -->
                                                            <i class="ri-book-line ri-1x" style="color:rgb(0, 151, 197); margin-right: 8px;"></i>
                                                            <?= htmlspecialchars($item['INA_DCTITULO']); ?>
                                                        </button>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div> <!-- end table-responsive-->
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->
                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div>
                    <!-- end row-->

                    <!-- HEAD META BASIC LOAD-->
	                <?php include '../../src/modalScroll.php'; ?>
	                <!-- HEAD META BASIC LOAD -->                                           

                    <script>
                        document.querySelectorAll('.list-group-item').forEach(button => {
                            button.addEventListener('click', function() {
                                document.getElementById('scrollableModalTitle').textContent = this.getAttribute('data-title');
                                document.getElementById('modal-body-content').innerHTML = this.getAttribute('data-content');
                            
                                        // Recebe o arquivo (se houver) e cria o link de download
                                        var fileUrl = this.getAttribute('data-file'); // Obtém o nome do arquivo

                            
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
                    
                    <div class="row">
                    <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'MORADOR'): ?>
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title" style="display: flex; align-items: center; color:rgb(129, 155, 170);"> <i class="ri-briefcase-line ri-2x" style="color:rgb(218, 5, 200); margin-right: 8px;"></i> Encomendas Disponíveis Para Retirada</h4>
                                    <p class="text-muted font-14">
                                    Os pacotes marcados como <strong>SIM</strong> na coluna <strong>RETIRAR?</strong> da tabela abaixo devem ser retirados imediatamente na portaria.  
                                    O pacote só será liberado pela portaria se o status da coluna <strong>RETIRAR?</strong> estiver marcado como <strong>SIM</strong>.

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
                                                            <th>RETIRAR?</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>                                                  
                                                        <?php foreach ($siteAdmin->ARRAY_ENCOMENDAINFO as $index => $item): ?>
                                                            <tr>
                                                                <?php
                                                                    $date = new DateTime($item['ENC_DTENTREGA_PORTARIA']);
                                                                    $dataEntrega = $date->format('d/m/Y H:i');
                                                                ?>
                                                                <td style="font-size: 12px;"><?= htmlspecialchars($item['ENC_IDENCOMENDA']); ?></td>
                                                                <td style="font-size: 12px;"><?= htmlspecialchars($item['USU_DCAPARTAMENTO']); ?></td>
                                                                <td style="font-size: 12px;"><?= htmlspecialchars($dataEntrega); ?></td>
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
                        <?php endif; ?>  

                        <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'MORADOR' || $nivelAcesso == 'SUPORTE'): ?>
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title" style="display: flex; align-items: center; color:rgb(129, 155, 170);"> <i class=" ri-mail-send-line ri-2x" style="color:rgb(218, 5, 200); margin-right: 8px;"></i> Sugestões / Reclamações</h4>
                                        <p class="text-muted font-14">
                                            Compartilhe sua sugestão ou reclamação!
                                            Sua opinião é importante para construirmos juntos um condomínio mais harmonioso e agradável para todos.
                                            <br><b>Atenção:</b> Os recados aqui publicados <strong>não são </strong>moderados pelo síndico. Por isso, vamos manter o respeito e a cordialidade em nossas mensagens. <br>  
                                            <strong>As mensagens enviadas anônimamente por meio deste formulário serão visíveis para todos os moradores. </strong>                                 
                                        </p>                            
                                        <div class="tab-content">
                                            <div class="tab-pane show active" id="basic-example-preview">
                                                <div class="table-responsive-sm">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h4 class="mt-0 mb-3">Deixe sua reclamação ou sugestão de forma anônima.</h4>
                                                            <form class="needs-validation" novalidate id="form" role="form" method="POST">
                                                            <textarea required class="form-control form-control-light mb-2" placeholder="Escreva aqui sua mensagem. (até 300 caracteres)" id="msg"  minlength="3" maxlength="300" name="msg" rows="5"></textarea>
                                                            <div class="text-end">
                                                                <div class="btn-group mb-2">
                                                                </div>
                                                                <div class="btn-group mb-2 ms-2">
                                                                    <button type="button" class="btn btn-primary btn-sm" id="botao">Enviar</button>
                                                                </div>
                                                            </div>
                                                            </form>

                                                            <?php foreach ($siteAdmin->ARRAY_MENSAGENSINFO as $index => $item): ?>
                                                            <div class="d-flex align-items-start mt-3">
                                                                <a class="pe-3" href="#">
                                                                    <img src="../../img/anonimo.jpg" class="avatar-sm rounded-circle" alt="Generic placeholder image">
                                                                </a>
                                                                <div class="w-100 overflow-hidden">  
                                                                    <?php if ($nivelAcesso == 'SINDICO' || $nivelAcesso == 'SUPORTE'): ?>
                                                                        <a class="text-danger" onclick="confirmDelete(event, '<?= htmlspecialchars($item['REC_IDRECLAMACAO'], ENT_QUOTES, 'UTF-8'); ?>')">
                                                                            <i class="mdi mdi-delete" title="Excluir Reclamação" style="cursor: pointer; font-size: 24px;"></i>
                                                                        </a>
                                                                    <?php endif; ?> 

                                                                    <?php     
                                                                        $data = new DateTime($item['REC_DTDATA']);
                                                                        $dataFormatada = $data->format('d/m/Y H:i:s');
                                                                    ?>

                                                                    <h5 class="mt-0"><?= htmlspecialchars($dataFormatada); ?></h5>                                                                    
                                                                    <td><?= htmlspecialchars($item['REC_DCMSG']); ?></td>                                                                       
                                                                </div>                                                            
                                                            </div>
                                                            <?php endforeach; ?>
                                                            <div class="text-center mt-2">
                                                                <a href="javascript:void(0);" class="text-danger"></a>
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
                        <?php endif; ?> 
                    </div>
                    <!-- end row-->

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