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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'ID da vaga é obrigatório.']);
        exit;
    }

    $id = $data['id'];
    $plate = strtoupper(substr($data['plate'], 0, 7));
    $apartment = preg_replace('/\\D/', '', $data['apartment']);
    $vehicle_model = strtoupper($data['vehicle_model']);
    $entry_time = $data['entry_time'];

    $slots = json_decode(file_get_contents('vagas/slots.json'), true);

    if (isset($slots[$id])) {
        if (empty($plate)) {
            // Liberar a vaga
            $slots[$id] = [
                'status' => 'free',
                'plate' => '',
                'apartment' => '',
                'vehicle_model' => '',
                'entry_time' => '',
                'alarm' => ''
            ];
        } else {
            // Atualizar vaga ocupada
            $slots[$id] = [
                'status' => 'occupied',
                'plate' => $plate,
                'apartment' => $apartment,
                'vehicle_model' => $vehicle_model,
                'entry_time' => $entry_time,
                'alarm' => ''
            ];
        }

        file_put_contents('vagas/slots.json', json_encode($slots, JSON_PRETTY_PRINT));
        echo json_encode(['success' => true]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Vaga não encontrada.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido.']);
}
