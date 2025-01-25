<?php
include_once '../objetos.php'; // Carrega a classe de conexão e objetos

session_start(); 
define('SESSION_TIMEOUT', 43200); // 30 minutos

if (!isset($_SESSION['user_id'])) 
{
  header("Location: https://www.prqdashortensias.com.br/index.php");
  exit();
}
	// Atualiza o timestamp da última atividade
	$_SESSION['last_activity'] = time();

	if (!isset($_SESSION['user_id'])) 
	{
	  header("Location: https://www.prqdashortensias.com.br/index.php");
	  exit();
	}

class registerUser extends SITE_ADMIN
{
    public function insertUser($email, $senha, $nome, $bloco, $apartamento, $nivel)
    {
        try {
            // Cria conexão com o banco de dados
            if (!$this->pdo) {
                $this->conexao();
            }

            $nome = strtoupper($nome);
            $email = strtoupper($email);

            // Prepara a consulta SQL para verificar o usuário
            $sql = "SELECT USU_IDUSUARIO, USU_DCSENHA, USU_DCEMAIL, USU_DCAPARTAMENTO FROM USU_USUARIO WHERE USU_DCAPARTAMENTO = :apartamento";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':apartamento', $apartamento, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Se o usuário for encontrado e a senha for válida
            if (isset($user['USU_IDUSUARIO'])) {
                echo "Apartamento já cadastrado."; 
                //exit();
            } else 
                {
                    $passHash = password_hash($senha, PASSWORD_DEFAULT);
                    $result = $this->insertUserInfo($email, $nome, $bloco, $apartamento, $nivel, $passHash);
                    
                    $SUBJECT = "Cadastro de novo usuário";
                    $MSG = "O morador(a) $nome com e-mail $email foi cadastrado no sistema do Condomínio Parque das Hortências.";
                    $this->notifyEmail($SUBJECT, $MSG); //notificação por email

                    $SUBJECT = "Seja Bem vindo(a) ao Condomínio Parque das Hortênsias";
                    $MSG = "Olá $nome, você foi cadastrado(a) no sistema do Condomínio Parque das Hortênsias. Seu usuário é seu e-mail e sua senha é: $senha. Para entrar no sistema acesse: https://www.prqdashortensias.com.br/";
                    $this->notifyUsuarioEmail($SUBJECT, $MSG, $email); //notificação por email

                    //--------------------LOG----------------------//
                    $LOG_DCTIPO = "NOVO CADASTRO";
                    $LOG_DCMSG = "O usuário $nome foi cadastrado com sucesso com credenciais de $nivel.";
                    $LOG_DCUSUARIO = $_SESSION['user_id'];
                    $LOG_DCAPARTAMENTO = $apartamento;
                    $this->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO);
                    //--------------------LOG----------------------//

                    echo "Usuário cadastrado com sucesso."; 
                    
                }
        } catch (PDOException $e) {  
            echo "Erro ao cadastrar usuário."; 
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $nome = $_POST['nome'];
    $bloco = $_POST['bloco'];
    $apartamento = $_POST['apartamento'];
    $nivel = $_POST['nivel'];
 
     // Cria o objeto de registro de usuário e chama o método insertUser
     $registerUser = new registerUser();
     $registerUser->insertUser($email, $senha, $nome, $bloco, $apartamento, $nivel);
 }
 ?>