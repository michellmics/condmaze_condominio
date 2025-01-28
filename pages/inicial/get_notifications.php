<?php
// Conexão com o banco de dados ou outra lógica para buscar notificações
// Exemplo de uma consulta simples
$notifications = [
    ['id' => 1, 'message' => 'Nova mensagem recebida'],
    ['id' => 2, 'message' => 'Novo comentário em seu post'],
];

// Retorne as notificações como JSON
echo json_encode($notifications);
?>