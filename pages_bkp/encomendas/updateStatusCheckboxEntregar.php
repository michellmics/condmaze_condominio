<?php
include_once "../../objects/objects.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;
    $status = $data['status'] ?? null;
    $nome = $data['nome'] ?? null;
    $telefone = $data['telefone'] ?? null;

    if ($id && $status) {
        $siteAdmin = new SITE_ADMIN();
        $result = $siteAdmin->updateCheckboxEncomendasPortaria($id, $status);

        if($status == "ENTREGUE")
        {
            //$result = $siteAdmin->whatsapp($nome, $telefone, $id, "entregue", "");
        }

        echo json_encode(['success' => true, 'message' => 'Status atualizado.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
    }
}
?>