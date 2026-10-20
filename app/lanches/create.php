<?php
// Verifica se o usuário está logado.
require_once __DIR__ . '/../../Login/verifica-login.php';
// Importa as funções usadas para trabalhar com o banco.
require_once __DIR__ . '/../../includes/functions.php';

// Guarda uma possível mensagem de erro.
$erro = "";

// Verifica se o formulário foi enviado pelo método POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pega o nome enviado pelo formulário.
    $nome = $_POST['nome'];
    // Pega a descrição enviada.
    $descricao = $_POST['descricao'];
    // Pega o preço enviado.
    $preco = $_POST['preco'];
    // Começa sem nenhuma foto.
    $foto = null;

    // Verifica se foi enviada uma foto e se o upload terminou corretamente.
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        // Define a pasta onde a foto será salva.
        $pastaDestino = __DIR__ . '/../../uploads/lanches/';
        // Cria um nome usando o horário atual + nome original do arquivo.
        $nomeArquivo = time() . '_' . basename($_FILES['foto']['name']);
        // Junta a pasta com o nome do arquivo.
        $caminhoDestino = $pastaDestino . $nomeArquivo;

        // Move a foto temporária para a pasta definitiva.
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoDestino)) {
            // Guarda somente o nome do arquivo no banco.
            $foto = $nomeArquivo;
        } else {
            // Se não conseguir salvar, mostra um erro.
            $erro = "Erro ao salvar a imagem.";
        }
    }

    // Só cadastra se não aconteceu nenhum erro.
    if (!$erro) {
        // Chama a função que faz o INSERT no banco.
        cadastrarLanche($conexao, $nome, $descricao, $preco, $foto);
        // Depois do cadastro, volta para a lista de lanches.
        header("Location: select.php");
        // Para a execução depois do redirecionamento.
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Define a codificação dos caracteres. -->
    <meta charset="UTF-8">
    <!-- Título da página. -->
    <title>Novo Lanche</title>
    <!-- Importa o arquivo CSS. -->
    <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
    <!-- Título mostrado na página. -->
    <h2>Cadastrar Lanche</h2>

    <!-- Mostra o erro somente quando existir uma mensagem. -->
    <?php if ($erro): ?>
        <p style="color:red;"><?php echo $erro; ?></p>
    <?php endif; ?>

    <!-- Formulário para cadastrar o lanche. -->
    <!-- multipart/form-data é necessário para enviar arquivos. -->
    <form method="POST" action="create.php" enctype="multipart/form-data">
        <label>Nome:</label>
        <input type="text" name="nome" required><br>

        <label>Descrição:</label>
        <textarea name="descricao"></textarea><br>

        <label>Preço:</label>
        <input type="number" step="0.01" name="preco" required><br>

        <label>Foto:</label>
        <input type="file" name="foto" accept="image/*"><br>

        <!-- Botão que envia o formulário. -->
        <button type="submit">Salvar</button>
    </form>

    <!-- Link para voltar à lista. -->
    <p><a href="select.php">Voltar</a></p>
</body>
</html>