<?php
session_set_cookie_params(['httponly'=> true]);

session_start();
require_once('./classes/usuario.php');
require_once('./db_connect.php');

if(isset($_SESSION['user'])){
    header("Location: ../dashboard.php");
    exit;
}else{
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if(isset($_POST['user_email']) && isset($_POST['user_password'])){
            $user_email = $_POST['user_email'];
            $user_password = $_POST['user_password'];

            $pdo = new Conexao();
            $stmt = $pdo->getConexao()->prepare("SELECT * FROM tb_usuarios WHERE email = :user_email AND senha = :user_password");
            $stmt->bindParam(':user_email', $user_email, PDO::PARAM_STR);
            $stmt->bindParam(':user_password', $user_password, PDO::PARAM_STR);
            if($stmt->execute()){//consulta executada
                if($stmt->rowCount() > 0){
                    $user_encontrado = $stmt->fetch(PDO::FETCH_ASSOC);
                    var_dump($user_encontrado);
                    $usuario = new Usuario($user_encontrado['nome'],  $user_password['email'], $user_encontrado['senha'], $user_encontrado['fk_funcao_id']);//Crio usuário com algumas informações fornecidas pelo cliente.
                }else{
                    $usuario_encontrado = false;
                    echo 
                }
            }          
            
            if (!$usuario_encontrado){
                $pdo = $usuario->getConexao();
                echo "Volte e informe novamente seus dados de login.<br>";
                echo "<a href='../index.php'>Voltar para Login</a>";
                die("Erro na consulta: " . implode(", ", $pdo->errorInfo()));
            }    
    
            if($usuario_encontrado){
                $_SESSION['user'] = $usuario->serialize();
                $_SESSION['funcao'] = $usuario->getFuncao();
                header("Location: ../dashboard.php");
                exit;
            }
            else{
                echo "Usuário ou senha inválidos.";
                echo "<a href='../index.php'>Voltar</a>";
            }
        }{
            var_dump($_POST['nome']);
            var_dump($_POST['user_password']);
            echo "Dados não preenchidos corretamente.";
            //configurar aviso
        }
    }
}

?>