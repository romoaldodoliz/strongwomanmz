<?php

$hostname = "localhost";
$username = "root"; 
$port = 8889; // Defina o número da porta como um inteiro
$password = "root";
$database = "strongwoman";

// Tentar estabelecer a conexão
$conn = new mysqli($hostname, $username, $password, $database, $port);

// Verificar se ocorreu algum erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
} else {
    // echo "conectado com sucesso";
}

// Defina o conjunto de caracteres para UTF-8 (utf8mb4 para compatibilidade total)
$conn->set_charset("utf8mb4");
?>
