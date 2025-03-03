<?php
require "../../src/sessionStartShield.php";
include_once "../../objects/objects.php";

class registerAvaliacao extends SITE_ADMIN
{
    public function insertAvaliacao($idprestador, $comentario, $nota, $idmorador)
    {
        try {
                // Cria conexão com o banco de dados
                if (!$this->pdo) {
                    $this->conexao();
                }

                // Prepara a consulta SQL para verificar o usuário
                $sql = "SELECT APS_NMNOTA FROM APS_AVALIACAO_PRESTADOR WHERE USU_IDUSUARIO = :idmorador AND PDS_IDPRESTADOR_SERVICO = :idprestador";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':idmorador', $idmorador, PDO::PARAM_STR);
                $stmt->bindParam(':idprestador', $idprestador, PDO::PARAM_STR);
                $stmt->execute();

                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                // Se o usuário for encontrado e a senha for válida
                if (isset($user['APS_NMNOTA'])) {
                    echo "Você já avaliou este prestador de serviço."; 
                    //exit();
                } else 
                    {                  
                        $result = $this->insertAvaliacaoPrestadorInfo($idprestador, $comentario, $nota, $idmorador);
                        $this->insertNotificacaoFront("Nova Aval. Prestador", $comentario, "TODOS");
                        echo "Avaliação cadastrada com sucesso."; 

                    }                    
                
        } catch (PDOException $e) {  
            echo "Erro ao cadastrar avaliação."; 
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idprestador = $_POST['idprestador'];
    $comentario = $_POST['comentario'];
    $nota = $_POST['nota']; 
    $idmorador = $_POST['idmorador'];
 
     // Cria o objeto de registro de usuário e chama o método insertUser
     $registerAvaliacao = new registerAvaliacao();
     $registerAvaliacao->insertAvaliacao($idprestador, $comentario, $nota, $idmorador);
 }
 ?>