<?php
include 'config/conexao.php';

echo "<style>body{font-family:Arial;padding:40px;background:#f5f5f5;} .success{color:green;} .error{color:red;} .info{color:blue;}</style>";
echo "<h1>🔧 Upgrade Sistema de Movimentos/Blog</h1>";

// Verificar estrutura atual
echo "<h2>📊 Estrutura Atual da Tabela 'movimentos':</h2>";
$result = $conn->query("SHOW COLUMNS FROM movimentos");
echo "<table border='1' cellpadding='10' style='background:white;border-collapse:collapse;'>";
echo "<tr><th>Campo</th><th>Tipo</th><th>Null</th><th>Key</th><th>Default</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['Field']}</td>";
    echo "<td>{$row['Type']}</td>";
    echo "<td>{$row['Null']}</td>";
    echo "<td>{$row['Key']}</td>";
    echo "<td>{$row['Default']}</td>";
    echo "</tr>";
}
echo "</table>";

// Campos que queremos adicionar para transformar em blog completo
$campos_novos = [
    "resumo" => "VARCHAR(500) DEFAULT NULL COMMENT 'Resumo curto para cards'",
    "conteudo" => "LONGTEXT DEFAULT NULL COMMENT 'Conteúdo completo do artigo em HTML'",
    "autor" => "VARCHAR(255) DEFAULT 'Strong Woman' COMMENT 'Nome do autor'",
    "tags" => "VARCHAR(500) DEFAULT NULL COMMENT 'Tags separadas por vírgula'",
    "destaque" => "BOOLEAN DEFAULT 0 COMMENT 'Artigo em destaque na página inicial'",
    "updated_at" => "TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"
];

echo "<h2>🆕 Adicionando Novos Campos:</h2>";

foreach ($campos_novos as $campo => $definicao) {
    // Verificar se o campo já existe
    $check = $conn->query("SHOW COLUMNS FROM movimentos LIKE '$campo'");
    
    if ($check->num_rows == 0) {
        $sql = "ALTER TABLE movimentos ADD COLUMN $campo $definicao";
        if ($conn->query($sql)) {
            echo "<p class='success'>✓ Campo '$campo' adicionado com sucesso!</p>";
        } else {
            echo "<p class='error'>✗ Erro ao adicionar campo '$campo': " . $conn->error . "</p>";
        }
    } else {
        echo "<p class='info'>ℹ Campo '$campo' já existe.</p>";
    }
}

// Verificar se precisamos renomear visualizacoes
$check = $conn->query("SHOW COLUMNS FROM movimentos LIKE 'visualizacoes'");
if ($check->num_rows == 0) {
    // Adicionar campo visualizacoes se não existir
    $sql = "ALTER TABLE movimentos ADD COLUMN visualizacoes INT DEFAULT 0";
    if ($conn->query($sql)) {
        echo "<p class='success'>✓ Campo 'visualizacoes' adicionado!</p>";
    }
} else {
    echo "<p class='info'>ℹ Campo 'visualizacoes' já existe.</p>";
}

echo "<h2>✅ Upgrade Concluído!</h2>";
echo "<p><strong>Novos recursos disponíveis:</strong></p>";
echo "<ul>";
echo "<li>📝 <strong>Resumo</strong>: Texto curto para exibir nos cards</li>";
echo "<li>📄 <strong>Conteúdo</strong>: Editor rico de texto para artigos completos</li>";
echo "<li>👤 <strong>Autor</strong>: Nome de quem escreveu o artigo</li>";
echo "<li>🏷️ <strong>Tags</strong>: Categorização e busca</li>";
echo "<li>⭐ <strong>Destaque</strong>: Mostrar artigo na home</li>";
echo "<li>👁️ <strong>Visualizações</strong>: Contador de acessos</li>";
echo "</ul>";

echo "<br><a href='admin/movimentos.php' style='background:#fb0a0a;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Ir para Movimentos</a>";

$conn->close();
?>
