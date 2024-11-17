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

// CArrega todos os status para o input status
if(!isset($todosStatus)){
    $todosStatus = $agendamentos->getTodosStatus();
} 

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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false){
    $input = json_decode(file_get_contents('php://input'), true);
    $action = $input['action'];

    // echo json_encode([
    //     "success" => true,
    //     "message" => "Entoru no ctr_agendamento.",
    //     "input" => $input
    // ]);
    switch ($action) {
        case "preencher":
            preeencher($agendamentos, $input);
            break;
        default:
        echo json_encode([
            "success" => false,
            "message" => "Erro ao Realizar operação."
        ]);
    }
    
}

function preeencher($agendamentos, $input){
        // Verifica se 'acao' e 'id' estão setados na entrada e se 'acao' é 'preencher'
        if (isset($input['action'], $input['id']) && $input['action'] == 'preencher') {
            $id = $input['id']; // Obtenha o id do item da entrada
            $produto = $agendamentos->carregarInformacoesItem($id); // Carregue informações do item no agendamento
            
            // Se as informações do item forem obtidas com sucesso
            if ($produto) {
                echo json_encode([
                    "success" => true,
                    "data" => $produto // Retorne as informações do item
                ]);
            }
        }else{
            echo json_encode([
                "success" => false,
                "message" => "Erro ao carregar informações do item."
            ]);
            exit;
        }
}