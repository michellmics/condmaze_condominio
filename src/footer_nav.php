<style>
        html, body {
        height: 100%; /* Garante que a altura da página seja de 100% da janela */
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    .container-fluid {
        flex: 1; /* O conteúdo principal ocupará o espaço disponível */
    }

.footer {
    position: fixed; /* Torna o rodapé fixo */
    bottom: 0; /* Fixa na parte inferior da janela */
    left: 0; /* Alinha à esquerda */
    width: 100%; /* Faz o rodapé ocupar toda a largura */
    background-color: #f8f9fa; /* Cor de fundo opcional */
    text-align: center; /* Centraliza o texto */
    padding: 10px 0; /* Espaçamento interno */
    z-index: 1000; /* Garante que fique sobre outros elementos */
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1); /* Adiciona uma leve sombra (opcional) */
}
</style>

<!-- Modal -->
<div class="modal fade" id="modalTermos" tabindex="-1" aria-labelledby="modalTermosLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTermosLabel">Termos de Privacidade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body" id="conteudoTermos">
                <p>hahahahaha</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 footer-links">
                <a href="https://codemaze.com.br" target="_blank">| <b>Codemaze</b> |</a>  
                <a href="#" onclick="abrirTermos()">Termo de Privacidade</a>
            </div>
            <div class="col-md-6">
                <div class="text-md-end footer-links d-none d-md-block"></div>
            </div>
        </div>
    </div>
</footer>

<script>
    function abrirTermos() {
        // Exibe o modal com o texto já definido
        var modal = new bootstrap.Modal(document.getElementById("modalTermos"));
        modal.show();
    }
</script>
