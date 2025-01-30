<?php
    ini_set('display_errors', 1);  // Habilita a exibição de erros
    error_reporting(E_ALL);        // Reporta todos os erros
	include_once "../../objects/objects.php";

class deleteReport extends SITE_ADMIN
{
    public function deleteReportFunc($mes, $ano)
    {
        try {
                // Cria conexão com o banco de dados
                if (!$this->pdo) {
                    $this->conexao();
                }
               
                $result = $this->deleteReport($mes, $ano);
                echo "Relatório excluído com sucesso.";      
                
        } catch (PDOException $e) {  
            echo "Erro ao excluir o relatório."; 
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mes = $_POST['mes'];
    $ano = $_POST['ano'];

     $deleteReport = new deleteReport();
     $deleteReport->deleteReportFunc($mes, $ano);
 }
 ?>