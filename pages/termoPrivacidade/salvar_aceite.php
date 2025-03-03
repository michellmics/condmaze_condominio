<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function forbiddenResponse() {
    http_response_code(403);
    die('Acesso não autorizado.');
}
if (!isset($_SESSION['csrf_token'])) {
    forbiddenResponse();
}


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