<?php
require_once '../../php/ctr_estoque.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>


    <link rel="stylesheet" href="./style/estoque.css">
    <script src="./js/estoque.js" defer></script>
</head>
<body>
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
    

        <div>
            <form action="" method="GET" id="form_filtro">
                <input type="text" name="buscar" id="buscar" placeholder="Digite um nome de produto...">
                <button type="submit">Pesquisar</button>
                <button type="button" onclick="mostrarFormCadastro()">Cadastrar</button>
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
        </div>

        <div>
            <!-- Formulário de cadastro -->

            <form action="" method="POST" id="form_cadastro">
            <h3>Cadastrar Novo Produto</h3>
                <div>
                    <label for="cadastro_nome_produto">Nome:</label>
                    <input type="text" name="cadastro_nome_produto" id="cadastro_nome_produto">
                </div>
                <div>
                    <div>
                        <label for="cadastro_custo_unitario">Custo Unitário:</label>
                        <input type="text" name="cadastro_custo_unitario" id="cadastro_custo_unitario">
                    </div>
                    <div>
                        <label for="cadastro_preco_venda">Preço de Venda:</label>
                        <input type="text" name="cadastro_preco_venda" id="cadastro_preco_venda">
                    </div>
                    <div>
                        <label for="cadastro_quantidade">Quantidade:</label>
                        <input type="number" name="cadastro_quantidade" id="cadastro_quantidade">
                    </div>
                </div>            
                <div>
                    <label for="cadastro_tipo">Tipo</label>
                    <select name="cadastro_tipo" id="cadastro_tipo">
                        <option value="">Escolha um tipo</option>
                        <?php
                        if($filtroTipo){
                            foreach($filtroTipo as $tipo_produto){
                                echo "<option value=".$tipo_produto['id'] .">". $tipo_produto['tipo']."</option>";
                            }
                        }
                        ?>
                    </select>
                    <label for="cadastro_categoria">Categoria</label>
                    <select name="cadastro_categoria" id="cadastro_categoria">
                        <option value="">Escolha uma categoria:</option>
                        <?php
                        if($filtroCategoria){
                            foreach($filtroCategoria as $categoria){
                                echo "<option value=".$categoria['id'] .">". $categoria['descricao']."</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <button type="button" onclick="cadastrar()">Cadastrar</button>
                    <button type="button" onclick="voltarFormularioCadastro()">Voltar</button>
                </div>
            </form>
        </div>

        <div>
            <!-- Formulário de atualização -->
            <form action="" method="POST" id="form_atualizar">
                <input type="hidden" id="produto_id" value="">

                <h3>Atualizar Produto</h3>
                <div>
                    <label for="atualizar_nome_produto">Nome:</label>
                    <input type="text" name="atualizar_nome_produto" id="atualizar_nome_produto">
                </div>
                <div>
                    <div>
                        <label for="atualizar_custo_unitario">Custo Unitário:</label>
                        <input type="text" name="atualizar_custo_unitario" id="atualizar_custo_unitario">
                    </div>
                    <div>
                        <label for="atualizar_preco_venda">Preço de Venda:</label>
                        <input type="text" name="atualizar_preco_venda" id="atualizar_preco_venda">
                    </div>
                    <div>
                        <label for="atualizar_quantidade">Quantidade:</label>
                        <input type="number" name="atualizar_quantidade" id="atualizar_quantidade">
                    </div>
                </div>            
                <div>
                    <label for="atualizar_tipo">Tipo</label>
                    <select name="atualizar_tipo" id="atualizar_tipo">
                        <option value="">Escolha um tipo</option>
                        <?php
                        if($filtroTipo){
                            foreach($filtroTipo as $tipo_produto){
                                echo "<option value=".$tipo_produto['id'] .">". $tipo_produto['tipo']."</option>";
                            }
                        }
                        ?>
                    </select>
                    <label for="atualizar_categoria">Categoria</label>
                    <select name="atualizar_categoria" id="atualizar_categoria">
                        <option value="">Escolha uma categoria:</option>
                        <?php
                        if($filtroCategoria){
                            foreach($filtroCategoria as $categoria){
                                echo "<option value=".$categoria['id'] .">". $categoria['descricao']."</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <button type="button" onclick="atualizar()">Atualizar</button>
                    <button type="button" onclick="voltarFormularioAtualizar()">Voltar</button>
                </div>
            </form>
        </div>

        <div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Custo Unitário</th>
                        <th>Preço de Venda</th>
                        <th>Ações</th>
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
                                echo "<td>
                                    <button type='button' onclick='mostrarFormAtualizar({$item['id']})'>Atualizar</button>
                                    <button type='button' onclick='deletar({$item['id']})'>Deletar</button>
                                </td>";
                            echo "</tr>";
                        }
                    }else{
                        echo "<p>Nenhum item de estoque encontrado</p>";
                    }
                    ?>
            </table>
        </div>
        <!-- Paginacao -->
        <div>
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
</body>
</html>