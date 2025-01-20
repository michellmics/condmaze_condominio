<?php
$data = json_decode(file_get_contents('php://input'), true);
$slots = json_decode(file_get_contents('slots.json'), true);

$id = $data['id'];
$newPlate = trim($data['plate']);

if (isset($slots[$id])) {
    $slots[$id]['status'] = $newPlate === '' ? 'free' : 'occupied';
    $slots[$id]['plate'] = $newPlate;
    file_put_contents('slots.json', json_encode($slots, JSON_PRETTY_PRINT));
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Slot not found.']);
}
?>
