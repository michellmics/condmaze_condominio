<?php
// Caminho do arquivo JSON com os dados das vagas
$jsonFile = 'vagas/slots.json';

// Verifica se a solicitação é do tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados enviados no corpo da solicitação
    $input = json_decode(file_get_contents('php://input'), true);

    // Verifica se o ID da vaga foi fornecido
    if (isset($input['id'])) {
        $slotId = $input['id'];

        // Carrega o conteúdo do arquivo JSON
        if (file_exists($jsonFile)) {
            $slots = json_decode(file_get_contents($jsonFile), true);

            // Verifica se o ID da vaga existe no arquivo
            if (isset($slots[$slotId])) {
                // Atualiza o status da vaga para "livre"
                $slots[$slotId] = [
                    'status' => 'free',
                    'plate' => '',
                    'vehicle_model' => '',
                    'apartment' => '',
                    'entry_time' => ''
                ];

                // Salva as alterações no arquivo JSON
                if (file_put_contents($jsonFile, json_encode($slots, JSON_PRETTY_PRINT))) {
                    // Retorna uma resposta de sucesso
                    http_response_code(200);
                    echo json_encode(['message' => 'Vaga liberada com sucesso.']);
                    exit;
                } else {
                    // Erro ao salvar o arquivo
                    http_response_code(500);
                    echo json_encode(['message' => 'Erro ao salvar as alterações no arquivo.']);
                    exit;
                }
            } else {
                // ID da vaga não encontrado
                http_response_code(404);
                echo json_encode(['message' => 'Vaga não encontrada.']);
                exit;
            }
        } else {
            // Arquivo JSON não encontrado
            http_response_code(500);
            echo json_encode(['message' => 'Arquivo de vagas não encontrado.']);
            exit;
        }
    } else {
        // Dados inválidos na solicitação
        http_response_code(400);
        echo json_encode(['message' => 'ID da vaga não fornecido.']);
        exit;
    }
} else {
    // Método HTTP inválido
    http_response_code(405);
    echo json_encode(['message' => 'Método não permitido.']);
    exit;
}
?>
