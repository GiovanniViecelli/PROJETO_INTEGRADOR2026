<?php
// Inicia a sessão para guardar o usuário logado.
session_start();
// Importa as funções e a conexão com o banco.
require_once __DIR__ . '/../includes/functions.php';

// Guarda uma mensagem de erro.
$mensagem = "";

// Verifica se o formulário de login foi enviado.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pega o e-mail informado.
    $email = $_POST['email'];
    // Pega a senha informada.
    $senha = $_POST['senha'];

    // Procura o usuário pelo e-mail.
    $usuario = buscarUsuarioPorEmail($conexao, $email);

    // Verifica se encontrou usuário e se a senha é igual à cadastrada.
    if ($usuario && $usuario['senha'] === $senha) {
        // Guarda o ID do usuário na sessão.
        $_SESSION['usuario_id'] = $usuario['id'];
        // Guarda o e-mail na sessão.
        $_SESSION['usuario_email'] = $usuario['email'];
        // Envia o usuário para o cardápio administrativo.
        header("Location: ../app/lanches/select.php");
        exit;
    } else {
        // Mostra mensagem caso os dados não estejam corretos.
        $mensagem = "Usuário inexistente.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body class="pagina-login">
    <!-- Card centralizado com a logo, o formulário e o link de cadastro. -->
    <div class="login-card">
        <!-- Logo da Gisburguer no topo do login. -->
        <img class="logo" src="../img/logo-gisburguer.svg" alt="Gisburguer - Hamburgueria">

        <h2>Login</h2>

        <?php if ($mensagem): ?>
            <p class="erro"><?php echo $mensagem; ?></p>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <label>E-mail:</label>
            <input type="email" name="email" required>

            <label>Senha:</label>
            <input type="password" name="senha" required>

            <button type="submit">Entrar</button>
        </form>

        <p>Não tem conta? <a href="cadastrar.php">Cadastre-se</a></p>
    </div>
</body>
</html>