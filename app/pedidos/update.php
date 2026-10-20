<?php
// Verifica se o usuário está logado.
require_once __DIR__ . '/../../Login/verifica-login.php';
// Importa as funções do sistema.
require_once __DIR__ . '/../../includes/functions.php';

// Pega o ID do pedido pela URL.
$id = $_GET['id'];
// Busca os dados atuais do pedido.
$pedido = buscarPedidoPorId($conexao, $id);

// Para se o pedido não existir.
if (!$pedido) {
    die("Pedido não encontrado.");
}

// Verifica se o formulário foi enviado.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pega os novos valores.
    $usuario_id = $_POST['usuario_id'];
    $lanche_id = $_POST['lanche_id'];
    $quantidade = $_POST['quantidade'];
    $status = $_POST['status'];

    // Atualiza o pedido no banco.
    atualizarPedido($conexao, $id, $usuario_id, $lanche_id, $quantidade, $status);
    // Volta para a lista.
    header("Location: select.php");
    exit;
}

// Busca usuários para o select.
$usuarios = listarUsuarios($conexao);
// Busca lanches para o select.
$lanches = listarLanches($conexao);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Pedido</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
    <h2>Editar Pedido</h2>

    <form method="POST" action="update.php?id=<?php echo $id; ?>">
        <label>Cliente:</label>
        <select name="usuario_id" required>
            <!-- Percorre os usuários. -->
            <?php foreach ($usuarios as $usuario): ?>
                <!-- selected deixa marcado o cliente atual. -->
                <option value="<?php echo $usuario['id']; ?>" <?php echo $usuario['id'] == $pedido['usuario_id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($usuario['email']); ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label>Lanche:</label>
        <select name="lanche_id" required>
            <!-- Percorre os lanches. -->
            <?php foreach ($lanches as $lanche): ?>
                <!-- Marca como selecionado o lanche atual do pedido. -->
                <option value="<?php echo $lanche['id']; ?>" <?php echo $lanche['id'] == $pedido['lanche_id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($lanche['nome']); ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label>Quantidade:</label>
        <!-- Mostra a quantidade atual no campo. -->
        <input type="number" name="quantidade" min="1" value="<?php echo $pedido['quantidade']; ?>" required><br>

        <label>Status:</label>
        <select name="status">
            <!-- Cria as opções de status usando um array. -->
            <?php foreach (['pendente', 'em preparo', 'pronto', 'entregue'] as $opcao): ?>
                <!-- Se a opção for igual ao status atual, marca selected. -->
                <option value="<?php echo $opcao; ?>" <?php echo $opcao == $pedido['status'] ? 'selected' : ''; ?>>
                    <!-- ucfirst deixa a primeira letra maiúscula. -->
                    <?php echo ucfirst($opcao); ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <button type="submit">Atualizar</button>
    </form>

    <p><a href="select.php">Voltar</a></p>
</body>
</html>