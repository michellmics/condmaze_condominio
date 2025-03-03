<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function forbiddenResponse() {
    http_response_code(403);
    die('Acesso não autorizado.');
}
if (!isset($_SESSION['csrf_token'])) {
    forbiddenResponse();
}

	include_once "../../objects/objects.php";

class deleteNotiObj extends SITE_ADMIN
{
    public function deleteNotificacoes($userid)
    {
        try {
                // Cria conexão com o banco de dados
                if (!$this->pdo) {
                    $this->conexao();
                }
               
                $result = $this->deleteNotificacoesbyUser($userid);
                return json_encode(["success" => true]);     
                
        } catch (PDOException $e) {  
            return json_encode(["error" => $e]);  
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents("php://input"), true);
    $userid = $data['userid'];

     $deleteNotificacoes = new deleteNotiObj();
     $result = $deleteNotificacoes->deleteNotificacoes($userid);
     echo $result;
 }
 ?> 