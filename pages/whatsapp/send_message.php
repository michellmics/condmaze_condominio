<?php
require __DIR__ . '/twilio/src/Twilio/autoload.php'; // Ajuste o caminho, se necessário.
include_once "../../objects/objects.php";

$siteAdmin = new SITE_ADMIN();  
$siteAdmin->conexao();

use Twilio\Rest\Client;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $telefone = $data['telefone'] ?? null;
    $message = $data['message'] ?? null;

    $siteAdmin->getParameterInfo();

    $parametros = ['WHATSAPP_TOKEN' => null, 'WHATSAPP_SID' => null, 'WHATSAPP_STATUS' => null];

    foreach ($siteAdmin->ARRAY_PARAMETERINFO as $item) {
        if (array_key_exists($item['CFG_DCPARAMETRO'], $parametros)) {
            $parametros[$item['CFG_DCPARAMETRO']] = $item['CFG_DCVALOR'];
        }
    }
    
    // Suas credenciais do Twilio
    $twilioNumber = 'whatsapp:+14155238886'; // Número do Twilio Sandbox
    $token = $parametros['WHATSAPP_TOKEN'];
    $sid = $parametros['WHATSAPP_SID'];
    $statusWhatsapp = $parametros['WHATSAPP_STATUS'];
    $to = "whatsapp:+55$telefone";

    if($statusWhatsapp != "ATIVO")
    {
        //--------------------LOG----------------------//
        $LOG_DCTIPO = "NOTIFICAÇÃO";
        $LOG_DCMSG = "Serviço de notificação por Whatsapp está desativado.";
        $LOG_DCUSUARIO = "SISTEMA";
        $LOG_DCCODIGO = "N/A";
        $LOG_DCAPARTAMENTO = "";
        $siteAdmin->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO, $LOG_DCCODIGO);
        //--------------------LOG----------------------//

        exit();
    }

    // Enviar mensagem via Twilio
    try {
        $client = new Client($sid, $token);

        $message = $client->messages->create(
            $to,
            [
                'from' => $twilioNumber,
                'body' => $message,
            ]
        );

        //--------------------LOG----------------------//
        $LOG_DCTIPO = "NOTIFICAÇÃO";
        $LOG_DCMSG = "Notificação por Whatsapp enviado com sucesso para o número $to.";
        $LOG_DCUSUARIO = "SISTEMA";
        $LOG_DCCODIGO = "N/A";
        $LOG_DCAPARTAMENTO = "";
        $siteAdmin->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO, $LOG_DCCODIGO);
        //--------------------LOG----------------------//

        echo json_encode(['success' => 'Notificação enviada ao Whatsapp do morador.']);
    } catch (Exception $e) {

        //--------------------LOG----------------------//
        $LOG_DCTIPO = "NOTIFICAÇÃO";
        $LOG_DCMSG = "Serviço de notificação por Whatsapp apresentou um erro.";
        $LOG_DCUSUARIO = "SISTEMA";
        $LOG_DCCODIGO = "N/A";
        $LOG_DCAPARTAMENTO = "";
        $siteAdmin->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO, $LOG_DCCODIGO);
        //--------------------LOG----------------------//

        echo json_encode(['error' => 'Notificação por Whatsapp apresentou um erro.']);
    }
}
?>