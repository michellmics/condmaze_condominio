<?php
require "../../src/sessionStartShield.php";
include_once "../../objects/objects.php";

class deletePendenciaObj extends SITE_ADMIN
{
    public function deletePendencia($id)
    {
        try {
                // Cria conexão com o banco de dados
                if (!$this->pdo) {
                    $this->conexao();
                }
               
                $result = $this->deletePendenciaInfo($id);
                echo "Pendência excluída com sucesso.";          
                
        } catch (PDOException $e) {  
            echo "Erro ao excluír a pendência."; 
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

     $deletePendencia = new deletePendenciaObj();
     $deletePendencia->deletePendencia($id);
 }
 ?>