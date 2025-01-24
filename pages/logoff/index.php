<?php
    session_start();
    $_SESSION = [];
    session_destroy();
    echo "<script>    localStorage.removeItem('authToken');    </script>";
    header("Location: ../login/index.php");
?>