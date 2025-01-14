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

// Função para chamar a API UAPI do cPanel
function call_uapi($cpanel_host, $endpoint, $params, $headers) {
    $url = $cpanel_host . '/execute/' . $endpoint;
    $query = http_build_query($params);

    $ch = curl_init($url . '?' . $query);
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
$response = call_uapi($cpanel_host, 'Mysql/create_database', ['name' => $database_name], $headers);

if ($response['status'] !== 1) {
    die("Erro ao criar o banco de dados: " . $response['errors'][0]);
}
echo "Banco de dados criado com sucesso!\n";

// 2. Criar o usuário do banco de dados
$response = call_uapi($cpanel_host, 'Mysql/create_user', [
    'name' => $database_user,
    'password' => $database_password
], $headers);

if ($response['status'] !== 1) {
    die("Erro ao criar o usuário do banco de dados: " . $response['errors'][0]);
}
echo "Usuário criado com sucesso!\n";

// 3. Conceder permissões ao usuário no banco de dados
$response = call_uapi($cpanel_host, 'Mysql/set_privileges_on_database', [
    'user' => $database_user,
    'database' => $database_name,
    'privileges' => 'ALL PRIVILEGES'
], $headers);

if ($response['status'] !== 1) {
    die("Erro ao conceder permissões ao usuário: " . $response['errors'][0]);
}
echo "Usuário associado ao banco com sucesso!\n";
?>