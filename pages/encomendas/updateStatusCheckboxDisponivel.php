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


include_once "../../objects/objects.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;
    $status = $data['status'] ?? null;
    $nome = $data['nome'] ?? null;
    $telefone = $data['telefone'] ?? null;
    $hash = $data['hash'] ?? null;
    $EMAIL = $data['email'] ?? null; 
    $idUser = $data['idUser'] ?? null;

    $nome = ucwords(strtolower($nome));

    $siteAdmin = new SITE_ADMIN();
    $siteAdmin->getParameterInfo();
    

    foreach ($siteAdmin->ARRAY_PARAMETERINFO as $item) {
        if ($item['CFG_DCPARAMETRO'] == 'NOME_CONDOMINIO') {
            $nomeCondominio = $item['CFG_DCVALOR']; 
        } elseif ($item['CFG_DCPARAMETRO'] == 'DOMINIO') {
            $dominio = $item['CFG_DCVALOR']; 
        }
    }


    if ($id && $status) {        
        $result = $siteAdmin->updateCheckboxEncomendasDisponivelMorador($id, $status);
        if($status == "DISPONIVEL")
        {
            $ASSUNTO = "NOVA ENCOMENDA: Uhuuul Chegou uma encomenda para Você. - $nomeCondominio";
            $MSG = "Olá *$nome*,\n\n"
        . "A portaria do *$nomeCondominio* acaba de *DISPONIBILIZAR* para retirada uma encomenda que chegou para você!\n\n"
        . "📦 *Código da Encomenda:* `$id`\n\n"
        . "Para retirar, dirija-se à portaria e clique no link abaixo para liberar a encomenda:\n\n"
        . "https://$dominio/pages/api/api_encomenda.php?hash=$hash";
            
           
            $returnWhats = $siteAdmin->whatsappApiSendMessage($MSG, $telefone);

            //nivel: TODOS, MORADOR, SINDICO OU PORTARIA
            //$siteAdmin->insertNotificacaoFrontByUsuario("Encomenda Chegou!", "Encomenda dísponivel na portaria", $idUser);
        }
        echo json_encode(['success' => "Notificação enviada"]);

    } else {
        echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
    }
}
?>