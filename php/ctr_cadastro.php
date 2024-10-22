<?php
session_set_cookie_params(['httponly'=> true]);

session_start();
require_once(__DIR__ . '/session_check.php');
require_once(__DIR__ . '/db_connect.php');
require_once(__DIR__ . '../classes/usuario.php');

if(!$logged_in){
    header("Location: ./index.php");
    exit;
}

$conexao = new Conexao();
$pdo = $conexao->getConexao();

if($pdo && $_SERVER['REQUEST_METHOD'] === "POST"){
    if(isset($_POST['username']) && isset($_POST['user_password']) && isset($_POST['confirmed_user_password']) && isset($_POST['user_type'])){
        $nome = $_POST['username'];
        $senha = $_POST['user_password'];
        $senha_confirmada = $_POST['confirmed_user_password'];
        $fk_funcao_id = $_POST['user_type'];

        if(empty($senha)){
            throw new Exception("Senha vazia. Preencha.");
        }else{
            if($senha != $senha_confirmada){
                throw new Exception("Ambas as senhas são diferentes. Digite novamente.");
            }else{
                $usuario = new Usuario($pdo, $nome, $senha, $fk_funcao_id);
            }
        }      
        
        $stmt = $pdo->prepare("INSERT INTO tb_usuarios (nome, senha, fk_funcao_id) VALUES (:nome, :senha, :fk_funcao_id)");
        $nome = $usuario->getNome();
        $senha = $usuario->getSenha();
        $fk_funcao_id = $usuario->getFuncao();
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindParam(':fk_funcao_id', $fk_funcao_id, PDO::PARAM_INT);
        if($stmt->execute()){
            echo "Cadastro com sucesso.";
        }else{
            echo "Cadastro não ocorreu com sucesso. Volte e tente novamente.";
            echo "<a href='../cadastro.php'>Voltar</a>";
        }
    }else{
        echo "Um ou mais campos não foram definidos/preenchidos. Tente novamente.";
        echo "<a href='../cadastro.php'>Voltar</a>";
    }

}

