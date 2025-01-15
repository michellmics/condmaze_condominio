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
                <script>document.write(new Date().getFullYear())</script> © Hyper - Coderthemes.com
            </div>
            <div class="col-md-6">
                <div class="text-md-end footer-links d-none d-md-block">
                    <a href="javascript: void(0);">About</a>
                    <a href="javascript: void(0);">Support</a>
                    <a href="javascript: void(0);">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</footer>