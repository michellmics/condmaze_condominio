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
        if($campo == "whatsportaria"){$campo = "TELEFONE_PORTARIA";}
        if($campo == "whatsEndpoint"){$campo = "WHATSAPP_ENDPOINT";} 
        if($campo == "whatsInstancia"){$campo = "WHATSAPP_INSTANCIA";}
        if($campo == "whatsToken"){$campo = "WHATSAPP_TOKEN";}
        if($campo == "ipPortaria"){$campo = "IP_PORTARIA";}
        if($campo == "whatsSindico"){$campo = "TELEFONE_SINDICO";}
        if($campo == "idioma"){$campo = "IDIOMA_APP";}
        if($campo == "EMAIL_SMTP_SENHA"){$campo = "MAIL_SMTP_PASS";}
        if($campo == "EMAIL_SMTP_USUARIO"){$campo = "MAIL_SMTP_USER";}
        if($campo == "EMAIL_SMTP_PORTA"){$campo = "MAIL_SMTP_PORT";}
        if($campo == "EMAIL_SMTP_HOST"){$campo = "MAIL_SMTP_HOST";}
        if($campo == "dominio"){$campo = "DOMINIO";}

        $result = $siteAdmin->updateConfigInfo($campo, $valor);   
        
        //--------------------LOG----------------------//
        $LOG_DCTIPO = "CONFIGURAÇÃO";
        $LOG_DCMSG = "A configuração de $campo foi atualizada.";
        $LOG_DCUSUARIO = "SINDICO";
        $LOG_DCCODIGO = "N/A";
        $LOG_DCAPARTAMENTO = "";
        $siteAdmin->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO, $LOG_DCCODIGO);
        //--------------------LOG----------------------//

        echo json_encode(["status" => "success", "message" => $result]);
    } else {

        //--------------------LOG----------------------//
        $LOG_DCTIPO = "CONFIGURAÇÃO";
        $LOG_DCMSG = "Houve uma tentativa de atualização do campo $campo, mas falhou!";
        $LOG_DCUSUARIO = "SINDICO";
        $LOG_DCCODIGO = "N/A";
        $LOG_DCAPARTAMENTO = "";
        $siteAdmin->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO, $LOG_DCCODIGO);
        //--------------------LOG----------------------//

        echo json_encode(["status" => "error", "message" => $result]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método inválido."]);
}
?>
