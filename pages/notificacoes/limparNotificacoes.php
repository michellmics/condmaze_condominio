<?php
	include_once "../../objects/objects.php";

class deleteNotiObj extends SITE_ADMIN
{
    public function deleteNotificacoes($userid)
    {
        try {
                // Cria conexão com o banco de dados
                if (!$this->pdo) {
                    $this->conexao();
                }
               
                $result = $this->deleteNotificacoesbyUser($userid);
                return json_encode(["success" => true]);     
                
        } catch (PDOException $e) {  
            return json_encode(["error" => $e]);  
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userid = $_POST['userid'];

     $deleteNotificacoes = new deleteNotiObj();
     $result = $deleteNotificacoes->deleteNotificacoes($userid);
     echo $result;

 }
 ?> 