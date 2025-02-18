<?php
require __DIR__ . '/twilio/src/Twilio/autoload.php'; // Ajuste o caminho, se necessário.
include_once "../../objects/objects.php";

$siteAdmin = new SITE_ADMIN();  
$siteAdmin->conexao();

use Twilio\Rest\Client;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $telefone = $data['telefone'] ?? null;
    $nome = $data['nome'] ?? null;
    $codigo = $data['codigo'] ?? null;
    $link = $data['link'] ?? null;
    $resposta = $data['resposta'] ?? null;

    $siteAdmin->getParameterInfo();

    $parametros = ['WHATSAPP_SENDER' => null, 'WHATSAPP_TOKEN' => null, 'WHATSAPP_SID' => null, 'WHATSAPP_STATUS' => null, 'NOME_CONDOMINIO' => null];

    foreach ($siteAdmin->ARRAY_PARAMETERINFO as $item) {
        if (array_key_exists($item['CFG_DCPARAMETRO'], $parametros)) {
            $parametros[$item['CFG_DCPARAMETRO']] = $item['CFG_DCVALOR']; 
        }
    } 
    
    // Suas credenciais do Twilio
    $twilioNumberFoneSender = $parametros['WHATSAPP_SENDER'];
    $twilioNumber = "whatsapp:+$twilioNumberFoneSender"; 
    $token = $parametros['WHATSAPP_TOKEN'];
    $sid = $parametros['WHATSAPP_SID'];
    $statusWhatsapp = $parametros['WHATSAPP_STATUS'];
    $condominioNome = $parametros['NOME_CONDOMINIO'];
    $to = "whatsapp:+55$telefone";
 
    if($statusWhatsapp != "ATIVO")
    {
        //--------------------LOG----------------------//
        $LOG_DCTIPO = "NOTIFICAÇÃO";
        $LOG_DCMSG = "Serviço de notificação por Whatsapp está desativado.";
        $LOG_DCUSUARIO = $nome;
        $LOG_DCCODIGO = "N/A";
        $LOG_DCAPARTAMENTO = "N/A";
        $siteAdmin->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO, $LOG_DCCODIGO);
        //--------------------LOG----------------------//

        exit();
    }

        $client = new Client($sid, $token);

        if($resposta == "disponivel")
        {
            $body = "Olá $nome, sua entrega com ID $codigo está disponível para retirada na portaria do $condominioNome. Ao chegar na portaria, acesse o link para liberar a sua retirada. $link";
            $template = "prq_hortensias_condominio_encomenda";
        }
        if($resposta == "liberar")
        {
            $body = "Olá *$nome*, a encomenda com ID *$codigo* foi *liberada* com sucesso.";
            $template = "prq_hortensias_condominio_encomenda_liberada";
        }
        if($resposta == "entregue")
        {
            $body = "Olá *$nome*, a encomenda com ID *$codigo* foi *entregue* com sucesso.";
            $template = "prq_hortensias_condominio_encomenda_entregue";
        }
 

        // Usando o template aprovado
        $message = $client->messages->create(
            $to, // Número de destino com WhatsApp
            [
                'from' => $twilioNumber, // Número Twilio
                'body' => $body,
                'template' => [
                    'name' => $template, // Nome do template aprovado
                    'parameters' => [
                        ['type' => 'text', 'text' => $nome],          // usuario_nome = Carlos
                        ['type' => 'text', 'text' => $codigo],         // id_entrega = 123456
                        ['type' => 'text', 'text' => $condominioNome], // condominio_nome = Residencial Alpha
                        ['type' => 'text', 'text' => $link] // link_liberar_entrega
                    ]
                ]
            ]
        );
        $resultWhatsTwilioSender =  $message->sid;
        //--------------------LOG----------------------//
        $LOG_DCTIPO = "NOTIFICAÇÃO";
        $LOG_DCMSG = "Notificação por Whatsapp enviada com sucesso para o número $to. texto: asdasd";
        $LOG_DCUSUARIO = strtoupper($nome);
        $LOG_DCCODIGO = $codigo;
        $LOG_DCAPARTAMENTO = "N/A";
        $siteAdmin->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO, $LOG_DCCODIGO);
        //--------------------LOG----------------------//

        echo json_encode(['success' => 'Notificação enviada ao Whatsapp do morador.']);

}
?>