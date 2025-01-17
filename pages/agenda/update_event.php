<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); 
define('SESSION_TIMEOUT', 43200); // 30 minutos

if (!isset($_SESSION['user_id'])) 
{
  header("Location: https://www.prqdashortensias.com.br/index.php");
  exit();
}
    // Atualiza o timestamp da última atividade
$_SESSION['last_activity'] = time();

if (!isset($_SESSION['user_id'])) 
{
  header("Location: https://www.prqdashortensias.com.br/index.php");
  exit();
}

$blocoSession = $_SESSION['user_bloco'];
$apartamentoSession = $_SESSION['user_apartamento'];
$nomeSession =  ucwords($_SESSION['user_name']);
$usuariologado = $nomeSession." <b>BL</b> ".$blocoSession." <b>AP</b> ".$apartamentoSession;
$userid = $_SESSION['user_id'];

$data = json_decode(file_get_contents('php://input'), true);

include_once '../../../objetos.php'; // Carrega a classe de conexão e objetos

// Instancia a classe SITE_ADMIN e chama a função de conexão
$admin = new SITE_ADMIN();
$admin->conexao(); // Conecta ao banco de dados usando a configuração

// Sanitização dos dados recebidos
$id = $data['id'];
$inicio = $data['inicio'];
$fim = $data['fim'];

// Consulta SQL para atualizar o evento
$sql = "UPDATE eventos SET inicio = :inicio, fim = :fim WHERE id = :id";
$stmt = $admin->pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->bindParam(':inicio', $inicio, PDO::PARAM_STR);
$stmt->bindParam(':fim', $fim, PDO::PARAM_STR);
$stmt->execute();

// Verifica se a atualização foi bem-sucedida
if ($stmt->rowCount() > 0) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>
