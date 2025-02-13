<?php
	include_once "../../objects/objects.php";

class registerArtigo extends SITE_ADMIN
{
    public function insertArtigo($titulo, $ordem, $artigo, $metodo, $fileUrl)
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

            $tituloValid = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Se o artigo for encontrado 
            if (isset($tituloValid['INA_DCTITULO']) && $metodo == "insert") {
                echo "Já existe um artigo com o mesmo título."; 
                exit();
            } else 
                {
                    if($metodo == "insert")
                    {
                        $result = $this->insertArtigoInfo($titulo, $ordem, $artigo, $fileUrl);
                        
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
                            $result = $this->updateArtigoInfo($titulo, $ordem, $artigo);
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

    // Diretório de upload
    $uploadDir = 'uploads/';
    
    // Verifica se a pasta existe, se não, cria
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Verifica se o arquivo foi enviado
    if (!empty($_FILES['arquivo']['name'])) {
        $fileName = basename($_FILES['arquivo']['name']);
        $filePath = $uploadDir . $fileName;
    
        // Move o arquivo para a pasta de uploads
        if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $filePath)) {
            $fileUrl = $filePath;
        } else {
            $fileUrl = null;
        }
    } else {
        $fileUrl = null;
    }

    echo $fileUrl;
    exit();


    $titulo = $_POST['titulo'];
    $ordem = $_POST['ordem'];
    $artigo = $_POST['artigo'];   
    $metodo = $_POST['metodo']; 
 
     $registerArtigo = new registerArtigo();
     $registerArtigo->insertArtigo($titulo, $ordem, $artigo, $metodo, $fileUrl);
 }
 ?>