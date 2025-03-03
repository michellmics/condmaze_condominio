<?php
require "../../src/sessionStartShield.php";
include_once "../../objects/objects.php";

class registerEmpresa extends SITE_ADMIN
{
    public function insertEmpresa($nome, $categoria, $telefone, $cidade)
    {
        try {
                // Cria conexão com o banco de dados
                if (!$this->pdo) {
                    $this->conexao();
                }

                // Prepara a consulta SQL para verificar o usuário
                $sql = "SELECT PDS_DCNOME FROM PDS_PRESTADORE_SERVICO WHERE PDS_DCNOME = :nome";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);

                $stmt->execute();

                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                // Se o usuário for encontrado e a senha for válida
                if (isset($user['PDS_DCNOME'])) {
                    echo "Prestador de serviço já cadastrado."; 
                    //exit();
                } else 
                    {                  
                        $result = $this->insertEmpresaPrestadorInfo($nome, $categoria, $telefone, $cidade);
                        $this->insertNotificacaoFront("Novo Prestador", $nome, "TODOS");
                        echo "Prestador de serviço cadastrado com sucesso."; 

                    }                    
                
        } catch (PDOException $e) {  
            echo "Erro ao cadastrar avaliação."; 
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $categoria = $_POST['categoria'];
    $telefone = $_POST['telefone']; 
    $cidade = $_POST['cidade'];
 
     // Cria o objeto de registro de usuário e chama o método insertUser
     $registerEmpresa = new registerEmpresa();
     $registerEmpresa->insertEmpresa($nome, $categoria, $telefone, $cidade);
 }
 ?>