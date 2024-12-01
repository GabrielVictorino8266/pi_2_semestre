<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Entre no Sistema</title>

    <link rel="stylesheet" href="../style/login.css">
</head>
<body>
    <div class="block">
        <img src="../assets/logo/logo-cliente.png" alt="img cliente">
    </div>

    <div class="login">
        <div class="title">
            <h2>Entrar</h2>
        </div>

    <form action="../php/ctr_login.php" method="post">
        <label for="user_email" class="email-user">Email do usuário:</label>
        <input type="email" name="user_email" class="email-input" id="user_email" placeholder="Digite seu email" required>
        <label for="user_password" class="password-user">Senha de usuário:</label>
        <input type="text" name="user_password" id="user_password" placeholder="Digite sua senha" class="password-input" required>
        <button type="submit" class="btn">Entrar</button>
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