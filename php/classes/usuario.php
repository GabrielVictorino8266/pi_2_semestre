<?php
require_once(__DIR__ . '/../db_connect.php');


class Usuario extends Conexao{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $funcao;
    
    public function __construct($id, $nome, $email, $senha, $funcao){
        $this->setNome($id);
        $this->setNome($nome);
        $this->setSenha($email);
        $this->setNome($senha);
        $this->setSenha($funcao);
    }

    //analisar implementação de consulta no banco de dados
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    


    public function getNome(){
        return $this->nome;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }


    public function getSenha(){
        return $this->senha;
    }

    public function setSenha($senha){
        $this->senha = $senha;
    }


    public function getFuncao(){
        return $this->funcao;
    }

    public function setFuncao($funcao){
        $this->funcao = $funcao;
    }   
    // Método para serializar o usuário
    public function serialize() {
        return serialize([
            'id' => $this->id,
            'nome' => $this->nome,
            'senha' => $this->senha,
            'funcao' => $this->funcao,
        ]);
    }
}