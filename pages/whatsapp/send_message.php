<?php
require __DIR__ . '/twilio/src/Twilio/autoload.php'; // Ajuste o caminho, se necessário.
include_once "../../objects/objects.php";

$siteAdmin = new SITE_ADMIN();  
$siteAdmin->conexao();

use Twilio\Rest\Client;

var_dump($siteAdmin->WHATSAPP_TOKEN);
die();

// Suas credenciais do Twilio
$sid = $siteAdmin->WHATSAPP_SID; // Substitua pelo seu Account SID
$token = $siteAdmin->WHATSAPP_TOKEN; // Substitua pelo seu Auth Token
$twilioNumber = 'whatsapp:+14155238886'; // Número do Twilio Sandbox

// Número de destino e mensagem
$to = 'whatsapp:+5511982734350'; // Substitua pelo número de destino (inclua o código do país)
$message = 'Olá! Esta é uma mensagem de teste enviada pelo Twilio.';

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

    echo "Mensagem enviada com sucesso! SID: " . $message->sid;
} catch (Exception $e) {
    echo "Erro ao enviar mensagem: " . $e->getMessage();
}
?>