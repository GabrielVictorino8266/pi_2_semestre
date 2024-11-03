<?php
require_once '../pi_2_semestre/php/ctr_dashboard.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>agendamento</title>
    <link rel="stylesheet" href="./style/agendamento.css">
</head>

<body>

    <div class="main">
        <div class="hamburger" id="hamburger">
            &#9776;
        </div>

        <div class="navbar" id="navbar">
            <p>Olá,
                <?php echo $_SESSION['user_name']; ?>
            </p>

            <div class="quit">
                <a href="./logout.php">Sair</a>
            </div>

            <div class="tools">
                <ul>
                    <li>
                        <a href="./dashboard.php" class="box first">DASHBOARD</a>
                    </li>
                    <li>
                        <a href="./estoque.php" class="box">ESTOQUE</a>
                    </li>
                    <li>
                        <a href="./agendamento.php" class="box choose">AGENDAMENTO</a>
                    </li>
                    <li>
                        <?php
                    if($funcao && $funcao['descricao'] == "Administrador"){
                        echo "<a href='./cadastro.php' class='box'>Cadastrar Usuário</a>";
                    }
                    ?>
                    </li>
                </ul>
            </div>
        </div>


        <div class="card">
            <div class="search-dropdown">
                <div class="search">
                    <label for="">
                        <input type="text" name="" id="" placeholder="Pesquisar">
                    </label>
                </div>
                <div class="dropdown">
                    &#9776;
                </div>
            </div>
        </div>

        <div class="card2">
            <div class="content">
                <div class="title">
                    <h3>Nome do Produto</h3>
                </div>
                <div class="description">
                    <h4>Quantidade</h4>
                    <h4>Custo Total</h4>
                    <h4>Preço Venda</h4>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/navbar.js"></script>
</body>

</html>