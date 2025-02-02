<?php
    ini_set('display_errors', 1);  // Habilita a exibição de erros
    error_reporting(E_ALL);        // Reporta todos os erros
	include_once "../../objects/objects.php";

class deleteAvaliacao extends SITE_ADMIN
{
    public function deleteAvaliacao($id)
    {
        try {
                // Cria conexão com o banco de dados
                if (!$this->pdo) {
                    $this->conexao();
                }
               
                $result = $this->deleteAvaliacaoPrestadorInfo($id);
                echo "Avaliação excluída com sucesso.";          
                
        } catch (PDOException $e) {  
            echo "Erro ao excluir a avaliação."; 
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

     $deleteAvaliacao = new deleteAvaliacao();
     $deleteAvaliacao->deleteAvaliacao($id);
 }
 ?>