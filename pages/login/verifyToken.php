<?php
// Configuração para exibir erros (remova em produção)
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

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

    if (!empty($token)) {
        // Supondo que o token está armazenado com informações de validade
        $tokenData = $token;

        // Divide o token em partes (dados e assinatura)
        $partes = explode('.', base64_decode($tokenData));
        if (count($partes) !== 2) {
            echo json_encode(['valid' => false, 'message' => 'Token inválido.']);
            exit;
        }
        
        $dadosCodificados = $partes[0];
        $assinatura = $partes[1];

        $dados = json_decode($dadosCodificados, true);

        if ($dados === null || !isset($dados['exp'])) {
            echo json_encode(['valid' => false, 'message' => 'Token inválido ou corrompido.']);
            exit;
        }

        // Verifica se o token expirou
        if (time() > $dados['exp']) {
            echo json_encode(['valid' => false, 'message' => 'Token expirado.'.$tokenData]);
            exit;
        }

        $chaveSecreta = "mcodemaze!4795condominio$#@!!@#$";

        // Verifica a assinatura do token
        $assinaturaCalculada = hash_hmac('sha256', $dadosCodificados, $chaveSecreta);
        if (!hash_equals($assinatura, $assinaturaCalculada)) {
            echo json_encode(['valid' => false, 'message' => 'Token inválido.']);
            exit;
        }
        else
        {
                        // Define as variáveis de sessão
                        $_SESSION['user_id'] = $dados['user_id'];
                        $_SESSION['user_bloco'] = $dados['user_bloco'] ?? null;
                        $_SESSION['user_apartamento'] = $dados['user_apartamento'] ?? null;
                        $_SESSION['user_name'] = $dados['user_name'] ?? null;
                        $_SESSION['user_nivelacesso'] = $dados['user_nivelacesso'] ?? null;
                        
            echo json_encode(['valid' => true, 'message' => 'Token válido.', 'user_id' => $dados['user_id']]);
        }
    }
    else {
        echo json_encode(['valid' => false, 'message' => 'Token não encontrado.']);
    }
} else {
    echo json_encode(['valid' => false, 'message' => 'Método não permitido.']);
}
