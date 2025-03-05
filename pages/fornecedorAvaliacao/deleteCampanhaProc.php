<?php
require "../../src/sessionStartShield.php";
include_once "../../objects/objects.php";

class deleteCampanha extends SITE_ADMIN
{
    public function deletePub($id)
    {
        try {
                // Cria conexão com o banco de dados
                if (!$this->pdo) {
                    $this->conexao();
                }
               
                $result = $this->deleteCampanhaPub($id);
                echo "Campanha excluída com sucesso.";      
                
        } catch (PDOException $e) {  
            echo "Erro ao excluir a campanha."; 
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

     $deletePubCamp = new deleteCampanha();
     $deletePubCamp->deletePub($id);
 }
 ?>