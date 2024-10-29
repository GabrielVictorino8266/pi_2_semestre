<?php
require_once __DIR__ . '\classes\conexao.php';
require_once __DIR__ . '\classes\query.php';

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
// $inicioDaSemana->modify('monday this week')->modify('+1 day');
$fimDaSemana = clone $hoje;
$fimDaSemana->modify('sunday this week');
$inicioDaSemana = $inicioDaSemana->format('Y-m-d');
$fimDaSemana = $fimDaSemana->format('Y-m-d');

$agendamentosDaSemana = $query->getAgendamentosDashboard($inicioDaSemana, $fimDaSemana);
if($agendamentosDaSemana){
    $quantidadeAgendamentos = count($agendamentosDaSemana);
    // var_dump($agendamentosParaEstaSenana);
}else{
    $quantidadeAgendamentos = 0;
}