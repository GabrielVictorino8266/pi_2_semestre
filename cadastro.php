<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
</head>
<body>
    <form action="dashboard.php" method="post">
        <label for="username">Nome de usuário:</label>
        <input type="text" name="username" id="username">
        <label for="user_password">Senha de usuário:</label>
        <input type="text" name="user_password" id="user_password">
        <label for="confirmed_user_password">Senha de usuário:</label>
        <input type="text" name="confirmed_user_password" id="confirmed_user_password">
        <select name="user_type" id="user_type">
            <option value="">Escolha uma opção</option>
            <option value="administrador">ADMINISTRADOR</option>
            <option value="funcionario">FUNCIONÁRIO</option>
        </select>
        <button type="submit">Cadastrar</button>
        <button type="reset">Limpar</button>
    </form>
</body>
</html>