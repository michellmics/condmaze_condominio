<?php
    ini_set('display_errors', 1);  // Habilita a exibição de erros
    error_reporting(E_ALL);        // Reporta todos os erros
    header('Content-Type: application/json');

	include_once '../../objects/objects_chart.php'; 
    $chartValor = new SITE_CHARTS(); 

    $chartValor->getPendenciaByMesFull();
    echo json_encode($chartValor->ARRAY_PENDENCIAMESFULLINFO);

    

    
?>