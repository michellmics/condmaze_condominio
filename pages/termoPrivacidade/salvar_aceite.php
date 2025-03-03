<?php
require "../../src/sessionStartShield.php";
include_once "../../objects/objects.php";	

$siteAdmin = new SITE_ADMIN();  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userid = $_POST['userid'];
    $nomeSession = $_POST['nomeSession'];
    $apartamentoSessio = $_POST['apartamentoSessio'];

    $result = $siteAdmin->updateTerPrivacidade($userid, $nomeSession, $apartamentoSessio);
    echo json_encode($result);
    exit;
}
?>