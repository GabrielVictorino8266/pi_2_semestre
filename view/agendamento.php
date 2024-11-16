<?php
require_once __DIR__ . "../../php/ctr_agendamento.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>agendamento</title>
    <link rel="stylesheet" href="../style/agendamento.css">
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
                <form action="" method="GET">
                <div class="search-dropdown">
                    <div class="search">
                        <input type="text" name="buscar" id="buscar" placeholder="Digite um nome de cliente">
                    </div>
                </div>
                <div class="filtros-datas">
                    <div class="filtro">
                        <label for="data_retirada_inicial">Data Retirada</label>
                        <input type="date" name="data_retirada_inicial" id="data_retirada_inicial">
                    </div>
                </div>
            </form>
            
            <div class="dados-tabela">
                <table>
                    <thead>
                        <tr>
                            <th>Data Retirada</th>
                            <th>Cliente</th>
                            <th>Status</th>
                            <th>Visualizar</th>
                        </tr>
                    </thead>
                    <?php
                        if($listagemAgendamentos){
                            foreach($listagemAgendamentos as $agendamento){
                                echo "<tr>";
                                    echo "<td>{$agendamento['data_retirada']}</td>";
                                    echo "<td>{$agendamento['nome']}</td>";
                                    echo "<td>{$agendamento['descricao']}</td>";
                                    echo "<td>
                                            <button type='button' onclick='visualizar({$agendamento['id']})'>Visualizar</button>
                                        </td>";
                                echo "</tr>";
                            }
                        }else{
                            echo "<p>Nenhum item de agendamento encontrado</p>";
                        }
                    ?>
                </table>
                <div>
                <!-- Paginacao -->
                <?php
                    for($i = $intervalo['inicio']; $i <= $intervalo['fim']; $i++){
                        if(!isset($_GET['buscar']) || !isset($_GET['data_retirada'])){
                            if($i == $pagina){
                                echo "<a class='active' href='?pagina={$i}'>{$i}</a> ";
                            }else{
                                echo "<a href='?pagina={$i}'>{$i}</a> ";
                            }
                        }else{
                            if($i == $pagina){
                                echo "<a class='active' href='?pagina={$i}&buscar={$nome_cliente}'>{$i}</a> ";
                            }else{
                                echo "<a href='?pagina={$i}&buscar={$nome_cliente}&data_retirada={$data_retirada}'>{$i}</a> ";
                            }
                        }
                    }
                ?>
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