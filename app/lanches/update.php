<?php
// Verifica se o usuário está logado.
require_once __DIR__ . '/../../Login/verifica-login.php';
// Importa as funções do banco.
require_once __DIR__ . '/../../includes/functions.php';

// Pega o ID do lanche pela URL.
$id = $_GET['id'];
// Busca os dados atuais desse lanche.
$lanche = buscarLanchePorId($conexao, $id);

// Se não encontrar o lanche, para e mostra uma mensagem.
if (!$lanche) {
    die("Lanche não encontrado.");
}

// Guarda uma possível mensagem de erro.
$erro = "";

// Verifica se o formulário de edição foi enviado.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
    // Pega os novos valores do formulário.
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    // Mantém a foto atual caso nenhuma nova seja enviada.
    $foto = $lanche['foto'];

    // Verifica se o usuário escolheu uma nova foto (NO_FILE = nenhuma foto escolhida).
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {

        // Foto maior do que o limite do PHP (upload_max_filesize).
        if ($_FILES['foto']['error'] === UPLOAD_ERR_INI_SIZE || $_FILES['foto']['error'] === UPLOAD_ERR_FORM_SIZE) {
            $erro = "A imagem é muito grande. O limite do servidor é " . ini_get('upload_max_filesize') . ".";

        // Qualquer outro erro no envio.
        } elseif ($_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
            $erro = "Erro ao enviar a imagem (código " . $_FILES['foto']['error'] . ").";

        } else {
            // Pega a extensão do arquivo em letras minúsculas (ex: jpg).
            $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

            // Só aceita arquivos de imagem.
            if (!in_array($extensao, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $erro = "Formato não permitido. Use JPG, PNG, GIF ou WEBP.";
            } else {
                // Define a pasta das imagens.
                $pastaDestino = __DIR__ . '/../../uploads/lanches/';
                // Cria a pasta caso ela ainda não exista.
                if (!is_dir($pastaDestino)) {
                    mkdir($pastaDestino, 0777, true);
                }
                // Cria um nome novo e seguro (sem espaços, acentos ou símbolos).
                $nomeArquivo = uniqid() . '.' . $extensao;
                // Monta o caminho final.
                $caminhoDestino = $pastaDestino . $nomeArquivo;

                // Move a nova foto para a pasta.
                if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoDestino)) {
                    // Só troca a foto se o upload funcionar.
                    $foto = $nomeArquivo;
                } else {
                    // Guarda a mensagem de erro.
                    $erro = "Erro ao salvar a nova imagem.";
                }
            }
        }
    }

    // Só atualiza se não houver erro.
    if (!$erro) {
        // Chama a função que faz o UPDATE.
        atualizarLanche($conexao, $id, $nome, $descricao, $preco, $foto);
        // Volta para a lista.
        header("Location: select.php");
        // Para a execução.
        exit;
    }

// Se o envio passar do limite post_max_size, o PHP descarta o formulário inteiro.
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $erro = "A imagem é muito grande. Escolha uma foto menor (limite do servidor: " . ini_get('post_max_size') . ").";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Lanche</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
    <h2>Editar Lanche</h2>

    <!-- Mostra a mensagem de erro se existir. -->
    <?php if ($erro): ?>
        <p style="color:red;"><?php echo $erro; ?></p>
    <?php endif; ?>

    <!-- Se o lanche tiver foto, mostra a foto atual. -->
    <?php if ($lanche['foto']): ?>
        <img src="/uploads/lanches/<?php echo rawurlencode($lanche['foto']); ?>" alt="Foto atual" width="150"><br>
    <?php endif; ?>

    <!-- Formulário de edição. O ID continua na URL. -->
    <form method="POST" action="update.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
        <label>Nome:</label>
        <input type="text" name="nome" value="<?php echo htmlspecialchars($lanche['nome']); ?>" required><br>

        <label>Descrição:</label>
        <textarea name="descricao"><?php echo htmlspecialchars($lanche['descricao']); ?></textarea><br>

        <label>Preço:</label>
        <input type="number" step="0.01" name="preco" value="<?php echo $lanche['preco']; ?>" required><br>

        <label>Nova foto (opcional):</label>
        <input type="file" name="foto" accept="image/*"><br>

        <button type="submit">Atualizar</button>
    </form>

    <p><a href="select.php">Voltar</a></p>
</body>
</html>