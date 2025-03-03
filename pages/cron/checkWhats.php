<?php
include_once "../../objects/objects.php";

$siteAdmin = new SITE_ADMIN();
$siteAdmin->getParameterInfo();

foreach ($siteAdmin->ARRAY_PARAMETERINFO as $item) {
    if ($item['CFG_DCPARAMETRO'] == 'TELEFONE_PORTARIA') {
        $telefonePortaria = $item['CFG_DCVALOR']; 
        break; 
    }
}  

$MSG = "Olá, bom dia. Checagem de conexão com o Whatsapp concluída. *Operacional*";
$response = $siteAdmin->whatsappApiSendMessage($MSG, $telefonePortaria);

//--------------------LOG----------------------//
$LOG_DCTIPO = "NOTIFICAÇÃO";
$LOG_DCMSG = "Checagem do Status da API do Whatsapp concluída com sucesso.";
$LOG_DCUSUARIO = "SISTEMA";
$LOG_DCCODIGO = "N/A";
$LOG_DCAPARTAMENTO = "N/A";
$siteAdmin->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO, $LOG_DCCODIGO);
//--------------------LOG----------------------//

var_dump($response);

?>