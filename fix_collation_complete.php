<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexão com o banco
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "strongwoman";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Correção de Collation - Strong Woman</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1200px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #fb0a0a; margin-bottom: 30px; }
        .step { margin: 20px 0; padding: 15px; border-left: 4px solid #fb0a0a; background: #fff5f5; }
        .success { color: #28a745; font-weight: bold; }
        .error { color: #dc3545; font-weight: bold; }
        .info { color: #17a2b8; }
        .warning { color: #ffc107; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        table th, table td { padding: 10px; text-align: left; border: 1px solid #ddd; }
        table th { background: #fb0a0a; color: white; }
        .btn { display: inline-block; padding: 10px 20px; background: #fb0a0a; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px; }
        .btn:hover { background: #d00909; }
        pre { background: #f8f9fa; padding: 10px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔧 Correção de Collation - Strong Woman Database</h1>";

// PASSO 1: Diagnosticar o problema
echo "<div class='step'>
        <h2>📊 Passo 1: Diagnóstico do Database</h2>";

$result = $conn->query("SELECT @@character_set_database, @@collation_database");
$db_charset = $result->fetch_row();
echo "<p><strong>Database charset:</strong> {$db_charset[0]}</p>";
echo "<p><strong>Database collation:</strong> {$db_charset[1]}</p>";

$result = $conn->query("SELECT @@character_set_connection, @@collation_connection");
$conn_charset = $result->fetch_row();
echo "<p><strong>Connection charset:</strong> {$conn_charset[0]}</p>";
echo "<p><strong>Connection collation:</strong> {$conn_charset[1]}</p>";
echo "</div>";

// PASSO 2: Verificar collation das tabelas
echo "<div class='step'>
        <h2>📋 Passo 2: Collation das Tabelas</h2>
        <table>
            <tr>
                <th>Tabela</th>
                <th>Collation Atual</th>
                <th>Status</th>
            </tr>";

$tables = ['movimentos', 'movimentos_fotos', 'noticias', 'eventos', 'galeria', 'homepagehero', 'doadores', 'configuracoes_doacoes'];

$tables_to_fix = [];
foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLE STATUS WHERE Name = '$table'");
    if ($row = $result->fetch_assoc()) {
        $collation = $row['Collation'];
        $status = ($collation === 'utf8mb4_general_ci') ? "<span class='success'>✓ OK</span>" : "<span class='warning'>⚠ Precisa corrigir</span>";
        
        if ($collation !== 'utf8mb4_general_ci') {
            $tables_to_fix[] = $table;
        }
        
        echo "<tr>
                <td>{$table}</td>
                <td>{$collation}</td>
                <td>{$status}</td>
              </tr>";
    }
}
echo "</table></div>";

// PASSO 3: Verificar colunas da tabela movimentos
echo "<div class='step'>
        <h2>🔍 Passo 3: Colunas da Tabela 'movimentos'</h2>
        <table>
            <tr>
                <th>Coluna</th>
                <th>Tipo</th>
                <th>Collation</th>
                <th>Status</th>
            </tr>";

$result = $conn->query("SHOW FULL COLUMNS FROM movimentos");
$columns_to_fix = [];
while ($row = $result->fetch_assoc()) {
    $collation = $row['Collation'] ?? 'N/A';
    $status = 'N/A';
    
    if ($collation !== 'N/A') {
        if ($collation === 'utf8mb4_general_ci') {
            $status = "<span class='success'>✓ OK</span>";
        } else {
            $status = "<span class='warning'>⚠ Precisa corrigir</span>";
            $columns_to_fix[] = $row['Field'];
        }
    }
    
    echo "<tr>
            <td>{$row['Field']}</td>
            <td>{$row['Type']}</td>
            <td>{$collation}</td>
            <td>{$status}</td>
          </tr>";
}
echo "</table></div>";

// PASSO 4: Aplicar correções
echo "<div class='step'>
        <h2>🛠️ Passo 4: Aplicando Correções</h2>";

// Converter database
echo "<p><strong>Convertendo database...</strong></p>";
if ($conn->query("ALTER DATABASE strongwoman CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci")) {
    echo "<p class='success'>✓ Database convertido com sucesso!</p>";
} else {
    echo "<p class='error'>✗ Erro ao converter database: " . $conn->error . "</p>";
}

// Converter cada tabela
foreach ($tables_to_fix as $table) {
    echo "<p><strong>Convertendo tabela: {$table}...</strong></p>";
    
    // Converter para utf8mb4_general_ci
    $sql = "ALTER TABLE {$table} CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
    if ($conn->query($sql)) {
        echo "<p class='success'>✓ Tabela {$table} convertida!</p>";
    } else {
        echo "<p class='error'>✗ Erro ao converter {$table}: " . $conn->error . "</p>";
    }
    
    // Definir como padrão
    $sql = "ALTER TABLE {$table} DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
    if ($conn->query($sql)) {
        echo "<p class='success'>✓ Padrão definido para {$table}!</p>";
    } else {
        echo "<p class='error'>✗ Erro ao definir padrão {$table}: " . $conn->error . "</p>";
    }
}

// Converter especificamente colunas problemáticas
if (count($columns_to_fix) > 0) {
    echo "<p><strong>Convertendo colunas específicas...</strong></p>";
    foreach ($columns_to_fix as $column) {
        // Buscar tipo da coluna
        $result = $conn->query("SHOW COLUMNS FROM movimentos WHERE Field = '{$column}'");
        $col_info = $result->fetch_assoc();
        $type = $col_info['Type'];
        
        $sql = "ALTER TABLE movimentos MODIFY {$column} {$type} CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
        if ($conn->query($sql)) {
            echo "<p class='success'>✓ Coluna {$column} convertida!</p>";
        } else {
            echo "<p class='error'>✗ Erro ao converter coluna {$column}: " . $conn->error . "</p>";
        }
    }
}

echo "</div>";

// PASSO 5: Forçar a conexão para usar utf8mb4
echo "<div class='step'>
        <h2>⚙️ Passo 5: Configurar Conexão</h2>";

// Verificar arquivo de conexão
$config_file = __DIR__ . '/admin/config/conexao.php';
$config_content = file_get_contents($config_file);

if (strpos($config_content, 'set_charset') === false && strpos($config_content, 'SET NAMES') === false) {
    echo "<p class='warning'>⚠ Arquivo de conexão precisa ser atualizado!</p>";
    echo "<p>Atualizando conexao.php...</p>";
    
    // Backup
    file_put_contents($config_file . '.backup', $config_content);
    
    // Adicionar set_charset após a conexão
    $new_content = str_replace(
        'die("Connection failed: " . $conn->connect_error);',
        'die("Connection failed: " . $conn->connect_error);' . "\n}\n\n// Definir charset para utf8mb4\n\$conn->set_charset('utf8mb4');\n",
        $config_content
    );
    
    file_put_contents($config_file, $new_content);
    echo "<p class='success'>✓ Arquivo conexao.php atualizado!</p>";
} else {
    echo "<p class='success'>✓ Arquivo de conexão já está configurado corretamente!</p>";
}

echo "</div>";

// PASSO 6: Verificação final
echo "<div class='step'>
        <h2>✅ Passo 6: Verificação Final</h2>";

$result = $conn->query("SHOW TABLE STATUS WHERE Name = 'movimentos'");
$row = $result->fetch_assoc();
echo "<p><strong>Collation final da tabela 'movimentos':</strong> <span class='success'>{$row['Collation']}</span></p>";

$result = $conn->query("SHOW FULL COLUMNS FROM movimentos WHERE Field IN ('titulo', 'tema', 'descricao', 'local')");
echo "<p><strong>Collation das colunas de texto:</strong></p><ul>";
while ($row = $result->fetch_assoc()) {
    echo "<li>{$row['Field']}: <span class='success'>{$row['Collation']}</span></li>";
}
echo "</ul>";

echo "<p class='success' style='font-size: 18px; margin-top: 20px;'>🎉 Correção concluída com sucesso!</p>";
echo "</div>";

echo "<div style='text-align: center; margin-top: 30px;'>
        <a href='admin/movimentosform.php' class='btn'>Testar Formulário de Movimentos</a>
        <a href='index.php' class='btn' style='background: #151515; margin-left: 10px;'>Voltar ao Site</a>
      </div>";

echo "</div>
</body>
</html>";

$conn->close();
?>
