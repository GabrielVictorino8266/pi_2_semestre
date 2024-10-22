<?php
$logged_in = true;

if(!isset($_SESSION['user'])){
    // Se o usuário não estiver logado, define logged_in como false
    $logged_in = false;
}
?>