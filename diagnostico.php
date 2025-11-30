<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Diagnóstico do Sistema Strong Woman</h1>";
echo "<style>body { font-family: Arial; padding: 20px; } .ok { color: green; } .error { color: red; } pre { background: #f5f5f5; padding: 10px; }</style>";

// Testar conexão
echo "<h2>1. Conexão com Banco de Dados</h2>";
include('config/conexao.php');

if ($conn->connect_error) {
    echo "<p class='error'>✗ ERRO na conexão: " . $conn->connect_error . "</p>";
    die();
} else {
    echo "<p class='ok'>✓ Conexão OK</p>";
}

// Listar todas as tabelas
echo "<h2>2. Tabelas Existentes</h2>";
$result = $conn->query("SHOW TABLES");
$tables = [];
while ($row = $result->fetch_array()) {
    $tables[] = $row[0];
}

echo "<pre>";
print_r($tables);
echo "</pre>";

// Verificar tabelas críticas
echo "<h2>3. Verificação de Tabelas Críticas</h2>";
$critical_tables = ['homepagehero', 'noticias', 'eventos', 'movimentos', 'doadores', 'configuracoes_doacoes'];

foreach ($critical_tables as $table) {
    if (in_array($table, $tables)) {
        // Contar registros
        $count_result = $conn->query("SELECT COUNT(*) as total FROM $table");
        $count = $count_result->fetch_assoc()['total'];
        echo "<p class='ok'>✓ Tabela '$table' existe - $count registros</p>";
    } else {
        echo "<p class='error'>✗ Tabela '$table' NÃO existe</p>";
    }
}

// Testar query homepagehero
echo "<h2>4. Teste de Query - homepagehero</h2>";
$sql = "SELECT * FROM homepagehero ORDER BY id ASC LIMIT 3";
$result = @$conn->query($sql);

if ($result) {
    echo "<p class='ok'>✓ Query executada com sucesso</p>";
    echo "<p>Registros encontrados: " . $result->num_rows . "</p>";
} else {
    echo "<p class='error'>✗ Erro na query: " . $conn->error . "</p>";
}

// Verificar arquivos críticos
echo "<h2>5. Arquivos Críticos</h2>";
$files = [
    'config/conexao.php',
    'components/header.php',
    'admin/helpers/auth.php',
    'admin/helpers/upload.php',
    'doacoes.php',
    'movimentos.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "<p class='ok'>✓ $file existe</p>";
    } else {
        echo "<p class='error'>✗ $file NÃO existe</p>";
    }
}

// Info do PHP
echo "<h2>6. Informações do PHP</h2>";
echo "<p>Versão PHP: " . phpversion() . "</p>";
echo "<p>Upload máximo: " . ini_get('upload_max_filesize') . "</p>";
echo "<p>Post máximo: " . ini_get('post_max_size') . "</p>";
echo "<p>Memória limite: " . ini_get('memory_limit') . "</p>";

echo "<hr>";
echo "<p><a href='index.php'>← Voltar para o Site</a> | <a href='admin/'>Admin</a></p>";

$conn->close();
?>
