<?php
// Conexão
$hostname = "localhost";
$username = "root"; 
$port = 8889;
$password = "root";
$database = "strongwoman";

$conn = new mysqli($hostname, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

echo "<h1>Corrigindo charset do database</h1>";
echo "<style>body{font-family:Arial;padding:40px;} .success{color:green;} .error{color:red;}</style>";

// 1. Alterar database
echo "<h2>1. Alterando database...</h2>";
$sql = "ALTER DATABASE strongwoman CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
if ($conn->query($sql)) {
    echo "<p class='success'>✓ Database alterado</p>";
} else {
    echo "<p class='error'>✗ Erro: " . $conn->error . "</p>";
}

// 2. Listar todas as tabelas
$result = $conn->query("SHOW TABLES");
$tables = [];
while ($row = $result->fetch_array()) {
    $tables[] = $row[0];
}

echo "<h2>2. Convertendo tabelas...</h2>";

// 3. Converter cada tabela
foreach ($tables as $table) {
    echo "<p><strong>Tabela: {$table}</strong></p>";
    
    // Converter tabela
    $sql = "ALTER TABLE `{$table}` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
    if ($conn->query($sql)) {
        echo "<p class='success'>✓ Convertida</p>";
    } else {
        echo "<p class='error'>✗ Erro: " . $conn->error . "</p>";
    }
}

echo "<h2>3. Verificação final</h2>";

// Verificar status das tabelas
foreach (['movimentos', 'movimentos_fotos', 'noticias', 'eventos'] as $table) {
    $result = $conn->query("SHOW TABLE STATUS WHERE Name = '{$table}'");
    $row = $result->fetch_assoc();
    echo "<p>{$table}: <strong>{$row['Collation']}</strong></p>";
}

echo "<h2 class='success'>✓ Concluído!</h2>";
echo "<p><a href='admin/movimentosform.php' style='background:#fb0a0a;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;display:inline-block;margin:20px 0;'>Testar Formulário</a></p>";

$conn->close();
?>
