<?php
// Dados do cPanel
$cpanel_user = 'inartcom'; // Usuário do cPanel
$cpanel_token = 'WNKQZAKMU8ZP0C6EW82PW67ZMZLTUUC0'; // Token gerado no cPanel
$cpanel_host = 'https://inart.com.br:2083'; // URL do cPanel (substitua pelo domínio do seu cPanel)

// Dados do banco de dados
$database_name = 'seubd';
$database_user = 'seuusuario';
$database_password = 'senha123';

// Cabeçalhos de autenticação
$headers = [
    'Authorization: cpanel ' . $cpanel_user . ':' . $cpanel_token,
    'Content-Type: application/json'
];

// Função para chamar a API do cPanel
function call_cpanel_api($url, $headers) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        die('Erro na chamada cURL: ' . curl_error($ch));
    }

    curl_close($ch);
    return json_decode($response, true);
}

// 1. Criar o banco de dados
$create_db_url = "$cpanel_host/json-api/cpanel?cpanel_jsonapi_user=$cpanel_user&cpanel_jsonapi_apiversion=2&cpanel_jsonapi_module=Mysql&cpanel_jsonapi_func=create_database&name=$database_name";
$response = call_cpanel_api($create_db_url, $headers);

if (isset($response['cpanelresult']['error'])) {
    die("Erro ao criar o banco de dados: " . $response['cpanelresult']['error']);
}
echo "Banco de dados criado com sucesso!\n";

// 2. Criar o usuário
$create_user_url = "$cpanel_host/json-api/cpanel?cpanel_jsonapi_user=$cpanel_user&cpanel_jsonapi_apiversion=2&cpanel_jsonapi_module=Mysql&cpanel_jsonapi_func=create_user&name=$database_user&password=$database_password";
$response = call_cpanel_api($create_user_url, $headers);

if (isset($response['cpanelresult']['error'])) {
    die("Erro ao criar o usuário do banco de dados: " . $response['cpanelresult']['error']);
}
echo "Usuário criado com sucesso!\n";

// 3. Associar o usuário ao banco
$add_user_to_db_url = "$cpanel_host/json-api/cpanel?cpanel_jsonapi_user=$cpanel_user&cpanel_jsonapi_apiversion=2&cpanel_jsonapi_module=Mysql&cpanel_jsonapi_func=set_privileges_on_database&user=$database_user&database=$database_name&privileges=ALL";
$response = call_cpanel_api($add_user_to_db_url, $headers);

if (isset($response['cpanelresult']['error'])) {
    die("Erro ao associar o usuário ao banco de dados: " . $response['cpanelresult']['error']);
}
echo "Usuário associado ao banco com sucesso!\n";
?>


// Autenticação no cPanel
$headers = [
    'Authorization: Basic ' . base64_encode($cpanel_user . ':' . $cpanel_pass)
];

// Criar o banco de dados
$create_db_url = "$cpanel_host/json-api/cpanel?cpanel_jsonapi_user=$cpanel_user&cpanel_jsonapi_apiversion=2&cpanel_jsonapi_module=Mysql&cpanel_jsonapi_func=create_database&name=$database_name";
$response = file_get_contents($create_db_url, false, stream_context_create(['http' => ['header' => $headers]]));

if ($response === false) {
    die("Erro ao criar o banco de dados.");
}
echo "Banco de dados criado com sucesso!\n";

// Criar o usuário
$create_user_url = "$cpanel_host/json-api/cpanel?cpanel_jsonapi_user=$cpanel_user&cpanel_jsonapi_apiversion=2&cpanel_jsonapi_module=Mysql&cpanel_jsonapi_func=create_user&name=$database_user&password=$database_password";
$response = file_get_contents($create_user_url, false, stream_context_create(['http' => ['header' => $headers]]));

if ($response === false) {
    die("Erro ao criar o usuário do banco de dados.");
}
echo "Usuário criado com sucesso!\n";

// Associar o usuário ao banco
$add_user_to_db_url = "$cpanel_host/json-api/cpanel?cpanel_jsonapi_user=$cpanel_user&cpanel_jsonapi_apiversion=2&cpanel_jsonapi_module=Mysql&cpanel_jsonapi_func=set_privileges_on_database&user=$database_user&database=$database_name&privileges=ALL";
$response = file_get_contents($add_user_to_db_url, false, stream_context_create(['http' => ['header' => $headers]]));

if ($response === false) {
    die("Erro ao associar o usuário ao banco de dados.");
}
echo "Usuário associado ao banco com sucesso!\n";
?>