<?php
require_once __DIR__ . "../../php/ctr_dashboard.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" href="../style/dashboard.css">

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
                    <a href="./dashboard.php" class="nav-link active" aria-current="page">DASHBOARD</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./estoque.php">ESTOQUE</a>
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
                    <a class="nav-link text-danger btn-sair" href="./logout.php">SAIR</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container mt-5">
        <form action="" method="GET" id="form_filtro" class="container mt-3">
            <div class="row g-3 align-items-end search-dropdown">
                <div class="col-md-7 search">
                    <div class="input-group">
                        <input type="text" class="form-control" name="buscar" id="buscar" placeholder="Digite um nome de cliente">
                        <button class="btn btn-primary" type="submit">Pesquisar</button>
                    </div>
                </div>
                <div class="col-md-4 filtro">
                    <div class="form-group">
                        <label for="status">Escolha um status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="">Escolha um status</option>
                            <?php
                            if ($todosStatus) {
                                foreach ($todosStatus as $status) {
                                    echo "<option value=" . $status['id'] . ">" . $status['descricao'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </form>

        <div class="table-responsive dados-tabela">
            <div class="info-alinhamento">
                <p>Agendamentos desta semana: <?php echo $totalAgendamentosDaSemana['total']; ?></p>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Data Retirada</th>
                        <th scope="col">Produto</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <?php
                if ($quantidadeAgendamentos) {
                    foreach ($agendamentosDaSemana as $agendamento) {
                        $data = new DateTimeImmutable($agendamento['data_retirada']);
                        if ($data) {
                            $dataFormatada = $data->format('d/m/Y'); # Formata a data para dd/mm/aaaa
                        }
                        echo "<tr>";
                        echo "<td>{$dataFormatada}</td>";
                        echo "<td>{$agendamento['produto']}</td>";
                        echo "<td>{$agendamento['nome_cliente']}</td>";
                        echo "<td>{$agendamento['status']}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>Nenhum agendamento encontrado</td></tr>";
                }
                ?>
            </table>
        </div>
        <div>
            <!-- Paginacao -->
            <?php
            for ($i = $intervalo['inicio']; $i <= $intervalo['fim']; $i++) {
                // Inicializa a URL com o parâmetro de página
                $pagina_url = "?pagina={$i}";

                // Adiciona o parâmetro 'buscar' se estiver definido
                if (isset($_GET['buscar']) && $_GET['buscar'] != "") {
                    $nome_cliente = htmlspecialchars($_GET['buscar'], ENT_QUOTES, 'UTF-8');
                    $pagina_url .= "&buscar={$nome_cliente}";
                }

                // Adiciona o parâmetro 'status' se estiver definido
                if (isset($_GET['status']) && $_GET['status'] != "") {
                    $status_id = htmlspecialchars($_GET['status'], ENT_QUOTES, 'UTF-8');
                    $pagina_url .= "&status={$status_id}";
                }

                // Define o link com a classe 'active' para a página atual
                if ($i == $pagina) {
                    echo "<a class='active' href='{$pagina_url}'>{$i}</a> ";
                } else {
                    echo "<a href='{$pagina_url}'>{$i}</a> ";
                }
            }
            ?>
        </div>
    </div>
    </div>

    <script src="../js/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>