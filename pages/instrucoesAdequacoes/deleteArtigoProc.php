<?php
	include_once "../../objects/objects.php";

class deleteArtigoObj extends SITE_ADMIN
{
    public function deleteArtigo($id)
    {
        try {
                // Cria conexão com o banco de dados
                if (!$this->pdo) {
                    $this->conexao();
                }
               
                $result = $this->deleteArtigoInfo($id);
                echo "Artigo excluído com sucesso.";          
                
        } catch (PDOException $e) {  
            echo "Erro ao excluído a avaliação."; 
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

     $deleteArtigo = new deleteArtigoObj();
     $deleteArtigo->deleteArtigo($id);
 }
 ?>