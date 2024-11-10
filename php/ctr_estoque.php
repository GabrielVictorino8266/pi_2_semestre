<?php
require_once __DIR__ . './classes/conexao.php';
require_once __DIR__ . './classes/query.php';
require_once __DIR__ . './classes/estoque.php';
require_once __DIR__ . './classes/paginacao.php';
require_once __DIR__ . './session_check.php';

define('PROJECT_ROOT_MYPATH', '../view'); // Ajuste para o caminho da raiz do projeto, como '/' para a raiz ou '/meu_projeto/'
verificarSessao(PROJECT_ROOT_MYPATH);

$conexao= new Conexao();#Chamo a conexao
$query = new Query($conexao);#Chamo a query

$estoque = new Estoque($query);

$funcao = $query->getFuncaoUsuarioId($_SESSION['user_id']);

/*
Configuração de pagina.
*/
$limite_pagina = 4;
if(isset($_GET['pagina'])){
    $pagina = $_GET['pagina'];
}else{  
    $pagina = 1;
}

/*
Listagem da contagem de todo o estoque.
*/
function listarEstoque($estoque, $pagina, $limite_pagina){
    $contagemEstoque = $estoque->listarContagemEstoque();
    $paginacao = new Paginacao($pagina, $limite_pagina, $contagemEstoque['total']);
    $inicio_pagina = $paginacao->calcularInicio();
    $intervalo = $paginacao->calcularIntervalo();
    
    $listagemEstoque = $estoque->listarEstoque($inicio_pagina, $limite_pagina);
    return ['listagem' => $listagemEstoque, 'paginacao' => $paginacao, 'intervalo' => $intervalo];
}

$listagemEstoque = listarEstoque($estoque, $pagina, $limite_pagina)['listagem'];
$intervalo = listarEstoque($estoque, $pagina, $limite_pagina)['intervalo'];


/*
Retorno de dados para filtros de Tipo Item e Categoria.
 */
$filtroTipo = $estoque->listarTipoItem();
$filtroCategoria = $estoque->listarCategoria();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false){
    $input = json_decode(file_get_contents('php://input'), true);
    $action = $input['action'];

    // echo json_encode($input);
    switch ($action) {
        case "preencher":
            preeencher($estoque, $input);
            break;
        case "atualizar":
            atualizar($estoque, $input);
            $listagemEstoque = listarEstoque($estoque, $pagina, $limite_pagina)['listagem'];
            break;
        case "cadastrar":
            cadastrar($estoque, $input);
            $listagemEstoque = listarEstoque($estoque, $pagina, $limite_pagina)['listagem'];
            break;
        default:
        echo json_encode([
            "success" => false,
            "message" => "Erro ao Realizar operação."
        ]);
    }
    
}

function preeencher($estoque, $input){
    // Verifica se 'acao' e 'id' est o setados na entrada e se 'acao'   'preencher'
    if (isset($input['action'], $input['id']) && $input['action'] == 'preencher') {
        $id = $input['id']; // Obtenha o id do item da entrada
        $produto = $estoque->carregarInformacoesItem($id); // Carregue informa es do item no estoque

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
            "message" => "Erro ao carregar informacoes do item."
        ]);
        exit;
    }
}


function atualizar($estoque, $input){

    // Verifica se 'acao' e 'id' est o setados na entrada e se 'acao'   'atualizar'
    if(isset($input['id'], $input['descricao'], $input['quantidade'], $input['custo'], $input['venda'], $input['tipo'], $input['categoria'], $input['ativado']) && $input['action'] == 'atualizar'){
        $dados = [
            'id' => $input['id'],
            'descricao' => $input['descricao'],
            'quantidade' => $input['quantidade'],
            'preco_unitario' => $input['custo'],
            'preco_venda' => $input['venda'],
            'tipo_id' => $input['tipo'],
            'categoria_id' => $input['categoria'],
            'ativado'=> $input['ativado']
        ];

        
        // Chama o método para atualizar o item no estoque
        $produto = $estoque->atualizarItem($input['id'], $dados);

        if($produto){
            echo json_encode([
                "success" => true,
                "message" => "Produto atualizado com sucesso!",
                "data" => $produto
            ]);
        }else{
            echo json_encode([
                "success" => false,
                "message" => "Erro ao atualizar o produto."
            ]);
        }
    }else{
        echo json_encode([
            "success" => false,
            "input" => $input,
            "message" => "Dados faltando em atualizar."
        ]);
    }
}

function cadastrar($estoque, $input){
    // Verifica se 'acao' e 'id' est o setados na entrada e se 'acao'   'atualizar'
    if(isset($input['descricao'], $input['quantidade'], $input['custo'], $input['venda'], $input['tipo'], $input['categoria'], $input['ativado']) && $input['action'] == 'cadastrar'){
        $dados = [
            'descricao' => $input['descricao'],
            'quantidade' => $input['quantidade'],
            'preco_unitario' => $input['custo'],
            'preco_venda' => $input['venda'],
            'tipo_id' => $input['tipo'],
            'categoria_id' => $input['categoria'],
            'ativado'=> $input['ativado']
        ];

        
        // Chama o método para atualizar o item no estoque
        $produto = $estoque->cadastrarProduto($dados);

        if($produto){
            echo json_encode([
                "success" => true,
                "message" => "Produto cadastrado com sucesso!",
                "data" => $produto
            ]);
        }else{
            echo json_encode([
                "success" => false,
                "message" => "Erro ao cadastar o produto."
            ]);
        }
    }else{
        echo json_encode([
            "success" => false,
            "input" => $input,
            "message" => "Dados faltando em cadastrar."
        ]);
    }
}