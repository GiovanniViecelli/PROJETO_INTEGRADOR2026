<?php
// Inicia a sessão para verificar se já existe um usuário logado.
session_start();

// Verifica se existe um ID de usuário na sessão.
if (isset($_SESSION['usuario_id'])) {
    // Se estiver logado, manda para o cardápio administrativo.
    header("Location: /app/lanches/select.php");
} else {
    // Se não estiver logado, manda para o login.
    header("Location: /Login/login.php");
}
// Encerra o script depois do redirecionamento.
exit;
?>