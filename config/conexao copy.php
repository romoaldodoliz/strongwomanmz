<?php
// Configuração da conexão com o banco de dados
$hostname = "strongwoman-mz.org.mysql:3306"; // Substitua pelo nome do host do seu banco de dados
$username = "strongwoman_mz_orgstrongwoman"; // Substitua pelo nome de usuário do seu banco de dados
$password = "Edmundo"; // Substitua pela senha do seu banco de dados
$database = "strongwoman_mz_orgstrongwoman"; // Substitua pelo nome do seu banco de dados

// Tentar estabelecer a conexão
$conn = new mysqli($hostname, $username, $password, $database);

// Verificar se ocorreu algum erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}else{
    // echo "conectado com sucesso";
}
// Defina o conjunto de caracteres para UTF-8 (opcional)
$conn->set_charset("utf8");
?>