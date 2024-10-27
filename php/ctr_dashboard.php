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
$inicioDaSemana = $inicioDaSemana->format('Y-m-d');
$fimDaaSemana = $fimDaSemana->format('Y-m-d');

$agendametosDaSemana = $query->getAgendamentosDashboard($inicioDaSemana, $fimDaaSemana);