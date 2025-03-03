<?php
require "../../src/sessionStartShield.php";
include_once "../../objects/objects.php";

class deletePrestador extends SITE_ADMIN
{
    public function deletePrestadorServ($id)
    {
        try {
                // Cria conexão com o banco de dados
                if (!$this->pdo) {
                    $this->conexao();
                }
               
                $result = $this->deletePrestadorInfo($id);
                echo "Prestador de Serviço excluído com sucesso.";          
                
        } catch (PDOException $e) {  
            echo "Erro ao excluir o Prestador de Serviço."; 
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

     $deletePrestador = new deletePrestador();
     $deletePrestador->deletePrestadorServ($id);
 }
 ?>