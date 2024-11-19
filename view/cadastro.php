<?php
require_once __DIR__ . '../../php/ctr_cadastro.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
</head>
<body>
    <a href="./dashboard.php">Voltar</a>
    <form action="../php/ctr_cadastro.php" method="post">
        <label for="user_name">Nome de usuário:</label>
        <input type="text" name="user_name" id="user_name" required>
        <label for="user_email">Email de usuário:</label>
        <input type="email" name="user_email" id="user_email" required>
        <label for="user_password">Senha de usuário:</label>
        <!-- Com javascript, verificar se ambos sao iguais password e confirmed_password e habilitar o botao -->
        <input type="password" name="user_password" id="user_password" required>
        <label for="confirmed_user_password">Senha de usuário:</label>
        <input type="password" name="confirmed_user_password" id="confirmed_user_password" required>
        <select name="user_type" id="user_type" required>
            <option value="Administrador">ADMINISTRADOR</option>
            <option value="Funcionário">FUNCIONÁRIO</option>
        </select>
        <button type="submit">Cadastrar</button>
        <button type="reset">Limpar</button>
        <?php if (isset($_GET['error'])): ?>
            <div class="error">
                <?php
                if (($_GET['error']) == 'cadastroerror'){
                    echo "Verifique se digitou a senha corretamete. O Email pode estar duplicado no sistema, escolha outro. Tente Novamente.";
                }
                ?>
            </div>
        <?php endif; ?>
    </form>
</body>
</html>