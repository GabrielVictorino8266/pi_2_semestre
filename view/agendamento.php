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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                    <li>
                        <a href="./agendamento.php" class="box choose">CADASTRAR CLIENTE</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card">
                <form action="" method="GET" class="container mt-3">
                <div class="row g-3 align-items-end search-dropdown">
                    <div class="col-md-7 search">
                        <div class="input-group">
                            <input type="text" class="form-control" name="buscar" id="buscar" placeholder="Digite um nome de cliente">
                            <button class="btn btn-primary" type="submit">Pesquisar</button>
                            <button class="btn btn-secondary" type="button" onclick="cadastrarAgendamento()">Cadastrar</button>
                        </div>
                    </div>
                    <div class="col-md-4 filtro">
                        <div class="form-group">
                            <label for="data_retirada_inicial" class="input-group-text">Data Retirada</label>
                            <input type="date" class="form-control" name="data_retirada_inicial" id="data_retirada_inicial">
                        </div>
                    </div>
                </div>
            </form>
            
            <div class="table-responsive dados-tabela">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Data Retirada</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Status</th>
                            <th scope="col">Visualizar</th>
                        </tr>
                    </thead>
                    <?php
                        if($listagemAgendamentos){
                            // var_dump($listagemAgendamentos);
                            foreach($listagemAgendamentos as $agendamento){
                                echo "<tr>";
                                    echo "<td style='display: none;'>{$agendamento['id_agendamento']}</td>";
                                    echo "<td>{$agendamento['data_retirada']}</td>";
                                    echo "<td>{$agendamento['nome']}</td>";
                                    echo "<td>{$agendamento['descricao']}</td>";
                                    echo "<td>
                                            <button type='button' class='btn btn-primary' onclick='visualizar({$agendamento['id_agendamento']})'>Visualizar</button>
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
                <nav aria-label="Paginacao">
                    <ul class="pagination justify-content-center">
                        <?php
                            for ($i = $intervalo['inicio']; $i <= $intervalo['fim']; $i++) {
                                $pagina_url = "?pagina={$i}";
                                
                                // Inclua o parâmetro "buscar" se estiver definido
                                if (isset($_GET['buscar']) && $_GET['buscar'] != "") {
                                    $nome_cliente = htmlspecialchars($_GET['buscar'], ENT_QUOTES, 'UTF-8');
                                    $pagina_url .= "&buscar={$nome_cliente}";
                                }
                                
                                // Inclua o parâmetro "data_retirada" se estiver definido
                                if (isset($_GET['data_retirada']) && $_GET['data_retirada'] != "") {
                                    $data_retirada = htmlspecialchars($_GET['data_retirada'], ENT_QUOTES, 'UTF-8');
                                    $pagina_url .= "&data_retirada={$data_retirada}";
                                }
                                
                                // Adicione a classe 'active' para a página atual
                                if ($i == $pagina) {
                                    echo "<li class='page-item'><a class='page-link active' href='{$pagina_url}'>{$i}</a> </li>";
                                } else {
                                    echo "<li class='page-item'><a class='page-link' href='{$pagina_url}'>{$i}</a></li>";
                                }
                            }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

        <div class="card2">
            <div class="content">
                <div class="title">
                    <h3>Ficha técnica</h3>
                </div>
                <form action="" method="POST" class="description">
                    <h5>Informações Cliente</h5>
                    <input type="text" id="id_cliente" name="id_cliente" style="display: none;">
                    <label for="nome_cliente">Cliente:</label>
                    <p id="nome_cliente" name="nome_cliente" style="display: inline;"></p><br>
                    <label for="email_cliente">Email:</label>
                    <p id="email_cliente" name="email_cliente" style="display: inline;"></p><br>
                    <label for="telefone_cliente">Telefone:</label>
                    <p id="telefone_cliente" name="telefone_cliente" style="display: inline;"></p><br>
                    
                    <h5>Informações Agendamento</h5>
                    <input type="text" id="id_agendamento" name="id_agendamento" style="display: none;">
                    <label for="receita">Receita:</label>
                    <select name="receita" id="receita">
                        <?php
                                if($todosProdutosFinais){
                                    foreach($todosProdutosFinais as $produtofinal){
                                        echo "<option value=".$produtofinal['id'] .">". $produtofinal['descricao']."</option>";
                                    }
                                }
                            ?>
                        </select><br>
                    <label for="quantidade">Quantidade:</label>
                    <input type="number" id="quantidade" name="quantidade" min="0"><br>
                    <label for="preco-venda">Preço Venda:</label>
                    <input type="text" id="preco-venda" name="preco-venda" readonly><br>
                    <label for="status">Status:</label>
                    <select name="status" id="status">
                       <?php
                            if($todosStatus){
                                foreach($todosStatus as $status){
                                    echo "<option value=".$status['id'] .">". $status['descricao']."</option>";
                                }
                            }
                        ?>
                    </select><br>
                    <label for="data_retirada">Data Retirada:</label>
                    <input type="date" id="data_retirada" name="data_retirada"><br>
                    <label for="data_agendamento">Data Agendamento:</label>
                    <input type="date" id="data_agendamento" name="data_agendamento"><br>
                    <label for="observacoes">Observações:</label>
                    <textarea id="observacoes" name="observacoes" rows="5" cols="33"></textarea><br>

                    <div class="form-buttons-acao">
                            <button type="button" class="btn" onclick="atualizar()">Atualizar</button>
                            <button type="button" class="btn" onclick="excluir()">Excluir</button>
                            <button type="button" class="btn" onclick="voltarAgendamento()">Voltar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../js/navbar.js"></script>
    <script src="../js/agendamento.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>