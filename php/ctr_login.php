<?php
require_once __DIR__ . '/classes/conexao.php';
require_once __DIR__ . '/classes/usuario.php';

// Verifica se a requisicao foi feita pelo metodo POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Verifica se o formulario foi preenchido
    if(isset($_POST['user_email']) && isset($_POST['user_password'])){
        // Verifica se o campos de email e senha estao vazios
        if(empty($_POST['user_email']) || empty($_POST['user_password'])){
            // Se os campos estiverem vazios, redireciona para a pagina de login com um erro
            echo "credenciaisnaopreenchidas";
            header('location: ../view/login.php?error=credenciaisnaopreenchidas');
            exit;
        }
        
        // Remove espacos em branco do email e senha
        $email = trim($_POST['user_email']);
        $senha = trim($_POST['user_password']);
        
        // Cria um objeto do tipo Usuario
        $usuario = new Usuario();
        // Chama o metodo login do objeto Usuario
        $usuario = $usuario->login($email, $senha);
        
        // Verifica se o metodo login retornou um objeto Usuario
        if($usuario){
            // Se sim, inicia uma sessao do usuario
            session_start();
            // Salva o id e o nome do usuario na sessao
            $_SESSION['user_id'] = $usuario->getId();
            $_SESSION['user_name'] = $usuario->getNome();
            // Redireciona para a pagina de dashboard
            echo "ok vai redirecionar";
            header('location: ../view/dashboard.php');
            exit;
        }else{
            // Se o metodo login nao retornou um objeto Usuario, redireciona para a pagina de login com um erro
            echo "erro login 1";
            header('location: ../view/login.php?error=login');
            exit;
        }
    }else{
        // Se o formulario nao foi preenchido, redireciona para a pagina de login com um erro
        echo "erro login 2";
        header('location: ../view/login.php?error=login');
        exit;
    }
}