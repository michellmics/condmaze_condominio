<?php

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $baseUrl = $protocol . "://" . $host;
    $webmailUrl = $baseUrl;

	session_start(); 
	define('SESSION_TIMEOUT', 43200); // 30 minutos
	
	if (!isset($_SESSION['user_id'])) 
	{
	  //header("Location: $webmailUrl");
	  //exit();
	}

    // Atualiza o timestamp da última atividade
	$_SESSION['last_activity'] = time();

	if (!isset($_SESSION['user_id'])) 
	{
	  //header("Location: $webmailUrl");
	  //exit();
	}

	$blocoSession = $_SESSION['user_bloco'];
	$apartamentoSession = $_SESSION['user_apartamento'];
	$nomeSession =  substr(strtoupper($_SESSION['user_name']),0,23); 
    $nomeSessionShort =  substr($nomeSession,0,15);
	$usuariologado =  "<b>BL</b> ".$blocoSession." <b>AP</b> ".$apartamentoSession;
    $nivelAcesso = strtoupper($_SESSION['user_nivelacesso']);
	$userid = $_SESSION['user_id'];
?>

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
                                <img src="../../img/logo_41x41_small.png" alt="small logo"> 
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

                    <!-- Topbar Search Form -->
                    <div class="app-search dropdown d-none d-lg-block">
                    </div>
                </div>

                <ul class="topbar-menu d-flex align-items-center gap-3">
                <?php echo $nomeSession; ?>
<br>
<?php echo "BL: " . $blocoSession . " AP: " . $apartamentoSession; ?><span style="font-size: 10px; color: #34deeb;"><?php echo $nivelAcesso; ?></span>
</ul>


                    
<!--
                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle arrow-none nav-user px-4" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <span class="account-user-avatar">
                                <img src="../../assets/images/users/avatar_generico.jpg" alt="user-image" width="32" class="rounded-circle">
                            </span>
                            <span class="d-lg-flex flex-column gap-1 d-none">
                                <h5 class="my-0"><?php //echo $nomeSessionShort; ?></h5>
                                <h6 class="my-0 fw-normal"><?php //echo $usuariologado; ?></h6> 
                                <h6 class="my-0 fw-normal"><?php //echo $nivelAcesso; ?></h6> 
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">

                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="mdi mdi-account-circle me-1"></i>
                                <span>Minha Conta</span>
                            </a>


                            <a href="../logoff/index.php" class="dropdown-item">
                                <i class="mdi mdi-logout me-1"></i>
                                <span>Sair</span>
                            </a>
                        </div>
                    </li> -->
                </ul>
            </div>
        </div>