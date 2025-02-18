<?php
include_once "../../objects/objects.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;
    $status = $data['status'] ?? null;
    $nome = $data['nome'] ?? null;
    $telefone = $data['telefone'] ?? null;
    $hash = $data['hash'] ?? null;

    $nome = ucwords(strtolower($nome));

    if ($id && $status) {
        $siteAdmin = new SITE_ADMIN();
        $result = $siteAdmin->updateCheckboxEncomendasDisponivelMorador($id, $status);
        if($status == "DISPONIVEL")
        {
            $link = "https://parquedashortensias.codemaze.com.br/api_encomenda.php?hash=$hash";
            $msg = "Olá *$nome*, sua entrega com ID *$id* está disponível para retirada na portaria do *Condomínio Parque das Hortênsias.*
                    \nAo chegar na portaria, acesse o link abaixo para liberar a retirada.\n\n$link";
            $result = $siteAdmin->whatsapp($nome, $link, $telefone, $id, "disponivel");
        }
        echo json_encode(['success' => $result]);

    } else {
        echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
    }
}
?>