<?php
$data = json_decode(file_get_contents('php://input'), true);

include_once "../../objects/objects.php";

// Instancia a classe SITE_ADMIN e chama a função de conexão
$admin = new SITE_ADMIN();
$admin->conexao(); // Conecta ao banco de dados usando a configuração

// Sanitização dos dados recebidos
$id = $data['id'];
$titulo = $data['titulo'];
$inicio = $data['inicio'];
$fim = $data['fim'];
$categoria = $data['categoria'];

var_dump($data);
die();

// As datas já estão no formato correto vindo do JavaScript, então não é necessário mais ajustes
// Consulta SQL para atualizar o evento
$sql = "UPDATE eventos SET inicio = :inicio, fim = :fim, titulo = :titulo, categoria = :categoria WHERE id = :id";
$stmt = $admin->pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->bindParam(':inicio', $inicio, PDO::PARAM_STR);
$stmt->bindParam(':fim', $fim, PDO::PARAM_STR);
$stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
$stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
$stmt->execute();

// Verifica se a atualização foi bem-sucedida
if ($stmt->rowCount() > 0) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>
