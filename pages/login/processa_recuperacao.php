<?php
include_once 'objetos.php'; 

class RecSystem extends SITE_ADMIN
{
    public function CheckValidUser($USU_DCAPARTAMENTO)
    {
            if (!$this->pdo) {
                $this->conexao();
            }

            $sql = "SELECT USU_DCEMAIL FROM USU_USUARIO WHERE USU_DCAPARTAMENTO = :USU_DCAPARTAMENTO";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':USU_DCAPARTAMENTO', $USU_DCAPARTAMENTO, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user['USU_DCEMAIL']) 
            {
                $email = $user['USU_DCEMAIL'];
                return $email;             
            } else 
                  {
                    //--------------------LOG----------------------//
                    $LOG_DCTIPO = "REC SENHA";
                    $LOG_DCMSG = "Apartamento não cadastrado no sistema";
                    $LOG_DCUSUARIO = "N/A";
                    $LOG_DCAPARTAMENTO = $USU_DCAPARTAMENTO;
                    $this->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO);
                    //--------------------LOG----------------------//
                    echo "Apartamento não cadastrado no sistema. Entre em contato com o síndico.";
                    exit();
                  }        
    }

    public function sendToken($apartamento,$email)
    {
            if (!$this->pdo) {
                $this->conexao();
            }
            
            try 
            {
                $USU_DCREDEF_TOKEN = bin2hex(random_bytes(16));
                $USU_DTREDEF_TOKEN_EXP = date('Y-m-d H:i:s', strtotime('+1 hour'));

                $sql = "UPDATE USU_USUARIO 
                    SET 
                    USU_DCREDEF_TOKEN = :USU_DCREDEF_TOKEN, 
                    USU_DTREDEF_TOKEN_EXP = :USU_DTREDEF_TOKEN_EXP
                    WHERE USU_DCAPARTAMENTO = :USU_DCAPARTAMENTO";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':USU_DCAPARTAMENTO', $apartamento, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DCREDEF_TOKEN', $USU_DCREDEF_TOKEN, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DTREDEF_TOKEN_EXP', $USU_DTREDEF_TOKEN_EXP, PDO::PARAM_STR);
                $stmt->execute();

                // Enviar o link de redefinição
                $link = "https://prqdashortensias.com.br/redefinir_senha.php?token=$USU_DCREDEF_TOKEN";
                $mensagem = "Clique no link para redefinir sua senha: $link";
                $assunto = "Condomínio Parque das Hortênsias - Recuperação de senha";

                $this->notifyUsuarioEmail($assunto,$mensagem,$email);
                echo "Um link de recuperação foi enviado para seu e-mail."; 
                
                //--------------------LOG----------------------//
                $LOG_DCTIPO = "REC SENHA";
                $LOG_DCMSG = "Envio de link de recuperação de senha para o e-mail: $email.";
                $LOG_DCUSUARIO = "N/A";
                $LOG_DCAPARTAMENTO = $apartamento;
                $this->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO);
                //--------------------LOG----------------------//
            }
            catch (Exception $e) 
            {
                echo "Erro ao processar a solicitação";
            }              
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $apartamento = $_POST['apartamento'];

    $RecSystem = new RecSystem();
    
    $email=$RecSystem->CheckValidUser($apartamento);
    $result=$RecSystem->sendToken($apartamento,$email);

}
 
?>