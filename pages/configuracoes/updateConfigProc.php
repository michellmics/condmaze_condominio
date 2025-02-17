<?php
header("Content-Type: application/json");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once "../../objects/objects.php";

$siteAdmin = new SITE_ADMIN();  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $campo = $_POST["campo"] ?? "";
    $valor = $_POST["valor"] ?? "";

    if (!empty($campo) && !empty($valor)) {

        if($campo == "nomeCondominio"){$campo = "NOME_CONDOMINIO";}
        if($campo == "qtdeUnidades"){$campo = "QTDE_APARTAMENTOS";}
        if($campo == "email"){$campo = "EMAIL_ALERTAS";}
        if($campo == "whatsStatus"){$campo = "WHATSAPP_STATUS";}
        if($campo == "whatsSender"){$campo = "WHATSAPP_SENDER";}
        if($campo == "whatsSid"){$campo = "WHATSAPP_SID";}
        if($campo == "whatsToken"){$campo = "WHATSAPP_TOKEN";}
        if($campo == "ipPortaria"){$campo = "IP_PORTARIA";}

        $result = $siteAdmin->updateConfigInfo($campo, $valor);   
        
        //--------------------LOG----------------------//
        $LOG_DCTIPO = "CONFIGURAÇÃO";
        $LOG_DCMSG = "A configuração de $campo foi atualizada.";
        $LOG_DCUSUARIO = "SINDICO";
        $LOG_DCCODIGO = "N/A";
        $LOG_DCAPARTAMENTO = "";
        $siteAdmin->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO, $LOG_DCCODIGO);
        //--------------------LOG----------------------//

        echo json_encode(["status" => "success", "message" => "$result"]);
    } else {

        //--------------------LOG----------------------//
        $LOG_DCTIPO = "CONFIGURAÇÃO";
        $LOG_DCMSG = "Houve uma tentativa de atualização do campo $campo, mas falhou!";
        $LOG_DCUSUARIO = "SINDICO";
        $LOG_DCCODIGO = "N/A";
        $LOG_DCAPARTAMENTO = "";
        $siteAdmin->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO, $LOG_DCCODIGO);
        //--------------------LOG----------------------//

        echo json_encode(["status" => "error", "message" => "Faiou"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método inválido."]);
}
?>
