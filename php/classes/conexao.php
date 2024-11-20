<?php

class Conexao{
    private $host = "localhost";
    private $dbname = "rotisdb";
    private $conexao;
    private $user = "root";
    private $password = "";
    // private $host = "127.0.0.1";
    // private $dbname = "u579326255_g2";
    // private $conexao;
    // private $user = "u579326255_g2";
    // private $password = "*G8z@tt|pGy";

    public function __construct(){
        $this->connect();    
    }

    private function connect(){
        try{
            $this->conexao = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->user,
                $this->password
            );

            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            echo "Erro com banco de dados: " . $e->getMessage();
        }
    }

    public function getConexao(){
        return $this->conexao;
    }


    public function closeConexao(){
        return $this->conexao = NULL;
    }

    public function __destruct(){
        $this->closeConexao();
    }
}