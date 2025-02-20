<?php

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
                "aidético" => "❤️",
                "aidética" => "❤️",
                "aleijado" => "❤️",
                "aleijada" => "❤️",
                "arrombado" => "❤️",
                "apenado" => "❤️",
                "apenada" => "❤️",
                "baba-ovo" => "❤️",
                "babaca" => "❤️",
                "babaovo" => "❤️",
                "bacura" => "❤️",
                "bagos" => "❤️",
                "baitola" => "❤️",
                "beata" => "❤️",
                "besta" => "❤️",
                "bicha" => "❤️",
                "bisca" => "❤️",
                "bixa" => "❤️",
                "boazuda" => "❤️",
                "boceta" => "❤️",
                "boco" => "❤️",
                "boiola" => "❤️",
                "bokete" => "❤️",
                "bolagato" => "❤️",
                "bolcat" => "❤️",
                "boquete" => "❤️",
                "bosseta" => "❤️",
                "bosta" => "❤️",
                "brioco" => "❤️",
                "bronha" => "❤️",
                "buca" => "❤️",
                "buceta" => "❤️",
                "bugre" => "❤️",
                "bunda" => "❤️",
                "bunduda" => "❤️",
                "burra" => "❤️",
                "burro" => "❤️",
                "busseta" => "❤️",
                "caceta" => "❤️",
                "cacete" => "❤️",
                "caga" => "❤️",
                "cagado" => "❤️",
                "cagao" => "❤️",
                "cagão" => "❤️",
                "cagona" => "❤️",
                "canalha" => "❤️",
                "canceroso" => "❤️",
                "caralho" => "❤️",
                "casseta" => "❤️",
                "cassete" => "❤️",
                "checheca" => "❤️",
                "chereca" => "❤️",
                "chibumba" => "❤️",
                "chibumbo" => "❤️",
                "chifruda" => "❤️",
                "chifrudo" => "❤️",
                "chochota" => "❤️",
                "chota" => "❤️",
                "chupada" => "❤️",
                "chupado" => "❤️",
                "clitoris" => "❤️",
                "clitóris" => "❤️",
                "cocaina" => "❤️",
                "cocaína" => "❤️",
                "corna" => "❤️",
                "cornagem" => "❤️",
                "cornisse" => "❤️",
                "corno" => "❤️",
                "cornuda" => "❤️",
                "cornudo" => "❤️",
                "cornão" => "❤️",
                "cretina" => "❤️",
                "cretino" => "❤️",
                "cu" => "❤️",
                "cú" => "❤️",
                "curalho" => "❤️",
                "cuzao" => "❤️",
                "cuzão" => "❤️",
                "cuzuda" => "❤️",
                "cuzudo" => "❤️",
                "debil" => "❤️",
                "débil" => "❤️",
                "debiloide" => "❤️",
                "debilóide" => "❤️",
                "esclerosado" => "❤️",
                "escrota" => "❤️",
                "escroto" => "❤️",
                "esporrada" => "❤️",
                "esporrado" => "❤️",
                "esporro" => "❤️",
                "estupida" => "❤️",
                "estúpida" => "❤️",
                "estupidez" => "❤️",
                "estupido" => "❤️",
                "estúpido" => "❤️",
                "fedida" => "❤️",
                "fedido" => "❤️",
                "fedor" => "❤️",
                "fedorenta" => "❤️",
                "feia" => "❤️",
                "feio" => "❤️",
                "feiosa" => "❤️",
                "feioso" => "❤️",
                "feioza" => "❤️",
                "feiozo" => "❤️",
                "felacao" => "❤️",
                "felação" => "❤️",
                "fenda" => "❤️",
                "fodao" => "❤️",
                "fodão" => "❤️",
                "fode" => "❤️",
                "fodi" => "❤️",
                "fodida" => "❤️",
                "fodido" => "❤️",
                "fudendo" => "❤️",
                "fudeção" => "❤️",
                "fudida" => "❤️",
                "fudido" => "❤️",
                "gonorrea" => "❤️",
                "gonorreia" => "❤️",
                "gonorréia" => "❤️",
                "grelinho" => "❤️",
                "grelo" => "❤️",
                "idiota" => "❤️",
                "idiotice" => "❤️",
                "imbecil" => "❤️",
                "ladra" => "❤️",
                "ladrao" => "❤️",
                "ladroeira" => "❤️",
                "ladrona" => "❤️",
                "ladrão" => "❤️",
                "lazarento" => "❤️",
                "ninfeta" => "❤️",
                "noia" => "❤️",
                "puta" => "❤️",
                "putinha" => "❤️",
                "puto" => "❤️"
            ];
            
            // Mensagem a ser verificada
            $mensagem = "Essa porra é uma merda! Eu sou um idiota por ter dito isso.";
            
            // Substituir as palavras ofensivas por ❤️
            foreach ($palavroes as $palavra => $emoji) {
                $mensagem = str_ireplace($palavra, $emoji, $mensagem);
            }








            $result = $this->gravarMensagemSugestao($mensagem);

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