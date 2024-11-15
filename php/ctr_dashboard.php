<?php
require_once __DIR__ . '/classes/conexao.php';
require_once __DIR__ . '/classes/query.php';
require_once __DIR__ . '/classes/paginacao.php';
require_once __DIR__ . '/session_check.php';

define('PROJECT_ROOT_MYPATH', '../view'); // Ajuste para o caminho da raiz do projeto, como '/' para a raiz ou '/meu_projeto/'
verificarSessao(PROJECT_ROOT_MYPATH);

$conexao = new Conexao(); #Cria conexão com o banco para esta tela
$query = new Query($conexao); # Passa a conexão para a classe query
$funcao = $query->getFuncaoUsuarioId($_SESSION['user_id']);


$hoje = new DateTime();
$inicioDaSemana = clone $hoje;
$inicioDaSemana->modify('monday this week');
$fimDaSemana = clone $hoje;
$fimDaSemana->modify('sunday this week');
$inicioDaSemana = $inicioDaSemana->format('Y-m-d');
$fimDaSemana = $fimDaSemana->format('Y-m-d');


// Define limite de pagina e define a pagina atual.
$limite_pagina = 4;
if(isset($_GET['pagina'])){
    $pagina = $_GET['pagina'];
}else{  
    $pagina = 1;
}

/* Verifcação para filtros */

if(isset($_GET['buscar'])){
    $nome_cliente = $_GET['buscar'];
}else{
    $nome_cliente = '';
}

if(isset($_GET['status'])){
    $status_id = $_GET['status'];
}else{
    $status_id = '';
}
$totalAgendamentosDaSemana = $query->getTotalPesquisarDashboard($inicioDaSemana, $fimDaSemana, $nome_cliente, $status_id); # Retorna o total de agendamentos

// Nova instância de paginacao
$paginacao = new Paginacao($pagina, $limite_pagina, $totalAgendamentosDaSemana['total']);
$inicio_pagina = $paginacao->calcularInicio();
$intervalo = $paginacao->calcularIntervalo();
$agendamentosDaSemana = $query->pesquisarDashboard($inicioDaSemana, $fimDaSemana, $inicio_pagina, $limite_pagina, $nome_cliente, $status_id);

if($agendamentosDaSemana){
    $quantidadeAgendamentos = $totalAgendamentosDaSemana;
}else{
    $quantidadeAgendamentos = 0;
}

// Filtro de Status
$todosStatus = $query->getTodosStatus();