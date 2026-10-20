<?php
// Inicia a sessão para poder verificar o usuário.
session_start();

// Se não existir o ID do usuário na sessão, significa que não está logado.
if (!isset($_SESSION['usuario_id'])) {
    // Manda para a tela de login.
    header("Location: ../../Login/login.php");
    // Para a execução para impedir acesso à página protegida.
    exit;
}
?>