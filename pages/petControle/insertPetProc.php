<?php
ini_set('display_errors', 1);  // Habilita a exibição de erros
error_reporting(E_ALL);        // Reporta todos os erros

include_once "../../objects/objects.php";

class registerPet extends SITE_ADMIN
{
    public function insertPet($idMorador, $nome, $raca, $tipo, $apartamento, $foto_path, $imageHash)
    {
        try {
            // Cria conexão com o banco de dados
            if (!$this->pdo) {
                $this->conexao();
            }

                $codigo = $this->insertPetInfo($idMorador, $nome, $raca, $tipo, $foto_path, $imageHash);
                
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
            echo "Erro ao cadastrar o Pet."; 
        } 
    }

    function getImageHashGD($imagePath) {
        $img = imagecreatefromjpeg($imagePath);  // Carrega a imagem
        $img = imagescale($img, 64, 64); // Redimensiona para 64x64 (ajustado para maior resolução)
        imagefilter($img, IMG_FILTER_GRAYSCALE); // Converte para tons de cinza
        
        $pixels = [];
        for ($y = 0; $y < 64; $y++) { // Aumentei o tamanho da imagem para 64x64
            for ($x = 0; $x < 64; $x++) {
                $rgb = imagecolorat($img, $x, $y);
                $gray = ($rgb >> 16) & 0xFF; // Pega o valor do vermelho (imagem em tons de cinza)
                $pixels[] = $gray;
            }
        }
    
        // Ordena os pixels e pega a mediana
        sort($pixels);
        $median = $pixels[count($pixels) / 2];
    
        // Debug: Verifica a mediana e os primeiros 10 valores dos pixels
        echo "Mediana: $median\n";
        echo "Primeiros 10 Pixels: " . implode(', ', array_slice($pixels, 0, 10)) . "\n";
    
        // Gera um hash baseado na mediana
        $hash = '';
        foreach ($pixels as $pixel) {
            $hash .= ($pixel >= $median) ? '1' : '0';
        }
    
        imagedestroy($img);
        return $hash;
    }
    
    
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Recebe os dados do formulário e os converte para maiúsculas
    $nome = strtoupper($_POST['nome']);
    $idMorador = strtoupper($_POST['idmorador']);
    $raca = strtoupper($_POST['raca']);
    $apartamento = $_POST['apartamento'];
    $tipo = $_POST['tipo'];

    // Processa a foto
    $foto = $_FILES['foto'];
    $extensao = pathinfo($foto['name'], PATHINFO_EXTENSION); 
    $codigo_unico = strtoupper(substr(uniqid(), -6));  // Gera um código único de 6 dígitos
    $foto_nome = $codigo_unico . '.' . $extensao;  // Define o nome do arquivo com a extensão
    $foto_path = "pets_img/$apartamento/$foto_nome";  // Caminho para salvar a foto
    
    // Verifica se o diretório do apartamento existe, se não, cria
    if (!is_dir("pets_img/$apartamento")) {
        mkdir("pets_img/$apartamento", 0777, true);  // Cria o diretório
    }

    // Verifica se o arquivo enviado é uma imagem
    $tipos_aceitos = ['jpeg', 'jpg', 'png', 'gif'];
    if (!in_array(strtolower($extensao), $tipos_aceitos)) {
        echo "Tipo de arquivo não permitido. Apenas imagens JPEG, PNG e GIF são aceitas.";
        exit;
    }

    // Carrega a imagem conforme sua extensão
    switch ($extensao) {
        case 'jpeg':
        case 'jpg':
            $imagem = imagecreatefromjpeg($foto['tmp_name']);
            break;
        case 'png':
            $imagem = imagecreatefrompng($foto['tmp_name']);
            break;
        case 'gif':
            $imagem = imagecreatefromgif($foto['tmp_name']);
            break;
        default:
            echo "Tipo de arquivo inválido.";
            exit;
    }

    // Obtém as dimensões originais da imagem
    $largura_original = imagesx($imagem);
    $altura_original = imagesy($imagem);

    // Calcula a nova altura mantendo a proporção
    $nova_largura = 500;
    $nova_altura = ($nova_largura / $largura_original) * $altura_original;

    // Cria uma nova imagem com a nova largura e altura
    $imagem_redimensionada = imagescale($imagem, $nova_largura, $nova_altura);



    // Salva a imagem redimensionada no diretório
    switch ($extensao) {
        case 'jpeg':
        case 'jpg':
            imagejpeg($imagem_redimensionada, $foto_path);
            break;
        case 'png':
            imagepng($imagem_redimensionada, $foto_path);
            break;
        case 'gif':
            imagegif($imagem_redimensionada, $foto_path);
            break;
    }

    // Libera a memória
    imagedestroy($imagem);
    imagedestroy($imagem_redimensionada);  

    // Se o upload e redimensionamento forem bem-sucedidos, insere as informações no banco
    $petAddInfo = new registerPet();
    $imageHash = $petAddInfo->getImageHashGD($foto_path);
    $petAddInfo->insertPet($idMorador, $nome, $raca, $tipo, $apartamento, $foto_path, $imageHash); 
}
?>
