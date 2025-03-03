<?php
    ini_set('display_errors', 1);  
    error_reporting(E_ALL);        
    include_once "objects/objects.php";

    $message = ""; 
    $messageType = ""; 
    $showButton = false; 
    $HASH = ""; 

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (!isset($_GET['hash'])) {
            $message = "Erro: Parâmetro 'hash' não encontrado.";
            $messageType = "error";
        } else {
            $HASH = $_GET['hash'];
            $showButton = true; 
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $siteAdmin = new SITE_ADMIN();

        if (!isset($_POST['hash'])) {
            $message = "Erro: Nenhum código de liberação encontrado.";
            $messageType = "error";
        } else { 
            $HASH = $_POST['hash'];
            $userInfo = $siteAdmin->getUserInfoEncomenda($HASH); 
            $response = $siteAdmin->updateCheckboxEncomendasMoradorByApi($HASH);

            if($response == "Já retirado")
            {

                $message = "Erro: Esta encomenda já foi entregue pela portaria.";
                $messageType = "error";
                $showButton = false; 
            }
            else
                {
                
                    if (isset($userInfo['USU_DCTELEFONE'])) {
                        $telefone = $userInfo['USU_DCTELEFONE'];
                        $encomendaId = $userInfo['ENC_IDENCOMENDA'];
                        $usuarioNome = ucwords(strtolower($userInfo['USU_DCNOME']));

                        $messageWhats = "Olá *$usuarioNome*, a encomenda com ID *$encomendaId* foi liberada com sucesso.";
                        $siteAdmin->whatsappApiSendMessage($messageWhats, $telefone);

                        $message = "Uhull!!! Encomenda liberada com sucesso!";
                        $messageType = "success";
                        $showButton = false; 
                    } else {
                        $message = "Ah não!!! Houve um erro durante a liberação! Dirija-se à portaria.";
                        $messageType = "error";
                    }
                }
        }
    }
?> 

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liberação de Encomenda</title>

    <!-- Ícones do PWA -->
    <link rel="icon" href="img_pwa/logo_icon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="img_pwa/logo_icon.png">

    <!-- Configurações do PWA -->
    <meta name="apple-mobile-web-app-title" content="Hortênsias">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#ffffff">

    <!-- Manifest JSON -->
    <link rel="manifest" href="/manifest.json">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 80%;
            max-width: 400px;
            text-align: center;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 16px;
            color: #fff;
        }

        .message.success {
            background-color: #4CAF50;
        }

        .message.error {
            background-color: #f44336;
        }

        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            display: inline-block;
            width: 100%;
            text-transform: uppercase;
        }

        .btn:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>

    <div class="container">
        <?php if ($message != ""): ?>
            <div class="message <?= $messageType ?>"><?= $message ?></div>
        <?php endif; ?>

        <?php if ($showButton): ?>
            <form method="POST">
                <input type="hidden" name="hash" value="<?= htmlspecialchars($HASH) ?>">
                <button type="submit" class="btn">Retirar a Encomenda</button>
            </form>
        <?php endif; ?>
    </div>

</body>
</html>
