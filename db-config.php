<?php
$host = 'localhost';  // Nome do host
$user = 'root';       // Usuário do MySQL
$password = 'root';       // Senha do MySQL (padrão é vazio)
$dbname = 'eventsmanager'; // Nome do banco de dados que você quer criar

// Conectar ao MySQL sem especificar o banco de dados
$conn = new mysqli($host, $user, $password);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se o banco de dados existe, se não, cria o banco
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Banco de dados criado ou já existe.<br>";
} else {
    die("Erro ao criar o banco de dados: " . $conn->error);
}

// Agora seleciona o banco de dados para usar
$conn->select_db($dbname);

// Opcional: Definir o charset para evitar problemas com acentuação
$conn->set_charset("utf8");

?>
