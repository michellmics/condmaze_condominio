<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once "../../objects/objects.php";

session_start();
define('SESSION_TIMEOUT', 43200); // 12 horas

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

class LoginSystem extends SITE_ADMIN
{
    public function validateUser($apartamento, $password)
    {
        try {
            if (!$this->pdo) {
                $this->conexao();
            }

            // Prepara a consulta SQL para verificar o usuário
            $sql = "SELECT USU_IDUSUARIO, USU_DCSENHA, USU_DCEMAIL, USU_DCNOME, USU_DCNIVEL, USU_DCBLOCO, USU_DCAPARTAMENTO 
                    FROM USU_USUARIO WHERE USU_DCAPARTAMENTO = :apartamento";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':apartamento', $apartamento, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['USU_DCSENHA'])) {
                // Configura a sessão
                $_SESSION['user_id'] = $user['USU_IDUSUARIO'];
                $_SESSION['user_name'] = $user['USU_DCNOME'];
                $_SESSION['user_email'] = $user['USU_DCEMAIL'];
                $_SESSION['user_apartamento'] = $user['USU_DCAPARTAMENTO'];
                $_SESSION['user_bloco'] = $user['USU_DCBLOCO'];
                $_SESSION['user_nivelacesso'] = $user['USU_DCNIVEL'];
                $_SESSION['last_activity'] = time();

                // Gera o token
                $token = $this->gerarToken($user['USU_IDUSUARIO']);

                // Atualiza o token no banco
                $sql = "UPDATE USU_USUARIO SET USU_DCTOKEN = :USU_DCTOKEN WHERE USU_DCAPARTAMENTO = :USU_DCAPARTAMENTO";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':USU_DCTOKEN', $token, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DCAPARTAMENTO', $apartamento, PDO::PARAM_STR);
                $stmt->execute();

                // Log de sucesso
                $this->insertLogInfo("LOGIN", "Usuário {$user['USU_DCNOME']} logado com sucesso.", $user['USU_DCNOME'], $user['USU_DCAPARTAMENTO']);

                echo json_encode(["success" => true, "token" => $token]);
            } else {
                // Log de falha
                $this->insertLogInfo("LOGIN FAILED", "Usuário ou senha incorretos.", "N/A", $apartamento);

                $_SESSION = [];
                session_destroy();
                echo json_encode(["success" => false, "message" => "Credenciais inválidas!"]);
            }
        } catch (PDOException $e) {
            error_log("Erro no login: " . $e->getMessage());
            echo json_encode(["success" => false, "message" => "Erro no servidor. Tente novamente mais tarde."]);
        }
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $apartamento = $data['apartamento'] ?? null;
    $password = $data['senha'] ?? null;

    if (empty($apartamento) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Todos os campos são obrigatórios."]);
        exit;
    }

    $loginSystem = new LoginSystem();
    $result = $loginSystem->validateUser($apartamento, $password);
}
?>
