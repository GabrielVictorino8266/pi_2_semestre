<?php
require_once("../php/db_connect.php");
// $conexao = new Conexao();
// $pdo = $conexao->getConexao();

class Usuario{
    private $pdo;
    private $id;
    private $nome;
    private $senha;
    private $funcao;
    
    public function __construct($pdo, $nome, $senha, $funcao){
        $this->pdo = $pdo;
        $this->setNome($nome);
        $this->setSenha($senha);
        $this->setFuncao($funcao);
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
            $stmt = $this->pdo->prepare("SELECT id FROM tb_funcoes WHERE descricao = :funcao");
            $stmt->bindParam(":funcao", $funcao, PDO::PARAM_STR);
            $stmt->execute();
            if($stmt){
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                if($results){
                    $funcao = $results['id'];
                    $this->funcao = $funcao;
                }
            }
        }
        }
    }