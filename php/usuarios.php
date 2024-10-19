<?php

require_once 'db_connect.php';

$conexao = new Conexao();
$db = $conexao->getConexao();

$sql = "select * from tb_usuarios";
$stmt = $db->prepare($sql);

$stmt->execute();

$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($usuarios as $user){
    echo $user['nome'] . "<br>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>testes</h1>
</body>
</html>