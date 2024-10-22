<?php
require_once(__DIR__ . '/php/ctr_cadastro.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
</head>
<body>
    <form action="./php/cadastro.php" method="post">
        <label for="username">Nome de usuário:</label>
        <input type="text" name="username" id="username" required>
        <label for="user_password">Senha de usuário:</label>
        <input type="text" name="user_password" id="user_password" required>
        <label for="confirmed_user_password">Senha de usuário:</label>
        <input type="text" name="confirmed_user_password" id="confirmed_user_password" required>
        <select name="user_type" id="user_type" required>
            <option value="Administrador">ADMINISTRADOR</option>
            <option value="Funcionário">FUNCIONÁRIO</option>
        </select>
        <button type="submit">Cadastrar</button>
        <button type="reset">Limpar</button>
    </form>
</body>
</html>