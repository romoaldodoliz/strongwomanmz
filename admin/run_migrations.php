<?php
/**
 * Script para executar migrações do banco de dados
 * Execute este arquivo uma vez para criar as novas tabelas
 */

include('config/conexao.php');

echo "<h1>Executando Migrações do Banco de Dados</h1>";
echo "<pre>";

$success_count = 0;
$error_count = 0;

// 1. Criar tabela configuracoes_doacoes
echo "Criando tabela configuracoes_doacoes...\n";
$sql = "CREATE TABLE IF NOT EXISTS `configuracoes_doacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_conta` varchar(255) DEFAULT NULL,
  `banco_nome` varchar(255) DEFAULT NULL,
  `mpesa_numero` varchar(20) DEFAULT NULL,
  `emola_numero` varchar(20) DEFAULT NULL,
  `paypal_button_code` text DEFAULT NULL,
  `instrucoes_gerais` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($sql) === TRUE) {
    echo "✓ Tabela configuracoes_doacoes criada\n";
    $success_count++;
} else {
    echo "✗ Erro: " . $conn->error . "\n";
    $error_count++;
}

// Inserir configuração padrão
echo "Inserindo configuração padrão...\n";
$sql = "INSERT INTO `configuracoes_doacoes` (`id`, `numero_conta`, `banco_nome`, `mpesa_numero`, `emola_numero`, `paypal_button_code`, `instrucoes_gerais`) 
VALUES (1, NULL, NULL, NULL, NULL, NULL, 'Obrigado por apoiar a Strong Woman!') 
ON DUPLICATE KEY UPDATE `id`=`id`";

if ($conn->query($sql) === TRUE) {
    echo "✓ Configuração padrão inserida\n";
    $success_count++;
} else {
    echo "✗ Erro: " . $conn->error . "\n";
    $error_count++;
}

// 2. Criar tabela doadores
echo "\nCriando tabela doadores...\n";
$sql = "CREATE TABLE IF NOT EXISTS `doadores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `valor` decimal(10, 2) NOT NULL,
  `metodo_pagamento` enum('banco','mpesa','emola','paypal','outro') NOT NULL,
  `data_doacao` date NOT NULL,
  `comprovativo` varchar(255) DEFAULT NULL,
  `mensagem` text DEFAULT NULL,
  `status` enum('pendente','confirmado','rejeitado') DEFAULT 'pendente',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_data_doacao` (`data_doacao`),
  KEY `idx_metodo` (`metodo_pagamento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($sql) === TRUE) {
    echo "✓ Tabela doadores criada\n";
    $success_count++;
} else {
    echo "✗ Erro: " . $conn->error . "\n";
    $error_count++;
}

// 3. Criar tabela movimentos
echo "\nCriando tabela movimentos...\n";
$sql = "CREATE TABLE IF NOT EXISTS `movimentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `tema` varchar(255) DEFAULT NULL,
  `descricao` text NOT NULL,
  `data_evento` date DEFAULT NULL,
  `local` varchar(255) DEFAULT NULL,
  `imagem_principal` varchar(255) DEFAULT NULL,
  `status` enum('rascunho','publicado','arquivado') DEFAULT 'publicado',
  `visualizacoes` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`),
  KEY `idx_data_evento` (`data_evento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($sql) === TRUE) {
    echo "✓ Tabela movimentos criada\n";
    $success_count++;
} else {
    echo "✗ Erro: " . $conn->error . "\n";
    $error_count++;
}

// 4. Criar tabela movimentos_fotos
echo "\nCriando tabela movimentos_fotos...\n";
$sql = "CREATE TABLE IF NOT EXISTS `movimentos_fotos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movimento_id` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `legenda` varchar(500) DEFAULT NULL,
  `ordem` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_movimento_id` (`movimento_id`),
  KEY `idx_ordem` (`ordem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($conn->query($sql) === TRUE) {
    echo "✓ Tabela movimentos_fotos criada\n";
    $success_count++;
} else {
    echo "✗ Erro: " . $conn->error . "\n";
    $error_count++;
}

// Adicionar foreign key se não existir
echo "\nAdicionando foreign key...\n";
$check_fk = $conn->query("SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS 
                          WHERE TABLE_SCHEMA = 'strongwoman' 
                          AND TABLE_NAME = 'movimentos_fotos' 
                          AND CONSTRAINT_NAME = 'fk_movimentos_fotos_movimento'");

if ($check_fk->num_rows == 0) {
    $sql = "ALTER TABLE `movimentos_fotos` 
            ADD CONSTRAINT `fk_movimentos_fotos_movimento` 
            FOREIGN KEY (`movimento_id`) REFERENCES `movimentos` (`id`) ON DELETE CASCADE";
    
    if ($conn->query($sql) === TRUE) {
        echo "✓ Foreign key adicionada\n";
        $success_count++;
    } else {
        echo "✗ Erro: " . $conn->error . "\n";
        $error_count++;
    }
} else {
    echo "✓ Foreign key já existe\n";
}

echo "\n========================================\n";
echo "Migração concluída!\n";
echo "Comandos executados com sucesso: $success_count\n";
echo "Erros: $error_count\n";
echo "========================================\n";

// Verificar tabelas criadas
echo "\nVerificando tabelas criadas:\n";
$tables = ['configuracoes_doacoes', 'doadores', 'movimentos', 'movimentos_fotos'];

foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows > 0) {
        echo "✓ Tabela '$table' criada com sucesso\n";
    } else {
        echo "✗ Tabela '$table' não foi criada\n";
    }
}

echo "</pre>";
echo "<p><a href='dashboard.php' class='btn btn-primary'>Voltar ao Dashboard</a></p>";

$conn->close();
?>
