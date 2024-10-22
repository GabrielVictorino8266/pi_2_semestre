<?php
session_start();
require_once('../classes/usuario.php');
require_once('db_connect.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['username']) && isset($_POST['user_password'])){
        $username = $_POST['username'];
        $user_password = $_POST['user_password'];
        $conexao = new Conexao();
        $pdo = $conexao->getConexao();
        
    
        //verificando existencia do usuario
        $stmt = $pdo->prepare("SELECT * FROM tb_usuarios WHERE nome = :nome");
        $stmt->bindParam(':nome',$username);
        $stmt->execute();
        if (!$stmt) {
            die("Erro na consulta: " . implode(", ", $pdo->errorInfo()));
        }else{
            $user_founded = $stmt->fetch(PDO::FETCH_ASSOC);
            // echo var_dump($user_founded);
        }
    
        if($user_founded && $user_password == $user_founded['senha']){
            $usuarioLogado = new Usuario($user_founded['id'], $user_founded['nome'], $user_founded['senha'], $user_founded['fk_funcao_id'], $user_founded['nome']);
            $_SESSION['user'] = serialize($usuarioLogado);
            header("Location: ../dashboard.php");
            exit;
        }
        else{
            echo "Usuário ou senha inválidos.";
            echo "<a href='../login.php'>Voltar</a>";
        }
    }
}
?>