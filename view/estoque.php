<?php
require_once __DIR__ . '../../php/ctr_estoque.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque</title>
    <link rel="stylesheet" href="../style/style.css">
    <script src="../js/estoque.js" defer></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <!-- NAVBAR -->
    <div>
        <nav>
            <div>
                <div>
                    <p>Olá, <?php echo $_SESSION['user_name']; ?></p>
                </div>
                <a class="link-opacity-75" href="./logout.php">Sair</a>
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
                <a href="./cadastro_cliente.php">Cadastrar Cliente</a>
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

            <form action="" method="POST" id="form_cadastro" style="display: none;">
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
                    <label for="cadastro_ativado">Ativado:</label>
                    <input type="number" id="cadastro_ativado" name="cadastro_ativado" value="" min="0" max="1">
                </div>
                <div>
                    <button type="button" onclick="cadastrar()">Cadastrar</button>
                    <button type="button" onclick="voltarFormularioCadastro()">Voltar</button>
                </div>
            </form>
        </div>

        <div>
            <!-- Formulário de atualização -->
            <form action="" method="POST" id="form_atualizar" style="display: none;">
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
                    <div>
                        <label for="atualizar_ativado">Ativado:</label>
                        <input type="number" id="atualizar_ativado" name="atualizar_ativado" value="" min="0" max="1">
                    </div>

                </div>
                <div>
                    <button type="button" onclick="atualizar()">Atualizar</button>
                    <button type="button" onclick="voltarFormularioAtualizar()">Voltar</button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Produto</th>
                        <th scope="col">Quantidade</th>
                        <th scope="col">Custo Unitário</th>
                        <th scope="col">Preço de Venda</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                    <?php
                    if($listagemEstoque){
                        foreach($listagemEstoque as $item){
                            echo "<tr>";
                                echo "<th scope='row'>{$item['id']}</th>";
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
        <nav aria-label="Paginacao">
            <ul class="pagination justify-content-center">
            <?php
                for($i = $intervalo['inicio']; $i <= $intervalo['fim']; $i++){
                    // Inicializa os parâmetros de URL vazios e os adiciona se existirem
                    $url_params = "?pagina={$i}";
                    if (isset($_GET['buscar'])) {
                        $url_params .= "&buscar=" . urlencode($_GET['buscar']);
                    }
                    if (isset($_GET['tipo_id'])) {
                        $url_params .= "&tipo_id=" . urlencode($_GET['tipo_id']);
                    }
                    if (isset($_GET['categoria_id'])) {
                        $url_params .= "&categoria_id=" . urlencode($_GET['categoria_id']);
                    }

                    // Verifica se é a página atual para definir a classe 'active'
                    if ($i == $pagina) {
                        echo "<li class='page-item'><a class='page-link' href='{$url_params}'>{$i}</a></li>";
                        // echo "<a class='active' href='{$url_params}'>{$i}</a> ";
                    } else {
                        echo "<li class='page-item'><a class='page-link' href='{$url_params}'>{$i}</a></li>";
                        // echo "<a href='{$url_params}'>{$i}</a> ";
                    }
                }
            ?>
            </ul>
        </nav>

    <!-- <li class="page-item"><a class="page-link" href="#">Previous</a></li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">Next</a></li> -->
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>