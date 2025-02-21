<?php

ini_set('display_errors', 1);  
error_reporting(E_ALL);        

$url = "https://parquedashortensias.codemaze.com.br/pages/ctrlVagasVisitante/cron_service_vagaCheck.php";
$result = file_get_contents($url);
echo $result;



?>
