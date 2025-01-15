<?php
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);

  	include_once '../../objetos.php'; 

    $siteAdmin = new SITE_ADMIN();  
    $siteAdmin->getFooterPublish();    

    //var_dump($siteAdmin->ARRAY_FOOTERPUBLISHINFO);

    $qtdePubli = count($siteAdmin->ARRAY_FOOTERPUBLISHINFO);
    $num = rand(0, $qtdePubli -1);
    $publiText = $siteAdmin->ARRAY_FOOTERPUBLISHINFO[$num]["PUB_DCDESC"];
?>


<style>
  /* Estilo para o container do texto rolante */
  .marquee-container {
    display: block;
    white-space: nowrap;
    overflow: hidden;
    width: 100%; /* Ajusta a largura conforme necessário */
    box-sizing: border-box;
    background-color:rgb(21, 129, 179); /* Exemplo de cor de fundo para o marquee */
    padding: 3px 0; /* Espaçamento para o marquee */
  }

  .marquee-container span {
    display: inline-block;
    animation: marquee 20s linear infinite;
    white-space: nowrap; /* Garante que o texto não quebre a linha */
    color: red;
  }

  /* Animação para rolar o texto */
  @keyframes marquee {
    0% {
      transform: translateX(100%); /* Começa fora da tela à direita */
    }
    100% {
      transform: translateX(-100%); /* Termina fora da tela à esquerda */
    }
  }

  /* Estilo do conteúdo abaixo do marquee */
  .footer-info {
    text-align: center;
    font-size: 11px;
    color: #333;
  }

  .footer-info a {
    color: #007bff;
    text-decoration: none;
  }

  .marquee-container p {
  color:rgb(243, 243, 243); /* Cor do texto do <p> */
}

  .footer-info a:hover {
    text-decoration: underline;
  }
</style>

<footer class="footerNew">
  <!-- Marquee com o conteúdo rolante -->
  <div class="marquee-container">
    <span><?php echo $publiText; ?></span>
  </div>
  
  <!-- Conteúdo abaixo do marquee -->
  <div class="footer-info">
    <a href="https://codemaze.com.br" target="_blank"><b>Codemaze</b></a> - Soluções de Mkt e Software | 
    <b><font color="red"><?php echo $_SESSION['user_nivelacesso']; ?></font></b> | 
    <a href="https://prqdashortensias.com.br/webmail" target="_blank">Webmail</a>
  </div>
</footer>
