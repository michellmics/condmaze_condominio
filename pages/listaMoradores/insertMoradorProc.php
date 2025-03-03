<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

	include_once "../../objects/objects.php";

class registerUser extends SITE_ADMIN
{
    public function insertUser($email, $senha, $nome, $bloco, $apartamento, $nivel, $telefone, $metodo)
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
            if (isset($user['USU_IDUSUARIO']) && $metodo == "insert") {
                echo "Apartamento já cadastrado."; 
                //exit();
            } else 
                {
                    if($metodo == "insert")
                    {
                        $passHash = password_hash($senha, PASSWORD_DEFAULT);
                        $result = $this->insertUserInfo($email, $nome, $bloco, $apartamento, $nivel, $passHash, $telefone);
                        
                     
                        //--------------------LOG----------------------//
                        $LOG_DCTIPO = "NOVO CADASTRO";
                        $LOG_DCMSG = "O morador $nome foi cadastrado com as credenciais de nível $nivel.";
                        $LOG_DCUSUARIO = $_SESSION['user_id'];
                        $LOG_DCAPARTAMENTO = $apartamento;
                        $this->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO);
                        //--------------------LOG----------------------//

                        echo "Morador cadastrado com sucesso."; 
                    }
                    if($metodo == "update")
                    {
                        if($senha == "")
                        {
                            $passHash = "IGNORE";
                            $result = $this->updateUserInfo($email, $nome, $bloco, $apartamento, $nivel, $passHash, $telefone);
                            echo "Morador atualizado com sucesso."; 
                        }
                        if($senha != "")
                        {
                            $passHash = password_hash($senha, PASSWORD_DEFAULT);
                            $result = $this->updateUserInfo($email, $nome, $bloco, $apartamento, $nivel, $passHash, $telefone);
                            echo "Morador atualizado com sucesso."; 
                        }

                        //--------------------LOG----------------------//
                        $LOG_DCTIPO = "UPDATE";
                        $LOG_DCMSG = "O morador $nome foi atualizado com sucesso.";
                        $LOG_DCUSUARIO = $_SESSION['user_id'];
                        $LOG_DCAPARTAMENTO = $apartamento;
                        $this->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO);
                        //--------------------LOG----------------------//
                    }
                    
                }
        } catch (PDOException $e) {  
            echo "Erro ao cadastrar usuário."; 
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Permite apenas requisições vindas do próprio servidor
    if ($_SERVER['REMOTE_ADDR'] !== $_SERVER['SERVER_ADDR']) {
        die('Acesso não autorizado.');
    }

    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $nome = $_POST['nome'];
    $bloco = $_POST['bloco'];
    $apartamento = $_POST['apartamento'];   
    
    if(!isset($_POST['nivel']))
    {
        $nivel = "MORADOR";
    }
    else
        {
            $nivel = $_POST['nivel'];
        }

    $telefone = $_POST['telefone'];
    $metodo = $_POST['metodo']; 
 
     // Cria o objeto de registro de usuário e chama o método insertUser
     $registerUser = new registerUser();
     $registerUser->insertUser($email, $senha, $nome, $bloco, $apartamento, $nivel, $telefone, $metodo);
 }
 ?>