
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
<style>
/* Estilo básico para o menu */
.nav.menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.nav.menu > li {
    display: inline-block;
    position: relative;
}

.nav.menu a {
    text-decoration: none;
    padding: 10px 15px;
    display: block;
    color: black; /* Texto preto para o menu principal */
}

/* Estilo para o submenu */
.submenu {
    list-style: none;
    padding: 0;
    margin: 0;
    position: absolute;
    top: -10px; /* Alinha o submenu ao topo do item pai */
    left: 100%; /* Submenu abre imediatamente ao lado */
    display: none; /* Submenu oculto por padrão */
    background-color: #fff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
    width: 100%; /* O submenu ocupa toda a largura do item pai */
    z-index: 1000; /* Certifica-se de que o submenu aparece por cima */
}

.submenu li {
    display: block;
}

.submenu a {
    padding: 20px 15px;
    white-space: nowrap;
    color: black; /* Texto preto para os itens do submenu */
    background-color: #fff; /* Fundo branco para contraste */
}

.submenu a:hover {
    background-color: #f0f0f0; /* Efeito hover no submenu */
}

/* Mostrar submenu ao passar o mouse */
.nav.menu > li:hover .submenu {
    display: block;
}

/* Responsivo: ajuste do submenu em telas menores */
@media (max-width: 768px) {
    .submenu {
        position: absolute;
        top: 100%; /* Alinha o submenu abaixo do item pai */
        left: 0; /* Submenu abre logo abaixo do item pai */
        width: 100%; /* Garante que o submenu se ajuste ao tamanho do item pai */
    }
}




</style>

<nav class="navigation">
    <ul class="nav menu">
        <?php echo $menu; ?>
    </ul>
</nav>