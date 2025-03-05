<?php
require "../../src/sessionStartShield.php";
include_once "../../objects/objects.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $_POST['id'];
    $status = $_POST['status'];

    $siteAdmin = new SITE_ADMIN(); 
     
    $result = $siteAdmin->updateCheckboxPublicidadeParceiro($id, $status);
    echo 'success';
}
?>