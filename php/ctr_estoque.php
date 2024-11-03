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