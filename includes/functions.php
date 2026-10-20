<?php
// Importa o arquivo que cria a conexão com o banco.
require_once __DIR__ . '/../database/connect.php';

// Cadastra um novo usuário no banco.
function cadastrarUsuario($conexao, $email, $senha) {
    // Comando SQL para inserir e-mail e senha.
    // Os nomes com : são parâmetros que serão preenchidos depois.
    $sql = "INSERT INTO usuarios (email, senha) VALUES (:email, :senha)";
    // Prepara o SQL para ser executado com segurança.
    $stmt = $conexao->prepare($sql);
    // Coloca o valor do e-mail no parâmetro :email.
    $stmt->bindParam(':email', $email);
    // Coloca o valor da senha no parâmetro :senha.
    $stmt->bindParam(':senha', $senha);
    // Executa o INSERT e retorna se deu certo ou não.
    return $stmt->execute();
}

// Procura um usuário usando o e-mail informado.
function buscarUsuarioPorEmail($conexao, $email) {
    // SQL que procura um usuário pelo e-mail.
    $sql = "SELECT * FROM usuarios WHERE email = :email";
    // Prepara o comando SQL.
    $stmt = $conexao->prepare($sql);
    // Passa o e-mail para o parâmetro :email.
    $stmt->bindParam(':email', $email);
    // Executa a busca.
    $stmt->execute();
    // Retorna uma linha como array associativo; se não achar, retorna false.
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Busca todos os lanches cadastrados.
function listarLanches($conexao) {
    // SELECT busca os dados e ORDER BY id organiza pelo ID.
    $sql = "SELECT * FROM lanches ORDER BY id";
    // query executa uma consulta simples sem parâmetros.
    $stmt = $conexao->query($sql);
    // fetchAll pega todas as linhas como arrays associativos.
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Procura um lanche específico pelo ID.
function buscarLanchePorId($conexao, $id) {
    // SQL que procura somente o registro do ID informado.
    $sql = "SELECT * FROM lanches WHERE id = :id";
    // Prepara o SQL.
    $stmt = $conexao->prepare($sql);
    // Coloca o ID no parâmetro :id.
    $stmt->bindParam(':id', $id);
    // Executa a busca.
    $stmt->execute();
    // Retorna o lanche encontrado ou false.
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Exclui um lanche pelo ID.
function excluirLanche($conexao, $id) {
    // SQL DELETE remove o registro correspondente ao ID.
    $sql = "DELETE FROM lanches WHERE id = :id";
    // Prepara o SQL.
    $stmt = $conexao->prepare($sql);
    // Passa o ID para :id.
    $stmt->bindParam(':id', $id);
    // Executa a exclusão.
    return $stmt->execute();
}

// Lista todos os usuários para aparecerem no formulário de pedido.
function listarUsuarios($conexao) {
    // Busca os usuários e organiza pelo ID.
    $sql = "SELECT * FROM usuarios ORDER BY id";
    // Executa a consulta.
    $stmt = $conexao->query($sql);
    // Retorna todos os usuários.
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Lista os pedidos e também traz o e-mail do cliente e o nome do lanche.
function listarPedidos($conexao) {
    // SELECT escolhe os campos que serão mostrados.
    $sql = "SELECT p.id, p.quantidade, p.status, p.data_pedido,
                   u.email AS cliente_email,
                   l.nome AS lanche_nome
            FROM pedidos p
            JOIN usuarios u ON p.usuario_id = u.id
            JOIN lanches l ON p.lanche_id = l.id
            ORDER BY p.id";
    // Executa a consulta.
    $stmt = $conexao->query($sql);
    // Retorna todos os pedidos encontrados.
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Procura um pedido pelo ID para poder editá-lo.
function buscarPedidoPorId($conexao, $id) {
    // SQL para encontrar o pedido.
    $sql = "SELECT * FROM pedidos WHERE id = :id";
    // Prepara o SQL.
    $stmt = $conexao->prepare($sql);
    // Passa o ID para o parâmetro.
    $stmt->bindParam(':id', $id);
    // Executa a consulta.
    $stmt->execute();
    // Retorna o pedido ou false se não encontrar.
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Exclui um pedido pelo ID.
function excluirPedido($conexao, $id) {
    // SQL que apaga o pedido.
    $sql = "DELETE FROM pedidos WHERE id = :id";
    // Prepara o SQL.
    $stmt = $conexao->prepare($sql);
    // Informa qual ID deve ser apagado.
    $stmt->bindParam(':id', $id);
    // Executa a exclusão.
    return $stmt->execute();
}

// Cadastra um novo lanche, incluindo a foto.
function cadastrarLanche($conexao, $nome, $descricao, $preco, $foto) {
    // SQL para inserir os dados do lanche.
    $sql = "INSERT INTO lanches (nome, descricao, preco, foto) VALUES (:nome, :descricao, :preco, :foto)";
    // Prepara o SQL.
    $stmt = $conexao->prepare($sql);
    // Passa cada valor para seu parâmetro.
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':foto', $foto);
    // Executa o cadastro.
    return $stmt->execute();
}

// Atualiza os dados de um lanche existente.
function atualizarLanche($conexao, $id, $nome, $descricao, $preco, $foto) {
    // SQL UPDATE altera os dados do registro que possui o ID informado.
    $sql = "UPDATE lanches SET nome = :nome, descricao = :descricao, preco = :preco, foto = :foto WHERE id = :id";
    // Prepara o SQL.
    $stmt = $conexao->prepare($sql);
    // Passa os novos valores para os parâmetros.
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':foto', $foto);
    // Informa qual registro será atualizado.
    $stmt->bindParam(':id', $id);
    // Executa a atualização.
    return $stmt->execute();
}
?>