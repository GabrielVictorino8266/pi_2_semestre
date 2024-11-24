<?php
require_once __DIR__ . '/classes/conexao.php';
require_once __DIR__ . '/classes/cadastroclientes.php';
require_once __DIR__ . '/session_check.php';
require_once __DIR__ . '/classes/paginacao.php';

define('PROJECT_ROOT_MYPATH', '../view'); 
verificarSessao(PROJECT_ROOT_MYPATH);


$cadastro = new CadastroClientes();
$listagem_clientes = $cadastro->listarClientes();

// $_SERVER['REQUEST_METHOD'] = 'POST';
// $input = json_decode('{
//     "id_cliente": "1",
//     "action": "atualizar",
//     "nome": "Teste",
//     "email": "r8xXa@example.com",
//     "telefone": "123456789",
//     "rua": "Rua Teste",
//     "numero": "123",
//     "bairro": "Bairro Teste",
//     "cidade": "Cidade Teste",
//     "estado": "Estado Teste",
//     "cep": "12345678"
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
    switch ($action) {
        case "preencher":
            preencher($cadastro, $input);
            break;
        case "atualizar":
            atualizar($cadastro, $input);
            break;
        // case "cadastrar":
        //     cadastrar($agendamentos, $input);
        //     break;
        default:
        echo json_encode([
            "success" => false,
            "message" => "Erro ao Realizar operação no switch do controlador."
        ]);
    }
}

function preencher($cadastro, $input){
    if(isset($input['action'], $input['id']) && $input['action'] == 'preencher'){
        $id = $input['id']; // Obtenha o id do item da entrada
        $cliente = $cadastro->buscarClientePorId($id);
        if($cliente){
            echo json_encode([
                "success" => true,
                "message" => "Cliente encontrado.",
                "cliente" => $cliente
            ]);
        }
    }else{
        echo json_encode([
            "success" => false,
            "message" => "Erro ao carregar informações do item. Chegou no controller."
        ]);
        exit;
    }
}

function atualizar($cadastro, $input){
    if(isset($input['id_cliente'], $input['nome'], $input['email'], $input['telefone'], $input['rua'], $input['numero'], $input['bairro'], $input['cidade'], $input['estado'], $input['cep']) && $input['action'] == 'atualizar'){
        $dados = [
            'id_cliente' => $input['id_cliente'],
            'nome' => $input['nome'],
            'email' => $input['email'],
            'telefone' => $input['telefone'],
            'rua' => $input['rua'],
            'numero' => $input['numero'],
            'bairro' => $input['bairro'],
            'cidade' => $input['cidade'],
            'estado' => $input['estado'],
            'cep' => $input['cep']
        ];
        $cliente = $cadastro->atualizarCliente($dados);
        if($cliente){
            echo json_encode([
                "success" => true,
                "message" => "Cliente Atualizado com suscesso."
            ]);
        }
    }else{
        echo json_encode([
            "success" => false,
            "message" => "Erro ao atualizar informações do cliente. Chegou no controller."
        ]);
        exit;
    }
}