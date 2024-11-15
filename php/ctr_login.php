<?php
require_once __DIR__ . '/classes/conexao.php';
require_once __DIR__ . '/classes/query.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $db = new Conexao();#Chamo a conexao
    $query = new Query($db);#Chamo a query

    if(isset($_POST['user_email']) && isset($_POST['user_password'])){
        $email = $_POST['user_email'];
        $password = $_POST['user_password'];

        #Verificar se usuario existe
        $usuario = $query->verificaEmailUsuario($email);

        if($usuario){#usuario existe
            if(password_verify($password, $usuario['senha'])){
                session_start();
                $_SESSION['user_id'] = $usuario['id'];
                $_SESSION['user_name'] = $usuario['nome'];
                #chamar usuario para serialize do id dele.
                header('location: ../view/dashboard.php');
            }else{
                header('location: ../view/login.php?error=login');
            }

        }else{#usuario nao existe
            header('location: ../view/login.php?error=login');
        }
    }
}