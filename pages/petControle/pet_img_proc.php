<?php
ini_set('display_errors', 1);  // Habilita a exibição de erros
error_reporting(E_ALL);        // Reporta todos os erros
include_once "../../objects/objects.php";

// Função para gerar o hash perceptual da imagem
function calculateColorHistogram($imagePath) {
    // Verifica se o arquivo existe
    if (!file_exists($imagePath)) {
        throw new Exception("Arquivo de imagem não encontrado.");
    }

    // Carrega a imagem conforme sua extensão
    $extensao = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
    switch ($extensao) {
        case 'jpeg':
        case 'jpg':
            $image = imagecreatefromjpeg($imagePath);
            break;
        case 'png':
            $image = imagecreatefrompng($imagePath);
            break;
        case 'gif':
            $image = imagecreatefromgif($imagePath);
            break;
        default:
            throw new Exception("Tipo de arquivo inválido.");
    }

    if (!$image) {
        throw new Exception("Falha ao carregar a imagem.");
    }

    $width = imagesx($image);
    $height = imagesy($image);
    $histogram = [];

    // Calcula o histograma de cores
    for ($x = 0; $x < $width; $x++) {
        for ($y = 0; $y < $height; $y++) {
            $rgb = imagecolorat($image, $x, $y);
            $colors = imagecolorsforindex($image, $rgb);
            $color = sprintf('%02X%02X%02X', $colors['red'], $colors['green'], $colors['blue']);
            $histogram[$color] = ($histogram[$color] ?? 0) + 1;
        }
    }

    imagedestroy($image);
    return json_encode($histogram); // Retorna o histograma como JSON
}

// Função para calcular a distância de Hamming entre dois hashes
function calculateChiSquaredDistance($histogram1, $histogram2) {
    // Converte os histogramas de JSON para arrays
    $histogram1 = json_decode($histogram1, true);
    $histogram2 = json_decode($histogram2, true);

    // Inicializa a soma da distância de Chi-Quadrado
    $distance = 0;

    // Junta todas as chaves dos dois histogramas
    $allKeys = array_unique(array_merge(array_keys($histogram1), array_keys($histogram2)));

    // Calcula a distância de Chi-Quadrado
    foreach ($allKeys as $key) {
        $h1 = isset($histogram1[$key]) ? $histogram1[$key] : 0;
        $h2 = isset($histogram2[$key]) ? $histogram2[$key] : 0;
        $distance += ($h1 - $h2) ** 2 / ($h1 + $h2 + 1e-6);  // Adiciona um pequeno valor para evitar divisão por zero
    }

    return $distance;
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

    // Cria um arquivo temporário para armazenar a imagem
    $tempImagePath = '/path/to/temp/directory/' . uniqid('image_', true) . '.' . $extensao;
    if (!move_uploaded_file($foto['tmp_name'], $tempImagePath)) {
        echo "Erro ao mover o arquivo para o diretório temporário.";
        exit;
    }

    // Chama a função passando o caminho do arquivo temporário
    try {
        $hash1 = calculateColorHistogram($tempImagePath);  // Gerando o hash perceptual da imagem recebida
    } catch (Exception $e) {
        echo "Erro ao processar a imagem: " . $e->getMessage();
        exit;
    }

    // Remove o arquivo temporário após o processamento
    unlink($tempImagePath);

    // Continuar com o processamento das imagens
    $imagensSemelhantes = [];

    foreach ($siteAdmin->ARRAY_HASHIMGINFO as $imgInfo) {
        $hash = $imgInfo['PEM_DCHASHBIN']; // O hash da imagem
        $distance = calculateChiSquaredDistance($hash1, $hash);  // Calcula a distância de Hamming

        // Ajuste o limiar conforme necessário
        if ($distance < 15) {  // Se a distância for menor que 35, considera como semelhante
            // Se a imagem for similar, adiciona as informações no array
            $imagensSemelhantes[] = [
                'nome' => $imgInfo['PEM_DCNOME'],
                'apartamento' => "194",  // Ajuste conforme necessário
                'tutor' => "TUTOR",  // Ajuste conforme necessário
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
            echo "<td style='cursor: pointer; vertical-align: middle;'>" . htmlspecialchars(strtoupper($imagem['raca']."-".$distance)) . "</td>";
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
}
?>
