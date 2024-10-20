<?php
require_once('./php/session_check.php');
require_once('./classes/usuario.php');

$usuarioLogado = unserialize($_SESSION['user']);
echo "Nome do usuário: " . htmlspecialchars($usuarioLogado->getNome());

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard front</h1>
</body>
</html>