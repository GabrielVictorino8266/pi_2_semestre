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
            $stmt = $pdo->getConexao()->prepare(
            "SELECT tb_usuarios.id, tb_usuarios.nome, tb_usuarios.email, tb_usuarios.senha, tb_funcoes.descricao as funcao FROM tb_usuarios INNER JOIN tb_funcoes 
            ON tb_funcoes.id = tb_usuarios.fk_funcao_id
            WHERE tb_usuarios.email = :user_email AND tb_usuarios.senha = :user_password");

            $stmt->bindParam(':user_email', $user_email, PDO::PARAM_STR);
            $stmt->bindParam(':user_password', $user_password, PDO::PARAM_STR);

            if($stmt->execute()){//consulta executada
                if($stmt->rowCount() > 0){
                    $user_encontrado = $stmt->fetch(PDO::FETCH_ASSOC);

                    $usuario = new Usuario($user_encontrado['id'],$user_encontrado['nome'],  $user_encontrado['email'], $user_encontrado['senha'], $user_encontrado['funcao']);//Crio usuário com algumas informações fornecidas pelo cliente.

                    $_SESSION['user'] = $usuario->serialize();
                    header('location: ../dashboard.php');
                    exit;
                }else{
                    $usuario_encontrado = false;
                    echo json_encode([
                        'status' =>  'error',
                        'message' => 'Usário ou senha não retornou dados no sistema.'
                    ]);
                    exit;
                }
            }
        }else{
            $usuario_encontrado = false;
            echo json_encode([
                'status' =>  'error',
                'message' => 'Usário ou senha inválidos no sistema.'
            ], JSON_UNESCAPED_UNICODE);
        }
    }
}
?>