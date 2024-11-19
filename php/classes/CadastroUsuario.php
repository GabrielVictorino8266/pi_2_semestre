<?php
require_once __DIR__ . '/classes/conexao.php';

class CadastroUsuario{
    private $conexao;

    function __construct(){
        $conexao = new Conexao();
        $this->conexao = $conexao->getConexao();
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
        Método usado para retornar o id da função do usuário,
        buscando pela descricao da funcao.
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

}