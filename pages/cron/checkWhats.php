<?php
include_once "../../objects/objects.php";

$siteAdmin = new SITE_ADMIN();
$siteAdmin->getParameterInfo();

foreach ($siteAdmin->ARRAY_PARAMETERINFO as $item) {
    if ($item['CFG_DCPARAMETRO'] == 'TELEFONE_PORTARIA') {
        $telefonePortaria = $item['CFG_DCVALOR']; 
    }
    if ($item['CFG_DCPARAMETRO'] == 'EMAIL_ALERTAS') {
        $emailAlerta = $item['CFG_DCVALOR']; 
    }
}  
$status = 0;

$MSG = "Olá, bom dia. Checagem de conexão com o Whatsapp concluída. *Operacional*";
$response = $siteAdmin->whatsappApiSendMessage($MSG, $telefonePortaria);

$response = json_decode($response, true);

if (isset($response['status'])) {
    $status = $response['status']; // Captura apenas o status
}

if($status == "500")
{    
    //--------------------LOG----------------------//
    $LOG_DCTIPO = "NOTIFICAÇÃO";
    $LOG_DCMSG = "Checagem do Status da API do Whatsapp concluída com erro. Verifique a conexão com a API.";
    $LOG_DCUSUARIO = "SISTEMA";
    $LOG_DCCODIGO = "N/A";
    $LOG_DCAPARTAMENTO = "N/A";
    $siteAdmin->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO, $LOG_DCCODIGO);
    //--------------------LOG----------------------//

    $siteAdmin->insertNotificacaoFrontByUsuario("API Whatsapp", "Notificação está Offline", "1000");
    $SUBJECT = "ATENÇÃO - NOTIFICAÇÃO POR WHATSAPP ESTÁ OFFINE";
    $siteAdmin->notifyUsuarioEmail($SUBJECT, $LOG_DCMSG, $emailAlerta, $anexo="na");

}
else
    {
        //--------------------LOG----------------------//
        $LOG_DCTIPO = "NOTIFICAÇÃO";
        $LOG_DCMSG = "Checagem do Status da API do Whatsapp concluída com sucesso.";
        $LOG_DCUSUARIO = "SISTEMA";
        $LOG_DCCODIGO = "N/A";
        $LOG_DCAPARTAMENTO = "N/A";
        $siteAdmin->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO, $LOG_DCCODIGO);
        //--------------------LOG----------------------//
    }

var_dump($response);
?>