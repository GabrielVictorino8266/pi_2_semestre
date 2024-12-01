<?php
require_once __DIR__ . '../../php/ctr_estoque.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque</title>
    <link rel="stylesheet" href="../style/estoque.css">
    <script src="../js/estoque.js" defer></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="d-flex flex-nowrap">
    <div class="d-flex flex-column flex-shrink-0 p-3 min-vh-100" id="navbarMenu">
        <!-- Botão de hambúrguer fixo no topo -->
        <button class="navbar-toggler d-lg-none position-fixed top-0 start-0 m-3" id="hamburgerButton" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list" style="color: black;"></i>
        </button>

        <!-- Menu lateral que vai aparecer/ocultar no mobile -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="nav nav-pills flex-column mb-auto flex-grow-1 justify-content-around">
                <li class="nav-item">
                    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none"></a>
                    <span class="fs-4">Olá, <?php echo $_SESSION['user_name']; ?></span>
                </li>
                <hr>
                <li class="nav-item">
                    <a href="./dashboard.php" class="nav-link" aria-current="page">DASHBOARD</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="./estoque.php">ESTOQUE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./agendamento.php">AGENDAMENTO</a>
                </li>
                <?php if ($funcao && $funcao['descricao'] == "Administrador"): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./cadastro.php">CADASTRAR USUÁRIO</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="./cadastro_cliente.php">CADASTRAR CLIENTE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="./logout.php">SAIR</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container mt-5">
        <form action="" method="GET" id="form_filtro" class="container mt-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-7">
                    <div class="input-group">
                        <input class="form-control" type="text" name="buscar" id="buscar" placeholder="Digite um nome de produto...">
                        <button class="btn btn-primary" type="submit">Pesquisar</button>
                        <button class="btn btn-secondary" data-bs-toggle='modal' data-bs-target='#formModalCadastrar' type="button">Cadastrar</button>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select class="form-control" name="tipo" id="tipo">
                                <option value="">Escolha um tipo</option>
                                <?php
                                if ($filtroTipo) {
                                    foreach ($filtroTipo as $tipo_produto) {
                                        echo "<option value=" . $tipo_produto['id'] . ">" . $tipo_produto['tipo'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="me-3">
                            <label for="categoria" class="form-label">Categoria</label>
                            <select class="form-control" name="categoria" id="categoria">
                                <option value="">Escolha uma categoria</option>
                                <?php
                                if ($filtroCategoria) {
                                    foreach ($filtroCategoria as $categoria) {
                                        echo "<option value=" . $categoria['id'] . ">" . $categoria['descricao'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>

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
                if ($listagemEstoque) {
                    foreach ($listagemEstoque as $item) {
                        echo "<tr>";
                        echo "<th scope='row'>{$item['id']}</th>";
                        echo "<td>{$item['descricao']}</td>";
                        echo "<td>{$item['quantidade']}</td>";
                        echo "<td>{$item['preco_unitario']}</td>";
                        echo "<td>{$item['preco_venda']}</td>";
                        echo "<td>
                                    <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#formModalAtualizar' onclick='mostrarFormAtualizar({$item['id']})'>Atualizar</button>
                                    <button type='button' class='btn btn-secondary' onclick='deletar({$item['id']})'>Deletar</button>
                                </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<p>Nenhum item de estoque encontrado</p>";
                }
                ?>
            </table>
        </div>
        <div>
            <nav aria-label="Paginacao">
                <ul class="pagination justify-content-center">
                    <?php
                    for ($i = $intervalo['inicio']; $i <= $intervalo['fim']; $i++) {
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
                            echo "<li class='page-item'><a class='page-link active' href='{$url_params}'>{$i}</a></li>";
                        } else {
                            echo "<li class='page-item'><a class='page-link' href='{$url_params}'>{$i}</a></li>";
                        }
                    }
                    ?>
                </ul>
            </nav>
        </div>
        <div class="modal fade" id="formModalAtualizar" tabindex="-1" aria-labelledby="formModalAtualizarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalAtualizarLabel">Atualizar Estoque</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" id="form_atualizar" style="display: none;">
                            <input class="form-control" type="hidden" id="produto_id" value="">
                            <div>
                                <label class="form-label" for="atualizar_nome_produto">Nome:</label>
                                <input class="form-control" type="text" name="atualizar_nome_produto" id="atualizar_nome_produto">
                            </div>
                            <div>
                                <div>
                                    <label class="form-label" for="atualizar_custo_unitario">Custo Unitário:</label>
                                    <input class="form-control" type="text" name="atualizar_custo_unitario" id="atualizar_custo_unitario">
                                </div>
                                <div>
                                    <label class="form-label" for="atualizar_preco_venda">Preço de Venda:</label>
                                    <input class="form-control" type="text" name="atualizar_preco_venda" id="atualizar_preco_venda">
                                </div>
                                <div>
                                    <label class="form-label" for="atualizar_quantidade">Quantidade:</label>
                                    <input class="form-control" type="number" name="atualizar_quantidade" id="atualizar_quantidade">
                                </div>
                            </div>
                            <div>
                                <label class="form-label" for="atualizar_tipo">Tipo</label>
                                <select class="form-control" name="atualizar_tipo" id="atualizar_tipo">
                                    <option value="">Escolha um tipo</option>
                                    <?php
                                    if ($filtroTipo) {
                                        foreach ($filtroTipo as $tipo_produto) {
                                            echo "<option value=" . $tipo_produto['id'] . ">" . $tipo_produto['tipo'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <label class="form-label" for="atualizar_categoria">Categoria</label>
                                <select class="form-control" name="atualizar_categoria" id="atualizar_categoria">
                                    <option value="">Escolha uma categoria:</option>
                                    <?php
                                    if ($filtroCategoria) {
                                        foreach ($filtroCategoria as $categoria) {
                                            echo "<option value=" . $categoria['id'] . ">" . $categoria['descricao'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <div>
                                    <label class="form-label" for="atualizar_ativado">Ativado:</label>
                                    <input class="form-control" type="number" id="atualizar_ativado" name="atualizar_ativado" value="" min="0" max="1">
                                </div>

                            </div>
                            <div>

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class='btn btn-primary' onclick="atualizar()">Atualizar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="formModalCadastrar" tabindex="-1" aria-labelledby="formModalCadastrarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalCadastrarLabel">Cadastrar Estoque</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" id="form_cadastro">
                            <div>
                                <label class="form-label" for="cadastro_nome_produto">Nome:</label>
                                <input class="form-control" type="text" name="cadastro_nome_produto" id="cadastro_nome_produto">
                            </div>
                            <div>
                                <div>
                                    <label class="form-label" for="cadastro_custo_unitario">Custo Unitário:</label>
                                    <input class="form-control" type="text" name="cadastro_custo_unitario" id="cadastro_custo_unitario">
                                </div>
                                <div>
                                    <label class="form-label" for="cadastro_preco_venda">Preço de Venda:</label>
                                    <input class="form-control" type="text" name="cadastro_preco_venda" id="cadastro_preco_venda">
                                </div>
                                <div>
                                    <label for="cadastro_quantidade">Quantidade:</label>
                                    <input class="form-control" type="number" name="cadastro_quantidade" id="cadastro_quantidade">
                                </div>
                            </div>
                            <div>
                                <label class="form-label" for="cadastro_tipo">Tipo</label>
                                <select class="form-control" name="cadastro_tipo" id="cadastro_tipo">
                                    <option value="">Escolha um tipo</option>
                                    <?php
                                    if ($filtroTipo) {
                                        foreach ($filtroTipo as $tipo_produto) {
                                            echo "<option value=" . $tipo_produto['id'] . ">" . $tipo_produto['tipo'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <label class="form-label" for="cadastro_categoria">Categoria</label>
                                <select class="form-control" name="cadastro_categoria" id="cadastro_categoria">
                                    <option value="">Escolha uma categoria:</option>
                                    <?php
                                    if ($filtroCategoria) {
                                        foreach ($filtroCategoria as $categoria) {
                                            echo "<option value=" . $categoria['id'] . ">" . $categoria['descricao'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div>
                                <label class="form-label" for="cadastro_ativado">Ativado:</label>
                                <input class="form-control" type="number" id="cadastro_ativado" name="cadastro_ativado" value="" min="0" max="1">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="cadastrar()">Cadastrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>