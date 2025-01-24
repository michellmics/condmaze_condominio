<?php
ini_set('display_errors', 1);  // Habilita a exibição de erros
error_reporting(E_ALL);        // Reporta todos os erros
include_once "../../objects/objects.php";

session_start(); 
define('SESSION_TIMEOUT', 43200); // 12 horas

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

                //TOKENIZAÇÃO
                $token = $this->gerarToken($user['USU_IDUSUARIO']);

                // Prepara a consulta SQL para verificar o usuário
                $sql = "UPDATE USU_USUARIO SET USU_DCTOKEN = :USU_DCTOKEN WHERE USU_DCAPARTAMENTO = :USU_DCAPARTAMENTO";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':USU_DCTOKEN', $token, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DCAPARTAMENTO', $apartamento, PDO::PARAM_STR);
                $stmt->execute();

                echo json_encode(["success" => true, "token" => $token]);

                /*

                //--------------------LOG----------------------//
                $LOG_DCTIPO = "LOGIN";
                $LOG_DCMSG = "Usuário ".$user['USU_DCNOME']." logado com sucesso.";
                $LOG_DCUSUARIO = $user['USU_DCNOME'];
                $LOG_DCAPARTAMENTO = $user['USU_DCAPARTAMENTO'];
                $this->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO);
                //--------------------LOG----------------------//

                        echo '<meta http-equiv="refresh" content="0;url=../inicial/index.php">'; // Redireciona após login bem-sucedido
                        exit();
                */
             
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
                    echo json_encode(["success" => false, "message" => "Credenciais inválidas!"]);
                }
        } catch (PDOException $e) {  
            echo "Erro: " . $e->getMessage();
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{

    $apartamento = $_POST['username'];
    $password = $_POST['password'];
    
    $loginSystem = new LoginSystem();
    $result=$loginSystem->validateUser($apartamento, $password);       

}
 
?>
