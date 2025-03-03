<?php


$secure_token = $_ENV['ENV_GETSERVICE_TOKEN'];

if (!isset($_GET['token']) || $_GET['token'] !== $secure_token) {
    http_response_code(403);
    die("Acesso negado!");
}

include_once "../../objects/objects.php";

$siteAdmin = new SITE_ADMIN();  

$siteAdmin->getParameterInfo();

// Inicializa as variáveis para evitar erro de variável indefinida
$nomeCondominio = null;
$EMAIL = null;
$toleranciaEstacionamento = 48; // Default para evitar erro caso não seja encontrado

foreach ($siteAdmin->ARRAY_PARAMETERINFO as $item) {
    if ($item['CFG_DCPARAMETRO'] == 'NOME_CONDOMINIO') {
        $nomeCondominio = $item['CFG_DCVALOR']; 
    } elseif ($item['CFG_DCPARAMETRO'] == 'EMAIL_ALERTAS') {
        $EMAIL = $item['CFG_DCVALOR']; 
    } elseif ($item['CFG_DCPARAMETRO'] == 'TELEFONE_SINDICO') {
        $telefoneSindico = $item['CFG_DCVALOR']; 
    } elseif ($item['CFG_DCPARAMETRO'] == 'DOMINIO') {
        $dominio = $item['CFG_DCVALOR']; 
    } elseif ($item['CFG_DCPARAMETRO'] == 'ESTACIONAMENTO_VISITANTES_TOLERANCIA') {
        $toleranciaEstacionamento = (int) $item['CFG_DCVALOR']; // Garante que seja um número
    }
}

// Verifica se os parâmetros essenciais estão definidos
if (!$toleranciaEstacionamento || !$nomeCondominio) {
    $ASSUNTO = "ATENÇÃO: Alerta de Veículo Irregular DESATIVADO.";
    $MSG = "O alerta de veículo irregular não está operando. Por favor, contate a Codemaze para suporte.";
    $siteAdmin->notifyUsuarioEmail($ASSUNTO, $MSG, $EMAIL);
    $siteAdmin->insertLogInfo("ALERTA", $MSG, "SISTEMA");
    die();
}

// Função para calcular a diferença de tempo entre agora e o 'entry_time'
function checkForAlarm($entry_time, $toleranciaEstacionamento) {
    $current_time = new DateTime(); // Hora atual
    $entry_time = DateTime::createFromFormat('d/m/Y, H:i:s', $entry_time); 

    if (!$entry_time) return false; // Retorna falso caso a data seja inválida

    // Calcula a diferença entre a hora atual e a hora de entrada
    $interval = $current_time->diff($entry_time);
    $horasPassadas = $interval->days * 24 + $interval->h;

    return $horasPassadas > $toleranciaEstacionamento; // Retorna true se passou do limite
}

// Caminho do arquivo JSON
$json_file = 'vagas/slots.json';

// Verifica se o arquivo existe antes de tentar lê-lo
if (!file_exists($json_file) || !is_readable($json_file)) {
    $ASSUNTO = "ATENÇÃO: Alerta de Veículo Irregular DESATIVADO.";
    $MSG = "O alerta de veículo irregular não está operando pois não encontrou o arquivo de vagas. Por favor, contate a Codemaze para suporte.";
    $siteAdmin->notifyUsuarioEmail($ASSUNTO, $MSG, $EMAIL);
    $siteAdmin->insertLogInfo("ALERTA", $MSG, "SISTEMA");
    die();
}

// Lê e decodifica o arquivo JSON
$slots = json_decode(file_get_contents($json_file), true);

if (!$slots) {
    $ASSUNTO = "ATENÇÃO: Alerta de Veículo Irregular DESATIVADO.";
    $MSG = "O alerta de veículo irregular não está operando pois o arquivo de vagas está corrompido ou vazio. Por favor, contate a Codemaze para suporte.";
    $siteAdmin->notifyUsuarioEmail($ASSUNTO, $MSG, $EMAIL);
    $siteAdmin->insertLogInfo("ALERTA", $MSG, "SISTEMA");
    die();
}

$contadorVeiculo = 0;

// Itera sobre os slots
foreach ($slots as $id => $slot) {
    if (!empty($slot['entry_time']) && checkForAlarm($slot['entry_time'], $toleranciaEstacionamento)) {
        $slots[$id]['alarm'] = 'alarmed';

        echo "Encontrado veículo irregular.\n";

        $veiculoI = $slot['vehicle_model'] ?? 'Desconhecido';
        $placaI = $slot['plate'] ?? 'Desconhecida';
        $apartamentoI = $slot['apartment'] ?? 'Desconhecido';

        $ASSUNTO = "ATENÇÃO: Alerta de Veículo Irregular - $nomeCondominio";
        $MSG = "O veículo modelo $veiculoI com placa $placaI sob responsabilidade do apartamento $apartamentoI está no estacionamento de visitantes há mais de $toleranciaEstacionamento dias.";
        
        $siteAdmin->notifyUsuarioEmail($ASSUNTO, $MSG, $EMAIL);
        $siteAdmin->insertLogInfo("ALERTA", $MSG, "SISTEMA");

        //Notificação para o front
        //nivel: TODOS, MORADOR, SINDICO OU PORTARIA
        $siteAdmin->insertNotificacaoFront("Veiculo Irregular", "Estacionamento de Visitantes", "PORTARIA");
        $siteAdmin->insertNotificacaoFront("Veiculo Irregular", "Estacionamento de Visitantes", "SINDICO");

        $msgWhatsapp = "Olá Sindico(a),\n\n"
        . "O veículo modelo $veiculoI com placa $placaI sob responsabilidade do apartamento $apartamentoI está no estacionamento de visitantes há mais de $toleranciaEstacionamento dias.";       
        $siteAdmin->whatsappApiSendMessage($msgWhatsapp, $telefoneSindico);

        $contadorVeiculo++;
    }
}

// Salva o arquivo JSON atualizado
file_put_contents($json_file, json_encode($slots, JSON_PRETTY_PRINT));

$MSG = "A rotina de verificação de veículos irregulares no estacionamento de visitantes terminou a checagem com sucesso. Encontrado $contadorVeiculo veículos irregulares.";
$siteAdmin->insertLogInfo("ALERTA", $MSG, "SISTEMA");

echo "Arquivo JSON atualizado com sucesso.\n";

?>
