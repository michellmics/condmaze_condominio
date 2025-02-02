<?php
ini_set('display_errors', 1);  // Habilita a exibição de erros
error_reporting(E_ALL);        // Reporta todos os erros

function getImageHashGD($imagePath) {
    $img = imagecreatefromjpeg($imagePath);
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

// Exemplo de comparação
$hash1 = getImageHashGD('foto3.jpg');
$hash2 = getImageHashGD('foto4.jpg');

$distance = hammingDistance($hash1, $hash2);
if ($distance < 10) { // Ajuste o limiar conforme necessário
    echo "Imagens semelhantes!";
} else {
    echo "Imagens diferentes!";
}



?>