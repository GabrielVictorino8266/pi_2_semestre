<?php
require_once __DIR__ . '\classes\conexao.php';
require_once __DIR__ . '\classes\query.php';
require_once __DIR__ . '\classes\paginacao.php';

session_start();

if(!isset($_SESSION['user_id'])){# Verificação de sessão
    header('location: ./index.php');
    exit;
}

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



// Definie limite de pagina e define a pagina atual.
$limite_pagina = 5;
if(isset($_GET['pagina'])){
    $pagina = $_GET['pagina'];
}else{  
    $pagina = 1;
}

// Executa consultas de listagem e total de agendamentos
$totalAgendamentosDaSemana = $query->getTotalAgendamentosDashboard($inicioDaSemana, $fimDaSemana); # Retorna o total de agendamentos

// Nova instância de paginacao
$paginacao = new Paginacao($pagina, $limite_pagina, $totalAgendamentosDaSemana['total']);
$inicio_pagina = $paginacao->calcularInicio();
$intervalo = $paginacao->calcularIntervalo();
$agendamentosDaSemana = $query->getAgendamentosDashboard($inicioDaSemana, $fimDaSemana, $inicio_pagina, $limite_pagina);

if($agendamentosDaSemana){
    $quantidadeAgendamentos = count($agendamentosDaSemana);
}else{
    $quantidadeAgendamentos = 0;
}

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    //Verfica se há algo na pesquisa para o nome de cliente.
    if(isset($_GET['buscar'])){
        $nome_cliente = $_GET['buscar'];
        // Executa consultas de listagem e total de agendamentos após pesquisa

        $totalAgendamentosDaSemana = $query->getTotalPesquisarDashboard($inicioDaSemana, $fimDaSemana, $nome_cliente); # Retorna o total de agendamentos

        // Nova instância de paginacao
        $paginacao = new Paginacao($pagina, $limite_pagina, $totalAgendamentosDaSemana['total']);
        $inicio_pagina = $paginacao->calcularInicio();
        $intervalo = $paginacao->calcularIntervalo();
        $agendamentosDaSemana = $query->pesquisarDashboard($inicioDaSemana, $fimDaSemana, $inicio_pagina, $limite_pagina, $nome_cliente);

        if($agendamentosDaSemana){
            $quantidadeAgendamentos = count($agendamentosDaSemana);
        }else{
            $quantidadeAgendamentos = 0;
        }
    }else{
        $nome_cliente = "";
    }
}