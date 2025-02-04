<?php
    //ini_set('display_errors', 1);  // Habilita a exibição de erros
    //error_reporting(E_ALL);        // Reporta todos os erros
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

   // $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
   // $host = $_SERVER['HTTP_HOST'];
    //$baseUrl = $protocol . "://" . $host;
    //$webmailUrl = $baseUrl . "/api//";

	include_once "../../objects/objects.php";
	
    $siteAdmin = new SITE_ADMIN();  
    $siteAdmin->getPopupImagePublish(); 
    $siteAdmin->getParameterInfo();
    $siteAdmin->getListaMensagensSugestoesInfo();     

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

