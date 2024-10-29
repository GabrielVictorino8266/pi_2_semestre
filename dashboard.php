<?php
require_once __DIR__ . '/php/ctr_dashboard.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>

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
    <div>
        <h1>Dashboard front</h1>
        <div>
            <form action="">
                <input type="text" name="buscar" id="buscar" placeholder="Digite um id ou nome de cliente">
            </form>
            <div>
                <p>Agendamentos desta semana: <?php echo $totalAgendamentosDaSemana['total']; ?></p>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Data Retirada</th>
                        <th>Produto</th>
                        <th>Cliente</th>
                        <th>Status</th>
                    </tr>
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
                    }
                    ?>
                </thead>
            </table>
            <div>
                <!-- Paginacao -->
                <?php
                    for($i = $intervalo_inicio; $i <= $intervalo_fim; $i++){
                        if($i == $pagina){
                            echo "<a class='active' href='?pagina={$i}'>{$i}</a> ";
                        }else{
                            echo "<a href='?pagina={$i}'>{$i}</a> ";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>