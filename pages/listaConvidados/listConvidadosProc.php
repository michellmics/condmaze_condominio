<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function forbiddenResponse() {
    http_response_code(403);
    die('Acesso não autorizado.');
}
if (!isset($_SESSION['csrf_token'])) {
    forbiddenResponse();
}

include_once "../../objects/objects.php";

class registerVisitante extends SITE_ADMIN
{
    public function insertVisitante($documento, $nome, $userid, $status, $apartamento, $metodo, $idconvidado)
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

            $status = ($status == 'on') ? 'ATIVO' : 'INATIVO';
            //implementar verificacao se visitante ja existe e qtde maxima de visitantes.

            if($metodo == "insert")
            {
                $result = $this->insertVisitListaInfo($nome, $userid, $documento, $status);
                $LOG_DCMSG = "O visitante $nome foi cadastrado com sucesso.";
            }
            if($metodo == "update")
            {
                $result = $this->updateVisitListaInfo($nome, $documento, $status, $idconvidado);
                $LOG_DCMSG = "O visitante $nome foi atualizado com sucesso.";
            }

            //--------------------LOG----------------------//
            $LOG_DCTIPO = "CADASTRO DE VISITANTE";            
            $LOG_DCUSUARIO = $userid;
            $LOG_DCAPARTAMENTO = $apartamento;
            $this->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO);
            //--------------------LOG----------------------
            echo "Convidado cadastrado com sucesso.";                                  
                   
                
        } catch (PDOException $e) {  
            echo "Erro ao cadastrar convidado."; 
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $documento = $_POST['documento'];
    $nome = strtoupper($_POST['nome']);
    $userid = $_POST['userid'];
    $status = $_POST['status'] ?? 'INATIVO';
    $apartamento = $_POST['apartamento'];
    $metodo = $_POST['metodo']; 
    $idconvidado = $_POST['idconvidado'];

     // Cria o objeto de registro de usuário e chama o método insertUser
     $registerVisitante = new registerVisitante();
     $registerVisitante->insertVisitante($documento, $nome, $userid, $status, $apartamento, $metodo, $idconvidado);
 }
 ?>