<?php

ini_set('display_errors', 1);  // Habilita a exibição de erros
error_reporting(E_ALL);        // Reporta todos os erros

include_once "../objects/objects.php";

$siteAdmin = new SITE_ADMIN();  

$siteAdmin->getParameterInfo();

foreach ($siteAdmin->ARRAY_PARAMETERINFO as $item) {
    if ($item['CFG_DCPARAMETRO'] == 'NOME_CONDOMINIO') {
        $nomeCondominio = $item['CFG_DCVALOR']; 
    }

    if ($item['CFG_DCPARAMETRO'] == 'EMAIL_ALERTAS') {
        $EMAIL = $item['CFG_DCVALOR']; 
    }

    if ($item['CFG_DCPARAMETRO'] == 'ESTACIONAMENTO_VISITANTES_TOLERANCIA') {
        $toleranciaEstacionamento = $item['CFG_DCVALOR']; 
    } 

  } 

if(!$toleranciaEstacionamento || !$nomeCondominio)
{
  $ASSUNTO = "ATENÇÃO: Alerta de Veículo Irregular DESATIVADO.";
  $MSG = "O alerta de veículo irregular não está operando. Por favor, contate a Codemaze para suporte.";
  $siteAdmin->notifyUsuarioEmail($ASSUNTO, $MSG, $EMAIL);

  $siteAdmin->insertLogInfo("ALERTA", $MSG, "SISTEMA");
 
  die();
}

// Função para calcular a diferença de tempo entre agora e o 'entry_time'
function checkForAlarm($entry_time) {
    $current_time = new DateTime(); // Hora atual
    $entry_time = DateTime::createFromFormat('d/m/Y, H:i:s', $entry_time); // Formato da data no JSON

    // Calcula a diferença entre a hora atual e a hora de entrada
    $interval = $current_time->diff($entry_time);

    // Verifica se a diferença é maior que 24 horas
    return $interval->days > $toleranciaEstacionamento;
}

// Caminho do arquivo JSON
$json_file = '../pages/ctrlVagasVisitante/vagas/slots.json';

// Lê o arquivo JSON
$slots = json_decode(file_get_contents($json_file), true); 

if(!$slots)
{
  $ASSUNTO = "ATENÇÃO: Alerta de Veículo Irregular DESATIVADO.";
  $MSG = "O alerta de veículo irregular não está operando pois não encontrou o arquivo de vagas. Por favor, contate a Codemaze para suporte.";
  $siteAdmin->notifyUsuarioEmail($ASSUNTO, $MSG, $EMAIL);
  $siteAdmin->insertLogInfo("ALERTA", $MSG, "SISTEMA"); 
  die();
}

$contadorVeiculo = 0;
// Itera sobre os slots
foreach ($slots as $id => $slot) {
    // Verifica se há um tempo de entrada
    if (!empty($slot['entry_time']) && checkForAlarm($slot['entry_time'])) {
        // Se a diferença for maior que 48h, define o 'alarm' como 'alarmed'
        $slots[$id]['alarm'] = 'alarmed';

        echo "Encontrado veiculo irregular.";

        $veiculoI = $slot['vehicle_model']; 
        $placaI = $slot['plate']; 
        $apartamentoI = $slot['apartment'];

        $ASSUNTO = "ATENÇÃO: Alerta de Veículo Irregular - $nomeCondominio";
        $MSG = "O veículo modelo $veiculoI com placa $placaI sob responsabilidade do apartamento $apartamentoI está no estacionamento de visitantes a mais de 48h.";
        $siteAdmin->notifyUsuarioEmail($ASSUNTO, $MSG, $EMAIL);
        $siteAdmin->insertLogInfo("ALERTA", $MSG, "SISTEMA");

        $contadorVeiculo++;
    }
}

file_put_contents($json_file, json_encode($slots, JSON_PRETTY_PRINT));
$MSG = "A rotina de verificação de veículos irregulares no estacionamento de visitantes, terminou a checagem com sucesso. Encontrado $contadorVeiculo veículos irregulares.";
$siteAdmin->insertLogInfo("ALERTA", $MSG, "SISTEMA");
echo "Arquivo JSON atualizado com sucesso.";

?>
