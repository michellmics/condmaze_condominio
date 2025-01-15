<?php

header('Content-Type: application/json');

if (!isset($_GET['cpanel_usuario'])) {
    echo "Arquivo de configuração incompleto.";
    die();
}

$cpanel_usuario = $_GET['cpanel_usuario'];
$configPath = "/home/$cpanel_usuario/config.cfg";

if (!file_exists($configPath)) {
    die("Erro: Arquivo de configuração não encontrado.");
}

$configContent = parse_ini_file($configPath, true);  // true para usar seções

if (!$configContent) {
    die("Erro: Não foi possível ler o arquivo de configuração.");
}

$host = $configContent['DATA DB']['host'];
$dbName = $configContent['DATA DB']['dbname'];
$dbUser = $configContent['DATA DB']['user'];
$dbPass = $configContent['DATA DB']['pass'];
$cpanelusuario = $configContent['CPANEL']['usuario'];
$cpanelDominio = $configContent['CPANEL']['dominio'];
$cpanelPorta = $configContent['CPANEL']['porta'];
$cpanelToken = $configContent['CPANEL']['token'];

// Dados do banco de dados
$database_name = $cpanel_user . "_" . $dbName; // Nome do banco
$user_name = $cpanel_user . "_" . $dbUser; // Nome do usuário
$user_password = $dbPass; // Senha do usuário do banco

// Dados do cPanel
$cpanel_user = $cpanelusuario;
$cpanel_token = $cpanelToken;
$cpanel_host = $cpanelDominio . ":" . $cpanelPorta;

// Cabeçalhos de autenticação
$headers = [
    'Authorization: cpanel ' . $cpanel_user . ':' . $cpanel_token,
    'Content-Type: application/x-www-form-urlencoded'
];

// Função para chamar a API UAPI do cPanel
function call_uapi($cpanel_host, $endpoint, $params, $headers) {
    $url = $cpanel_host . '/execute/' . $endpoint;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        die('Erro na chamada cURL: ' . curl_error($ch));
    }

    curl_close($ch);
    return json_decode($response, true);
}

// Criar o banco de dados
$response = call_uapi($cpanel_host, 'Mysql/create_database', ['name' => $database_name], $headers);

if ($response['status'] !== 1) {
    die("Erro ao criar o banco de dados: " . implode(', ', $response['errors']));
}
echo "Banco de dados '$database_name' criado com sucesso!\n";

// Criar o usuário do banco de dados
$response = call_uapi($cpanel_host, 'Mysql/create_user', [
    'name' => $user_name,
    'password' => $user_password
], $headers);

if ($response['status'] !== 1) {
    die("Erro ao criar o usuário: " . implode(', ', $response['errors']));
}
echo "Usuário '$user_name' criado com sucesso!\n";

// Associar o usuário ao banco de dados com todos os privilégios
$response = call_uapi($cpanel_host, 'Mysql/set_privileges_on_database', [
    'user' => $user_name,
    'database' => $database_name,
    'privileges' => 'ALL PRIVILEGES'
], $headers);

if ($response['status'] !== 1) {
    die("Erro ao associar o usuário ao banco de dados: " . implode(', ', $response['errors']));
}
echo "Usuário '$user_name' associado ao banco '$database_name' com todos os privilégios!\n";

// Agora, conectar ao banco de dados e executar o arquivo SQL

try {
    // Conectar ao banco de dados usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$database_name", $user_name, $user_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexão ao banco de dados '$database_name' estabelecida com sucesso!\n";

    // Caminho do arquivo SQL
    $sqlFilePath = "db.sql"; // Caminho para o arquivo .sql

    // Verificar se o arquivo SQL existe
    if (!file_exists($sqlFilePath)) {
        die("Erro: O arquivo SQL não foi encontrado.");
    }

    // Ler o conteúdo do arquivo SQL
    $sqlContent = file_get_contents($sqlFilePath);

    if ($sqlContent === false) {
        die("Erro ao ler o conteúdo do arquivo SQL.");
    }

    // Executar o conteúdo do arquivo SQL
    $pdo->exec($sqlContent);

    echo "Arquivo SQL executado com sucesso no banco '$database_name'!\n";

} catch (PDOException $e) {
    die("Erro na conexão ou na execução do SQL: " . $e->getMessage());
}

?>
