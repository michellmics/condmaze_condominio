<?php
	//session_start(); 
	//define('SESSION_TIMEOUT', 43200); // 30 minutos
	
	if (!isset($_SESSION['user_id'])) 
	{
	  header("Location: https://www.prqdashortensias.com.br/index.php");
	  exit();
	}

    // Atualiza o timestamp da última atividade
	$_SESSION['last_activity'] = time();

	if (!isset($_SESSION['user_id'])) 
	{
	  header("Location: https://www.prqdashortensias.com.br/index.php");
	  exit();
	}

    if ($_SESSION['user_nivelacesso'] == "SINDICO") 
    { 

        $menu = "
        <li><a href='index.php'>Inicio</a></li>
        <li><a href='morador_table.php'>Moradores</a></li>
        <li><a href='lista_table.php'>Lista de Convidados</a></li>
        <li><a href='view_relatorio.php'>Indicadores</a></li>
        <li><a href='lista_log.php'>Atividades</a></li>
        <li><a href='schedule.php'>Agenda</a></li>
        <li><a href='morador_form_edit_profile.php'>Minha Conta</a></li>
        <li><a href='../logoff.php'>Sair</a></li>
        ";
    }
    if ($_SESSION['user_nivelacesso'] == "PORTARIA") 
    { 

        $menu = "
        <li><a href='index.php'>Inicio</a></li>
        <li><a href='morador_table.php'>Moradores</a></li>
        <li><a href='schedule.php'>Agenda</a></li>
        <li><a href='../logoff.php'>Sair</a></li>
        ";
    }
    if ($_SESSION['user_nivelacesso'] == "MORADOR") 
    {
        $menu = "
        <li><a href='index.php'>Inicio</a></li>
        <li><a href='lista_table.php'>Lista de Convidados</a></li>
        <li><a href='view_relatorio.php'>Indicadores</a></li>
        <li><a href='morador_form_edit_profile.php'>Minha Conta</a></li>
        <li><a href='../logoff.php'>Sair</a></li>
        ";
    }
    if ($_SESSION['user_nivelacesso'] == "PARCEIRO") 
    { 

        $menu = "
        <li><a href='index.php'>Inicio</a></li>
        <li><a href='../logoff.php'>Sair</a></li>
        ";
    }
	
	$blocoSession = $_SESSION['user_bloco'];
	$apartamentoSession = $_SESSION['user_apartamento'];
	$nomeSession =  ucwords($_SESSION['user_name']);
	$usuariologado = $nomeSession." <b>BL</b> ".$blocoSession." <b>AP</b> ".$apartamentoSession;
	$userid = $_SESSION['user_id'];
?>
        
        
        <!-- ========== Horizontal Menu Start ========== -->
        <div class="topnav">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg">
                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboards" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="uil-window"></i>Início <div class="dropdown-item"></div>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboards" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="uil-window"></i>Moradores <div class="dropdown-item"></div>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboards" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="uil-dashboard"></i>Indicadores <div class="dropdown-item"></div>
                                </a>
                            </li>
                            
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-components" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="uil-package"></i>Administração <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-components">
                                    <a href="widgets.html" class="dropdown-item">Widgets</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layouts" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="uil-window"></i>Layouts <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-layouts">
                                    <a href="layouts-horizontal.html" class="dropdown-item" target="_blank">Horizontal</a>
                                    <a href="layouts-full.html" class="dropdown-item" target="_blank">Full</a>
                                    <a href="layouts-fullscreen.html" class="dropdown-item" target="_blank">Fullscreen</a>
                                    <a href="layouts-hover.html" class="dropdown-item" target="_blank">Hover Menu</a>
                                    <a href="layouts-compact.html" class="dropdown-item" target="_blank">Compact Menu</a>
                                    <a href="layouts-icon-view.html" class="dropdown-item" target="_blank">Icon View</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!-- ========== Horizontal Menu End ========== -->