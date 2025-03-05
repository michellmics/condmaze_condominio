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

        if($item['PDS_STSTATUS'] == "PUB")
        {
            $siteAdmin->updatePublicidade($item['PDS_IDPRESTADOR_SERVICO'], "SIM"); 
        }
        else
            {
                $siteAdmin->updatePublicidade($item['PDS_IDPRESTADOR_SERVICO'], "NÃO"); 
            }

    } else {

        $siteAdmin->updatePublicidade($item['PDS_IDPRESTADOR_SERVICO'], "NÃO"); 
    }
}

//--------------------LOG----------------------//
$LOG_DCTIPO = "CRON";
$LOG_DCMSG = "CRON PUBLICIDADE RODOU";
$LOG_DCUSUARIO = "SISTEMA";
$LOG_DCCODIGO = "N/A";
$LOG_DCAPARTAMENTO = "";
$siteAdmin->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO, $LOG_DCCODIGO);
//--------------------LOG----------------------//

?>