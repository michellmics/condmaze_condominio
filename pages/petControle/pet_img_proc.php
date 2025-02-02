<?php
ini_set('display_errors', 1);  // Habilita a exibição de erros
error_reporting(E_ALL);        // Reporta todos os erros
include_once "../../objects/objects.php";

function getImageHashGD($imageResource) {
    $img = $imageResource; // Agora, usa o recurso de imagem diretamente
    $img = imagescale($img, 8, 8); // Redimensiona para 8x8
    imagefilter($img, IMG_FILTER_GRAYSCALE); // Converte para tons de cinza

    $pixels = [];
    for ($y = 0; $y < 8; $y++) {
        for ($x = 0; $x < 8; $x++) {
            $rgb = imagecolorat($img, $x, $y);
            $gray = ($rgb >> 16) & 0xFF; // Pega o valor do vermelho (imagem em tons de cinza)
            $pixels[] = $gray;
        }
    }

    $avg = array_sum($pixels) / count($pixels);
    $hash = '';
    foreach ($pixels as $pixel) {
        $hash .= ($pixel >= $avg) ? '1' : '0';
    }

    imagedestroy($img);
    return $hash;
}

function hammingDistance($hash1, $hash2) {
    return count(array_diff_assoc(str_split($hash1), str_split($hash2)));
}


// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {    
    
    // Recebe os dados do formulário e os converte para maiúsculas
    $foto = $_FILES['arquivo'];
    $tipo = $_POST['tipo'];
    $extensao = pathinfo($foto['name'], PATHINFO_EXTENSION); 

    $siteAdmin = new SITE_ADMIN();  
    $siteAdmin->getHashImgInfo($tipo);  

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


}

// Exemplo de comparação
$hash1 = getImageHashGD($imagem);

$imagensSemelhantes = [];

foreach ($siteAdmin->ARRAY_HASHIMGINFO as $imgInfo) {
    $hash = $imgInfo['PEM_DCHASHBIN']; // O hash da imagem
    $distance = hammingDistance($hash1, $hash);

    // Ajuste o limiar conforme necessário
    if ($distance < 20) {
        // Se a imagem for similar, adiciona as informações no array
        $imagensSemelhantes[] = [
            'nome' => $imgInfo['PEM_DCNOME'],
            'apartamento' => "APARTAMENTO",
            'tutor' => "TUTOR",
            'raca' => $imgInfo['PEM_DCRACA']
        ];
    }
}

// Exibindo as imagens semelhantes encontradas
if (!empty($imagensSemelhantes)) {
    foreach ($imagensSemelhantes as $imagem) {

        // Exibindo nome dentro de um <td> corretamente
        echo "<table><tr><th>NOME</th><th>RAÇA</th><th>TUTOR</th><th>APTO</th>";
        echo "<td style='cursor: pointer; vertical-align: middle;'>" . htmlspecialchars(strtoupper($imagem['nome'])) . "</td>";
        echo "<td style='cursor: pointer; vertical-align: middle;'>" . htmlspecialchars(strtoupper($imagem['raca'])) . "</td>";
        echo "<td style='cursor: pointer; vertical-align: middle;'>" . htmlspecialchars(strtoupper($imagem['tutor'])) . "</td>";
        echo "<td style='cursor: pointer; vertical-align: middle;'>" . htmlspecialchars(strtoupper($imagem['apartamento'])) . "</td>";
        echo "</tr></table>";
    }
} else {
    echo "Nenhuma imagem semelhante encontrada.";
}





?>