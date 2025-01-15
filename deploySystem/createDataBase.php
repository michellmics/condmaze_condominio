<?php

header('Content-Type: application/json');

echo "cheguei";
die();

// Dados do cPanel
$cpanel_user = 'inartcom'; 
$cpanel_token = 'WNKQZAKMU8ZP0C6EW82PW67ZMZLTUUC0';
$cpanel_host = 'https://inart.com.br:2083'; 

// Dados do banco de dados
$database_name = $cpanel_user . '_bdcondominio'; // Nome do banco
$user_name = $cpanel_user . '_userbdcondominio'; // Nome do usuário
$user_password = 'Mi479585!condominio'; // Senha do usuário do banco

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
?>