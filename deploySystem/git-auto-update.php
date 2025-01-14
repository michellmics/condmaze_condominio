<?php
// Define o caminho para o diretório do repositório
$repoDir = '/home/inart/public_html/'; // Altere conforme necessário

// Muda para o diretório do repositório
chdir($repoDir);

// Executa o comando Git pull
$output = [];
$returnVar = 0;
exec('git pull origin main', $output, $returnVar);

// Verifica se o comando foi bem-sucedido
if ($returnVar !== 0) {
    // Ocorreu um erro
    echo "Erro ao fazer pull: " . implode("\n", $output);
} else {
    // Pull bem-sucedido
    echo "Repositório atualizado com sucesso.";
}
?>