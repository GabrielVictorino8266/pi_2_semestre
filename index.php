<?php
require_once __DIR__ . './php/session_check.php';
define('PROJECT_ROOT_MYPATH', './view'); // Ajuste para o caminho da raiz do projeto, como '/' para a raiz ou '/meu_projeto/'
verificarSessao(PROJECT_ROOT_MYPATH);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem vindo - Entre no Sistema</title>
</head>
<body>
    <h1>Bem vindo</h1>
    <p>Você será redirecionado. Se isto não funcionar, tente clicar no link abaixo:</p>
    <a href="./view/login.php">Acessar página de Login</a>
</body>
</html>