<?php
session_start();

if(isset($_SESSION['user'])){
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Entre no Sistema</title>
</head>
<body>
    <form action="./php/ctr_login.php" method="post">
        <label for="username">Nome de usuário:</label>
        <input type="text" name="username" id="username" required>
        <label for="user_password">Senha de usuário:</label>
        <input type="text" name="user_password" id="user_password" required>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>