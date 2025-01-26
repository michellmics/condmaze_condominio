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

    // Suas credenciais do Twilio
    $sid = $siteAdmin->WHATSAPP_SID; // Substitua pelo seu Account SID
    $token = $siteAdmin->WHATSAPP_TOKEN; // Substitua pelo seu Auth Token
    $twilioNumber = 'whatsapp:+14155238886'; // Número do Twilio Sandbox

    // Número de destino e mensagem
    $to = "whatsapp:+55$telefone"; // Substitua pelo número de destino (inclua o código do país)

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

        echo json_encode(['success' => 'Notificação enviada ao Whatsapp do morador.']);
    } catch (Exception $e) {
        echo json_encode(['error' => 'Notificação por Whatsapp apresentou um erro.']);
    }
}
?>