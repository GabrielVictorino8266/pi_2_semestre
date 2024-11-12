<?php
// Senha do usuário
$senha = 'teste';

// Gerando o hash da senha usando bcrypt
$hash = password_hash($senha, PASSWORD_BCRYPT);

// Exibindo o hash gerado
echo $hash;

//Agora faça o insert no banco e teste.
?>
