<?php
    header('Content-Type: application/json');

	include_once '../../objects/objects_chart.php'; 
    $chartValor = new SITE_CHARTS(); 

    $result = $chartValor->getFundoReservaFull();
    //var_dump($chartValor->ARRAY_FUNDORESERVA);
    echo json_encode($result);    
 
    
?>