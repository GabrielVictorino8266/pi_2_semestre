<?php
require_once __DIR__ . './conexao.php';

class Estoque{
    private $query;


    public function __construct()
    {
        $this->query = new Query(new Conexao());
    }

    public function cadastrarProduto($dados){
        /*
        Método usado para cadastrar produto.
        */ 
        return $this->query->cadastrarProduto($dados);
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

    public function atualizarItem($id, $dados){
        return $this->query->atualizarItem($id, $dados);
    }
    public function carregarInformacoesItem($id){
        return $this->query->carregarInformacoesItem($id);
    }
    

    // public function deletarProduto($id){
    //     return $this->query->deletarProduto($id);
    // }

    public function getTotalEstoque($tipo_pesquisa, $nome_pesquisa, $categoria_pesquisa){
        return $this->query->getTotalEstoque($tipo_pesquisa, $nome_pesquisa, $categoria_pesquisa);
    }

    public function getPesquisarEstoque($inicio, $limite, $tipo_pesquisa, $nome_pesquisa, $categoria_pesquisa){
        return $this->query->getPesquisarEstoque($inicio, $limite, $tipo_pesquisa, $nome_pesquisa, $categoria_pesquisa);
    }

}