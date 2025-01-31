<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $var1 = $_POST['var1'] ?? 'valor_padrao1';
    $var2 = $_POST['var2'] ?? 'valor_padrao2';
    $var3 = $_POST['var3'] ?? 'valor_padrao3';

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