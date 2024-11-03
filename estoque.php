<?php
require_once './php/ctr_estoque.php';



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque</title>
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

        <h1>Estoque front</h1>
        <div>
            <form action="" method="GET" id="form_filtro">
                <input type="text" name="buscar" id="buscar" placeholder="Digite um nome de produto...">
                <button type="submit">Pesquisar</button>
                <select name="tipo" id="tipo">
                    <option value="">Escolha um tipo</option>
                    <?php
                    if($filtroTipo){
                        foreach($filtroTipo as $tipo_produto){
                            echo "<option value=".$tipo_produto['id'] .">". $tipo_produto['tipo']."</option>";
                        }
                    }
                    ?>
                </select>
                <select name="categoria" id="categoria">
                    <option value="">Escolha uma categoria</option>
                    <?php
                    if($filtroCategoria){
                        foreach($filtroCategoria as $categoria){
                            echo "<option value=".$categoria['id'] .">". $categoria['descricao']."</option>";
                        }
                    }
                    ?>
                </select>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Custo Unitário</th>
                        <th>Preço de Venda</th>
                    </tr>
                </thead>
                    <?php
                    if($listagemEstoque){
                        foreach($listagemEstoque as $item){
                            echo "<tr>";
                                echo "<td>{$item['id']}</td>";
                                echo "<td>{$item['descricao']}</td>";
                                echo "<td>{$item['quantidade']}</td>";
                                echo "<td>{$item['preco_unitario']}</td>";
                                echo "<td>{$item['preco_venda']}</td>";
                            echo "</tr>";
                        }
                    }else{
                        echo "<p>Nenhum item de estoque encontrado</p>";
                    }
                    ?>
            </table>
            <div>
                <!-- Paginacao -->
                <?php
                    for($i = $intervalo['inicio']; $i <= $intervalo['fim']; $i++){
                        if(!isset($_GET['buscar']) || !isset($_GET['tipo_id']) || !isset($_GET['categoria_id'])){
                            if($i == $pagina){
                                echo "<a class='active' href='?pagina={$i}'>{$i}</a> ";
                            }else{
                                echo "<a href='?pagina={$i}'>{$i}</a> ";
                            }
                        }else{
                            if($i == $pagina){
                                echo "<a class='active' href='?pagina={$i}&buscar={$nome_produto}'>{$i}</a> ";
                            }else{
                                echo "<a href='?pagina={$i}&buscar={$nome_produto}&tipo={$tipo_id}&categoria={$categoria_id}'>{$i}</a> ";
                            }
                        }
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>