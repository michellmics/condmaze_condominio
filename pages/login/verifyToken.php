<?php
session_start();

// Inclua aqui o arquivo de configuração ou conexão com o banco de dados, se necessário
include_once "../../objects/objects.php";

header('Content-Type: application/json');

$siteAdmin = new SITE_ADMIN();

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
            $userIdMorador = $dados['user_id'];

            if (!$siteAdmin->pdo) {
                $siteAdmin->conexao();
            }

            // Prepara a consulta SQL para verificar o usuário
            $sql = "SELECT USU_IDUSUARIO, USU_DCSENHA, USU_DCEMAIL, USU_DCNOME, USU_DCNIVEL, USU_DCBLOCO, USU_DCAPARTAMENTO 
            FROM USU_USUARIO WHERE USU_IDUSUARIO = :USU_IDUSUARIO";
            $stmt = $siteAdmin->pdo->prepare($sql);
            $stmt->bindParam(':USU_IDUSUARIO', $userIdMorador, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Define as variáveis de sessão
            $_SESSION['user_id'] = $user['USU_IDUSUARIO'];
            $_SESSION['user_name'] = $user['USU_DCNOME'];
            $_SESSION['user_email'] = $user['USU_DCEMAIL'];
            $_SESSION['user_apartamento'] = $user['USU_DCAPARTAMENTO'];
            $_SESSION['user_bloco'] = $user['USU_DCBLOCO'];
            $_SESSION['user_nivelacesso'] = $user['USU_DCNIVEL'];
            $_SESSION['last_activity'] = time();
                        
            echo json_encode(['valid' => true, 'message' => 'Token válido.', 'user_id' => $dados['user_id']]);
        }
    }
    else {
        echo json_encode(['valid' => false, 'message' => 'Token não encontrado.']);
    }
} else {
    echo json_encode(['valid' => false, 'message' => 'Método não permitido.']);
}
