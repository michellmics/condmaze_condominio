<?php
include_once "../../objects/objects.php";
include_once "../../wideimage/WideImage.php";

class registerPet extends SITE_ADMIN
{
    // Função para inserir o pet no banco de dados
    public function insertPet($idMorador, $nome, $raca, $tipo, $apartamento, $foto_path, $cor)
    {
        try {
            if (!$this->pdo) {
                $this->conexao();
            }

            // Insere as informações do pet, incluindo o histograma de cores
            $codigo = $this->insertPetInfo($idMorador, $nome, $raca, $tipo, $foto_path, $cor);

            //--------------------LOG----------------------//
            $LOG_DCTIPO = "PET";
            $LOG_DCMSG = "Pet registrado no sistema para o apartamento $apartamento.";
            $LOG_DCUSUARIO = "MORADOR";
            $LOG_DCCODIGO = "N/A";
            $LOG_DCAPARTAMENTO = $apartamento;
            $this->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO, $LOG_DCCODIGO);
            //--------------------LOG----------------------//

            echo "Pet registrado com sucesso.";
        } catch (PDOException $e) {
            echo "Erro ao cadastrar o Pet: " . $e->getMessage();
        } catch (Exception $e) {
            echo "Erro ao processar a imagem: " . $e->getMessage();
        }
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário e os converte para maiúsculas
    $nome = strtoupper($_POST['nome']);
    $idMorador = $_POST['idmorador'];
    $raca = strtoupper($_POST['raca']);
    $apartamento = $_POST['apartamento'];
    if(isset($_POST['tipo'])){$tipo = $_POST['tipo'];}
    if(isset($_POST['cor'])){$cor = $_POST['cor'];}

    if(!$nome || !$raca || !$tipo || !$cor)
    {
        echo "Todos os campos devem ser preenchidos.";
        exit;
    }

    // Processa a foto
    $foto = $_FILES['foto'];
    $extensao = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
    $codigo_unico = strtoupper(substr(uniqid(), -6));  // Gera um código único de 6 dígitos
    $foto_nome = $codigo_unico . '.' . $extensao;  // Define o nome do arquivo com a extensão
    $foto_path = "pets_img/$apartamento/$foto_nome";  // Caminho para salvar a foto

    // Verifica se o diretório do apartamento existe, se não, cria
    if (!is_dir("pets_img/$apartamento")) {
        mkdir("pets_img/$apartamento", 0777, true);  // Cria o diretório
    }

    // Verifica se o arquivo enviado é uma imagem
    $tipos_aceitos = ['jpeg', 'jpg', 'png', 'gif'];
    if (!in_array($extensao, $tipos_aceitos)) {
        echo "Tipo de arquivo não permitido. Apenas imagens JPEG, PNG e GIF são aceitas.";
        exit;
    }

    // Move o arquivo para o diretório de destino
    if (!move_uploaded_file($foto['tmp_name'], $foto_path)) {
        echo "Erro ao mover o arquivo.";
        exit;
    }

   

    $image = new Imagick($foto_path);
    
    // Redimensiona mantendo a proporção
    $image->thumbnailImage(500, 0); // Define apenas a largura, mantendo a altura proporcional
    
    // Salva a imagem
    $image->writeImage($foto_path);
    
    // Libera a memória
    $image->clear();
    $image->destroy();

    // Calcula o histograma de cores e insere as informações no banco
    $petAddInfo = new registerPet();
     $petAddInfo->insertPet($idMorador, $nome, $raca, $tipo, $apartamento, $foto_path, $cor);
}
?>