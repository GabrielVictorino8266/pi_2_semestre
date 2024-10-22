<?php
session_set_cookie_params(['httponly'=> true]);

session_start();
require_once('./classes/usuario.php');

if(isset($_SESSION['user'])){
    header("Location: ../dashboard.php");
    exit;
}else{
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['username']) && isset($_POST['user_password'])){
            $username = $_POST['username'];
            $user_password = $_POST['user_password'];
    
            $usuario = new Usuario($username,  $user_password, "");//Crio usuário com algumas informações fornecidas pelo cliente.
    
            $usuario_encontrado = $usuario->carregarUsuario($username);
            
            if (!$usuario_encontrado){
                $pdo = $usuario->getConexao();
                echo "Volte e informe novamente seus dados de login.<br>";
                echo "<a href='../index.php'>Voltar para Login</a>";
                die("Erro na consulta: " . implode(", ", $pdo->errorInfo()));
            }    
    
            if($usuario_encontrado){
                $_SESSION['user'] = $usuario->serialize();
                header("Location: ../dashboard.php");
                exit;
            }
            else{
                echo "Usuário ou senha inválidos.";
                echo "<a href='../index.php'>Voltar</a>";
            }
        }
    }
}

?>