<?php
$data = json_decode(file_get_contents('php://input'), true);
$slots = json_decode(file_get_contents('slots.json'), true);

$id = $data['id'];
$newPlate = trim($data['plate']);

if (isset($slots[$id])) {
    // Se a vaga está sendo ocupada
    if ($newPlate !== '') {
        $slots[$id]['status'] = 'occupied';
        $slots[$id]['plate'] = $newPlate;
        $slots[$id]['entry_time'] = date('Y-m-d H:i:s');  // Registra a data e hora de entrada
    }
    // Se a vaga está sendo liberada
    else {
        $slots[$id]['status'] = 'free';
        $slots[$id]['plate'] = '';
        $slots[$id]['entry_time'] = '';  // Limpa a data e hora ao liberar a vaga
    }

    file_put_contents('slots.json', json_encode($slots, JSON_PRETTY_PRINT));
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Slot not found.']);
}
?>
