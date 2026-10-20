<?php
// Bloqueia o acesso de quem não estiver logado.
require_once __DIR__ . '/../../Login/verifica-login.php';
// Importa as funções do projeto.
require_once __DIR__ . '/../../includes/functions.php';

// Busca todos os lanches no banco.
$lanches = listarLanches($conexao);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Codificação da página. -->
    <meta charset="UTF-8">
    <title>Cardápio</title>
    <!-- Importa o CSS. -->
    <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
    <!-- Logo da Gisburguer no topo do cardápio administrativo. -->
    <img class="logo logo-topo" src="../../img/logo-gisburguer.svg" alt="Gisburguer - Hamburgueria">
    <h2>Cardápio de Lanches</h2>
    <!-- Link para sair da conta. -->
    <p><a href="../../Login/logout.php">Sair</a></p>
    <!-- Link para cadastrar um novo lanche. -->
    <p><a href="create.php">+ Novo lanche</a></p>

    <!-- Tabela que mostra os lanches. -->
    <table border="1" cellpadding="8">
        <tr>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Ações</th>
        </tr>
        <!-- Percorre cada lanche retornado do banco. -->
        <?php foreach ($lanches as $lanche): ?>
        <tr>
            <!-- htmlspecialchars evita que texto salvo seja interpretado como HTML. -->
            <td><?php echo htmlspecialchars($lanche['nome']); ?></td>
            <td><?php echo htmlspecialchars($lanche['descricao']); ?></td>
            <!-- number_format deixa o preço no formato brasileiro. -->
            <td>R$ <?php echo number_format($lanche['preco'], 2, ',', '.'); ?></td>
            <td>
                <!-- Envia o ID para a página de edição. -->
                <a href="update.php?id=<?php echo $lanche['id']; ?>">Editar</a> |
                <!-- Envia o ID para exclusão e pede confirmação antes. -->
                <a href="delete.php?id=<?php echo $lanche['id']; ?>" onclick="return confirm('Excluir este lanche?')">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>