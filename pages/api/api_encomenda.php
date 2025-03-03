<?php
    include_once "../../objects/objects.php";

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

            
            if (isset($userInfo['USU_DCTELEFONE'])) 
            {

                $telefone = $userInfo['USU_DCTELEFONE'];
                $encomendaId = $userInfo['ENC_IDENCOMENDA'];
                $usuarioNome = ucwords(strtolower($userInfo['USU_DCNOME']));

                if($userInfo['ENC_STENTREGA_MORADOR'] == "ENTREGUE")
                {
                    $message = "Erro: Sua encomenda já foi entregue.";
                    $messageType = "error";
                    $showButton = false; 

                    $messageWhats = "Olá *$usuarioNome*, a encomenda com ID *$encomendaId* já foi entregue. Em caso de dúvidas, verifique com a portaria.";
                    $siteAdmin->whatsappApiSendMessage($messageWhats, $telefone);
                }
                else
                    {
                        $message = "Uhull!!! Encomenda liberada com sucesso!";
                        $messageType = "success";
                        $showButton = false; 

                        $messageWhats = "Olá *$usuarioNome*, a encomenda com ID *$encomendaId* foi liberada com sucesso.";
                        $siteAdmin->whatsappApiSendMessage($messageWhats, $telefone);
                    }

            } else {
                $message = "Ah não!!! Houve um erro durante a liberação! Por favor, dirija-se à portaria.";
                $messageType = "error";
            }
                
        }
    }
?> 

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- HEAD META BASIC LOAD-->
	<?php include '../../src/headMeta.php'; ?>
	<!-- HEAD META BASIC LOAD -->

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
