<?php
// Importa as funções e a conexão com o banco.
require_once __DIR__ . '/includes/functions.php';

// Busca todos os lanches para mostrar no cardápio público.
$lanches = listarLanches($conexao);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cardápio - Gisburguer</title>
    <link rel="stylesheet" href="/style/style.css">
    <style>
        /* Cria uma grade para os cards dos lanches. */
        .grid-cardapio {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }
        /* Estilo de cada card. */
        .card-lanche {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(42, 21, 21, 0.15);
                      }
        /* Define o tamanho das imagens dos lanches. */
        .card-lanche img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }
        /* Área exibida quando o lanche não tem foto. */
        .card-lanche .sem-foto {
            width: 100%;
            height: 160px;
            background: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
        }
        /* Espaçamento do nome do lanche. */
        .card-lanche h3 {
            margin: 12px 0 4px;
        }
        /* Estilo da descrição. */
        .card-lanche p {
            padding: 0 12px;
            color: #555;
            font-size: 14px;
        }
        /* Destaque do preço. */
        .card-lanche .preco {
            font-weight: bold;
            color: #d84315;
            padding-bottom: 12px;
        }
    </style>
</head>
<body>
    <header class="header-cardapio">
        <!-- Logo da Gisburguer no topo do cardápio (versão clara para o fundo laranja). -->
        <img class="logo" src="img/logo-gisburguer-claro.svg" alt="Gisburguer - Hamburgueria">
        <!-- Link para clientes que querem fazer um pedido. -->
        <a href="/Login/login.php">Já sou cliente / Fazer pedido</a>
    </header>

    <main>
        <div class="grid-cardapio">
            <!-- Percorre todos os lanches. -->
            <?php foreach ($lanches as $lanche): ?>
            <div class="card-lanche">
                <!-- Se existir foto, mostra a imagem. -->
                <?php if ($lanche['foto']): ?>
                    <img src="/uploads/lanches/<?php echo htmlspecialchars($lanche['foto']); ?>" alt="<?php echo htmlspecialchars($lanche['nome']); ?>">
                <?php else: ?>
                    <!-- Caso não exista foto, mostra um espaço informando isso. -->
                    <div class="sem-foto">Sem foto</div>
                <?php endif; ?>

                <!-- Mostra nome, descrição e preço. -->
                <h3 class='titulo-lanche'><?php echo htmlspecialchars($lanche['nome']); ?></h3>
                <p><?php echo htmlspecialchars($lanche['descricao']); ?></p>
                <p class="preco">R$ <?php echo number_format($lanche['preco'], 2, ',', '.'); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        <!-- Mostra o ano atual automaticamente. -->
        <p>Projeto Integrador &copy; <?php echo date('Y'); ?></p>
    </footer>
</body>
</html>