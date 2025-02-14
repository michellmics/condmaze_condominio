<?php
ini_set('upload_max_filesize', '50M');
ini_set('post_max_size', '50M');
ini_set('memory_limit', '256M');
ini_set('max_execution_time', '300');

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
    $uploadDir = '/var/www/html/pages/instrucoesAdequacoes/uploads/';
    
    // Verifica se a pasta existe, se não, cria
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Define o limite de tamanho do arquivo (10MB)
    $maxFileSize = 10 * 1024 * 1024; // 10MB
    
    // Verifica se o arquivo foi enviado
    if (!empty($_FILES['arquivo']['name'])) {
        $fileName = basename($_FILES['arquivo']['name']);
        $filePath = $uploadDir . $fileName;
        $fileSize = $_FILES['arquivo']['size'];

            // Verifica se o arquivo excede o tamanho permitido
            if ($fileSize > $maxFileSize) {
                echo "Erro: O arquivo excede o limite de 10MB.";
                exit();
            }

            // Obtém o título do arquivo e remove os espaços
            $tituloFile = $_POST['titulo']; // Considerando que o título vem de um campo no formulário
            $tituloFormatado = str_replace(' ', '_', $tituloFile); // Substitui os espaços por underscores
            
            // Cria o nome do arquivo com o timestamp e o título formatado
            $timestamp = time(); // Obtém o timestamp atual
            $fileName = $timestamp . '_' . $tituloFormatado . '.' . pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION); // Adiciona a extensão do arquivo

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


    $titulo = $_POST['titulo'];
    $ordem = $_POST['ordem'];
    $artigo = $_POST['artigo'];   
    $metodo = $_POST['metodo']; 
 
     $registerArtigo = new registerArtigo();
     $registerArtigo->insertArtigo($titulo, $ordem, $artigo, $metodo, $fileUrl);
 }
 ?>