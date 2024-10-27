<?php
require_once __DIR__ . './conexao.php';

class Query{
    private $db;

    public function __construct(Conexao $db){
        $this->db = $db->getConexao();
    }

    public function verificaEmailUsuario($email){
        /*
        Método usado para consultar apenas o email do usuario
        buscando retornar se este existe.
        */
        $query = "SELECT * FROM tb_usuarios WHERE email = :email";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
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
            $stmt = $this->db->prepare($query);

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
        Método usado para retornar o id da função do usuário.
        */
        try{
            $query = "SELECT * FROM tb_funcoes WHERE descricao = :funcao";
            $stmt = $this->db->prepare($query);
    
            $stmt->bindParam(":funcao", $funcao, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }

    }
}
?>