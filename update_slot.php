<?php
$data = json_decode(file_get_contents('php://input'), true);
$slots = json_decode(file_get_contents('slots.json'), true);

$id = $data['id'];
$newPlate = trim($data['plate']);
$newApartment = trim($data['apartment']);
$newModel = trim($data['vehicle_model']);
$newEntryTime = $data['entry_time'];  // A data já chega formatada

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
    echo json_encode(['success' => false, 'message' => 'Slot not found.']);
}
?>
