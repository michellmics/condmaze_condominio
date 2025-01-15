<!DOCTYPE html>
<html>
  <head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4VK4QL1B8G"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
        
      gtag('config', 'G-4VK4QL1B8G'); 
    </script>
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
        <img src="https://www.prqdashortensias.com.br/img/logo_site_small.png"></img>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Acesso a área administrativa</p>
        <form id="demo-form" action="login.php" method="post" autocomplete="on">
          <div class="form-group has-feedback">
            <input type="number" class="form-control" id="apartamento" placeholder="Digite o número do apartamento" name="username" autocomplete="username"/>
            <span class="glyphicon glyphicon-home form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" aria-label="Digite sua senha" class="form-control" id="password" placeholder="Digite sua senha" name="password" autocomplete="current-password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <div class="text-left">
              <a href="recuperar_senha.php" class="btn btn-link">Esqueceu sua senha?</a>
            </div>
            <div class="text-left">
              <a href="https://www.prqdashortensias.com.br/hortensiasapp.apk" download class="btn btn-link">Download App (Android)</a>
          </div>
          </div>
          <div class="row">
            <div class="col-xs-8">                 
            </div><!-- /.col -->
            <div class="col-xs-4">
              
              <button onclick="onSubmit(event)" type="submit" class="btn btn-primary btn-block btn-flat">login</button>
            </div><!-- /.col -->
          </div>
          <br>
          <center><div class="g-recaptcha" data-sitekey="6Lf3654qAAAAANEwGw3z4944gsNE3IT_vVAIrkSP"></div></center>
        </form>

        <!-- SCRIPT RECAPTCHA -->
                    <!-- Onde a mensagem de sucesso/erro será exibida -->
				<div id="form-message"></div>
						<script src="https://www.google.com/recaptcha/api.js" async defer></script>

						<!-- Ajax para envio e exibicao do resultado sem load de pag nova -->
						<script>
							document.getElementById('demo-form').addEventListener('submit', function(e) {
							    e.preventDefault(); // Impede o envio tradicional do formulário
							
							    // Verifica o reCAPTCHA
							    var recaptchaResponse = grecaptcha.getResponse();
							    if (recaptchaResponse.length === 0) {
							        document.getElementById('form-message').innerHTML = "Por favor, complete o reCAPTCHA.";
							        return; // Se o reCAPTCHA não foi resolvido, não submeta o formulário
							    }
							
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
							
							    xhr.send(formData); // Envia o formulário via AJAX
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
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>