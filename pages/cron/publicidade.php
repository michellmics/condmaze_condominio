<?php
include_once "../../objects/objects.php";

$dataAtual = new DateTime();
$siteAdmin = new SITE_ADMIN();
$prestadoresAll = $siteAdmin->getAllPrestadores();

foreach ($prestadoresAll as $item)
{
    $dataInicio = new DateTime($item['PDS_DTPUB_INI']);
    $dataFim = new DateTime($item['PDS_DTPUB_FIM']);

    // Verificando se a data atual está dentro do intervalo
    if ($dataAtual >= $dataInicio && $dataAtual <= $dataFim) {

        $siteAdmin->updatePublicidade($item['PDS_IDPRESTADOR_SERVICO'], "SIM"); 

    } else {

        $siteAdmin->updatePublicidade($item['PDS_IDPRESTADOR_SERVICO'], "NÃO"); 
    }
}



?>