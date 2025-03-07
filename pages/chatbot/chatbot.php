<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); // Permite requisições de qualquer origem

$api_key = "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";
$regimento = file_get_contents("regimento.txt");

function perguntarChatbot($pergunta) {
    global $api_key, $regimento;

    $url = "https://api.openai.com/v1/chat/completions";

    $data = [
        "model" => "gpt-4o-mini", 
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