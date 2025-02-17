<?php
    
    
    $ipAcessoClient = $_SERVER['HTTP_X_REAL_IP'];
    $checkPortaria = new SITE_ADMIN();  
    $resultPortCheck = $checkPortaria->getValidPortariaInfo($ipAcessoClient);

    if($resultPortCheck != 1 && $user['USU_DCNIVEL'] == "PORTARIA")
    {
        session_start();
        session_unset();  
        session_destroy();  

        echo '<script type="text/javascript">
            window.location.href = "../login/index.php";
          </script>';
    }
?>

<style>
        html, body {
        height: 100%; 
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    .container-fluid {
        flex: 1; 
    }

.footer {
    position: fixed; 
    bottom: 0; 
    left: 0; 
    width: 100%; 
    background-color: #f8f9fa; 
    text-align: center; 
    padding: 10px 0; 
    z-index: 1000; 
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1); 
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
        var modal = new bootstrap.Modal(document.getElementById("modalTermos"));
        modal.show();
    }
</script>


