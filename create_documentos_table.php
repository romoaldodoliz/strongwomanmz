<?php
include 'config/conexao.php';

// Dropar tabela se existir para recriar corretamente
$conn->query("DROP TABLE IF EXISTS documentos");

// Criar tabela documentos
$sql = "CREATE TABLE documentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    arquivo VARCHAR(500) NOT NULL,
    tipo_arquivo VARCHAR(50) NOT NULL,
    tamanho_arquivo INT NOT NULL,
    categoria VARCHAR(100),
    downloads INT DEFAULT 0,
    status ENUM('publicado', 'rascunho') DEFAULT 'publicado',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($sql)) {
    echo "<h2 style='color: green;'>✓ Tabela 'documentos' criada com sucesso!</h2>";
} else {
    echo "<h2 style='color: red;'>✗ Erro ao criar tabela: " . $conn->error . "</h2>";
}

// Criar diretório para uploads de documentos
$upload_dir = __DIR__ . '/uploads/documentos';
if (!file_exists($upload_dir)) {
    if (mkdir($upload_dir, 0755, true)) {
        echo "<p style='color: green;'>✓ Diretório 'uploads/documentos' criado!</p>";
    } else {
        echo "<p style='color: red;'>✗ Erro ao criar diretório de uploads!</p>";
    }
} else {
    echo "<p style='color: blue;'>ℹ Diretório 'uploads/documentos' já existe!</p>";
}

echo "<br><a href='admin/documentos.php' style='background:#fb0a0a;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Ir para Documentos</a>";

$conn->close();
?>
