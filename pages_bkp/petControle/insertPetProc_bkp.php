<?php
include_once "../../objects/objects.php";

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

    // Redimensiona a imagem
    list($largura_original, $altura_original) = getimagesize($foto_path);
    $nova_largura = 500;
    $nova_altura = intval(($nova_largura / $largura_original) * $altura_original);

    $imagem_redimensionada = imagecreatetruecolor($nova_largura, $nova_altura);
    $imagem_original = imagecreatefromstring(file_get_contents($foto_path));
    imagecopyresampled($imagem_redimensionada, $imagem_original, 0, 0, 0, 0, $nova_largura, $nova_altura, $largura_original, $altura_original);

    // Salva a imagem redimensionada
    switch ($extensao) {
        case 'jpeg':
        case 'jpg':
            imagejpeg($imagem_redimensionada, $foto_path, 90); // 90% de qualidade
            break;
        case 'png':
            imagepng($imagem_redimensionada, $foto_path, 9); // 9 é o nível de compressão (0-9)
            break;
        case 'gif':
            imagegif($imagem_redimensionada, $foto_path);
            break;
    }

    // Libera a memória
    imagedestroy($imagem_original);
    imagedestroy($imagem_redimensionada);

    // Calcula o histograma de cores e insere as informações no banco
    $petAddInfo = new registerPet();
     $petAddInfo->insertPet($idMorador, $nome, $raca, $tipo, $apartamento, $foto_path, $cor);
}
?>