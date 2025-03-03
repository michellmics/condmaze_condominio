<?php
// Recebe o JSON da Evolution API
$json = file_get_contents("php://input");
$data = json_decode($json, true);

// Verifica se é um evento de desconexão
//if (isset($data['event']) && $data['event'] === 'instance_disconnected') {
    $instanceId = $data['instance_id'];

    $siteAdmin = new SITE_ADMIN();
    
    //--------------------LOG----------------------//
    $LOG_DCTIPO = "UPDATE";
    $LOG_DCMSG = "Webhook acionado pela API do Whatsapp. Altendo o status para DISCONNCETD.";
    $LOG_DCUSUARIO = "SISTEMA";
    $LOG_DCCODIGO = "N/A";
    $LOG_DCAPARTAMENTO = "";
    $siteAdmin->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO, $LOG_DCCODIGO);
    //--------------------LOG----------------------//

    $siteAdmin->updateWhatsappAPIStatus("DISCONNECTED");
//}

http_response_code(200); 
?>