<?php
require_once('./php/session_check.php');
require_once('./classes/usuario.php');

$usuarioLogado = unserialize($_SESSION['user']);
echo "Nome do usuário: " . htmlspecialchars($usuarioLogado->getNome());
