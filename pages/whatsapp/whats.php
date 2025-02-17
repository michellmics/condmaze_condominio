<?php

require __DIR__ . '/twilio/src/Twilio/autoload.php';

use Twilio\Rest\Client;

$sid = 'US27bf524c9b23155b1dd29788b65d0d08'; // Coloque manualmente o SID da conta Twilio
$token = '67c680df0b9006f769848d7799323326'; // Coloque manualmente o Auth Token
$client = new Client($sid, $token);

try {
    $client->api->v2010->accounts($sid)->fetch();
    echo "Autenticação bem-sucedida!";
} catch (Exception $e) {
    echo "Erro de autenticação: " . $e->getMessage();
}


die();
/*

require __DIR__ . '/twilio/src/Twilio/autoload.php'; // Ajuste o caminho, se necessário.
include_once "../../objects/objects.php";

$siteAdmin = new SITE_ADMIN();  
$siteAdmin->conexao();
$siteAdmin->getParameterInfo();
use Twilio\Rest\Client;

$parametros = ['WHATSAPP_TOKEN' => null, 'WHATSAPP_SID' => null, 'WHATSAPP_STATUS' => null];

foreach ($siteAdmin->ARRAY_PARAMETERINFO as $item) {
    if (array_key_exists($item['CFG_DCPARAMETRO'], $parametros)) {
        $parametros[$item['CFG_DCPARAMETRO']] = $item['CFG_DCVALOR'];
    }
}

// Suas credenciais do Twilio
$twilioNumber = 'whatsapp:+15557337654'; // Número do Twilio Sandbox
$token = $parametros['WHATSAPP_TOKEN'];
$sid = $parametros['WHATSAPP_SID'];
$statusWhatsapp = $parametros['WHATSAPP_STATUS'];
$to = "whatsapp:+5511982734350";


$client = new Client($sid, $token);

// Usando o template aprovado
$message = $client->messages->create(
    $to, // Número de destino com WhatsApp
    [
        'from' => $twilioNumber, // Número Twilio
        'body' => 'Mensagem personaliada se não for usar template',
        'template' => [
            'name' => 'prq_hortensias_condominio_encomenda', // Nome do template aprovado
            'parameters' => [
                ['type' => 'text', 'text' => "Michell Duarte"],          // usuario_nome = Carlos
                ['type' => 'text', 'text' => "123456"],         // id_entrega = 123456
                ['type' => 'text', 'text' => 'Condomínio Parque das Hortênsias'], // condominio_nome = Residencial Alpha
                ['type' => 'text', 'text' => "https://codemaze.com.br"] // link_liberar_entrega
            ]
        ]
    ]
);
$resultWhatsTwilioSender =  $message->sid;
var_dump($resultWhatsTwilioSender);
*/
?>