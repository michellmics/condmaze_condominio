<?php
    header('Content-Type: application/json');

	include_once '../../objects/objects_chart.php'; 
    $chartValor = new SITE_CHARTS(); 

    $chartValor->getFundoReservaFull();
    echo json_encode($chartValor->ARRAY_FUNDORESERVA);    

    
?>