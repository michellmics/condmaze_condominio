<div class="modal fade" id="modalTermo" tabindex="-1" aria-labelledby="modalTermoLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTermoLabel">Termo de Privacidade e Proteção de Dados</h5>
            </div>
            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                <p><strong>Última atualização:</strong> [Data]</p>
                <p>A <strong>[Nome da Empresa/Sistema]</strong> valoriza sua privacidade e está comprometida com a proteção dos seus dados pessoais, em conformidade com a LGPD.</p>

                <h5>1. Dados Coletados</h5>
                <ul>
                    <li>Nome completo;</li>
                    <li>Telefone;</li>
                    <li>E-mail;</li>
                    <li>Número do apartamento.</li>
                </ul>

                <h5>2. Finalidade da Coleta de Dados</h5>
                <ul>
                    <li>Cadastro e identificação do morador;</li>
                    <li>Comunicação e envio de notificações;</li>
                    <li>Controle de acesso e segurança;</li>
                    <li>Cumprimento de obrigações legais.</li>
                </ul>

                <h5>3. Seus Direitos</h5>
                <p>Você pode acessar, corrigir ou excluir seus dados conforme a LGPD. Entre em contato: <strong>[seuemail@empresa.com]</strong>.</p>

                <!-- Checkbox para aceitar os termos -->
                <div class="form-check mt-3">
                    <input type="checkbox" class="form-check-input" id="aceiteTermo" onchange="liberarBotao()">
                    <label class="form-check-label" for="aceiteTermo">Li e aceito os termos de privacidade</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnAceitar" class="btn btn-success" disabled onclick="enviarAceite($userid, $nomeSession, $apartamentoSessio)">OK</button>>OK</button>
            </div>
        </div>
    </div>
</div>

<script>
    function liberarBotao() {
        document.getElementById('btnAceitar').disabled = !document.getElementById('aceiteTermo').checked;
    }

    function enviarAceite(userid, nomeSession, apartamentoSessio) {
        fetch("salvar_aceite.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `var1=${encodeURIComponent(var1)}&var2=${encodeURIComponent(var2)}&var3=${encodeURIComponent(var3)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "sucesso") {
                var modalTermo = bootstrap.Modal.getInstance(document.getElementById("modalTermo"));
                modalTermo.hide();
                console.log("Dados enviados:", data.dados);
            } else {
                alert("Erro ao registrar o aceite.");
            }
        })
        .catch(error => console.error("Erro na requisição:", error));
    }

    // Abrir o modal automaticamente ao carregar a página
    document.addEventListener("DOMContentLoaded", function () {
        var modalTermo = new bootstrap.Modal(document.getElementById("modalTermo"));
        modalTermo.show();
    });
</script>

