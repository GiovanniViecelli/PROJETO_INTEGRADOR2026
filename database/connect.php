<?php
// Define o endereço/IP do servidor onde está o PostgreSQL.
$host = "192.168.10.23";
// Define o nome do banco de dados que será usado.
$dbname = "hamburgueria";
// Define o usuário usado para acessar o banco.
$user = "hamburgueria";
// Define a senha desse usuário.
$pass = "hamburgueria";

// try tenta executar a conexão sem derrubar o programa imediatamente.
try {
    // Cria uma conexão PDO com o PostgreSQL.
    // pgsql informa que o banco é PostgreSQL.
    // host e dbname informam onde e qual banco será acessado.
    $conexao = new PDO(
        "pgsql:host=$host;dbname=$dbname",
        $user,
        $pass
    );

    // Faz o PDO mostrar erros como exceções quando algo der errado.
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Se a conexão falhar, entra aqui.
} catch (PDOException $e) {
    // Para o programa e mostra a mensagem do erro de conexão.
    $die = "Erro na conexão: " . $e->getMessage();
    die($die);
}
?>