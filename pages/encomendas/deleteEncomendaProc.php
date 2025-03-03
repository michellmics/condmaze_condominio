<?php
require "../../src/sessionStartShield.php";
include_once "../../objects/objects.php";

class deleteEncomenda extends SITE_ADMIN
{
    public function deleteAvaliacao($id)
    {
        try {
                // Cria conexão com o banco de dados
                if (!$this->pdo) {
                    $this->conexao();
                }
               
                $result = $this->deleteEncomenda($id);
                echo "Encomenda excluída com sucesso.";      
                
        } catch (PDOException $e) {  
            echo "Erro ao excluir a avaliação."; 
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

     $deleteEncomenda = new deleteEncomenda();
     $deleteEncomenda->deleteEncomenda($id);
 }
 ?>