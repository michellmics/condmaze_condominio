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

    header('Content-Type: application/json');

	include_once '../../objects/objects_chart.php'; 
    $chartValor = new SITE_CHARTS(); 

    $chartValor->getPendenciaByMesFull();
    echo json_encode($chartValor->ARRAY_PENDENCIAMESFULLINFO);

    

    
?>