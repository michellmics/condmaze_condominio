<?php
include_once "../../objects/objects.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;
    $status = $data['status'] ?? null;

    if ($id && $status) {
        $siteAdmin = new SITE_ADMIN();
        $result = $siteAdmin->updateCheckboxEncomendasMorador($id, $status);

        echo json_encode(['success' => $result]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
    }
}
?>