<?php
require_once __DIR__ . '/conexao.php';

class Dashboard{
    private $conexao;
    

    public function __construct(){
        $conexao = new Conexao();
        $this->conexao = $conexao->getConexao();
    }
}