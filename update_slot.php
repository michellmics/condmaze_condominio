<?php
$data = json_decode(file_get_contents('php://input'), true);
$slots = json_decode(file_get_contents('slots.json'), true);

$id = $data['id'];
$newPlate = strtoupper(trim($data['plate'])); // Placa em maiúsculas
$newApartment = trim($data['apartment']);
$newModel = strtoupper(trim($data['vehicle_model'])); // Modelo em maiúsculas
$newEntryTime = $data['entry_time']; // Data formatada enviada pelo cliente

// Validações no servidor
if (!preg_match('/^[A-Z0-9]{1,7}$/', $newPlate)) {
    echo json_encode(['success' => false, 'message' => 'Placa inválida!']);
    exit;
}

if (!preg_match('/^\d+$/', $newApartment)) {
    echo json_encode(['success' => false, 'message' => 'Apartamento inválido!']);
    exit;
}

if (empty($newModel)) {
    echo json_encode(['success' => false, 'message' => 'Modelo do veículo inválido!']);
    exit;
}

if (isset($slots[$id])) {
    // Se a vaga está sendo ocupada
    if ($newPlate !== '') {
        $slots[$id]['status'] = 'occupied';
        $slots[$id]['plate'] = $newPlate;
        $slots[$id]['apartment'] = $newApartment;
        $slots[$id]['vehicle_model'] = $newModel;
        $slots[$id]['entry_time'] = $newEntryTime;  // A data de entrada já está formatada
    }
    // Se a vaga está sendo liberada
    else {
        $slots[$id]['status'] = 'free';
        $slots[$id]['plate'] = '';
        $slots[$id]['apartment'] = '';
        $slots[$id]['vehicle_model'] = '';
        $slots[$id]['entry_time'] = '';  // Limpa a data e hora ao liberar a vaga
    }

    file_put_contents('slots.json', json_encode($slots, JSON_PRETTY_PRINT));
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => f
