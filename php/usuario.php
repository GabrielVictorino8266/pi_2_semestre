<?php

class Usuario{
    private $id;
    private $nome;
    private $funcao;
    private $tipo_usuario;
    
    public function __construc($id, $nome, $funcao, $tipo_usuario){
        $this->id = $id;
        $this->nome = $nome;
        $this->funcao = $funcao;
        $this->tipo_usuario = $tipo_usuario;
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->nome;
    }

    public function getFuncao(){
        return $this->funcao;
    }

    public function getTipoUsuario(){
        return $this->tipo_usuario;
    }
}