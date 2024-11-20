<?php

class Conexao{
    private $host = "127.0.0.1";
    // private $host = "127.0.0.1::3306";
    // private $host = "localhost";
    private $dbname = "u579326255_g2";
    // private $dbname = "rotisdb";
    private $user = "u579326255_g2";
    // private $user = "root";
    private $password = "*G8z@tt|pGy";
    // private $password = "";
    private $conexao;

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