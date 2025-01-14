<?php
$cpanel_user = 'inartcom';
$cpanel_pass = 'Mi47958585!';
$cpanel_host = 'https://inart.com.br:2083'; // Substitua pelo domínio do seu cPanel

$database_name = 'seubd';
$database_user = 'seuusuario';
$database_password = 'senha123';

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