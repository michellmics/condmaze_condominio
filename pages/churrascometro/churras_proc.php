<?php
ini_set('display_errors', 1);  // Habilita a exibição de erros
error_reporting(E_ALL);        // Reporta todos os erros
include_once "../../objects/objects.php";

$siteAdmin = new SITE_ADMIN();  

// Capturar os valores do formulário
$qtde_homens = $_POST['qtdehomem'] ?? 0;
$qtde_mulheres = $_POST['qtdemulher'] ?? 0;
$idmorador = $_POST['idmorador'] ?? 0;

$siteAdmin->insertChurrasEventoInfo($idmorador, $qtde_homens, $qtde_mulheres);



// Inserir os itens da lista
if (!empty($_POST['descricao'])) {
    for ($i = 0; $i < count($_POST['descricao']); $i++) {
        $descricao = $_POST['descricao'][$i];
        $carne = isset($_POST['carneCheckbox'][$i]) ? 1 : 0;
        $quantidade = $_POST['quantidade'][$i] ?? 0;
        $valor_unitario = $_POST['valorunitario'][$i] ?? 0;
        $valor_total = $_POST['valortotal'][$i] ?? 0;

        $siteAdmin->insertChurrasEventoItensInfo($idmorador, $descricao, $carne, $quantidade, $valor_unitario, $valor_total);

    }
}


?>
