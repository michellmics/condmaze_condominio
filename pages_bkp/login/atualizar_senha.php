<?php
include_once "../../objects/objects.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $token = $_POST['token'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $siteAdmin = new SITE_ADMIN();

    if (!$siteAdmin->pdo) {
        $siteAdmin->conexao();
    }

    $sql = "SELECT USU_DCAPARTAMENTO FROM USU_USUARIO WHERE USU_DCREDEF_TOKEN = :USU_DCREDEF_TOKEN AND USU_DTREDEF_TOKEN_EXP > NOW()";
    $stmt = $siteAdmin->pdo->prepare($sql);
    $stmt->bindParam(':USU_DCREDEF_TOKEN', $token, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user['USU_DCAPARTAMENTO']) 
    {
        $sql = "UPDATE USU_USUARIO 
        SET 
        USU_DCSENHA = :USU_DCSENHA
        WHERE USU_DCAPARTAMENTO = :USU_DCAPARTAMENTO";

        $stmt = $siteAdmin->pdo->prepare($sql);
        $stmt->bindParam(':USU_DCSENHA', $password, PDO::PARAM_STR);
        $stmt->bindParam(':USU_DCAPARTAMENTO', $user['USU_DCAPARTAMENTO'], PDO::PARAM_STR);
        $stmt->execute();

        echo "Sua senha foi atualizada com sucesso. Clique <a href='https://parquedashortensias.codemaze.com.br/pages/login/'>aqui </a>para realizar o login.";
    }
    else
        {
            echo "Erro: Link inválido ou token expirado.";
        }
}
?>
