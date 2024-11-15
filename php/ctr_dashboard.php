<?php
require_once __DIR__ . './classes/dashboard.php';
require_once __DIR__ . './classes/paginacao.php';
require_once __DIR__ . './session_check.php';

define('PROJECT_ROOT_MYPATH', '../view'); // Ajuste para o caminho da raiz do projeto, como '/' para a raiz ou '/meu_projeto/'
verificarSessao(PROJECT_ROOT_MYPATH);

// Captura id do usuário para a página
$funcao = $_SESSION['user_funcao'];


// Preparação da Lógica de Data e Período do Dashboard
// Obtem a data de hoje e a ajusta para o in ício e o final da semana
// O método 'modify' modifica a data de acordo com a regra passada
// O método 'format' forma a data no formato desejado
$inicioDaSemana = (new DateTime())->modify('monday this week')->format('Y-m-d');
$fimDaSemana = (new DateTime())->modify('sunday this week')->format('Y-m-d');

/* Verificação para filtros */
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

// Configuração de Página
if(isset($_GET['pagina'])){
    $pagina = $_GET['pagina'];
}else{  
    $pagina = 1;
}

$dashboard = new Dashboard(); # Instância de Dashboard

$totalAgendamentosDaSemana = $dashboard->getTotalPesquisarDashboard($inicioDaSemana, $fimDaSemana, $nome_cliente, $status_id); # Retorna o total de agendamentos

// Configuração da Paginação.
$paginacao = new Paginacao($pagina, $limite_pagina = 4, $totalAgendamentosDaSemana['total']);
$inicio_pagina = $paginacao->calcularInicio();
$intervalo = $paginacao->calcularIntervalo();
$agendamentosDaSemana = $dashboard->pesquisarDashboard($inicioDaSemana, $fimDaSemana, $inicio_pagina, $limite_pagina, $nome_cliente, $status_id);

if($agendamentosDaSemana){
    $quantidadeAgendamentos = $totalAgendamentosDaSemana;
}else{
    $quantidadeAgendamentos = 0;
}

// Retorna todos os status do banco.
$todosStatus = $dashboard->getTodosStatus();