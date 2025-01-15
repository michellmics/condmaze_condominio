<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Diretório anterior ao public_html
    $config_dir = dirname(__DIR__); // Ajuste conforme necessário
    $config_file = $config_dir . '/config.cfg';

    // Dados do formulário
    $data = [
        'DB' => [
            'host' => $_POST['db_host'] ?? '',
            'dbname' => $_POST['db_name'] ?? '',
            'user' => $_POST['db_user'] ?? '',
            'pass' => $_POST['db_pass'] ?? '',
        ],
        'EMAIL' => [
            'Username' => $_POST['email_user'] ?? '',
            'Password' => $_POST['email_pass'] ?? '',
            'Host' => $_POST['email_host'] ?? '',
            'Port' => $_POST['email_port'] ?? '',
        ],
        'CPANEL' => [
            'token' => $_POST['cpanel_token'] ?? '',
            'dominio' => $_POST['cpanel_dominio'] ?? '',
            'porta' => $_POST['cpanel_porta'] ?? '',
        ],
    ];

    // Gerar conteúdo do arquivo config.cfg
    $config_content = "[DATA DB]\n";
    foreach ($data['DB'] as $key => $value) {
        $config_content .= "$key = $value\n";
    }

    $config_content .= "\n[EMAIL]\n";
    foreach ($data['EMAIL'] as $key => $value) {
        $config_content .= "$key = $value\n";
    }

    $config_content .= "\n[CPANEL]\n";
    foreach ($data['CPANEL'] as $key => $value) {
        $config_content .= "$key = $value\n";
    }

    // Escrever no arquivo
    if (file_put_contents($config_file, $config_content)) {
        echo "Arquivo config.cfg gerado com sucesso no diretório: $config_dir";
    } else {
        echo "Erro ao gerar o arquivo config.cfg.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Config.cfg</title>
</head>
<body>
    <h1>Gerar Arquivo config.cfg</h1>
    <form method="POST">
        <h2>Banco de Dados</h2>
        <label>Host:</label><br>
        <input type="text" name="db_host" required><br>
        <label>Nome do Banco:</label><br>
        <input type="text" name="db_name" required><br>
        <label>Usuário:</label><br>
        <input type="text" name="db_user" required><br>
        <label>Senha:</label><br>
        <input type="password" name="db_pass" required><br>

        <h2>E-mail</h2>
        <label>Usuário:</label><br>
        <input type="text" name="email_user" required><br>
        <label>Senha:</label><br>
        <input type="password" name="email_pass" required><br>
        <label>Host:</label><br>
        <input type="text" name="email_host" required><br>
        <label>Porta:</label><br>
        <input type="number" name="email_port" required><br>

        <h2>cPanel</h2>
        <label>Token:</label><br>
        <input type="text" name="cpanel_token" required><br>
        <label>Domínio:</label><br>
        <input type="text" name="cpanel_dominio" required><br>
        <label>Porta:</label><br>
        <input type="number" name="cpanel_porta" required><br><br>

        <button type="submit">Gerar Config.cfg</button>
    </form>
</body>
</html>
