<?php
include('config/conexao.php');

echo "<h2>Corrigindo Collation das Tabelas</h2>";

// Lista de tabelas para corrigir
$tables = ['movimentos', 'movimentos_fotos', 'doadores', 'configuracoes_doacoes', 'noticias', 'eventos', 'galeria', 'homepagehero'];

foreach ($tables as $table) {
    // Verificar se tabela existe
    $check = $conn->query("SHOW TABLES LIKE '$table'");
    if ($check && $check->num_rows > 0) {
        echo "<p>Corrigindo tabela <strong>$table</strong>...</p>";
        
        // Converter tabela para utf8mb4
        $sql1 = "ALTER TABLE `$table` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
        if ($conn->query($sql1)) {
            echo "<p style='color:green;'>✓ Tabela $table convertida com sucesso!</p>";
        } else {
            echo "<p style='color:orange;'>⚠ Aviso ao converter $table: " . $conn->error . "</p>";
        }
        
        // Alterar collation da tabela
        $sql2 = "ALTER TABLE `$table` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
        if ($conn->query($sql2)) {
            echo "<p style='color:green;'>✓ Collation da tabela $table alterada!</p>";
        }
        
    } else {
        echo "<p style='color:gray;'>- Tabela $table não existe (pulando)</p>";
    }
    echo "<hr>";
}

// Corrigir o database inteiro
echo "<h3>Corrigindo Database Completo</h3>";
$db_name = 'strongwoman';
$sql = "ALTER DATABASE `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
if ($conn->query($sql)) {
    echo "<p style='color:green;'>✓ Database $db_name atualizado com sucesso!</p>";
} else {
    echo "<p style='color:red;'>✗ Erro: " . $conn->error . "</p>";
}

echo "<br><br><a href='admin/movimentosform.php' style='background:#fb0a0a; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;'>Testar Movimentos Form</a>";
echo " | <a href='index.php' style='background:#151515; color:white; padding:10px 20px; text-decoration:none; border-radius:5px; margin-left:10px;'>Voltar ao Site</a>";

$conn->close();
?>
