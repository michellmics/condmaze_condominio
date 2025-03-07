<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot - Regimento Interno</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Chatbot - Regimento Interno</h2>
        <div class="chat-box border rounded p-3 mb-3">
            <div id="chat" class="overflow-auto" style="height: 300px;"></div>
        </div>
        <div class="input-group">
            <input type="text" id="pergunta" class="form-control" placeholder="Digite sua pergunta...">
            <button class="btn btn-primary" onclick="enviarPergunta()">Enviar</button>
        </div>
    </div>

    <script>
        function enviarPergunta() {
            let pergunta = document.getElementById("pergunta").value.trim();
            if (pergunta === "") return;

            let chat = document.getElementById("chat");
            chat.innerHTML += `<div class='text-end'><b>Você:</b> ${pergunta}</div>`;

            fetch("chatbot.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "pergunta=" + encodeURIComponent(pergunta)
            })
            .then(response => response.json())
            .then(data => {
                chat.innerHTML += `<div class='text-start'><b>Bot:</b> ${data.resposta}</div>`;
                chat.scrollTop = chat.scrollHeight; // Rola para a última mensagem
            });

            document.getElementById("pergunta").value = "";
        }
    </script>
</body>
</html>
