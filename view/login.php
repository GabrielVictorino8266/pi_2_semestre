<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Entre no Sistema</title>
</head>
<body>
    <form action="../php/ctr_login.php" method="post">
        <label for="user_email">Email do usuário:</label>
        <input type="email" name="user_email" id="user_email" required>
        <label for="user_password">Senha de usuário:</label>
        <input type="text" name="user_password" id="user_password" required>
        <button type="submit">Entrar</button>
        <?php if (isset($_GET['error'])): ?>
            <div class="error">
                <?php
                if (($_GET['error']) == 'login'){
                    echo "Login Incorreto. Verifique sua senha e email";
                }else if(($_GET['error']) == 'credenciaisnaopreenchidas'){
                    echo "Verifique se os campos estão preenchidos.";
                }
                ?>
            </div>
        <?php endif; ?>
    </form>
</body>
</html>