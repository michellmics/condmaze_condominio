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

include_once '../../../objetos.php'; // Carrega a classe de conexão e objetos

// Instancia a classe SITE_ADMIN e chama a função de conexão
$admin = new SITE_ADMIN();
$admin->conexao(); // Conecta ao banco de dados usando a configuração

// Recebe os dados enviados via POST
$data = json_decode(file_get_contents('php://input'), true);

// Verifique se os dados foram recebidos corretamente
if (!$data || !isset($data['titulo'], $data['inicio'], $data['fim'])) {
    echo json_encode(['status' => 'error', 'message' => 'Dados incompletos']);
    exit;
}

// Escapa os dados para evitar injeção de SQL
$titulo = $data['titulo'];
$inicio = $data['inicio'];
$fim = $data['fim'];

// Prepara a consulta SQL com parâmetros
$sql = "INSERT INTO eventos (titulo, inicio, fim) VALUES (:titulo, :inicio, :fim)";
$stmt = $admin->pdo->prepare($sql);

// Vincula os parâmetros à consulta
$stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
$stmt->bindParam(':inicio', $inicio, PDO::PARAM_STR);
$stmt->bindParam(':fim', $fim, PDO::PARAM_STR);

try {
    // Executa a consulta
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        // Caso a execução falhe, capturamos o erro
        echo json_encode(['status' => 'error', 'message' => 'Falha na execução da consulta']);
    }
} catch (PDOException $e) {
    // Exibe o erro se ocorrer uma exceção
    echo json_encode(['status' => 'error', 'message' => 'Erro no banco de dados: ' . $e->getMessage()]);
}
?>
