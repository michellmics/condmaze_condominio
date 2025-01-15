<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Diretório anterior ao public_html
    $config_dir = '/home/inartcom';
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
    <style>
        body {
            background-color: #1c1c1c;
            color: #ecf0f1;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h1, h2 {
            color: #e67e22;
        }
        form {
            background-color: #2c2c2c;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 60%;
            margin: auto;
        }
        label {
            color: #ecf0f1;
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        input[type="text"], input[type="password"], input[type="number"] {
            background-color: #2c2c2c;
            color: #ecf0f1;
            border: 1px solid #e67e22;
            padding: 8px;
            width: 100%;
            margin-top: 5px;
            border-radius: 4px;
        }
        input[type="text"]:focus, input[type="password"]:focus, input[type="number"]:focus {
            border-color: #d35400;
            outline: none;
        }
        input[readonly] {
            background-color: #555;
            cursor: not-allowed;
        }
        button {
            background-color: #e67e22;
            color: #fff;
            border: none;
            padding: 10px 20px;
            margin-top: 20px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #d35400;
        }
        .container {
            width: 60%;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gerar Arquivo config.cfg</h1>
        <form method="POST">
            <h2>Banco de Dados</h2>
            <label for="db_host">Host:</label>
            <input type="text" name="db_host" id="db_host" value="localhost" readonly><br>

            <label for="db_name">Nome do Banco:</label>
            <input type="text" name="db_name" id="db_name" required><br>

            <label for="db_user">Usuário:</label>
            <input type="text" name="db_user" id="db_user" required><br>

            <label for="db_pass">Senha:</label>
            <input type="password" name="db_pass" id="db_pass" required><br>

            <h2>E-mail</h2>
            <label for="email_user">Usuário:</label>
            <input type="text" name="email_user" id="email_user" required><br>

            <label for="email_pass">Senha:</label>
            <input type="password" name="email_pass" id="email_pass" required><br>

            <label for="email_host">Host:</label>
            <input type="text" name="email_host" id="email_host" required><br>

            <label for="email_port">Porta:</label>
            <input type="number" name="email_port" id="email_port" value="587" readonly><br>

            <h2>cPanel</h2>
            <label for="cpanel_token">Token:</label>
            <input type="text" name="cpanel_token" id="cpanel_token" required><br>

            <label for="cpanel_dominio">Domínio:</label>
            <input type="text" name="cpanel_dominio" id="cpanel_dominio" required><br>

            <label for="cpanel_porta">Porta:</label>
            <input type="number" name="cpanel_porta" id="cpanel_porta" value="2083" readonly><br><br>

            <button type="submit">Gerar Config.cfg</button>
        </form>
    </div>
</body>
</html>
