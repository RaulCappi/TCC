<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET' || $_SERVER['REQUEST_METHOD'] === 'POST') { // Verifica se é uma requisição GET
    session_unset(); // Remove todas as variáveis de sessão
    session_destroy(); // Destrói a sessão

    $_SESSION['msg_logout'] =
        "<h5 style='color: red; text-align: center'>Conta desconectada!</h5>";
    header("Location: ../index.php");
    exit();
}


?>