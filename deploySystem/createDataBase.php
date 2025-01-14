<?php
echo "aaa";
// Dados do cPanel
$cpanel_user = 'inartcom'; // Usuário do cPanel
$cpanel_token = 'WNKQZAKMU8ZP0C6EW82PW67ZMZLTUUC0'; // Token gerado no cPanel
$cpanel_host = 'https://inart.com.br:2083'; // URL do cPanel (substitua pelo domínio do seu cPanel)

// Dados do banco de dados
$database_name = $cpanel_user . '_meubd'; // Nome do banco, incluindo o prefixo do usuário

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

// Debug: Verificar os dados sendo enviados
echo "Tentando criar o banco de dados com o nome: $database_name\n";

// Chamada para criar o banco de dados
$response = call_uapi($cpanel_host, 'Mysql/create_database', ['name' => $database_name], $headers);

// Debug: Verificar resposta da API
print_r($response);

if ($response['status'] !== 1) {
    die("Erro ao criar o banco de dados: " . implode(', ', $response['errors']));
}

echo "Banco de dados criado com sucesso!\n";
?>