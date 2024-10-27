<?php
require_once __DIR__ . './classes/conexao.php';
require_once __DIR__ . './classes/query.php';

session_start();

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
    <nav>
        <?php
        if($funcao && $funcao == "Administrador"){
            echo "<a href='./cadastro.php'>Cadastrar Usuário</a>";
        }
        ?>
        <a href="./estoque.php">Estoque</a>
        <a href="./agendamento.php">Agendamento</a>
        <a href="./dashboard.php">Dashboard</a>
    </nav>

    <a href="./logout.php">Sair</a>
</body>
</html>