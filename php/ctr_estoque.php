<?php
require_once __DIR__ . './classes/conexao.php';
require_once __DIR__ . './classes/query.php';
require_once __DIR__ . './classes/estoque.php';
require_once __DIR__ . '\classes\paginacao.php';

session_start();

$conexao= new Conexao();#Chamo a conexao
$query = new Query($conexao);#Chamo a query

/*
Verificando a função do usuário.
*/
$funcao = $query->getFuncaoUsuarioId($_SESSION['user_id']);

if(!isset($_SESSION['user_id'])){# Verificação de sessão
    header('location: ./index.php');
    exit;
}

/*
Configuração de pagina.
*/
// Define limite de pagina e define a pagina atual.
$limite_pagina = 4;
if(isset($_GET['pagina'])){
    $pagina = $_GET['pagina'];
}else{  
    $pagina = 1;
}


/*
Instanciando objeto estoque da Classe Estoque.
*/
$estoque = new Estoque($query);

// Captura a ação desejada da URL
$action = isset($_POST['action']) ? $_POST['action'] : '';

if($action == "preencher" && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $dados = [
        'id' => $id
    ];

    $sucesso = $estoque->carregarInformacoesItem($id);

    if($sucesso){
        echo json_encode([
            'success' => true, 'produto' => $sucesso
        ]);
    }else{
        echo json_encode([
            'success' => false, 'message' => "Informações não recuperadas!"
        ]);
    }
}


//Lógica de atualização
if ($action == 'atualizar' &&  $_SERVER['REQUEST_METHOD'] == 'POST') {
    //atualizando dados
    // Monta dos dados para atualizar
    $dados = [
        'id' => $_POST['id'],
        'descricao' => $_POST['descricao'],
        'quantidade' => $_POST['quantidade'],
        'preco_unitario' => $_POST['custo'],
        'preco_venda' => $_POST['venda'],
        'tipo_id' => $_POST['tipo'],
        'categoria_id' => $_POST['categoria']
    ];
    $id = $dados['id'];

    $sucesso = $estoque->atualizarItem($id, $dados);
    if($sucesso){
        echo json_encode([
            'success' => true, 'message' => "Item atualizado com sucesso!", 'produto' => $sucesso
        ]);
    }else{
        echo json_encode([
            'success' => false, 'message' => "Item não foi atualizado!"
        ]);
    }
    exit;
}


//Lógica de exclusão
if($action == "deletar" && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $dados = ['id' => $_POST['id']];

    $id = $dados['id'];
    $sucesso = $estoque->deletarProduto($id);

    if($sucesso){
        echo json_encode([
            'success' => true, 'message' => "Item excluído com sucesso!"
        ]);
    }else{
        echo json_encode([
            'success' => false, 'message' => "Item não foi excluído!"
        ]);
    }
    exit;
}

//lógica de cadastro
if($action == "cadastrar" && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $dados = [
        'descricao' => $_POST['descricao'],
        'quantidade' => $_POST['quantidade'],
        'preco_unitario' => $_POST['custo'],
        'preco_venda' => $_POST['venda'],
        'tipo_id' => $_POST['tipo'],
        'categoria_id' => $_POST['categoria']
    ];

    $sucesso = $estoque->cadastrarProduto($dados);
    if($sucesso){
        echo json_encode([
            'success' => true, 'message' => "Item cadastrado com sucesso!"
        ]);
    }else{
        echo json_encode([
            'success' => false, 'message' => "Item não foi cadastrado!"
        ]);
    }
    exit;
}

/*
Listagem da contagem de todo o estoque.
*/
$contagemEstoque = $estoque->listarContagemEstoque();
$paginacao = new Paginacao($pagina, $limite_pagina, $contagemEstoque['total']);
$inicio_pagina = $paginacao->calcularInicio();
$intervalo = $paginacao->calcularIntervalo();

$listagemEstoque = $estoque->listarEstoque($inicio_pagina, $limite_pagina);

/*
Retorno de dados para filtros de Tipo Item e Categoria.
 */
$filtroTipo = $estoque->listarTipoItem();
$filtroCategoria = $estoque->listarCategoria();