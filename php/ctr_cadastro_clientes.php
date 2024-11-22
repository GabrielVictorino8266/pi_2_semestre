<?php
require_once __DIR__ . '/classes/conexao.php';
require_once __DIR__ . '/classes/cadastroclientes.php';
require_once __DIR__ . '/session_check.php';
require_once __DIR__ . '/classes/paginacao.php';

define('PROJECT_ROOT_MYPATH', '../view'); 
verificarSessao(PROJECT_ROOT_MYPATH);

$cadastro = new CadastroClientes();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    $cadastro->adicionarCliente($nome, $email, $telefone);
    $_SESSION['message'] = "Cliente cadastrado com sucesso!";
    header('Location: cadastrarclientes.php');
    exit;
}

// Exibe mensagem de sucesso se houver
if (isset($_SESSION['message'])) {
    echo "<p>{$_SESSION['message']}</p>";
    unset($_SESSION['message']);
}

$listagem_clientes = $cadastro->listarClientes();