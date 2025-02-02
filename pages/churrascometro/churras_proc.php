<?php

// Capturar os valores do formulário
$qtde_homens = $_POST['qtdehomem'] ?? 0;
$qtde_mulheres = $_POST['qtdemulher'] ?? 0;
$carne_necessaria = $_POST['carnenecessaria'] ?? 0;
$carne_calculada = $_POST['carnecalculada'] ?? 0;
$custo_total = $_POST['custototal'] ?? 0;
$custo_por_pessoa = $_POST['custoporpessoa'] ?? 0;

var_dump($qtde_homens);
die();

// Inserir os itens da lista
if (!empty($_POST['descricao'])) {
    for ($i = 0; $i < count($_POST['descricao']); $i++) {
        $descricao = $_POST['descricao'][$i];
        $carne = isset($_POST['carneCheckbox'][$i]) ? 1 : 0;
        $quantidade = $_POST['quantidade'][$i] ?? 0;
        $valor_unitario = $_POST['valorunitario'][$i] ?? 0;
        $valor_total = $_POST['valortotal'][$i] ?? 0;

    }
}


?>
