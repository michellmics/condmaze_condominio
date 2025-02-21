<?php

$url = "https://parquedashortensias.codemaze.com.br/pages/ctrlVagasVisitante/service_cron_check_vagas.php"; 
$conteudo = file_get_contents($url);
var_dump($conteudo);
echo $conteudo;
?>

