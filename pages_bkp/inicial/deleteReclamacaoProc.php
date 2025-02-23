<?php
	include_once "../../objects/objects.php";

class deleteReclamacaoObj extends SITE_ADMIN
{
    public function deleteReclamacao($id)
    {
        try {
                // Cria conexão com o banco de dados
                if (!$this->pdo) {
                    $this->conexao();
                }
               
                $result = $this->deleteReclamacaoInfo($id);
                echo "Reclamação excluída com sucesso.";          
                
        } catch (PDOException $e) {  
            echo "Erro ao excluír a reclamação."; 
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

     $deleteReclamacao = new deleteReclamacaoObj();
     $deleteReclamacao->deleteReclamacao($id);
 }
 ?>