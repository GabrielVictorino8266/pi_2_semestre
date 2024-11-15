<?php
require_once __DIR__ .  '/conexao.php';
require_once __DIR__ . '/query.php';


class Usuario{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $funcao;
    private $conexao;
    
    public function __construct($id = null, $nome = null, $email = null, $senha = null, $funcao = null){
        $conexao = new Conexao();
        $this->conexao = $conexao->getConexao();
        $this->setId($id);
        $this->setNome($nome);
        $this->setEmail($email);
        $this->setSenha($senha);
        $this->setFuncao($funcao);
    }

    //Getters

    public function getId(){
        return $this->id;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getSenha(){
        return $this->senha;
    }

    //Setters

    public function setId($id){
        $this->id = $id;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setSenha($senha){
        $this->senha = $senha;
    }

    public function setFuncao($funcao){
        $this->funcao = $funcao;
    }

    public function login($email, $senha){
        /*
            Método que busca informações no banco e,
            se existir, retorno nova instância do usuário.
        */
        $usuario = $this->verificaEmailUsuario($email);
        if ($usuario){
            return $this->verificaSenha($senha, $usuario);
        } else {
            return false;
        }
    }

    private function verificaSenha($senha, $usuario){
        /*
        Método usado para verificar senha do usuário.
        Retorna falso se senha incorreta.
        */
        if (password_verify($senha, $usuario['senha'])) {
            return new Usuario($usuario['id'], $usuario['nome'], $usuario['email'], $usuario['senha'], $usuario['funcao_id']);
        } else {
            return false;
        }
    }
    
    private function verificaEmailUsuario($email){
        /*
        Método usado para consultar apenas o email do usuario
        buscando retornar se este existe.
        */
        $stmt = $this->conexao->prepare("SELECT * FROM tb_usuarios WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        #Verificacao se o usuario foi encontrado
        if($stmt->rowCount() > 0){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }

    public function registarUsuario($nome, $email, $senha, $funcao_id){
        /*  
        Método usadao para registrar o usuario.
        */
        $query = "INSERT INTO tb_usuarios (nome, email, senha, funcao_id) VALUES (:nome, :email, :senha, :funcao_id)";

        try{
            $stmt = $this->conexao->prepare($query);

            $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":senha", $senha, PDO::PARAM_STR);
            $stmt->bindParam(":funcao_id", $funcao_id, PDO::PARAM_INT);

            $stmt->execute();
            return true;

        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function getFuncao($funcao){
        /*
        Método usado para retornartodas as informações da função do usuário,
        buscando pela descricao da funcao na pagina dashboard, exibindo
        cadastrar usuario ao administrador.
        */
        try{
            $query = "SELECT * FROM tb_funcoes WHERE descricao = :funcao";
            $stmt = $this->conexao->prepare($query);
    
            $stmt->bindParam(":funcao", $funcao, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function getFuncaoUsuarioId($id){
        /*
        Método usado para retornar o id da função do usuário,
        buscando pelo id do usuário.
        */
        try{
            $query = "SELECT * FROM tb_usuarios INNER JOIN tb_funcoes ON tb_usuarios.funcao_id = tb_funcoes.id WHERE tb_usuarios.id = :id";
            $stmt = $this->conexao->prepare($query);
    
            $stmt->bindParam(":id", $id, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }

    }
}