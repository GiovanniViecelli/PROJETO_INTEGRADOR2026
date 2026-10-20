<?php
// Verifica se o usuário está logado.
require_once __DIR__ . '/../../Login/verifica-login.php';
// Importa as funções do projeto.
require_once __DIR__ . '/../../includes/functions.php';

// Busca todos os pedidos já com cliente e lanche relacionados.
$pedidos = listarPedidos($conexao);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pedidos</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
    <h2>Pedidos</h2>
    <!-- Links de navegação. -->
    <p><a href="../lanches/select.php">Cardápio</a> | <a href="../../Login/logout.php">Sair</a></p>
    <p><a href="create.php">+ Novo pedido</a></p>

    <!-- Tabela dos pedidos. -->
    <table border="1" cellpadding="8">
        <tr>
            <th>Cliente</th>
            <th>Lanche</th>
            <th>Qtd</th>
            <th>Status</th>
            <th>Data</th>
            <th>Ações</th>
        </tr>
        <!-- Percorre todos os pedidos. -->
        <?php foreach ($pedidos as $pedido): ?>
        <tr>
            <td><?php echo htmlspecialchars($pedido['cliente_email']); ?></td>
            <td><?php echo htmlspecialchars($pedido['lanche_nome']); ?></td>
            <td><?php echo $pedido['quantidade']; ?></td>
            <td><?php echo htmlspecialchars($pedido['status']); ?></td>
            <td><?php echo $pedido['data_pedido']; ?></td>
            <td>
                <!-- Envia o ID para edição. -->
                <a href="update.php?id=<?php echo $pedido['id']; ?>">Editar</a> |
                <!-- Envia o ID para exclusão e pede confirmação. -->
                <a href="delete.php?id=<?php echo $pedido['id']; ?>" onclick="return confirm('Excluir este pedido?')">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>