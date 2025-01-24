<?php
// Configuração para exibir erros (remova em produção)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Inclua aqui o arquivo de configuração ou conexão com o banco de dados, se necessário
include_once "../../objects/objects.php";

header('Content-Type: application/json');

// Verifica se o token foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados enviados no corpo da requisição
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['token']) || empty($input['token'])) {
        echo json_encode(['success' => false, 'message' => 'Token não fornecido.']);
        exit;
    }

    $token = $input['token'];

    // Exemplo de verificação de token (substitua conforme sua lógica)
    // Aqui, supomos que o token é salvo no banco de dados com informações do usuário
    $siteAdmin = new SITE_ADMIN();
    $siteAdmin->getTokenInfo('eyJ1c2VyX2lkIjozNTIsImV4cCI6MTc0MDMyOTcxNn0uNTA3YjE4OTI2ZTA4MzU0MWM3NGJmOGU5ZDM0MmFmZWE3YTJiNzdkZDgwNmE4ZjlmZjk1NTQ5Y2YwZmMyMzEzNQ=='); // Método fictício para buscar informações do token

    if (!empty($siteAdmin->ARRAY_TOKENINFO)) {
        // Supondo que o token está armazenado com informações de validade
        $tokenData = $siteAdmin->ARRAY_TOKENINFO;

        // Divide o token em partes (dados e assinatura)
        $partes = explode('.', base64_decode($tokenData));
        if (count($partes) !== 2) {
            echo json_encode(['valid' => false, 'message' => 'Token inválido.']);
            exit;
        }
        
        $dadosCodificados = $partes[0];

        $dados = json_decode($dadosCodificados, true);

        if ($dados === null || !isset($dados['exp'])) {
            echo json_encode(['valid' => false, 'message' => 'Token inválido ou corrompido.']);
            exit;
        }

        // Verifica se o token expirou
        if (time() > $dados['exp']) {
            echo json_encode(['valid' => false, 'message' => 'Token expirado.']);
            exit;
        } else {
            echo json_encode(['valid' => true, 'message' => 'Token válido.', 'user' => $tokenData['user']]);
        }
    }
    else {
        echo json_encode(['valid' => false, 'message' => 'Token não encontrado.']);
    }
} else {
    echo json_encode(['valid' => false, 'message' => 'Método não permitido.']);
}
