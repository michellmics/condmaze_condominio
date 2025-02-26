<?php
    if (session_status() === PHP_SESSION_NONE) {
        ini_set('session.gc_maxlifetime', 43200);
        ini_set('session.cookie_lifetime', 43200);
        session_set_cookie_params(43200);
        session_start();
    }

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $baseUrl = $protocol . "://" . $host;
    $siteUrl = $baseUrl;
    $webmailUrl = $baseUrl . "/api//";

	$blocoSession = $_SESSION['user_bloco'];
	$apartamentoSession = $_SESSION['user_apartamento'];
	$nomeSession =  substr(strtoupper($_SESSION['user_name']),0,21)."..."; 
    $nomeSessionShort =  substr($nomeSession,0,15);
	$usuariologado =  "<b>BL</b> ".$blocoSession." <b>AP</b> ".$apartamentoSession;
    $nivelAcesso = strtoupper($_SESSION['user_nivelacesso']);
	$userid = $_SESSION['user_id'];
    $lang = $_SESSION['lang'] ?? 'pt';

    if (isset($_GET['lang'])) {
        $lang = $_GET['lang'];
        $_SESSION['lang'] = $lang;
    }

    include_once "../../objects/objects.php";
    $notificacao = new SITE_ADMIN();      
    $notificacao->getNotificacaoByUsuarioFront($userid);

    //var_dump($notificacao->ARRAY_NOTIFICACAOFRONTINFO);
    //die();
    


    // Carrega o dicionário
    $translations = include "../../src/lang/$lang.php"; 
?>

<!-- MODAL TERMOS -->
<?php include 'preloader.php'; ?>
<!-- MODAL TERMOS -->
<style>
.modal-backdrop.show {
    background-color: rgba(0, 0, 0, 0.8) !important; 
}
</style>


    <!-- ========== Topbar Start ========== -->
        <div class="navbar-custom">
            <div class="topbar container-fluid">
                <div class="d-flex align-items-center gap-lg-2 gap-1">

                    <!-- Topbar Brand Logo -->
                    <div class="logo-topbar">
                        <!-- Logo light -->
                        <a href="../inicial/index.php" class="logo-light">
                            <span class="logo-lg">
                                <img src="../../img/logo_128x32_white.png" alt="logo">
                            </span>
                            <span class="logo-sm">
                                <img src="../../img/logo_128x128.png" alt="small logo">
                            </span>
                        </a>

                        <!-- Logo Dark -->
                        <a href="../inicial/index.php" class="logo-dark">
                            <span class="logo-lg">
                                <img src="../../img/logo_128x32_black.png" alt="dark logo">
                            </span>
                            <span class="logo-sm">
                                <img src="../../img/logo_41x41_small.png" alt="small logo">
                            </span>
                        </a>
                    </div>

                    <!-- Sidebar Menu Toggle Button -->
                    <button class="button-toggle-menu">
                        <i class="mdi mdi-menu"></i>
                    </button>

                    <!-- Horizontal Menu Toggle Button -->
                    <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>
                </div>

                <ul class="topbar-menu d-flex align-items-center gap-3">
                    <!--
                    <li class="dropdown d-lg-none">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ri-search-line font-22"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                            <form class="p-3">
                                <input type="search" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                            </form>
                        </div>
                    </li>--> 

                    <!-- idioma -->                      
                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="../../assets/images/flags/<?php echo $lang === 'pt' ? 'br' : 'us'; ?>.jpg" alt="user-image" class="me-0 me-sm-1" height="12">
                            <span class="align-middle d-none d-lg-inline-block">
                                <?php echo $lang === 'pt' ? 'Português' : 'English'; ?>
                            </span>
                            <i class="mdi mdi-chevron-down d-none d-sm-inline-block align-middle"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated">
                            <!-- Português -->
                            <a href="?lang=pt" class="dropdown-item">
                                <img src="../../assets/images/flags/br.jpg" alt="user-image" class="me-1" height="12">
                                <span class="align-middle">Português</span>
                            </a>
                            <!-- Inglês -->
                             <!--
                            <a href="?lang=en" class="dropdown-item">
                                <img src="../../assets/images/flags/us.jpg" alt="user-image" class="me-1" height="12">
                                <span class="align-middle">English</span>
                            </a>
                            -->
                        </div>
                    </li>

                    <!-- Notificações -->
                    
                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ri-notification-3-line font-22"></i>
                            <span class="noti-icon-badge style=background-color: green;"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg py-0">
                            <div class="p-2 border-top-0 border-start-0 border-end-0 border-dashed border">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 font-16 fw-semibold"> Notificações</h6>
                                    </div>
                                    <div class="col-auto">
                                    <a href="javascript:void(0);" class="text-dark text-decoration-underline" id="limparNotificacoes" data-userid="<?= htmlspecialchars($userid); ?>">
                                        <small>Limpar Todos</small>
                                    </a>
                                    </div>
                                </div>
                            </div>

                            <div class="px-2" style="max-height: 300px;" data-simplebar>  
                                <?php foreach ($notificacao->ARRAY_NOTIFICACAOFRONTINFO as $notificacaoItem) : ?>     
                                    <?php
                                        $date = new DateTime($notificacaoItem['NOT_DTINSERT']);
                                        $dataFormatPend = $date->format('d/m/Y H:i');
                                    ?>                      
                                    <a href="javascript:void(0);" 
                                        class="dropdown-item p-0 notify-item card unread-noti shadow-none mb-2">
                                    <div class="card-body">
                                        
                                        <span class="float-end noti-close-btn text-muted" 
                                              data-id="<?php echo $notificacaoItem['USN_IDNOTIFICACAO']; ?>"> 
                                            <i class="mdi mdi-close"></i>
                                        </span>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="notify-icon bg-primary">
                                                    <i class="mdi mdi-comment-account-outline"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 text-truncate ms-2" title="<?= htmlspecialchars($notificacaoItem['NOT_DCMSG']); ?>">
                                                <h5 class="noti-item-title fw-semibold font-14"><?= htmlspecialchars($notificacaoItem['NOT_DCTITLE']); ?> <small class="fw-normal text-muted ms-1"><?= htmlspecialchars($dataFormatPend); ?></small></h5>
                                                <small class="noti-item-subtitle text-muted"><?= htmlspecialchars($notificacaoItem['NOT_DCMSG']); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <?php endforeach; ?>
                                <script>
                                    document.getElementById("limparNotificacoes").addEventListener("click", function() {                                       
                                    
                                        let userid = this.dataset.userid; // Forma alternativa de obter o atributo data-*
                                        console.log("Enviando userid:", userid); // Debug
                                    
                                        fetch("../notificacoes/limparNotificacoes.php", {
                                            method: "POST",
                                            headers: { "Content-Type": "application/json" },
                                            body: JSON.stringify({ userid: userid }) // Envia o userid como JSON
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                document.querySelector(".px-2").innerHTML = "<p class='text-center text-muted'>Nenhuma notificação.</p>";
                                            } else {
                                                alert("Erro ao limpar notificações: " + data.error);
                                            }
                                        })
                                        .catch(error => console.error("Erro na requisição:", error));
                                    });

                                        // Evento para limpar apenas UMA notificação
                                        document.querySelectorAll(".noti-close-btn").forEach(btn => {
                                            btn.addEventListener("click", function(event) {
                                                event.stopPropagation(); // Evita que clique no botão acione outros eventos
                                            
                                                let idNotificacao = this.getAttribute("data-id");
                                                let notiItem = this.closest(".notify-item"); // Pega o elemento da notificação
                                            
                                                fetch("../notificacoes/limparNotificacoesByid.php", {
                                                    method: "POST",
                                                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                                                    body: "id=" + encodeURIComponent(idNotificacao)
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    if (data.success) {
                                                        notiItem.remove(); // Remove a notificação da interface
                                                    } else {
                                                        alert("Erro ao remover notificação: " + data.error);
                                                    }
                                                })
                                                .catch(error => console.error("Erro:", error));
                                            });
                                        });
                                </script>

                                <div class="text-center">
                                    <i class="mdi mdi-dots-circle mdi-spin text-muted h3 mt-0"></i>
                                </div>
                            </div>

                        </div>
                    </li>
                   
                    <!-- Escurecer tema -->
                    <li class="d-none d-sm-inline-block">
                        <div class="nav-link" id="light-dark-mode" data-bs-toggle="tooltip" data-bs-placement="left" title="Modo do Tema">
                            <i class="ri-moon-line font-22"></i>
                        </div>
                    </li>

                    <!-- FullScreen -->
                    <li class="d-none d-md-inline-block">
                        <a class="nav-link" href="" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line font-22"></i>
                        </a>
                    </li>

                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle arrow-none nav-user px-2" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <span class="account-user-avatar">
                                <img src="../../assets/images/users/Hall.jpg" alt="user-image" width="32" class="rounded-circle">
                            </span>
                            <span class="d-lg-flex flex-column gap-1 d-none">
                                <h5 class="my-0"><?php $nomeSession = ucwords(strtolower($nomeSession)); echo $nomeSession; ?></h5>
                                <h6 class="my-0 fw-normal"><?php echo "BL: " . $blocoSession . " APTO: " . $apartamentoSession; ?></h6>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                            <!-- item-->
                            <div class=" dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Bem Vindo(a)</h6>
                            </div>
                            <!-- item-->
                            <a style="cursor: pointer;" onclick="window.location.href='https://parquedashortensias.codemaze.com.br/pages/listaMoradores/insertMorador.php?apartamento=<?= $apartamentoSession; ?>'" class="dropdown-item">
                                <i class="mdi mdi-account-circle me-1"></i>
                                <span>Minha Conta</span>
                            </a>

                            <!-- item-->
                             <!--
                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="mdi mdi-account-edit me-1"></i>
                                <span>Suporte</span>
                            </a>
                            -->

                            <!-- item-->
                            <a href="../logoff/index.php" class="dropdown-item">
                                <i class="mdi mdi-lifebuoy me-1"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>