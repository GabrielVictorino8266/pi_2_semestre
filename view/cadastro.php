<?php
require_once __DIR__ . '../../php/ctr_cadastro.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>

    <link rel="stylesheet" href="../style/cadastro.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <a class="link-opacity-75 mb-4 d-inline-block" href="./dashboard.php">Voltar</a>
        <h3 class="text-center mb-4">Cadastrar Usuário no Sistema</h3>
        <form action="../php/ctr_cadastro.php" method="post" class="card p-5 shadow">
            <div class="mb-3">
                <label for="user_name" class="form-label">Nome de usuário:</label>
                <input type="text" class="form-control" name="user_name" id="user_name" required>
            </div>

            <div class="mb-3">
                <label for="user_email" class="form-label">Email de usuário:</label>
                <input type="email" class="form-control" name="user_email" id="user_email" required>
            </div>

            <div class="mb-3">
                <label for="user_password" class="form-label">Senha de usuário:</label>
                <input type="password" class="form-control" name="user_password" id="user_password" required>
            </div>

            <div class="mb-3">
                <label for="confirmed_user_password" class="form-label">Senha de usuário:</label>
                <input type="password" class="form-control" name="confirmed_user_password" id="confirmed_user_password" required>
            </div>

            <div class="mb-3">
                <label for="user_type" class="form-label">Tipo de Usuário:</label>
                <select class="form-control" name="user_type" id="user_type" required>
                    <option value="Administrador">ADMINISTRADOR</option>
                    <option value="Funcionário">FUNCIONÁRIO</option>
                </select>
            </div>

            <div class="text-center mt-4">
                <button class='btn btn-primary' type="submit">Cadastrar</button>
                <button class='btn btn-secondary' type="reset">Limpar</button>
                <?php if (isset($_GET['error'])): ?>
                    <div class="error">
                        <?php
                        if (($_GET['error']) == 'cadastroerror') {
                            echo "Verifique se digitou a senha corretamete. O Email pode estar duplicado no sistema, escolha outro. Tente Novamente.";
                        }
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>