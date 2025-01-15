<?php
    $siteAdmin = new SITE_ADMIN();  
    $siteAdmin->getFooterPublish();    

    //var_dump($siteAdmin->ARRAY_FOOTERPUBLISHINFO);

    $qtdePubli = count($siteAdmin->ARRAY_FOOTERPUBLISHINFO);
    $num = rand(0, $qtdePubli -1);
    if(isset($siteAdmin->ARRAY_FOOTERPUBLISHINFO[$num]["PUB_DCDESC"])){$publiText = $siteAdmin->ARRAY_FOOTERPUBLISHINFO[$num]["PUB_DCDESC"];}
?>

<footer class="footer">
    <div class="container-fluid">
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