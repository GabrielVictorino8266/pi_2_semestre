<?php
require_once __DIR__ .  '/conexao.php';
require_once __DIR__ . '/query.php';


class Usuario{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $funcao;
    private $db;
    
    public function __construct(Conexao $db, $id, $nome, $email, $senha, $funcao){
        $this->db = $db->getConexao();
        $this->setId($id);
        $this->setNome($nome);
        $this->setEmail($email);
        $this->setSenha($senha);
        $this->setFuncao($funcao);
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


    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
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
            'id' => $this->id
        ]);
    }
}