<?php

ini_set('display_errors', 1);  // Habilita a exibição de erros
error_reporting(E_ALL);        // Reporta todos os erros
include_once "../../objects/objects.php";

$siteAdmin = new SITE_ADMIN();
$siteAdmin->getParameterInfo();

foreach ($siteAdmin->ARRAY_PARAMETERINFO as $item) {
  if ($item['CFG_DCPARAMETRO'] == 'NOME_CONDOMINIO') {
      $nomeCondominio = $item['CFG_DCVALOR']; 
      break; 
  }
}

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];

?>

<!DOCTYPE html>
<html lang="en" data-layout-mode="detached" data-topbar-color="dark" data-menu-color="light" data-sidenav-user="true">

<head>
    <meta charset="utf-8" />
    <title><?php echo $nomeCondominio; ?></title>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4VK4QL1B8G"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
        
      gtag('config', 'G-4VK4QL1B8G'); 
    </script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- Theme Config Js -->
    <script src="../../assets/js/hyper-config.js"></script>

    <!-- Vendor css -->
    <link href="../../assets/css/vendor.min.css" rel="stylesheet" type="text/css" />
 
    <!-- App css -->
    <link href="../../assets/css/app-modern.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />

	<!-- PWA MOBILE CONF -->
	<?php include '../../src/pwa_conf.php'; ?>
	<!-- PWA MOBILE CONF -->
     
</head>

<body class="authentication-bg pb-0">

    <div class="auth-fluid">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box">
            <div class="card-body d-flex flex-column h-100 gap-3">

                <!-- Logo -->
                <div class="auth-brand text-center text-lg-start">
                    <a href="index.html" class="logo-dark">
                        <span><img src="../../img/logo_128x32_black.png" alt="dark logo" height="22"></span>
                    </a>
                    <a href="index.html" class="logo-light">
                        <span><img src="../../img/logo_128x32_black.png" alt="logo" height="22"></span>
                    </a>
                </div>

                <div class="my-auto">
                    <!-- title-->
                    <h4 class="mt-0">Acesso ao Sistema</h4>
                    <p class="text-muted mb-4">Utilize o número do apartamento e a senha.</p>

                    <!-- form -->
                    <form id="loginForm">
                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Apartamento</label>
                            <input class="form-control" type="number" id="apartamento" required="" placeholder="Digite o número do apartamento" name="apartamento" autocomplete="apartamento">
                        </div>
                        <div class="mb-3">
                            <a href="pages-recoverpw-2.html" class="text-muted float-end"><small>Esqueceu sua senha?</small></a>
                            <label for="password" class="form-label">Senha</label>
                            <input class="form-control" type="password" required="" id="password" placeholder="Digite sua senha" name="password" autocomplete="current-password">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                <label class="form-check-label" for="checkbox-signin">Lembrar?</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <a href="<?php echo $host; ?>/appCondominio.apk" download class="btn btn-link">Download App (Android)</a>
                        </div>
                        <div class="d-grid mb-0 text-center">
                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-login"></i> Entrar </button>
                        </div>
                        <br><br>
                    </form>
                    <!-- end form-->
                </div>

                <script>
                         document.getElementById('loginForm').addEventListener('submit', function(event) {
                    event.preventDefault();
                        
                    const apartamento = document.getElementById('apartamento').value;
                    const password = document.getElementById('password').value;
                    const rememberMe = document.getElementById('checkbox-signin').checked;
                        
                    fetch('login.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ apartamento, senha: password })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Login bem-sucedido!');
                            const token = data.token;
                        
                            // Salva o token no localStorage se "Lembrar-me" estiver marcado
                            if (rememberMe) {
                                localStorage.setItem('authToken', token);
                            }
                        
                            // Redireciona para a página protegida
                            window.location.href = 'dashboard.php';
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => console.error('Erro:', error));
                });
                </script>
                <!-- Footer-->
                <footer class="footer footer-alt">
                    <p class="text-muted">Não têm uma conta? Entre em contato com o síndico.</p>
                </footer>

            </div> <!-- end .card-body -->
        </div>

    </div>
    <!-- end auth-fluid-->
    <!-- Vendor js -->
    <script src="../../assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="../../assets/js/app.min.js"></script>

</body>

</html>