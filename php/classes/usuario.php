<?php
require_once(__DIR__ . '/../db_connect.php');


class Usuario extends Conexao{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $funcao;
    
    public function __construct($nome, $email, $senha, $funcao){
        parent::__construct();
        $this->setNome($nome);
        $this->setSenha($senha);
        // $this->setFuncao($funcao);
    }

    //analisar implementação de consulta no banco de dados
    public function getId(){
        return $this->id;
    }



    public function getNome(){
        return $this->nome;
    }

    public function setNome($nome){
        $nome = filter_var($nome, FILTER_SANITIZE_STRING);
        if(isset($nome)){
            if(empty($nome)){
                throw new Exception("Campo nome é obrigatório!");
            }
            $this->nome = $nome;
        }
    }



    public function getSenha(){
        return $this->senha;
    }

    public function setSenha($senha){
        if(isset($senha)){
            if(empty($senha)){
                throw new Exception("Campo senha é obrigatório.", 1);
                
            }
            $this->senha = $senha;
        }
    }



    public function getFuncao(){
        return $this->funcao;
    }

    public function setFuncao($funcao){
        if(isset($funcao)){
            if(empty($funcao)){
                throw new Exception("Campo Função não pode ser vazio.");   
            }
            $this->funcao = $this->consultarFuncao($funcao);
        }   
    }

    private function consultarFuncao($funcao){
        $stmt = $this->getConexao()->prepare("SELECT id FROM tb_funcoes WHERE descricao = :funcao");
        $stmt->bindParam(":funcao", $funcao, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt){
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            if($results){
                return $results['id'];
            }
        }
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