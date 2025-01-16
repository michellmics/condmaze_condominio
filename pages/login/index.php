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
    <link rel="icon" href="https://www.prqdashortensias.com.br/logo_icon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="https://www.prqdashortensias.com.br/logo_icon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="https://www.prqdashortensias.com.br/logo_icon.png">
    <meta name="apple-mobile-web-app-title" content="Hortensias">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Theme Config Js -->
    <script src="../../assets/js/hyper-config.js"></script>

    <!-- Vendor css -->
    <link href="../../assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="../../assets/css/app-modern.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body class="authentication-bg pb-0">

    <div class="auth-fluid">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box">
            <div class="card-body d-flex flex-column h-100 gap-3">

                <!-- Logo -->
                <div class="auth-brand text-center text-lg-start">
                    <a href="index.html" class="logo-dark">
                        <span><img src="../../assets/images/logo-dark.png" alt="dark logo" height="22"></span>
                    </a>
                    <a href="index.html" class="logo-light">
                        <span><img src="../../assets/images/logo.png" alt="logo" height="22"></span>
                    </a>
                </div>

                <div class="my-auto">
                    <!-- title-->
                    <h4 class="mt-0">Acesso ao Sistema</h4>
                    <p class="text-muted mb-4">Utilize o número do apartamento e a senha..</p>

                    <!-- form -->
                    <form action="#">
                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Apartamento</label>
                            <input class="form-control" type="number" id="apartamento" required="" placeholder="Digite o número do apartamento" name="username" autocomplete="username">
                        </div>
                        <div class="mb-3">
                            <a href="pages-recoverpw-2.html" class="text-muted float-end"><small>Forgot your password?</small></a>
                            <label for="password" class="form-label">Senha</label>
                            <input class="form-control" type="password" required="" id="password" placeholder="Digite sua senha" name="password" autocomplete="current-password">
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                <label class="form-check-label" for="checkbox-signin">Lembrar?</label>
                            </div>
                        </div>
                        <div class="d-grid mb-0 text-center">
                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-login"></i> Entrar </button>
                        </div>
                    </form>
                    <!-- end form-->
                </div>

                <!-- Footer-->
                <footer class="footer footer-alt">
                    <p class="text-muted">Não têm uma conta? Solicite ao Síndico agora mesmo :)</p>
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