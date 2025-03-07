<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // Permite requisições de qualquer origem

$api_key = "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";
$regimento = file_get_contents("regimento.txt"); // Carrega o regimento interno

function buscarTrechosRelevantes($pergunta, $regimento) {
    $linhas = explode("\n", $regimento);
    $palavras_chave = explode(" ", strtolower($pergunta)); // Divide a pergunta em palavras-chave
    $trechos_relevantes = [];

    foreach ($linhas as $linha) {
        foreach ($palavras_chave as $palavra) {
            if (stripos($linha, $palavra) !== false) {
                $trechos_relevantes[] = $linha;
                break; // Evita adicionar a mesma linha várias vezes
            }
        }
    }

    return implode("\n", array_unique($trechos_relevantes)); // Remove duplicatas e junta os trechos
}

function perguntarChatbot($pergunta) {
    global $api_key, $regimento;

    $url = "https://api.openai.com/v1/chat/completions";

    // Buscar apenas os trechos relevantes do regimento
    $trechos_relevantes = buscarTrechosRelevantes($pergunta, $regimento);

    if (empty($trechos_relevantes)) {
        $trechos_relevantes = "Nenhuma informação específica foi encontrada no regimento. Responda da melhor forma possível com base em regras comuns de condomínios.";
    }

    $data = [
        "model" => "gpt-4o-mini", 
        "messages" => [
            ["role" => "system", "content" => "Você é um assistente especializado no regimento interno do condomínio."],
            ["role" => "user", "content" => "Baseado no seguinte regimento:\n" . $trechos_relevantes],
            ["role" => "user", "content" => $pergunta]
        ],
        "temperature" => 0.5,
        "max_tokens" => 500
    ];

    $headers = [
        "Content-Type: application/json",
        "Authorization: Bearer " . $api_key
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200) {
        return "Erro na API OpenAI: " . $response;
    }

    $decoded_response = json_decode($response, true);

    return $decoded_response["choices"][0]["message"]["content"] ?? "Desculpe, não consegui responder.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pergunta = $_POST["pergunta"] ?? "";

    if (empty($pergunta)) {
        echo json_encode(["resposta" => "Por favor, faça uma pergunta válida."]);
        exit;
    }

    $resposta = perguntarChatbot($pergunta);
    echo json_encode(["resposta" => $resposta]);
}
?>
