<?php

include_once "../../objects/objects.php";

class registerVisitante extends SITE_ADMIN
{
    public function insertVisitante($documento, $nome, $userid, $status, $apartamento)
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

            //implementar verificacao se visitante ja existe e qtde maxima de visitantes.

            $result = $this->insertVisitListaInfo($nome, $userid, $documento, $status);

            //--------------------LOG----------------------//
            $LOG_DCTIPO = "CADASTRO DE VISITANTE";
            $LOG_DCMSG = "O visitante $nome foi cadastrado com sucesso.";
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
    $nome = $_POST['nome'];
    $userid = $_POST['userid'];
    $status = $_POST['status'];
    $apartamento = $_POST['apartamento'];

    echo $userid;
    exit;

 
     // Cria o objeto de registro de usuário e chama o método insertUser
     $registerVisitante = new registerVisitante();
     $registerVisitante->insertVisitante($documento, $nome, $userid, $status, $apartamento);
 }
 ?>