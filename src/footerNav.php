<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <script>document.write(new Date().getFullYear())</script> © ConDMazE by Codemaze
            </div>
            <div class="col-md-6">
                <div class="text-md-end footer-links d-none d-md-block">
                    <a href="#" onclick="abrirTermos()"><?php echo $translations['termo_priva']; ?></a>                 
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