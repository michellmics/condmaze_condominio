<?php
require __DIR__ . '/twilio/src/Twilio/autoload.php'; // Ajuste o caminho, se necessário.

use Twilio\Rest\Client;

// Suas credenciais do Twilio


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
