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
$fimDaSemana = clone $hoje;
$fimDaSemana->modify('sunday this week');
$inicioDaSemana = $inicioDaSemana->format('Y-m-d');
$fimDaSemana = $fimDaSemana->format('Y-m-d');

// PAGINAÇÃO
$limite_pagina = 5; # Define o limite de agendamentos por pagina
if(isset($_GET['pagina'])){
    $pagina = $_GET['pagina'];
}else{  
    $pagina = 1;
}
$inicio_pagina = ($pagina * $limite_pagina) - $limite_pagina;

// Executa a consulta no banco
$agendamentosDaSemana = $query->getAgendamentosDashboard($inicioDaSemana, $fimDaSemana, $inicio_pagina, $limite_pagina);
$totalAgendamentosDaSemana = $query->getTotalAgendamentosDashboard($inicioDaSemana, $fimDaSemana);
var_dump($totalAgendamentosDaSemana);

if($agendamentosDaSemana){
    $quantidadeAgendamentos = count($agendamentosDaSemana);
   }else{
    $quantidadeAgendamentos = 0;
}