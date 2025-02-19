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

      <style>
      .password-container {
        position: relative;
      }
      .toggle-password {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
      }
    </style>
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <img src="https://www.prqdashortensias.com.br/img/logo_site_small.png"></img>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Redefinição de senha</p>
        <form id="demo-form" action="atualizar_senha.php" method="post">
          <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
          <div class="form-group has-feedback">
            <input type="password" class="form-control" id="password" placeholder="Digite sua nova senha" name="password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <span class="toggle-password" onclick="togglePassword('password_redit', this)"></span>
            Preencha para alterar a senha. Ela deve ter pelo menos 8 caracteres, incluir uma letra maiúscula e um caractere especial.
          </div>

          <div class="form-group has-feedback">
            <input type="password" class="form-control" id="password_redit" placeholder="Repita a nova senha" name="password_redit"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <span class="toggle-password" onclick="togglePassword('password_redit', this)"></span>
          </div>
          
          <div class="row">
            <div class="col-xs-8">                 
            </div><!-- /.col -->
            <div class="col-xs-4">
              
              <button type="submit" class="btn btn-primary btn-block btn-flat">Enviar</button>
            </div><!-- /.col -->
          </div>
          <br>
        </form>

						<div id="password-error"></div>
            <div id="form-message"></div>

<script>
    function togglePassword(inputId, toggleElement) {
    const passwordField = document.getElementById(inputId);

    if (passwordField.type === "password") {
      passwordField.type = "text";
    } else {
      passwordField.type = "password";
    }
  }

    document.getElementById('demo-form').addEventListener('submit', function (e) {
        e.preventDefault(); // Impede o envio tradicional do formulário
        
        const password = document.getElementById('password').value;
        const passwordRedit = document.getElementById('password_redit').value;
        const passwordError = document.getElementById('password-error');

        // Verifica se as senhas coincidem
        if (password !== passwordRedit) {
            passwordError.style.display = 'block';
            passwordError.textContent = "As senhas não coincidem.";
            return; // Interrompe o envio
        }

        // Verifica os requisitos de força da senha
        const passwordRegex = /^(?=.*[A-Z])(?=.*[!@#$%^&*(),.?":{}|<>]).{6,}$/;
        if (!passwordRegex.test(password)) {
            passwordError.style.display = 'block';
            passwordError.textContent = "A senha deve ter 6 caracteres, incluindo uma letra maiúscula e um caractere especial.";
            return; // Interrompe o envio
        }

        // Se tudo estiver correto, oculta o erro e envia o formulário
        passwordError.style.display = 'none';

        // Envia o formulário usando Ajax
        const formData = new FormData(this);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', this.action, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
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