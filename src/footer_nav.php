<?php
    $siteAdmin = new SITE_ADMIN();  
    $siteAdmin->getFooterPublish();    

    //var_dump($siteAdmin->ARRAY_FOOTERPUBLISHINFO);

    $qtdePubli = count($siteAdmin->ARRAY_FOOTERPUBLISHINFO);
    $num = rand(0, $qtdePubli -1);
    if(isset($siteAdmin->ARRAY_FOOTERPUBLISHINFO[$num]["PUB_DCDESC"])){$publiText = $siteAdmin->ARRAY_FOOTERPUBLISHINFO[$num]["PUB_DCDESC"];}
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

<footer class="footer">
    <div class="container-fluid">
    <div class="row col-md-12">
            <div class="marquee-container text-md-end footer-links d-none d-md-block">
                <span><?php echo "texxxxexxxxexxxxexxxxexxxxexxxxexxxxexxxxexxxxexxxxexxxxexxxxexxxxexxxxexxxxexxxx"; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">               
                <a href="https://codemaze.com.br" target="_blank"><b>Codemaze</b></a> - Soluções de Mkt e Software | 
                <b><font color="red"><?php echo $_SESSION['user_nivelacesso']; ?></font></b> | 
            </div>
            <div class="col-md-6">
                <div class="text-md-end footer-links d-none d-md-block">
                    <a href="javascript: void(0);">Webmail</a>
                </div>
            </div>
        </div>
    </div>
</footer>
