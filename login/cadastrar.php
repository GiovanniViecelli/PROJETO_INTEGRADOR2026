<?php
// Importa as funções de usuário e a conexão com o banco.
require_once __DIR__ . '/../includes/functions.php';

// Guarda uma mensagem para o usuário.
$mensagem = "";

// Verifica se o cadastro foi enviado pelo formulário.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pega o e-mail digitado.
    $email = $_POST['email'];
    // Pega a senha digitada.
    $senha = $_POST['senha'];

    // Verifica se já existe alguém com esse e-mail.
    if (buscarUsuarioPorEmail($conexao, $email)) {
        // Mostra aviso se o e-mail já estiver cadastrado.
        $mensagem = "Este e-mail já está cadastrado.";
    } else {
        // Cadastra o novo usuário.
        cadastrarUsuario($conexao, $email, $senha);
        // Depois do cadastro, manda para a tela de login.
        header("Location: login.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body class="pagina-login">
    <!-- Card centralizado com a logo e o formulário de cadastro. -->
    <div class="login-card">
        <!-- Logo da Gisburguer no topo. -->
        <img class="logo" src="../img/logo-gisburguer.svg" alt="Gisburguer - Hamburgueria">

        <h2>Criar Conta</h2>

        <!-- Só mostra a mensagem quando ela não estiver vazia. -->
        <?php if ($mensagem): ?>
            <p class="erro"><?php echo $mensagem; ?></p>
        <?php endif; ?>

        <!-- Formulário de cadastro. -->
        <form method="POST" action="cadastrar.php">
            <label>E-mail:</label>
            <input type="email" name="email" required>

            <label>Senha:</label>
            <input type="password" name="senha" required>

            <button type="submit">Cadastrar</button>
        </form>

        <p>Já tem conta? <a href="login.php">Fazer login</a></p>
    </div>
</body>
</html>