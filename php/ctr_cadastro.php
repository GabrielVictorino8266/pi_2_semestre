<?php
require_once __DIR__ . './classes/conexao.php';
require_once __DIR__ . './classes/query.php';
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $db = new Conexao(); #Chamo a conexao
    $query = new Query($db); #Chamo a query

    if(isset($_SESSION['user_id'])){
        #mudar para isset($_SESSION['user_id'])

        if(isset($_POST['user_name']) && isset($_POST['user_email']) && isset($_POST['user_password']) && isset($_POST['user_type'])){
            $nome = $_POST['user_name'];
            $email = $_POST['user_email'];
            $password = $_POST['user_password'];
            $user_type = $query->getFuncao($_POST['user_type']);
    
            $senhaHash = password_hash($password, PASSWORD_DEFAULT);
            if($senhaHash){
                if($query->registarUsuario($nome, $email, $senhaHash, $user_type['id'])){
                    header('location: ../dashboard.php?success=cadastrosuccess');# Redireciona para dashboard com parâmetro de sucesso
                }else{
                    header('location: ../cadastro.php?error=cadastroerror');# Redireciona para cadastro com parâmetro de erro de cadastro

                }
            }
        }
    }else{
        header('location: ../index.php?error=login');
    }
}