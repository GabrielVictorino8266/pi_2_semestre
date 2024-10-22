<?php
session_set_cookie_params(['httponly'=> true]);

session_start();
require_once('session_check.php');
require_once('classes/usuario.php');

if(!$logged_in){
    header("Location: ./index.php");
    exit;
}
$usuarioLogado = unserialize($_SESSION['user']);

if(!$usuarioLogado){
    echo "Falha ao capturar informações.";
    exit;
}

echo "Nome do usuário: " . htmlspecialchars($usuarioLogado['nome']);