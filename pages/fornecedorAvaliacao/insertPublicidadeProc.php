<?php
include_once "../../objects/objects.php";
//require "../../src/sessionStartShield.php";

class registePublicidade extends SITE_ADMIN
{
    public function insertPub($categoria, $nomeprestador, $campanha, $datapubini, $datapubfim, $ordem, $url, $hexcolorbg, $observacoes, $nomeImg)
    {
        try {
            // Cria conexão com o banco de dados
            if (!$this->pdo) {
                $this->conexao();
            }

            $metodo = "insert";

            if($metodo == "insert")
            {
                $result = $this->insertPublicidadeInfo($categoria, $nomeprestador, $campanha, $datapubini, $datapubfim, $ordem, $url, $hexcolorbg, $observacoes, $nomeImg);
                $LOG_DCMSG = "A publicidade foi cadastrada com sucesso.";
            }

            //--------------------LOG----------------------//
            $LOG_DCTIPO = "CADASTRO DE PUBLICIDADE";            
            $LOG_DCUSUARIO = "SISTEMA";
            $LOG_DCAPARTAMENTO = "N/A";
            $this->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO);
            //--------------------LOG----------------------//

            return true; // Se inserido com sucesso

        } catch (PDOException $e) {  
            return false; // Se houver erro
        } 
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta os dados do formulário
    $categoria = $_POST['categoria'];
    $nomeprestador = $_POST['nomeprestador'];
    $campanha = $_POST['campanha'];
    $datapubini = $_POST['datapubini'];
    $datapubfim = $_POST['datapubfim'];
    $imagem = $_FILES['imagem'];
    $ordem = $_POST['ordem'];
    $url = $_POST['url'];
    $hexcolorbg = $_POST['hexcolorbg'];
    $observacoes = $_POST['observacoes']; 


    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
    
        $imagem = $_FILES['imagem'];
        $nomeArquivoOriginal = $imagem['name'];
        $extensao = pathinfo($nomeArquivoOriginal, PATHINFO_EXTENSION); // Obtém a extensão do arquivo
    
        // Cria o nome do arquivo com timestamp
        $nomeImg = time() . '.' . $extensao; // Usando timestamp para renomear a imagem
    
        // Diretório de destino
        $diretorioDestino = "../../publicidade/";

        // Caminho completo onde o arquivo será movido
        $caminhoDestino = $diretorioDestino . $nomeImg;
    
        // Verifica se o diretório de destino existe
        if (!is_dir($diretorioDestino)) {
            mkdir($diretorioDestino, 0777, true); // Cria o diretório se não existir
        }
    
        // Move o arquivo para o diretório de destino
        if (move_uploaded_file($imagem['tmp_name'], $caminhoDestino)) { 
            // Se foi salva a imagem com sucesso.

            // Cria o objeto de registro de publicidade
            $registerPub = new registePublicidade();
            $insertSuccess = $registerPub->insertPub($categoria, $nomeprestador, $campanha, $datapubini, $datapubfim, $ordem, $url, $hexcolorbg, $observacoes, $nomeImg);

            if ($insertSuccess) {
                $response = array("success" => true, "message" => "Publicidade cadastrada com sucesso.");
            } else {
                $response = array("success" => false, "message" => "Erro ao cadastrar a publicidade.");
            }

        } else {
            // Se ocorrer algum erro ao mover a imagem
            $response = array("success" => false, "message" => "Erro ao mover a imagem.");
        }
    } else {
        // Se a imagem não foi enviada ou ocorreu um erro
        $response = array("success" => false, "message" => "Erro ao enviar a imagem.");
    }

    // Retorna a resposta como JSON
    echo json_encode($response);
}
?>
