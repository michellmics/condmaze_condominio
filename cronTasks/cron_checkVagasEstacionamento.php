<?php

ini_set('display_errors', 1);  
error_reporting(E_ALL);        

$url = "https://parquedashortensias.codemaze.com.br/pages/ctrlVagasVisitante/cron_service_vagaCheck.php";
$result = @file_get_contents($url);  // @ para suprimir erros

if ($result === FALSE) {
    echo "Falha ao acessar o URL.";
} else {
    echo $result;
}

?>