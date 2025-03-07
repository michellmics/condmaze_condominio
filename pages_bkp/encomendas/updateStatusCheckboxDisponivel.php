<?php
include_once "../../objects/objects.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'] ?? null;
    $status = $data['status'] ?? null;
    $nome = $data['nome'] ?? null;
    $telefone = $data['telefone'] ?? null;
    $hash = $data['hash'] ?? null;
    $EMAIL = $data['email'] ?? null;

    $nome = ucwords(strtolower($nome));

    $siteAdmin = new SITE_ADMIN();
    $siteAdmin->getParameterInfo();
    
    foreach ($siteAdmin->ARRAY_PARAMETERINFO as $item) {
        if ($item['CFG_DCPARAMETRO'] == 'NOME_CONDOMINIO') {
            $nomeCondominio = $item['CFG_DCVALOR']; 
            break; 
        }
    }  


    if ($id && $status) {        
        $result = $siteAdmin->updateCheckboxEncomendasDisponivelMorador($id, $status);
        if($status == "DISPONIVEL")
        {
            $ASSUNTO = "NOVA ENCOMENDA: Uhuuul Chegou uma encomenda para Você. - $nomeCondominio";
            $MSG = "Olá $nome,
            A portaria do $nomeCondominio acaba de liberar para retirada uma encomenda que chegou para você!<br>
            Para retirar, acesse o portal <strong>https://prqdashortênsias.com.br.</strong><br>
            Na seção <strong>Encomendas Disponíveis Para Retirada</strong> Marque a opção <strong>RETIRAR</strong> como <strong>SIM</strong> e dirija-se a portaria.<br><br>
            
            Atenciosamente,<br>
            $nomeCondominio <br>
            Rua dos Estudantes, 505 - Hortolândia/SP CEP 13186-170<br>
            <a href='prqdashortensias.com.br'>prqdashortensias.com.br</a>";

            $siteAdmin->notifyUsuarioEmail($ASSUNTO, $MSG, $EMAIL);
        }
        echo json_encode(['success' => $result]);

    } else {
        echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
    }
}
?>