<?php
ini_set('display_errors', 1);  // Habilita a exibição de erros
error_reporting(E_ALL);        // Reporta todos os erros
include_once "../../objects/objects.php";

function getImageHashGD($imageResource) {
    // Verifica a extensão da imagem
    $extensao = image_type_to_extension(exif_imagetype($imageResource), false);

    // Carrega a imagem conforme a extensão
    switch (strtolower($extensao)) {
        case 'jpeg':
        case 'jpg':
            $img = imagecreatefromjpeg($imageResource);
            break;
        case 'png':
            $img = imagecreatefrompng($imageResource);
            break;
        case 'gif':
            $img = imagecreatefromgif($imageResource);
            break;
        default:
            echo "Formato de imagem não suportado.\n";
            return null;
    }

    if (!$img) {
        echo "Erro ao carregar a imagem.\n";
        return null;
    }

    // Redimensiona e aplica a conversão para escala de cinza
    $img = imagescale($img, 64, 64);
    imagefilter($img, IMG_FILTER_GRAYSCALE);

    $pixels = [];
    for ($y = 0; $y < 64; $y++) {
        for ($x = 0; $x < 64; $x++) {
            $rgb = imagecolorat($img, $x, $y);
            $gray = ($rgb >> 16) & 0xFF;  // Intensidade de cinza
            $pixels[] = $gray;
        }
    }

    // Calcula a média dos pixels
    $avg = array_sum($pixels) / count($pixels);
    echo "Média: $avg\n";

    // Gera o hash comparando com a média
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
 
if (!$imagem) {
    echo "Erro ao carregar a imagem.";
    exit;
}
$hash1 = getImageHashGD($imagem);

$imagensSemelhantes = [];



foreach ($siteAdmin->ARRAY_HASHIMGINFO as $imgInfo) {
    $hash = $imgInfo['PEM_DCHASHBIN']; // O hash da imagem
    $distance = hammingDistance($hash1, $hash); 

    echo "Distância ". $imgInfo['PEM_DCNOME'] . " = " . $distance . "<br>"; 

    // Ajuste o limiar conforme necessário
    if ($distance < 20) { 
        // Se a imagem for similar, adiciona as informações no array
        $imagensSemelhantes[] = [
            'nome' => $imgInfo['PEM_DCNOME'],
            'apartamento' => "194",
            'tutor' => "TUTOR",
            'raca' => $imgInfo['PEM_DCRACA'],
            'img' => $imgInfo['PET_DCPATHFOTO']

        ];
    }
}



// Exibindo as imagens semelhantes encontradas
if (!empty($imagensSemelhantes)) {
    echo "<table id='basic-datatable' class='table table-striped dt-responsive nowrap w-100'>
            <thead>
                <tr>
                    <th>NOME</th>
                    <th>RAÇA</th>
                    <th>APTO</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>";
    foreach ($imagensSemelhantes as $imagem) {
        echo "<tr>";      
        echo "<td style='cursor: pointer; vertical-align: middle;'>" . htmlspecialchars(strtoupper($imagem['nome'])) . "</td>";
        echo "<td style='cursor: pointer; vertical-align: middle;'>" . htmlspecialchars(strtoupper($imagem['raca'])) . "</td>";
        echo "<td style='cursor: pointer; vertical-align: middle;'>" . htmlspecialchars(strtoupper($imagem['apartamento'])) . "</td>";
        echo "<td style='cursor: pointer; vertical-align: middle;'>
                <a class='pe-3' href='#' data-bs-toggle='modal' data-bs-target='#imagemModal' onclick='mostrarImagem(\"" . htmlspecialchars($imagem['img']) . "\")'>
                    <img src='" . htmlspecialchars($imagem['img']) . "' class='avatar-sm rounded-circle' alt='Imagem do pet'>
                </a>
              </td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
} else {
    echo "Nenhuma imagem semelhante encontrada.";
}


echo "</tbody></table>";



?>