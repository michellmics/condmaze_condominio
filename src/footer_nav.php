<?php
    ini_set('display_errors', 1);  // Habilita a exibição de erros
    error_reporting(E_ALL);        // Reporta todos os erros
	  include_once "../../objects/objects.php";
	
	  session_start(); 
    $_SESSION['last_activity'] = time();
	  define('SESSION_TIMEOUT', 43200); // 30 minutos

    $siteAdmin = new SITE_ADMIN();  
    $siteAdmin->getFooterPublish();    

    //var_dump($siteAdmin->ARRAY_FOOTERPUBLISHINFO);

    $qtdePubli = count($siteAdmin->ARRAY_FOOTERPUBLISHINFO);
    $num = rand(0, $qtdePubli -1);
    $publiText = $siteAdmin->ARRAY_FOOTERPUBLISHINFO[$num]["PUB_DCDESC"];
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