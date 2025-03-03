<?php
require "../../src/sessionStartShield.php";
include_once "../../objects/objects.php";

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id)) {
    $eventId = $data->id;
    
    // Instancia a classe SITE_ADMIN e chama a função de conexão
    $admin = new SITE_ADMIN();
    $admin->conexao(); // Conecta ao banco de dados usando a configuração

    // Deletar o evento
    $sql = "DELETE FROM eventos WHERE id = :id";
    $stmt = $admin->pdo->prepare($sql);
    $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
}
?>
