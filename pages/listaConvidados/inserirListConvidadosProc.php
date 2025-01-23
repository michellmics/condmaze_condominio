<?php

session_start(); 
define('SESSION_TIMEOUT', 43200); // 30 minutos

if (!isset($_SESSION['user_id'])) 
{
  header("Location: ../../index.html");
  exit();
}
// Atualiza o timestamp da última atividade
$_SESSION['last_activity'] = time();

if (!isset($_SESSION['user_id'])) 
{
  header("Location: ../../index.html");
  exit();
}

include_once "../../objects/objects.php";

class registerVisitante extends SITE_ADMIN
{
    public function insertVisitante($documento, $nome, $userid, $status)
    {
        try {
            // Cria conexão com o banco de dados
            if (!$this->pdo) {
                $this->conexao();
            }

            $this->getParameterInfo();

            foreach($this->ARRAY_PARAMETERINFO as $value)
            {
                if($value["CFG_DCPARAMETRO"] == "MAX_CONVIDADOS")
                {
                    $maxConvidados = $value["CFG_DCVALOR"];
                }
            } 

            $sql = "SELECT COUNT(*) as total FROM LIS_LISTACONVIDADOS WHERE USU_IDUSUARIO = $userid";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $total = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $nome = strtoupper($nome);
            $documento = strtoupper($documento);

            // Prepara a consulta SQL para verificar o usuário
            $sql = "SELECT LIS_IDLISTACONVIDADOS, USU_IDUSUARIO, LIS_DCNOME, LIS_DCDOCUMENTO FROM LIS_LISTACONVIDADOS WHERE LIS_DCNOME = :nome AND USU_IDUSUARIO = :userid";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Se o usuário for encontrado e a senha for válida
            if (isset($user['USU_IDUSUARIO'])) 
            {
                echo "Usuário já cadastrado."; 

            } else             
                {
                    if($maxConvidados <= $total['total'])
                    {
                        echo "São permitidos apenas $maxConvidados convidados por apartamento.";
                    }
                    else
                    {
                        $result = $this->insertVisitListaInfo($nome, $userid, $documento, $status);

                        //--------------------LOG----------------------//
                        $LOG_DCTIPO = "CADASTRO DE VISITANTE";
                        $LOG_DCMSG = "O visitante $nome foi cadastrado com sucesso.";
                        $LOG_DCUSUARIO = $_SESSION['user_id'];
                        $LOG_DCAPARTAMENTO = $_SESSION['user_apartamento'];
                        $this->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO);
                        //--------------------LOG----------------------//

                        echo "Convidado cadastrado com sucesso."; 
                    }              
                   
                }
        } catch (PDOException $e) {  
            echo "Erro ao cadastrar convidadoaaa."; 
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $documento = $_POST['documento'];
    $nome = $_POST['nome'];
    $userid = $_POST['userid'];
    $status = $_POST['status'];

 
     // Cria o objeto de registro de usuário e chama o método insertUser
     $registerVisitante = new registerVisitante();
     $registerVisitante->insertVisitante($documento, $nome, $userid, $status);
 }
 ?>