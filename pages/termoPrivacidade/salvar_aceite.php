<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $var1 = $_POST['userid'] ?? 'valor_padrao1'; 
    $var2 = $_POST['nomeSession'] ?? 'valor_padrao2';
    $var3 = $_POST['apartamentoSessio'] ?? 'valor_padrao3';

    // Simula salvamento no banco de dados
    $_SESSION['termo_aceito'] = true;
    $_SESSION['dados_termo'] = [
        'var1' => $var1,
        'var2' => $var2,
        'var3' => $var3
    ];

    echo json_encode(["status" => "sucesso", "mensagem" => "Aceite registrado com sucesso!", "dados" => $_SESSION['dados_termo']]);
    exit;
}
?>