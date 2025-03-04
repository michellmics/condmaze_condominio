<?php
include_once "../../objects/objects.php";

$siteAdmin = new SITE_ADMIN();
$siteAdmin->deleteOldLogs();
 
//--------------------LOG----------------------//
$LOG_DCTIPO = "NOTIFICAÇÃO";
$LOG_DCMSG = "Script de manutenção executado com sucesso.";
$LOG_DCUSUARIO = "SISTEMA";
$LOG_DCCODIGO = "N/A";
$LOG_DCAPARTAMENTO = "N/A";
$siteAdmin->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO, $LOG_DCCODIGO);
//--------------------LOG----------------------//

?>