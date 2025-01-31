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
<div class="modal fade" id="modalTermo" tabindex="-1" aria-labelledby="modalTermoLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTermoLabel">Termo de Privacidade e Proteção de Dados</h5>
            </div>
            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                <p><strong>Última atualização:</strong> 30/01/2025</p>
                <p>A <strong>Codemaze</strong> valoriza sua privacidade e está comprometida com a proteção dos seus dados pessoais, em conformidade com a LGPD.</p>

                <h5>1. Dados Coletados</h5>
                <ul>
                    <li>Nome completo;</li>
                    <li>Telefone;</li>
                    <li>E-mail;</li>
                    <li>Número do apartamento.</li>
                    <li>Bloco do apartamento.</li>
                </ul>

                <h5>2. Finalidade da Coleta de Dados</h5>
                <ul>
                    <li>Cadastro e identificação do morador;</li>
                    <li>Comunicação e envio de notificações;</li>
                    <li>Controle de acesso e segurança;</li>
                    <li>Cumprimento de obrigações legais.</li>
                </ul>

                <h5>3. Seus Direitos</h5>
                <p>Você pode acessar, corrigir ou excluir seus dados conforme a LGPD. Entre em contato: <strong>suporte@codemaze.com.br</strong>.</p>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 footer-links" >               
                <a href="https://codemaze.com.br" target="_blank">| <b>Codemaze</b> |</a>  <a href="#" onclick="abrirTermos()">Termo de Privacidade</a>
            </div>
            <div class="col-md-6">
                <div class="text-md-end footer-links d-none d-md-block">
                    
                </div>
            </div>            
            
        </div>
    </div>
</footer>

<script>
    function abrirTermos() {
        fetch("../termoPrivacidade/termos.php")
            .then(response => response.text())
            .then(data => {
                document.getElementById("conteudoTermos").innerHTML = data;
                var modal = new bootstrap.Modal(document.getElementById("modalTermos"));
                modal.show();
            })
            .catch(error => console.error("Erro ao carregar os termos:", error));
    }
</script>


