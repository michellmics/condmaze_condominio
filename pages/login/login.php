<?php
include_once 'objetos.php'; 
session_start(); 

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

class LoginSystem extends SITE_ADMIN
{
    public function validateUser($apartamento, $password)
    {
        try {
            // Cria conexão com o banco de dados
            if (!$this->pdo) {
                $this->conexao();
            }

            // Prepara a consulta SQL para verificar o usuário
            $sql = "SELECT USU_IDUSUARIO, USU_DCSENHA, USU_DCEMAIL, USU_DCNOME, USU_DCNIVEL, USU_DCBLOCO, USU_DCAPARTAMENTO FROM USU_USUARIO WHERE USU_DCAPARTAMENTO = :apartamento";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':apartamento', $apartamento, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Se o usuário for encontrado e a senha for válida
            if ($user && password_verify($password, $user['USU_DCSENHA'])) {
                $_SESSION['user_id'] = $user['USU_IDUSUARIO']; // Armazena o ID na sessão
                $_SESSION['user_name'] = $user['USU_DCNOME'];
                $_SESSION['user_email'] = $user['USU_DCEMAIL'];
                $_SESSION['user_apartamento'] = $user['USU_DCAPARTAMENTO'];
                $_SESSION['user_bloco'] = $user['USU_DCBLOCO'];
                $_SESSION['user_nivelacesso'] = $user['USU_DCNIVEL'];

                //--------------------LOG----------------------//
                $LOG_DCTIPO = "LOGIN";
                $LOG_DCMSG = "Usuário ".$user['USU_DCNOME']." logado com sucesso.";
                $LOG_DCUSUARIO = $user['USU_IDUSUARIO'];
                $LOG_DCAPARTAMENTO = $user['USU_DCAPARTAMENTO'];
                $this->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO);
                //--------------------LOG----------------------//

                echo '<meta http-equiv="refresh" content="0;url=sistema/index.php">'; // Redireciona após login bem-sucedido
                exit();
             
            } else 
                {
                    //--------------------LOG----------------------//
                    $LOG_DCTIPO = "LOGIN FAILED";
                    $LOG_DCMSG = "Usuario ou senha incorretos";
                    $LOG_DCUSUARIO = "N/A";
                    $LOG_DCAPARTAMENTO = $apartamento;
                    $this->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO);
                    //--------------------LOG----------------------//

                    $_SESSION = [];
                    session_destroy();
                    echo "Usuário ou senha incorretos."; 
                }
        } catch (PDOException $e) {  
            echo "Erro: " . $e->getMessage();
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $secretKey = "6Lf3654qAAAAADXFzRqJWg7dN-XLJN_JJFMD7Lgx"; 

    $recaptchaResponse = $_POST['g-recaptcha-response'];

    // Verifique se o token foi recebido
    if (!empty($recaptchaResponse))  
    {
        
        // Verifique o reCAPTCHA fazendo uma solicitação à API do Google
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");
        $responseKeys = json_decode($response, true);

        // Verifique o sucesso da validação
        if ($responseKeys["success"]) 
        {
            $apartamento = $_POST['username'];
            $password = $_POST['password'];

            $loginSystem = new LoginSystem();
            $result=$loginSystem->validateUser($apartamento, $password);
        }
        else 
            {
                //--------------------LOG----------------------//
                $LOG_DCTIPO = "LOGIN FAILED";
                $LOG_DCMSG = "Falha na verificação do reCAPTCHA";
                $LOG_DCUSUARIO = "N/A";
                $LOG_DCAPARTAMENTO = $apartamento;
                $this->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO);
                //--------------------LOG----------------------//
                echo "Falha na verificação do reCAPTCHA. Por favor, tente novamente.";
            }
    }
    else 
        {
            //--------------------LOG----------------------//
            $LOG_DCTIPO = "LOGIN FAILED";
            $LOG_DCMSG = "Não completou o reCAPTCHA";
            $LOG_DCUSUARIO = "N/A";
            $LOG_DCAPARTAMENTO = $apartamento;
            $this->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO);
            //--------------------LOG----------------------//

            echo "Por favor, complete o reCAPTCHA.";
        }
}
 
?>
