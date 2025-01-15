<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar a senha do Banco de Dados
    $db_pass = $_POST['db_pass'] ?? '';
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/', $db_pass)) {
        echo "A senha do Banco de Dados deve ter pelo menos 8 caracteres, incluindo uma letra maiúscula, um número e um caractere especial.";
        exit();
    }

    // Diretório anterior ao public_html
    $config_dir = '/home/inartcom';
    $config_file = $config_dir . '/config.cfg';

    // Dados do formulário
    $data = [
        'DB' => [
            'host' => '"' . ($_POST['db_host'] ?? '') . '"',
            'dbname' => '"' . ($_POST['db_name'] ?? '') . '"',
            'user' => '"' . ($_POST['db_user'] ?? '') . '"',
            'pass' => '"' . $db_pass . '"',
        ],
        'EMAIL' => [
            'Username' => '"' . ($_POST['email_user'] ?? '') . '"',
            'Password' => '"' . ($_POST['email_pass'] ?? '') . '"',
            'Host' => '"' . ($_POST['email_host'] ?? '') . '"',
            'Port' => '"' . ($_POST['email_port'] ?? '') . '"',
        ],
        'CPANEL' => [
            'token' => '"' . ($_POST['cpanel_token'] ?? '') . '"',
            'usuario' => '"' . ($_POST['cpanel_usuario'] ?? '') . '"',
            'dominio' => '"' . ($_POST['cpanel_dominio'] ?? '') . '"',
            'porta' => '"' . ($_POST['cpanel_porta'] ?? '') . '"',
        ],
    ];

    $user_cpanel_get = $_POST['cpanel_usuario'];

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
        header("Location: ../deploySystem/createDataBase.php?cpanel_usuario=$user_cpanel_get");
        exit(); // Certifique-se de sair após o redirecionamento
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
    <title>Instalação Sistema Condominios</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
            margin: 0;
        }
        h1, h2 {
            color: #3498db;
            text-align: center;
        }
        form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 60%;
            margin: 30px auto;
        }
        label {
            color: #555;
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }
        input[type="text"], input[type="password"], input[type="number"] {
            background-color: #f9f9f9;
            color: #333;
            border: 1px solid #ddd;
            padding: 10px;
            width: 100%;
            margin-top: 5px;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="text"]:focus, input[type="password"]:focus, input[type="number"]:focus {
            border-color: #3498db;
            outline: none;
        }
        input[readonly] {
            background-color: #f1f1f1;
            cursor: not-allowed;
            border-color: #ccc;
        }
        button {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 12px 20px;
            margin-top: 20px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }
        button:hover {
            background-color: #2980b9;
        }
        .container {
            width: 70%;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Instalação Sistema Condominios</h1>
        <form method="POST">
            <h2>Banco de Dados</h2>
            <div class="form-group">
                <label for="db_host">Host:</label>
                <input type="text" name="db_host" id="db_host" value="localhost" readonly><br>
            </div>

            <div class="form-group">
                <label for="db_name">Nome do Banco:</label>
                <input type="text" name="db_name" id="db_name" value="dbcondominio" readonly required><br>
            </div>

            <div class="form-group">
                <label for="db_user">Usuário:</label>
                <input type="text" name="db_user" id="db_user" value="userdbcondominio" readonly required><br>
            </div>

            <div class="form-group">
                <label for="db_pass">Senha:</label>
                <input type="password" name="db_pass" id="db_pass" required><br>
                <small>Senha deve ter ao menos 8 caracteres, 1 maiúscula, 1 número e 1 caractere especial.</small>
            </div>

            <h2>E-mail</h2>
            <div class="form-group">
                <label for="email_user">Usuário: Ex.: contato@dominio.com.br</label>
                <input type="text" name="email_user" id="email_user" required><br>
            </div>

            <div class="form-group">
                <label for="email_pass">Senha:</label>
                <input type="password" name="email_pass" id="email_pass" required><br>
            </div>

            <div class="form-group">
                <label for="email_host">Host: Ex.: mail.dominio.com.br</label>
                <input type="text" name="email_host" id="email_host" required><br>
            </div>

            <div class="form-group">
                <label for="email_port">Porta:</label>
                <input type="number" name="email_port" id="email_port" value="587" readonly><br>
            </div>

            <h2>cPanel</h2>
            <div class="form-group">
                <label for="cpanel_token">Token:</label>
                <input type="text" name="cpanel_token" id="cpanel_token" required><br>
            </div>

            <div class="form-group">
                <label for="cpanel_usuario">Usuário:</label>
                <input type="text" name="cpanel_usuario" id="cpanel_usuario" required><br>
            </div>

            <div class="form-group">
                <label for="cpanel_dominio">Domínio: Ex.: https://dominio.com.br</label>
                <input type="text" name="cpanel_dominio" id="cpanel_dominio" required><br>
            </div>

            <div class="form-group">
                <label for="cpanel_porta">Porta:</label>
                <input type="number" name="cpanel_porta" id="cpanel_porta" value="2083" readonly><br><br>
            </div> 

            <button type="submit">Instalar Sistema</button>
        </form>
    </div>
</body>
</html>
