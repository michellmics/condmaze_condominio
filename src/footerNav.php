<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <script>document.write(new Date().getFullYear())</script> © Hyper - Coderthemes.com
            </div>
            <div class="col-md-6">
                <div class="text-md-end footer-links d-none d-md-block">
                    <a href="#" onclick="abrirTermos()">Termo de Privacidade</a>
                    <a href="#" target="_blank">| <b>O2 Innova</b> |</a>  
                </div>
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