<?php
// Configurar a API Key da OpenAI
$api_key = "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";

// Carregar o regimento interno do condomínio
$regimento = file_get_contents("regimento.txt");

// Função para fazer a requisição à OpenAI
function perguntarChatbot($pergunta) {
    global $api_key, $regimento;

    $url = "https://api.openai.com/v1/chat/completions";

    $data = [
        "model" => "gpt-4", // Ou "gpt-3.5-turbo" para reduzir custos
        "messages" => [
            ["role" => "system", "content" => "Você é um assistente especializado no regimento interno do condomínio."],
            ["role" => "user", "content" => "O regimento interno do condomínio é:\n" . $regimento],
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
    curl_close($ch);

    $decoded_response = json_decode($response, true);
    return $decoded_response["choices"][0]["message"]["content"] ?? "Desculpe, não consegui responder.";
}

// Teste do chatbot
$pergunta = "Quais são as regras para uso da piscina?";
$resposta = perguntarChatbot($pergunta);
echo "Pergunta: $pergunta\n";
echo "Resposta: $resposta\n";
?>
