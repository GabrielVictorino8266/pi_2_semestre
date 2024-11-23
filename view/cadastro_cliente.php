<?php
require_once __DIR__ . "/../php/ctr_cadastro_clientes.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Clientes</title>
</head>
<body>
    <h2>Cadastro de Clientes</h2>
    
    <form action="../php/ctr_cadastro_clientes.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>
        
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" required><br><br>
        
        <input type="submit" value="Cadastrar Cliente">
    </form>

    <div id="listagemclientes">
        <h3>Listagem de Clientes</h3>
        <table>
            <thead>
                <td>Id</td>
                <td>Nome</td>
                <td>Email</td>
                <td>Telefone</td>
            </thead>
            <?php
            foreach ($listagem_clientes as $cliente){
                echo "<tr>";
                echo "<td>".$cliente['id']."</td>";
                echo "<td>".$cliente['nome']."</td>";
                echo "<td>".$cliente['email']."</td>";
                echo "<td>".$cliente['telefone']."</td>";
                echo "</tr>";
            }
            ?>
        </table>
        
    </div>
</body>
</html>
