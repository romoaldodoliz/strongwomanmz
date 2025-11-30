-- =====================================================
-- Script de Migração do Banco de Dados - Strong Woman
-- Tabelas: configuracoes_doacoes, doadores, movimentos, movimentos_fotos
-- =====================================================

-- Tabela de Configurações de Doações
CREATE TABLE IF NOT EXISTS `configuracoes_doacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_conta` varchar(255) DEFAULT NULL,
  `banco_nome` varchar(255) DEFAULT NULL,
  `mpesa_numero` varchar(20) DEFAULT NULL,
  `emola_numero` varchar(20) DEFAULT NULL,
  `paypal_button_code` text DEFAULT NULL,
  `instrucoes_gerais` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserir configuração padrão
INSERT INTO `configuracoes_doacoes` (`id`, `numero_conta`, `banco_nome`, `mpesa_numero`, `emola_numero`, `paypal_button_code`, `instrucoes_gerais`) 
VALUES (1, NULL, NULL, NULL, NULL, NULL, 'Obrigado por apoiar a Strong Woman!') 
ON DUPLICATE KEY UPDATE `id`=`id`;

-- Tabela de Doadores
CREATE TABLE IF NOT EXISTS `doadores` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Movimentos (Blog de Eventos Strong Woman)
CREATE TABLE IF NOT EXISTS `movimentos` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Fotos dos Movimentos (Galeria de cada movimento)
CREATE TABLE IF NOT EXISTS `movimentos_fotos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movimento_id` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `legenda` varchar(500) DEFAULT NULL,
  `ordem` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_movimento_id` (`movimento_id`),
  KEY `idx_ordem` (`ordem`),
  CONSTRAINT `fk_movimentos_fotos_movimento` FOREIGN KEY (`movimento_id`) REFERENCES `movimentos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- Fim do Script de Migração
-- =====================================================
