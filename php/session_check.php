<?php
session_start();

/**
 * Verifica se a sessão do usuário está ativa.
 * 
 * Se a sessão do usuário não estiver ativa (não há 'user_id' na sessão),
 * redireciona o usuário para a página de login.
 */
function verificarSessao($redirecionar){
    if(!isset($_SESSION["user_id"])){
        header("location: " . $redirecionar . "/login.php");
        exit;
    }
}