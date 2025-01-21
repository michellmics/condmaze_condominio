<?php

// Função para calcular a diferença de tempo entre agora e o 'entry_time'
function checkForAlarm($entry_time) {
    $current_time = new DateTime(); // Hora atual
    $entry_time = DateTime::createFromFormat('d/m/Y, H:i:s', $entry_time); // Formato da data no JSON

    // Calcula a diferença entre a hora atual e a hora de entrada
    $interval = $current_time->diff($entry_time);

    // Verifica se a diferença é maior que 24 horas
    return $interval->days > 2;
}

// Caminho do arquivo JSON
$json_file = 'slots.json';

// Lê o arquivo JSON
$slots = json_decode(file_get_contents($json_file), true);

// Itera sobre os slots
foreach ($slots as $id => $slot) {
    // Verifica se há um tempo de entrada
    if (!empty($slot['entry_time']) && checkForAlarm($slot['entry_time'])) {
        // Se a diferença for maior que 48h, define o 'alarm' como 'alarmed'
        $slots[$id]['alarm'] = 'alarmed';
    }
}

// Salva as alterações no arquivo JSON
file_put_contents($json_file, json_encode($slots, JSON_PRETTY_PRINT));

echo "Arquivo JSON atualizado com sucesso.";

?>
