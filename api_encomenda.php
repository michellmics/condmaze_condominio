<?php
    ini_set('display_errors', 1);  
    error_reporting(E_ALL);        
    include_once "objects/objects.php";

    $message = ""; // Variável para armazenar a mensagem de erro ou sucesso
    $messageType = ""; // Variável para armazenar o tipo da mensagem (sucesso ou erro)

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $siteAdmin = new SITE_ADMIN();

        if (!isset($_GET['hash'])) {
            $message = "Erro: Parâmetro 'hash' não encontrado.";
            $messageType = "error";
        } else {
            $HASH = $_GET['hash'];
            
            $userInfo = $siteAdmin->getUserInfoEncomenda($HASH);
            $response = $siteAdmin->updateCheckboxEncomendasMoradorByApi($HASH);

            $telefone = $userInfo['USU_DCTELEFONE'];
            $encomendaId = $userInfo['ENC_IDENCOMENDA'];
            $usuarioNome = $userInfo['USU_DCNOME'];

            if ($response != "0") 
            {
                $msg = "Olá $usuarioNome, a encomenda com ID $encomendaId foi liberada com sucesso.";
                $result = $siteAdmin->whatsapp($msg,$telefone);

                $message = "Uhull!!! Encomenda liberada com sucesso!";
                $messageType = "success";
            } else {
                $message = "Ah não!!! Houve um erro durante a liberação! Dirija-se a portaria.";
                $messageType = "error";
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
        /* Estilos gerais */
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
            margin: 50px auto;
            text-align: center;
        }

        /* Estilo das mensagens */
        .message {
            padding: 20px;
            margin: 10px;
            border-radius: 5px;
            font-size: 16px;
            color: #fff;
            display: inline-block;
            width: 60%;
            box-sizing: border-box;
        }

        /* Mensagem de sucesso */
        .message.success {
            background-color: #4CAF50; /* Verde */
        }

        /* Mensagem de erro */
        .message.error {
            background-color: #f44336; /* Vermelho */
        }

        /* Estilo de borda e sombreamento */
        .message.success, .message.error {
            border: 1px solid #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

    <div class="container">
        <?php
        if ($message != "") {
            echo "<div class='message $messageType'>$message</div>";
        }
        ?>
    </div>

</body>
</html>
