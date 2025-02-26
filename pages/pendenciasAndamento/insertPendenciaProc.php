<?php
ini_set('upload_max_filesize', '50M');
ini_set('post_max_size', '50M');
ini_set('memory_limit', '256M');
ini_set('max_execution_time', '300');

	include_once "../../objects/objects.php";

class registerPendencia extends SITE_ADMIN
{
    public function insertPend($titulo, $evol, $obs, $metodo, $id)
    {
        try {
            // Cria conexão com o banco de dados
            if (!$this->pdo) {
                $this->conexao();
            }

            // Prepara a consulta SQL para verificar o usuário
            $sql = "SELECT EPE_DCTITULO FROM EPE_EVOLUCAO_PENDENCIA WHERE EPE_DCTITULO = :EPE_DCTITULO";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':EPE_DCTITULO', $titulo, PDO::PARAM_STR);
            $stmt->execute();

            $tituloValid = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Se o artigo for encontrado 
            if (isset($tituloValid['EPE_DCTITULO']) && $metodo == "insert") {
                echo "Já existe uma pendência com o mesmo título."; 
                exit();
            } else 
                {
                    if($metodo == "insert")
                    {
                        $titulo = strtoupper($titulo);
                        $this->insertNotificacaoFront("Nova Pendência", $titulo, "TODOS");
                        $result = $this->insertPendenciaInfo($titulo, $evol, $obs);
                        
                        /*                      
                        //--------------------LOG----------------------//
                        $LOG_DCTIPO = "NOVO CADASTRO";
                        $LOG_DCMSG = "O usuário $nome foi cadastrado com sucesso com credenciais de $nivel.";
                        $LOG_DCUSUARIO = $_SESSION['user_id'];
                        $LOG_DCAPARTAMENTO = $apartamento;
                        $this->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO);
                        //--------------------LOG----------------------//
                        */  
                        echo "Pendência cadastrada com sucesso."; 
                    }
                    if($metodo == "update")
                    {
                            $result = $this->updatePendenciaInfo($titulo, $evol, $obs, $id);
                            $this->insertNotificacaoFront("Atualização Pendência", $titulo, "TODOS");
                            echo "Pendência atualizada com sucesso."; 
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
    $evol = $_POST['evol'];
    $obs = $_POST['obs'];   
    $metodo = $_POST['metodo']; 
    $id = $_POST['id']; 
 
     $registerPendencia = new registerPendencia();
     $registerPendencia->insertPend($titulo, $evol, $obs, $metodo, $id);
 }
 ?>