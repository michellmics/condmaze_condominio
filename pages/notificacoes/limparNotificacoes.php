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
                echo json_encode(["success" => true]);     
                
        } catch (PDOException $e) {  
            echo json_encode(["error" => true]);  
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userid = $_POST['userid'];

     $deleteNotificacoes = new deleteNotiObj();
     $deleteNotificacoes->deleteNotificacoes($userid);
 }
 ?>