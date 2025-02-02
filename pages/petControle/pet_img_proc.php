<?php
ini_set('display_errors', 1);  // Habilita a exibição de erros
error_reporting(E_ALL);        // Reporta todos os erros
include_once "../../objects/objects.php";

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {    
    // Recebe os dados do formulário e os converte para maiúsculas
    $raca = $_POST['raca'];
    $tipo = $_POST['tipo'];
    $cor = $_POST['cor'];


    $siteAdmin = new SITE_ADMIN();  
    $siteAdmin->getHashImgInfo($raca, $cor, $tipo);  

    foreach ($siteAdmin->ARRAY_HASHIMGINFO as $imgInfo) {
            $imgResult[] = [
                'nome' => $imgInfo['PEM_DCNOME'],
                'apartamento' => "194",  // Ajuste conforme necessário
                'tutor' => "TUTOR",  // Ajuste conforme necessário
                'raca' => $imgInfo['PEM_DCRACA'],
                'img' => $imgInfo['PET_DCPATHFOTO'],
                'tipo' => $imgInfo['PEM_DCTIPO']
            ];            
    }

    // Exibindo as imagens semelhantes encontradas
    if (!empty($imgResult)) {
        echo "<table id='basic-datatable' class='table table-striped table-sm dt-responsive nowrap w-100'>
                <thead>
                    <tr>
                        <th></th>
                        <th>NOME</th>
                        <th>RAÇA</th>
                        <th>APTO</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>";
        foreach ($imgResult as $imagem) {
            
            if($imagem['tipo'] == "GATO"){$iconPet = "fa-solid fa-cat";}
            if($imagem['tipo'] == "CAO"){$iconPet = "fa-solid fa-dog";}
            if($imagem['tipo'] == "PASSARO"){$iconPet = "fa-solid fa-dove";}
            
        


            echo "<tr>";  
            echo "<td style='vertical-align: middle;'><i class='{$iconPet}' style='color:rgb(2, 133, 255); font-size: 18px;'></i></td>";  
            echo "<td style='cursor: pointer; vertical-align: middle; font-size: 10px;'>" . htmlspecialchars(substr(strtoupper($imagem['nome']),0,13)) . "</td>";
            echo "<td style='cursor: pointer; vertical-align: middle; font-size: 10px;'>" . htmlspecialchars(substr(strtoupper($imagem['raca']),0,13)) . "</td>";
            echo "<td style='cursor: pointer; vertical-align: middle; font-size: 10px;'>" . htmlspecialchars(strtoupper($imagem['apartamento'])) . "</td>";
            echo "<td style='cursor: pointer; vertical-align: middle;'>
                    <a class='pe-3' href='#' data-bs-toggle='modal' data-bs-target='#imagemModal' onclick='mostrarImagem(\"" . htmlspecialchars($imagem['img']) . "\")'>
                        <img src='" . htmlspecialchars($imagem['img']) . "' class='avatar-sm rounded-circle' alt='Imagem do pet'>
                    </a>
                  </td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "Nenhuma pet encontrado.";
    }
}
?>
