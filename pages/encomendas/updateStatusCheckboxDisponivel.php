<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once "../../objects/objects.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;
    $status = $data['status'] ?? null;

    if ($id && $status) {
        $siteAdmin = new SITE_ADMIN();
        $result = $siteAdmin->updateCheckboxEncomendasDisponivelMorador($id, $status);
        if($status == "DISPONIVEL")
        {
            $msg = "Olá, sua entrega está disponível para retirada na portaria do Condomínio Parque das Hortênsias.";
            $telefone = "11982734350";
            $result = $siteAdmin->whatsapp($msg,$telefone);
        }
        echo json_encode(['success' => $result]);

    } else {
        echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
    }
}
?>