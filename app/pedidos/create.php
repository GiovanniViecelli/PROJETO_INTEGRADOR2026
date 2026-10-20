<?php
// Verifica se o usuário está logado.
require_once __DIR__ . '/../../Login/verifica-login.php';
// Importa as funções do sistema.
require_once __DIR__ . '/../../includes/functions.php';

// Verifica se o formulário foi enviado.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pega o ID do cliente enviado pelo formulário.
    $usuario_id = $_POST['usuario_id'];
    // Pega o ID do lanche escolhido.
    $lanche_id = $_POST['lanche_id'];
    // Pega a quantidade pedida.
    $quantidade = $_POST['quantidade'];
    // Pega o status inicial do pedido.
    $status = $_POST['status'];

    // Cadastra o pedido no banco.
    cadastrarPedido($conexao, $usuario_id, $lanche_id, $quantidade, $status);
    // Depois de cadastrar, volta para a lista.
    header("Location: select.php");
    // Para a execução.
    exit;
}

// Busca os usuários para preencher o select de cliente.
$usuarios = listarUsuarios($conexao);
// Busca os lanches para preencher o select de lanche.
$lanches = listarLanches($conexao);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Pedido</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
    <h2>Cadastrar Pedido</h2>

    <!-- Formulário que envia os dados por POST. -->
    <form method="POST" action="create.php">
        <label>Cliente:</label>
        <select name="usuario_id" required>
            <!-- Percorre os usuários e cria uma opção para cada um. -->
            <?php foreach ($usuarios as $usuario): ?>
                <option value="<?php echo $usuario['id']; ?>"><?php echo htmlspecialchars($usuario['email']); ?></option>
            <?php endforeach; ?>
        </select><br>

        <label>Lanche:</label>
        <select name="lanche_id" required>
            <!-- Percorre os lanches e cria uma opção para cada um. -->
            <?php foreach ($lanches as $lanche): ?>
                <option value="<?php echo $lanche['id']; ?>"><?php echo htmlspecialchars($lanche['nome']); ?></option>
            <?php endforeach; ?>
        </select><br>

        <label>Quantidade:</label>
        <!-- min=1 impede quantidade menor que 1 no navegador. -->
        <input type="number" name="quantidade" min="1" value="1" required><br>

        <label>Status:</label>
        <!-- Lista de status possíveis para o pedido. -->
        <select name="status">
            <option value="pendente">Pendente</option>
            <option value="em preparo">Em preparo</option>
            <option value="pronto">Pronto</option>
            <option value="entregue">Entregue</option>
        </select><br>

        <button type="submit">Salvar</button>
    </form>

    <p><a href="select.php">Voltar</a></p>
</body>
</html>