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

// Carrega todos os status para o input status
if(!isset($todosStatus)){
    $todosStatus = $agendamentos->getTodosStatus();
} 
// Carrega todos os status para o input status
if(!isset($todosProdutosFinais)){
    $todosProdutosFinais = $agendamentos->getTodosProdutosFinais();
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

// $_SERVER['REQUEST_METHOD'] = 'POST';
// $input = json_decode('{

//     "id_agendamento": "86",
//     "action": "atualizar",
//     "data_agendamento": "2024-12-03",
//     "produto_final_id": "2",
//     "status_id": "1",
//     "observacoes": "",
//     "data_retirada": "2024-12-05",
//     "quantidade": "1",
//     "ativado": "1"
// }
// }', true);
// $_SERVER['CONTENT_TYPE'] = 'application/json';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false){
    $input = json_decode(file_get_contents('php://input'), true);
    $action = $input['action'];

    // echo json_encode([
    //     "success" => true,
    //     "message" => "Entoru no ctr_agendamento.",
    //     "input" => $input
    // ]);
    // exit;
    switch ($action) {
        case "preencher":
            preeencher($agendamentos, $input);
            break;
        case "atualizar":
            atualizar($agendamentos, $input);
            break;
        case "cadastrar":
            cadastrar($agendamentos, $input);
            break;
        default:
        echo json_encode([
            "success" => false,
            "message" => "Erro ao Realizar operação no switch do controlador."
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

function cadastrar($agendamentos, $input){
    // Verifica se 'acao' e 'id' estão setados na entrada e se 'acao' é 'atualizar'
    if(isset($input['nome_cliente'], $input['receita'], $input['quantidade'], $input['status_id'], $input['data_retirada'],$input['data_agendamento'],$input['observacoes']) && $input['action'] == 'cadastrar'){
        $nome_cliente = $input['nome_cliente'];

        //realiza pesquisa do id do cliente
        $cliente = $agendamentos->pesquisarCliente($nome_cliente)['id'];

        if(!$cliente){// Caso o retorno nao seja valido, atribui novamente
            echo json_encode([
                "success" => false,
                "message" => "Erro ao cadastar o agendamento. Nome de Cliente Invalido"
            ]);
            exit;
        }

        $dados = [
            'cliente_id' => $cliente,
            'receita' => $input['receita'],
            'quantidade' => $input['quantidade'],
            'status_id' => $input['status_id'],
            'observacoes' => $input['observacoes'],
            'data_retirada' => $input['data_retirada'],
            'data_agendamento' => $input['data_agendamento'],
            'ativado' => $input['ativado']
        ];

        // Chama o método para atualizar o item no agendamento
        $produto = $agendamentos->cadastrarAgendamento($dados);

        if($produto){
            echo json_encode([
                "success" => true,
                "message" => "Agendamento cadastrado com sucesso!",
            ]);
        }else{
            echo json_encode([
                "success" => false,
                "message" => "Erro ao cadastar o agendamento."
            ]);
        }
    }else{
        echo json_encode([
            "success" => false,
            "message" => "Erro ao cadastrar o agendamento. Parametros "
        ]);
    }
}

function atualizar($agendamentos, $input){
    if(isset($input['id_agendamento'], $input['data_agendamento'], $input['produto_final_id'], $input['status_id'], $input['observacoes'], $input['data_retirada'], $input['quantidade']) && $input['action'] == 'atualizar'){
        $dados = [
            'data_agendamento' => (string)$input['data_agendamento'],
            'produto_final_id' => (int)$input['produto_final_id'],
            'status_id' => (int)$input['status_id'],
            'observacoes' => (string)$input['observacoes'],
            'data_retirada' => (string)$input['data_retirada'],
            'quantidade_receita' => (int)$input['quantidade'],
            'id_agendamento' => (int)$input['id_agendamento'],
            'ativado' => (int)$input['ativado']
        ];

        $produto = $agendamentos->atualizarAgendamento($dados);

        if($produto){
            echo json_encode([
                "success" => true,
                "message" => "Agendamento atualizado com sucesso!",
                "data" => $produto
            ]);
        }else{
            echo json_encode([
                "success" => false,
                "message" => "Erro ao atualizar o agendamento. Banco nao conseguiu atualizar."
            ]);
        }
    }else{
        echo json_encode([
            "success" => false,
            "message" => "Erro ao atualizar o agendamento. Parametros incorretos."        
        ]);
    }
}

//Pesquisa dinamica de cadastro

if(isset($_GET['termo'])){
    $termo = $_GET['termo']; // Obtenha o termo de pesquisa
    $clientes_pesquisados = $agendamentos->consultaClientes($termo); // Chame o método para buscar clientes com o termo de pesquisa
    if(is_array($clientes_pesquisados) && !empty($clientes_pesquisados)){
        echo json_encode($clientes_pesquisados);
    }else{
        echo json_encode([]);
    }
}