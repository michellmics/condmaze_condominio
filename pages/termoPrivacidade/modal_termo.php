<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termo de Privacidade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    <div class="container mt-5">
        <h3>Cadastro</h3>
        
        <!-- Botão para abrir o modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTermo">
            Ver Termo de Privacidade
        </button>

        <!-- Checkbox para aceitar -->
        <div class="form-check mt-3">
            <input type="checkbox" class="form-check-input" id="aceiteTermo">
            <label class="form-check-label" for="aceiteTermo">Li e aceito os termos de privacidade</label>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalTermo" tabindex="-1" aria-labelledby="modalTermoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTermoLabel">Termo de Privacidade e Proteção de Dados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
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
                    <p>Os dados são utilizados para:</p>
                    <ul>
                        <li>Cadastro e identificação do morador;</li>
                        <li>Comunicação e envio de notificações;</li>
                        <li>Controle de acesso e segurança;</li>
                        <li>Cumprimento de obrigações legais.</li>
                    </ul>

                    <h5>3. Segurança e Armazenamento</h5>
                    <p>Os dados são protegidos contra acessos não autorizados e armazenados em ambiente seguro.</p>

                    <h5>4. Seus Direitos</h5>
                    <p>Você pode acessar, corrigir ou excluir seus dados conforme a LGPD. Entre em contato: <strong>[seuemail@empresa.com]</strong>.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
