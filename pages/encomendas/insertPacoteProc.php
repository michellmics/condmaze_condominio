<?php

include_once "../../objects/objects.php";

class registerPacote extends SITE_ADMIN
{
    public function insertPacote($apartamento, $observacao)
    {
        try {
            // Cria conexão com o banco de dados
            if (!$this->pdo) {
                $this->conexao();
            }

            //implementar a validacao pra saber se existe o morador/ap
            $countMoradores = $this->getMoradoresByApInfo($apartamento);

            if(!isset($this->ARRAY_LISTAMORADORESINFO["USU_IDUSUARIO"]))
            {
                echo "Morador não encontrado no sistema. Verifique se está cadastrado."; 
            }
            else
            {
                $codigo = $this->insertPacoteInfo($this->ARRAY_LISTAMORADORESINFO["USU_IDUSUARIO"], $observacao);
                
                //--------------------LOG----------------------//
                $LOG_DCTIPO = "ENCOMENDA";
                $LOG_DCMSG = "Encomenda registrada no sistema para o apartamento $apartamento com código $codigo.";
                $LOG_DCUSUARIO = "PORTARIA";
                $LOG_DCCODIGO = $codigo;
                $LOG_DCAPARTAMENTO = $apartamento;
                $this->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO, $LOG_DCCODIGO);
                //--------------------LOG----------------------//
                
                echo "Pacote registrado com sucesso. Código $codigo";
            }
 
        } catch (PDOException $e) {  
            echo "Erro ao cadastrar pacote."; 
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $apartamento = $_POST['apartamento'];
    $observacao = strtoupper($_POST['observacao']);

     // Cria o objeto de registro de usuário e chama o método insertUser
     $registerPacote = new registerPacote();
     $registerPacote->insertPacote($apartamento, $observacao);
 }
 ?>