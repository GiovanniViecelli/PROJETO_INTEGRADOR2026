<?php
// Verifica se o usuário está logado.
require_once __DIR__ . '/../../Login/verifica-login.php';
// Importa a função de exclusão.
require_once __DIR__ . '/../../includes/functions.php';

// Pega da URL o ID do lanche que será excluído.
// Exemplo: delete.php?id=3
$id = $_GET['id'];
// Chama a função que faz o DELETE no banco.
excluirLanche($conexao, $id);

// Volta para a lista de lanches.
header("Location: select.php");
// Encerra o script.
exit;
?>