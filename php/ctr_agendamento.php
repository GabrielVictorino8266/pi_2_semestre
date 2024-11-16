<?php
require_once __DIR__ . '/session_check.php';
require_once __DIR__ . '/classes/agendamento.php';
require_once __DIR__ . '/classes/paginacao.php';

define('PROJECT_ROOT_MYPATH', '../view'); // Ajuste para o caminho da raiz do projeto, como '/' para a raiz ou '/meu_projeto/'
verificarSessao(PROJECT_ROOT_MYPATH);

$funcao = $_SESSION['user_funcao'];

if(isset($_GET['data_retirada_inicial'])){
    $data_retirada_inicial = $_GET['data_retirada_inicial'];
}else{
    $data_retirada_inicial = '';
}

/* Verificação para filtros */
if(isset($_GET['buscar'])){
    $nome_cliente = $_GET['buscar'];
}else{
    $nome_cliente = '';
}

// Configuração de Página
if(isset($_GET['pagina'])){
    $pagina = $_GET['pagina'];
}else{  
    $pagina = 1;
}

$agendamentos = new Agendamento(); # Instância de Dashboard

$totalAgendamentos = $agendamentos->getTotalAgendamentos($nome_cliente, $data_retirada_inicial); # Retorna o total de agendamentos

// Configuração da Paginação.
$paginacao = new Paginacao($pagina, $limite_pagina = 8, $totalAgendamentos['total']);
$inicio_pagina = $paginacao->calcularInicio();
$intervalo = $paginacao->calcularIntervalo();
$listagemAgendamentos = $agendamentos->pesquisarAgendamentos($inicio_pagina,  $limite_pagina = 8, $nome_cliente, $data_retirada_inicial);


if($totalAgendamentos){
    $quantidadeAgendamentos = $totalAgendamentos['total'];
}else{
    $quantidadeAgendamentos = 0;
}