<?php

class Usuario{
    private $id;
    private $nome;
    private $senha;
    private $funcao;
    private $tipo_usuario;
    
    public function __construct($id, $nome, $senha, $funcao, $tipo_usuario){
        $this->id = $id;
        $this->nome = $nome;
        $this->senha = $senha;
        $this->funcao = $funcao;
        $this->tipo_usuario = $tipo_usuario;
    }

    public function getId(){
        return $this->id;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getSenha(){
        return $this->senha;
    }
    public function getFuncao(){
        return $this->funcao;
    }

    public function getTipoUsuario(){
        return $this->tipo_usuario;
    }
}