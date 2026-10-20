<?php
// Verifica se o usuário está logado.
require_once __DIR__ . '/../../Login/verifica-login.php';
// Importa as funções do banco.
require_once __DIR__ . '/../../includes/functions.php';

// Pega da URL o ID do pedido que será excluído.
$id = $_GET['id'];
// Executa o DELETE do pedido.
excluirPedido($conexao, $id);

// Volta para a lista de pedidos.
header("Location: select.php");
// Finaliza o script.
exit;
?>