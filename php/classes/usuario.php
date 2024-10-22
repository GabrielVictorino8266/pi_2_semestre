<?php
require_once(__DIR__ . '/../db_connect.php');


class Usuario extends Conexao{
    private $id;
    private $nome;
    private $senha;
    private $funcao;
    
    public function __construct($nome, $senha){
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


    public function criarUsuario(){
        $sql = "INSERT INTO tb_usuarios (nome, senha, fk_funcao_id) VALUES (:nome, :senha, :fk_funcao_id)";
        $stmt = $this->getConexao()->prepare($sql);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':senha', $this->senha);
        $stmt->bindParam(':fk_funcao_id', $this->funcao);

        if($stmt->execute()){
            $this->id = $this->lastInsertId();
            return True;
        }

        return False;
    }

    public function carregarUsuario($username){
        $sql = "SELECT * FROM tb_usuarios WHERE nome = :username";
        $stmt = $this->getConexao()->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        if($stmt->execute()){
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if($usuario){
                $this->id = $usuario['id'];
                $this->nome = $usuario['nome'];
                $this->senha = $usuario['senha'];
                $this->funcao = $usuario['fk_funcao_id'];
            }
            // echo "consulta funcionou";
            return $usuario;
        }else{
            return NULL;
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

    // Método estático para desserializar o usuário
    public static function unserialize($data) {
        $unserializedData = unserialize($data);
        return new self($unserializedData['id'], $unserializedData['nome'], $unserializedData['senha'], $unserializedData['funcao']);
    }
}