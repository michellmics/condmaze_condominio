<?php
ini_set('session.gc_maxlifetime', 43200);
ini_set('session.cookie_lifetime', 43200);
session_set_cookie_params(43200);
session_start();

if (isset($_SESSION['user_id'])) { 
    header('Location: ../inicial/index.php');
    exit;
}
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


<style>
/* Preloader container */
#preloader {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(255, 255, 255, 0.8);  /* semi-transparent background */
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;  /* ensures it's on top of everything */
}

/* Loader styles */
.loader {
  width: 64px;
  height: 64px;
  position: relative;
  animation: rotate 1.5s ease-in infinite alternate;
}

.loader::before {
  content: '';
  position: absolute;
  left: 0;
  bottom: 0;
  color:rgb(255, 36, 65);
  background: currentColor;
  width: 64px;
  height: 32px;
  border-radius: 0 0 50px 50px;
}

.loader::after {
  content: '';
  position: absolute;
  left: 50%;
  top: 10%;
  background: rgb(22, 109, 150);
  width: 8px;
  height: 64px;
  animation: rotate 1.2s linear infinite alternate-reverse;
}

/* Rotation animation */
@keyframes rotate {
  100% {
    transform: rotate(360deg);
  }
}
</style> 

<style>
        /* Estilização do modal deteccao pwa*/
        #pwaModal {
            display: none; 
            position: fixed; 
            z-index: 1000; 
            left: 0; 
            top: 0; 
            width: 100%; 
            height: 100%; 
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 400px;
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .close-btn {
            cursor: pointer;
            background-color: red;
            color: white;
            border: none;
            padding: 8px 12px;
            margin-top: 10px;
            border-radius: 5px;
        }
    </style>

<body class="authentication-bg pb-0">

<!-- Preloader Wrapper -->
<div id="preloader">
  <span class="loader"></span>
</div>

    <!-- Modal -->
    <div id="pwaModal">
        <div class="modal-content">
            <h3>Instale o app (PWA) no iPhone 📱</h3>
            <p>Para instalar como um PWA, clique agora no botão <strong>Compartilhar</strong> (ícone no Safari) que esta no rodapé e depois em <strong>Adicionar à Tela de Início</strong>.</p>
            <button class="close-btn" onclick="fecharModal()">Fechar</button>
        </div> 
    </div>

    <div class="auth-fluid">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box">
            <div class="card-body d-flex flex-column h-100 gap-3">

                <!-- Logo -->
                <div class="auth-brand text-center text-lg-start">
                    <a href="index.html" class="logo-dark">
                        <span><img src="../../img/logo_128x32_black.png" width="162px" height="43px" alt="logo" style="height: 43px; width: 162px;"></span>
                    </a>
                    <a href="index.html" class="logo-light">
                        <span><img src="../../img/logo_128x32_black.png" alt="logo" height="22"></span>
                    </a>
                </div>

                <div class="my-auto">
                    <!-- title-->
                    <h4 class="mt-0">Acesso ao Sistema </h4>
                    <p class="text-muted mb-4">Utilize o número do apartamento e a senha</p>

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
                                <label class="form-check-label" for="checkbox-signin">Manter Conectado?</label>
                            </div>
                        </div>
                        <div class="mb-3">
                          <!--   <a href="app_hortensias.apk" download class="btn btn-link">Download App (Android)</a> -->
                        </div>
                        <div class="d-grid mb-0 text-center">
                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-login"></i> Entrar </button>
                        </div>
                        <br><br>
                    </form>
                    <!-- end form-->
                </div>

                <script>
                    // Verifica o token ao carregar a página
                    document.addEventListener('DOMContentLoaded', () => {
                        const token = localStorage.getItem('authToken');
                        if (token) {
                            fetch('verifyToken.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({ token })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.valid) {
                                    // Token válido, redireciona para a página inicial
                                    window.location.href = '../inicial/index.php';
                                } else {
                                    // Token inválido, remove do localStorage
                                    localStorage.removeItem('authToken');
                                } 
                            })
                            .catch(error => console.error('Erro ao verificar token:', error));
                        }
                    });

                    // Envia o formulário de login
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
                                const token = data.token;
                        
                                // Salva o token no localStorage se "Lembrar-me" estiver marcado
                                if (rememberMe) {
                                    localStorage.setItem('authToken', token); 
                                }
                        
                                // Redireciona para a página protegida
                                window.location.href = '../inicial/index.php';
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

    <script>
        function detectarPWAeiPhone() {
            // Verifica se é um iPhone
            let isIphone = /iphone|ipod/i.test(navigator.userAgent);

            // Verifica se já está rodando como PWA
            let isPWA = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone;

            // Se for iPhone e não for PWA, exibe o modal
            if (isIphone && !isPWA) {
                document.getElementById("pwaModal").style.display = "block";
            }
        }

        function fecharModal() {
            document.getElementById("pwaModal").style.display = "none";
        }

        // Executa a verificação após o carregamento da página
        window.onload = detectarPWAeiPhone;
    </script>
    
    <!-- end auth-fluid-->
    <!-- Vendor js -->
    <script src="../../assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="../../assets/js/app.min.js"></script>

</body>

</html>
