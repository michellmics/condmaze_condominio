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

            if(count($this->ARRAY_LISTAMORADORESINFO) == 0)
            {
                echo "Morador não encontrado no sistema. Verifique se está cadastrado."; 
            }
            else
            {
                $result = $this->insertPacoteInfo($this->ARRAY_LISTAMORADORESINFO["USU_IDUSUARIO"], $observacao);
                echo "Pacote cadastrado com sucesso."; 
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