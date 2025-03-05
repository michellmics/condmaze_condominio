<?php
require "../../src/sessionStartShield.php";
include_once "../../objects/objects.php";

class insertMsg extends SITE_ADMIN
{
    public function insertMsg($msg)
    {
        try {
            // Cria conexão com o banco de dados
            if (!$this->pdo) {
                $this->conexao();
            }

            

            $palavroes = [
                "aidético" => "🤬",
                "bacura" => "🤬",
                "putona" => "🤬"
            ];
            
           
            foreach ($palavroes as $palavra => $emoji) {
                $msg = str_ireplace($palavra, $emoji, $msg);
            }
            



            $result = $this->gravarMensagemSugestao($msg);

            echo "Mensagem enviada com sucesso.";                                  
                   
                
        } catch (PDOException $e) {  
            echo "Erro ao cadastrar convidado."; 
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $msg = $_POST['msg'];

    if($msg == "")
    {
        echo "O campo de mensagem não pode estar vazio.";
        exit();
    }

     // Cria o objeto de registro de usuário e chama o método insertUser
     $insertMsg= new insertMsg();
     $insertMsg->insertMsg($msg);
 }
 ?>