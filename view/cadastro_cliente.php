<?php
require_once __DIR__ . "/../php/ctr_cadastro_clientes.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastro de Clientes</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        
    </head>
    <body>
        <div class="container mt-5">
            <h3 class="text-center">Cadastro de Clientes</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formModal">Cadastrar</button>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <th scope="col">Id</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Rua</th>
                    <th scope="col">Numero</th>
                    <th scope="col">Bairro</th>
                    <th scope="col">Cidade</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Cep</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($listagem_clientes as $cliente){
                        echo "<tr>";
                        echo "<th scope='row' id='idcliente'>".$cliente['id']."</th>";
                        echo "<td>".$cliente['nome']."</td>";
                        echo "<td>".$cliente['email']."</td>";
                        echo "<td>".$cliente['telefone']."</td>";
                        echo "<td>".$cliente['rua']."</td>";
                        echo "<td>".$cliente['numero']."</td>";
                        echo "<td>".$cliente['bairro']."</td>";
                        echo "<td>".$cliente['cidade']."</td>";
                        echo "<td>".$cliente['estado']."</td>";
                        echo "<td>".$cliente['cep']."</td>";
                        echo "<td>";
                        echo "<button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#formModalAtualizar' onclick='mostrarFormAtualizar({$cliente['id']})'>Atualizar</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Preencha o formulario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="form_cadastro">
                        <div class="mb-3">
                            <label class="form-label" for="nome">Nome:</label>
                            <input class="form-control" type="text" id="nome" name="nome" placeholder="Nome do cliente">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="email">E-mail:</label>
                            <input class="form-control" type="email" id="email" name="email" placeholder="E-mail do cliente" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="telefone">Telefone:</label>
                            <input class="form-control" type="text" id="telefone" name="telefone" placeholder="Telefone do cliente" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="rua">Rua:</label>
                            <input class="form-control" type="text" id="rua" name="rua" placeholder="Rua" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label" for="numero">Numero:</label>
                            <input class="form-control" type="email" id="numero" name="numero" placeholder="Numero" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="bairro">Bairro:</label>
                            <input class="form-control" type="text" id="bairro" `name="bairro" placeholder="Bairro" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="cidade">Cidade:</label>
                            <input class="form-control" type="text" id="cidade" name="cidade" placeholder="Cidade" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="estado">Estado:</label>
                            <input class="form-control" type="text" id="estado" name="estado" placeholder="Estado" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="cep">CEP:</label>
                            <input class="form-control" type="text" id="cep" name="cep" placeholder="CEP" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary" onclick="cadastrar()">Enviar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="formModalAtualizar" tabindex="-1" aria-labelledby="formModalAtualizarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalAtualizarLabel">Preencha o formulario de atualização</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="form_cadastro">
                        <div class="mb-3">
                            <label class="form-label" for="atualizar_nome">Nome:</label>
                            <input class="form-control" type="text" id="atualizar_nome" name="atualizar_nome" placeholder="Nome do cliente">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="atualizar_email">E-mail:</label>
                            <input class="form-control" type="email" id="atualizar_email" name="atualizar_email" placeholder="E-mail do cliente" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="atualizar_telefone">Telefone:</label>
                            <input class="form-control" type="text" id="atualizar_telefone" name="atualizar_telefone" placeholder="Telefone do cliente" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="atualizar_rua">Rua:</label>
                            <input class="form-control" type="text" id="atualizar_rua" name="atualizar_rua" placeholder="Rua" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label" for="atualizar_numero">Numero:</label>
                            <input class="form-control" type="email" id="atualizar_numero" name="atualizar_numero" placeholder="Numero" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="atualizar_bairro">Bairro:</label>
                            <input class="form-control" type="text" id="atualizar_bairro" name="atualizar_bairro" placeholder="Bairro" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="atualizar_cidade">Cidade:</label>
                            <input class="form-control" type="text" id="atualizar_cidade" name="atualizar_cidade" placeholder="Cidade" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="atualizar_estado">Estado:</label>
                            <input class="form-control" type="text" id="atualizar_estado" name="atualizar_estado" placeholder="Estado" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="atualizar_cep">CEP:</label>
                            <input class="form-control" type="text" id="atualizar_cep" name="atualizar_cep" placeholder="CEP" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary" onclick="atualizar()">Enviar</button>
                </div>
            </div>
        </div>
    </div>


    <script src="../js/cadastroCliente.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
