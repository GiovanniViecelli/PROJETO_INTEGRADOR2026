<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Codificação dos caracteres. -->
    <meta charset="UTF-8">
    <title>Hamburgueria</title>
    <!-- Importa o CSS principal. -->
    <link rel="stylesheet" href="/style/style.css">
</head>
<body>
    <!-- Cabeçalho do site. -->
    <header>
        <h1>🍔 Hamburgueria</h1>
        <!-- Só mostra a navegação se houver usuário logado. -->
        <?php if (isset($_SESSION['usuario_email'])): ?>
            <nav>
                <!-- Link para o cardápio administrativo. -->
                <a href="/app/lanches/select.php">Cardápio</a> |
                <!-- Link para os pedidos. -->
                <a href="/app/pedidos/select.php">Pedidos</a> |
                <!-- Mostra o e-mail do usuário logado. -->
                <span>Olá, <?php echo htmlspecialchars($_SESSION['usuario_email']); ?></span> |
                <!-- Link para sair. -->
                <a href="/Login/logout.php">Sair</a>
            </nav>
        <?php endif; ?>
    </header>
    <!-- Abre a área principal; o footer fecha esta tag. -->
    <main>