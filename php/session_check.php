<?php
// session_set_cookie_params(['lifetime' => 86400, 'httponly'=> true]);
session_set_cookie_params(['httponly'=> true]);

session_start();

if(!isset($_SESSION['user'])){
    // Se o usuário não estiver logado, redireciona para a página inicial (login)
    header("Location: ./index.php");
    exit;
}
?>