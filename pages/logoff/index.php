<?php
    session_start();
    $_SESSION = [];
    session_destroy();
    echo "<script>
            localStorage.removeItem('authToken');
            window.location.href = '../login/index.php';  // Redirecionamento no cliente
          </script>";
    exit();
?>