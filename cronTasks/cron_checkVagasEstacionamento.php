<?php
ini_set('display_errors', 1);  // Habilita a exibição de erros
error_reporting(E_ALL);        // Reporta todos os erros

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];

include_once "../objects/objects.php";
$siteAdmin = new SITE_ADMIN();  

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
$json_file = '../pages/ctrlVagasVisitante/vagas/slots.json';

// Lê o arquivo JSON
$slots = json_decode(file_get_contents($json_file), true); 

// Itera sobre os slots
foreach ($slots as $id => $slot) {
    // Verifica se há um tempo de entrada
   // if (!empty($slot['entry_time']) && checkForAlarm($slot['entry_time'])) {
        // Se a diferença for maior que 48h, define o 'alarm' como 'alarmed'
        $slots[$id]['alarm'] = 'alarmed';

        echo "Encontrado veiculo irregular.";

        $veiculoI = $slot['vehicle_model']; 
        $placaI = $slot['plate']; 
        $apartamentoI = $slot['apartment'];

        $ASSUNTO = "ALERTA DE VEÍCULO IRREGULAR";
        $MSG = "O veículo modelo $veiculoI com placa $placaI sob responsabilidade do apartamento $apartamentoI está no estacionamento de visitantes a mais de 48h.";
        $sendMailResult = $siteAdmin->notifyEmail($ASSUNTO, $MSG, $host);
        var_dump($sendMailResult);
   // }
}

// Salva as alterações no arquivo JSON
file_put_contents($json_file, json_encode($slots, JSON_PRETTY_PRINT));

echo "Arquivo JSON atualizado com sucesso.";

?>
