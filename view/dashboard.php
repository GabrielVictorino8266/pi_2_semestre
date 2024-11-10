<?php
require_once __DIR__ . "../../php/ctr_dashboard.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Inclua o jQuery -->
    <script src="./js/dashboard.js" defer></script>
</head>
<body>
    <!-- NAV -->
    <div>
        <nav>
            <div>
                <div>
                    <p>Olá, <?php echo $_SESSION['user_name']; ?></p>
                </div>
                <a href="./logout.php">Sair</a>
            </div>
            <div>
                <?php
                if($funcao && $funcao['descricao'] == "Administrador"){
                    echo "<a href='./cadastro.php'>Cadastrar Usuário</a>";
                }
                ?>
                <a href="./estoque.php">Estoque</a>
                <a href="./agendamento.php">Agendamento</a>
                <a href="./dashboard.php">Dashboard</a>
            </div>
        </nav>
    </div>

    <!-- PAGINACAO E TABELA -->
    <div>
        <h1>Dashboard front</h1>
        <div>
            <form action="" method="GET" id="form_filtro">
                <input type="text" name="buscar" id="buscar" placeholder="Digite um nome de cliente">
                <button type="submit">Pesquisar</button>
                <select name="status" id="status">
                    <option value="">Escolha um status</option>
                    <?php
                    if($todosStatus){
                        foreach($todosStatus as $status){
                            echo "<option value=".$status['id'] .">". $status['descricao']."</option>";
                        }
                    }
                    ?>
                </select>
            </form>

            <!-- EXIBIÇAO DE TABELA -->
            <div>
                <p>Agendamentos desta semana: <?php echo $totalAgendamentosDaSemana['total']; ?></p>
            </div>
            <div>
                <table>
                    <thead>
                        <tr>
                            <th>Data Retirada</th>
                            <th>Produto</th>
                            <th>Cliente</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <?php
                        if($quantidadeAgendamentos){
                            foreach($agendamentosDaSemana as $agendamento){
                                $data = new DateTimeImmutable($agendamento['data_retirada']);
                                if($data){
                                    $dataFormatada = $data->format('d/m/Y'); # Formata a data para dd/mm/aaaa
                                }
                                echo "<tr>";
                                    echo "<td>{$dataFormatada}</td>";
                                    echo "<td>{$agendamento['produto']}</td>";
                                    echo "<td>{$agendamento['nome_cliente']}</td>";
                                    echo "<td>{$agendamento['status']}</td>";
                                echo "</tr>";
                            }
                        }else{
                            echo "<p>Nenhum agendamento encontrado</p>";
                        }
                    ?>
                </table>
            </div>
            <div>
                <!-- Paginacao -->
                <?php
                    for($i = $intervalo['inicio']; $i <= $intervalo['fim']; $i++){
                        if(!isset($_GET['buscar']) || !isset($_GET['status'])){
                            if($i == $pagina){
                                echo "<a class='active' href='?pagina={$i}'>{$i}</a> ";
                            }else{
                                echo "<a href='?pagina={$i}'>{$i}</a> ";
                            }
                        }else{
                            if($i == $pagina){
                                echo "<a class='active' href='?pagina={$i}&buscar={$nome_cliente}'>{$i}</a> ";
                            }else{
                                echo "<a href='?pagina={$i}&buscar={$nome_cliente}&status={$status_id}'>{$i}</a> ";
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>

<!-- Exibir informação de sucesso de cadastro. -->