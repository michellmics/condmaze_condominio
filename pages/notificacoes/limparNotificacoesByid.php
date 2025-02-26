<?php
	include_once "../../objects/objects.php";

class deleteNotiObj extends SITE_ADMIN
{
    public function deleteNotificacoes($id)
    {
        try {
                // Cria conexão com o banco de dados
                if (!$this->pdo) {
                    $this->conexao();
                }
               
                $result = $this->deleteNotificacoesbyId($id);
                echo "Notificação excluída com sucesso.";      
                
        } catch (PDOException $e) {  
            echo "Erro ao excluir a notificação."; 
        } 
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = isset($_POST['id']) ? intval($_POST['id']) : null;    

     $deleteNotificacoes = new deleteNotiObj();
     $deleteNotificacoes->deleteNotificacoes($id);
 }
 ?>