<?php
require_once __DIR__ . './classes/conexao.php';
require_once __DIR__ . './classes/query.php';
require_once __DIR__ . './classes/estoque.php';

$db = new Conexao();#Chamo a conexao
$conexao = $db->getConexao();#Chamo a conexao
$query = new Query($con);#Chamo a query