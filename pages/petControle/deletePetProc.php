<?php
    ini_set('display_errors', 1);  // Habilita a exibição de erros
    error_reporting(E_ALL);        // Reporta todos os erros
	include_once "../../objects/objects.php";

class deletePetMorador extends SITE_ADMIN
{
    public function deletePetbd($id)
    {
        try {
                // Cria conexão com o banco de dados
                if (!$this->pdo) {
                    $this->conexao();
                }
               
                $result = $this->deletePetInfo($id);
                echo "Pet excluído com sucesso. id: $id";          
                
        } catch (PDOException $e) {  
            echo "Erro ao excluir o Pet."; 
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

     $deletePet = new deletePetMorador();
     $deletePet->deletePetbd($id);
 }
 ?>