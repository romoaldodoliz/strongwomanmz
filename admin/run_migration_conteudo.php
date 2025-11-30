<?php
/**
 * Executor de Migration - Conteúdo Frontend
 */

include('config/conexao.php');

echo "<h1>Executando Migration - Conteúdo Frontend</h1>";
echo "<pre>";

$success = 0;
$errors = 0;

// Ler arquivo SQL
$sql_content = file_get_contents('migration_conteudo_frontend.sql');

// Remover comentários e dividir por ;
$sql_content = preg_replace('/--.*$/m', '', $sql_content);
$statements = explode(';', $sql_content);

foreach ($statements as $statement) {
    $statement = trim($statement);
    
    if (empty($statement)) {
        continue;
    }
    
    if ($conn->query($statement) === TRUE) {
        $success++;
        echo "✓ Comando executado\n";
    } else {
        $errors++;
        echo "✗ Erro: " . $conn->error . "\n";
    }
}

echo "\n========================================\n";
echo "Migration concluída!\n";
echo "Sucesso: $success\n";
echo "Erros: $errors\n";
echo "========================================\n";

// Verificar se tabela foi criada
$result = $conn->query("SHOW TABLES LIKE 'conteudo_frontend'");
if ($result->num_rows > 0) {
    echo "\n✓ Tabela 'conteudo_frontend' criada com sucesso!\n";
    
    // Contar registros
    $count_result = $conn->query("SELECT COUNT(*) as total FROM conteudo_frontend");
    $count = $count_result->fetch_assoc();
    echo "✓ {$count['total']} registros de conteúdo inseridos\n";
} else {
    echo "\n✗ Tabela 'conteudo_frontend' NÃO foi criada\n";
}

echo "</pre>";
echo "<p><a href='dashboard.php' class='btn btn-primary'>Voltar ao Dashboard</a></p>";
echo "<p><a href='conteudo-frontend.php' class='btn btn-success'>Ir para Editor de Conteúdo</a></p>";

$conn->close();
?>
