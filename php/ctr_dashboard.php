<?php
session_set_cookie_params(['httponly'=> true]);

session_start();
require_once('session_check.php');
require_once('classes/usuario.php');

if(!$logged_in){
    header("Location: ./index.php");
    exit;
}
var_dump($_SESSION['user']);
$usuarioLogado = unserialize($_SESSION['user']);
$funcao = $usuarioLogado['funcao'];

if(!$usuarioLogado){
    echo "Falha ao capturar informações.";
    exit;
}

echo "<p id='nome_usuario'>" . htmlspecialchars($usuarioLogado['nome']) . "</p>";
echo "<p id='nome_usuario'>" . htmlspecialchars($usuarioLogado['funcao']) . "</p>";


//verificar permissões para exibir telas
//listar agendamentos a contar da data de hoje, para mais 6 dias