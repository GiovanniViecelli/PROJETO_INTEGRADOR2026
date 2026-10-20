<?php
// Inicia/acessa a sessão atual.
session_start();
// Destrói os dados da sessão, fazendo o usuário sair.
session_destroy();
// Volta para a tela de login.
header("Location: login.php");
exit;
?>