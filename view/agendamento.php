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
                    <a class="nav-link" href="./estoque.php">ESTOQUE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="./agendamento.php">AGENDAMENTO</a>
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
                    <a class="nav-link text-danger btn-sair" href="./logout.php">SAIR</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="container mt-5">
        <form action="" method="GET" class="container mt-3">
            <div class="row g-3 align-items-end search-dropdown">
                <div class="col-md-7 search">
                    <div class="input-group">
                        <input type="text" class="form-control" name="buscar" id="buscar" placeholder="Digite um nome de cliente">
                        <button class="btn btn-primary" type="submit">Pesquisar</button>
                        <button class="btn btn-secondary" data-bs-toggle='modal' data-bs-target='#formModalCadastrar' type="button">Cadastrar</button>
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
                if ($listagemAgendamentos) {
                    foreach ($listagemAgendamentos as $agendamento) {
                        echo "<tr>";
                        echo "<td style='display: none;'>{$agendamento['id_agendamento']}</td>";
                        echo "<td>{$agendamento['data_retirada']}</td>";
                        echo "<td>{$agendamento['nome']}</td>";
                        echo "<td>{$agendamento['descricao']}</td>";
                        echo "<td>
                                        <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#formModalAtualizar' onclick='visualizar({$agendamento['id_agendamento']})'>Visualizar</button>
                                    </td>";
                        echo "</tr>";
                    }
                } else {
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

        <div class="modal fade" id="formModalAtualizar" tabindex="-1" aria-labelledby="formModalAtualizarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalAtualizarLabel">Ficha Técnica</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" class="description">
                            <div class="mb-3">
                                <h5>Informações Cliente</h5>
                                <input class="form-control" type="text" id="id_cliente" name="id_cliente" style="display: none;">

                                <div class="d-flex">
                                    <label class="form-label me-2" for="nome_cliente">Cliente:</label>
                                    <p id="nome_cliente" name="nome_cliente"></p>
                                </div>

                                <div class="d-flex">
                                    <label class="form-label me-2" for="email_cliente">Email:</label>
                                    <p id="email_cliente" name="email_cliente" style="display: inline;"></p>
                                </div>
                                
                                <div class="d-flex">
                                    <label class="form-label me-2" for="telefone_cliente">Telefone:</label>
                                    <p id="telefone_cliente" name="telefone_cliente" style="display: inline;"></p>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h5>Informações Agendamento</h5>
                                <input class="form-control" type="text" id="id_agendamento" name="id_agendamento" style="display: none;">
                                <label class="form-label" for="receita">Receita:</label>
                                <select class="form-control" name="receita" id="receita">
                                    <?php
                                    if ($todosProdutosFinais) {
                                        foreach ($todosProdutosFinais as $produtofinal) {
                                            echo "<option value=" . $produtofinal['id'] . ">" . $produtofinal['descricao'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <label class="form-label" for="quantidade">Quantidade:</label>
                                <input class="form-control" type="number" id="quantidade" name="quantidade" min="0">
                                <label class="form-label" for="preco-venda">Preço Venda:</label>
                                <input class="form-control" type="text" id="preco-venda" name="preco-venda" readonly>
                                <label class="form-label" for="status">Status:</label>
                                <select class="form-control" name="status" id="status">
                                    <?php
                                    if ($todosStatus) {
                                        foreach ($todosStatus as $status) {
                                            echo "<option value=" . $status['id'] . ">" . $status['descricao'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <label class="form-label" for="data_retirada">Data Retirada:</label>
                                <input class="form-control" type="date" id="data_retirada" name="data_retirada">
                                <label class="form-label" for="data_agendamento">Data Agendamento:</label>
                                <input class="form-control" type="date" id="data_agendamento" name="data_agendamento">
                                <label class="form-label" for="observacoes">Observações:</label>
                                <textarea class="form-control" id="observacoes" name="observacoes" rows="5" cols="33"></textarea>
                            </div>
                            <div class="modal-footer form-buttons-acao">
                                <button type="button" class="btn btn-primary" onclick="atualizar()">Atualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="formModalCadastrar" tabindex="-1" aria-labelledby="formModalCadastrarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalCadastrarLabel">Cadastrar Agendamento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body dflex">
                        <form action="" method="POST" class="description">
                            <div class="mb-3">
                                <h5>Informações Cliente</h5>
                                <label class="form-label" for="cadastrar_nome_cliente">Nome do cliente:</label>
                                <input class="form-control" type="text" id="cadastrar_nome_cliente" name="cadastrar_nome_cliente" autocomplete="off">
                                <div id="caixaSugestao" class="list-group position-absolute w-75 shadow "></div>
                            </div>

                            <div class="mb-3">
                                <h5>Informações Agendamento</h5>
                                <label class="form-label" for="cadastrar_receita">Receita:</label>
                                <select class="form-control" name="cadastrar_receita" id="cadastrar_receita">
                                    <?php
                                    if ($todosProdutosFinais) {
                                        foreach ($todosProdutosFinais as $produtofinal) {
                                            echo "<option value=" . $produtofinal['id'] . ">" . $produtofinal['descricao'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <label class="form-label" for="cadastrar_quantidade">Quantidade:</label>
                                <input class="form-control" type="number" id="cadastrar_quantidade" name="cadastrar_quantidade" min="0">
                                <label class="form-label" for="cadastrar_status">Status:</label>
                                <select class="form-control" name="cadastrar_status" id="cadastrar_status">
                                    <?php
                                    if ($todosStatus) {
                                        foreach ($todosStatus as $status) {
                                            echo "<option value=" . $status['id'] . ">" . $status['descricao'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <label class="form-label" for="cadastrar_data_retirada">Data Retirada:</label>
                                <input class="form-control" type="date" id="cadastrar_data_retirada" name="cadastrar_data_retirada">
                                <label class="form-label" for="cadastrar_data_agendamento">Data Agendamento:</label>
                                <input class="form-control" type="date" id="cadastrar_data_agendamento" name="cadastrar_data_agendamento">
                                <label class="form-label" for="cadastrar_observacoes">Observações:</label>
                                <textarea class="form-control" id="cadastrar_observacoes" name="cadastrar_observacoes" rows="5" cols="33"></textarea>
                            </div>
                            <div class="modal-footer form-buttons-acao">
                                <button type="button" class="btn btn-primary" onclick="cadastrarAgendamento()">Cadastrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/agendamento.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>