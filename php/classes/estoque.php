<?php
require_once __DIR__ . './conexao.php';

class Estoque{
// desenvolver a composição de composição aqui
// Desenvolver as funções de estoque aqui
    private $query;


    public function __construct(Query $query)
    {
        $this->query = $query;
    }

    public function cadastrarProduto($descricao, $quantidade, $preco_unitario, $preco_venda, $tipo_id, $categoria_id){
        /*
        Método usado para cadastrar produto.
        */ 

    }


    public function listarEstoque($inicio, $limite){
        /*
        Método utilizado para listar o estoque.
        */
        return $this->query->listarEstoque($inicio, $limite);
    }

    public function listarContagemEstoque(){
        /*
        Método utilizado para listar o total de registros no estoque,
        sem filtros.
        */
        return $this->query->listarContagemEstoque($this->query);
    }

    public function listarTipoItem(){
        return $this->query->listarTipoItem();
    }


    public function listarCategoria(){
        return $this->query->listarCategoria();
    }
}