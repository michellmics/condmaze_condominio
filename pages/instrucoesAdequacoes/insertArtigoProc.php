<?php
	include_once "../../objects/objects.php";

class registerArtigo extends SITE_ADMIN
{
    public function insertUser($titulo, $ordem, $artigo, $metodo)
    {
        try {
            // Cria conexão com o banco de dados
            if (!$this->pdo) {
                $this->conexao();
            }

            // Prepara a consulta SQL para verificar o usuário
            $sql = "SELECT INA_DCTITULO FROM INA_INSTRUCOES_ADEQUACOES WHERE INA_DCTITULO = :INA_DCTITULO";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':INA_DCTITULO', $titulo, PDO::PARAM_STR);
            $stmt->execute();

            $titulo = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Se o artigo for encontrado 
            if (isset($titulo['INA_DCTITULO']) && $metodo == "insert") {
                echo "Já existe um artigo com o mesmo título."; 
                exit();
            } else 
                {
                    if($metodo == "insert")
                    {
                        $passHash = password_hash($senha, PASSWORD_DEFAULT);
                        $result = $this->insertUserInfo($email, $nome, $bloco, $apartamento, $nivel, $passHash, $telefone);
                        
                        /*                     
                        //--------------------LOG----------------------//
                        $LOG_DCTIPO = "NOVO CADASTRO";
                        $LOG_DCMSG = "O usuário $nome foi cadastrado com sucesso com credenciais de $nivel.";
                        $LOG_DCUSUARIO = $_SESSION['user_id'];
                        $LOG_DCAPARTAMENTO = $apartamento;
                        $this->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO);
                        //--------------------LOG----------------------//
                        */  
                        echo "Artigo cadastrado com sucesso."; 
                    }
                    if($metodo == "update")
                    {
                            $result = $this->updateUserInfo($email, $nome, $bloco, $apartamento, $nivel, $passHash, $telefone);
                            echo "Morador atualizado com sucesso."; 
                    }
                    
                }
        } catch (PDOException $e) {  
            echo "Erro ao cadastrar o artigo."; 
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $ordem = $_POST['ordem'];
    $artigo = $_POST['artigo'];   
    $metodo = $_POST['metodo']; 
 
     $registerArtigo = new registerArtigo();
     $registerArtigo->insertArtigo($titulo, $ordem, $artigo, $metodo);
 }
 ?>