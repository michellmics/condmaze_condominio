<?php
    ini_set('display_errors', 1);  
    error_reporting(E_ALL);        
	include_once "objects/objects.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $siteAdmin = new SITE_ADMIN();

    if(!isset($_GET['hash'])){echo "error"; die();}

    $HASH = $_GET['hash'];

    

    $response = $siteAdmin->updateCheckboxEncomendasMoradorByApi($HASH);

    if($response == "1")
    {
        echo "Uhull!!! Encomenda liberada com sucesso!";
    }
    else
        {
            echo "ah não!!! Houve um erro durante a liberação! Dirija-se a portaria.";
        }
}
?>
