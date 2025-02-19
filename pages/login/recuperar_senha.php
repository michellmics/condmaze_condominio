<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Condomínio Parque das Hortênsias</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

		<link rel="icon" href="https://www.prqdashortensias.com.br/logo_icon.ico" type="image/x-icon">
    	<link rel="shortcut icon" href="https://www.prqdashortensias.com.br/logo_icon.ico" type="image/x-icon">
    	<link rel="apple-touch-icon" href="https://www.prqdashortensias.com.br/logo_icon.png">
    	<meta name="apple-mobile-web-app-title" content="Hortensias">
    	<meta name="apple-mobile-web-app-capable" content="yes">
    	<meta name="apple-mobile-web-app-status-bar-style" content="default">
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="https://www.prqdashortensias.com.br" target="_self"><img src="https://www.prqdashortensias.com.br/img/logo_site_small.png"></img></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Recuperação de senha</p>
        <form id="demo-form" action="processa_recuperacao.php" method="post">
          <div class="form-group has-feedback">
            <input type="number" class="form-control" id="apartamento" placeholder="Digite o número do apartamento" name="apartamento"/>
            <span class="glyphicon glyphicon-home form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">                 
            </div><!-- /.col -->
            <div class="col-xs-4">
              
              <button onclick="onSubmit(event)" type="submit" class="btn btn-primary btn-block btn-flat">Enviar</button>
            </div><!-- /.col -->
          </div>
          <br>
        </form>

						<div id="form-message"></div>

						<!-- Ajax para envio e exibicao do resultado sem load de pag nova -->
						<script>
							document.getElementById('demo-form').addEventListener('submit', function(e) {
							    e.preventDefault(); // Impede o envio tradicional do formulário
						
							    var formData = new FormData(this); // Captura todos os dados do formulário
							
							    var xhr = new XMLHttpRequest();
							    xhr.open('POST', this.action, true); // Configura o envio via POST para o arquivo PHP
							
							    xhr.onload = function() {
							        if (xhr.status === 200) {
							            // Exibe a resposta do servidor na página
							            document.getElementById('form-message').innerHTML = xhr.responseText;
							        } else {
							            document.getElementById('form-message').innerHTML = "Houve um erro no envio do formulário.";
							        }
							    };
							
							    xhr.send(formData);
							});
						</script>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
    <!-- jQuery 2.1.3 -->
    <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
  </body>
</html>