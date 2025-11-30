-- =====================================================
-- Tabela de Conteúdo Frontend Editável
-- =====================================================

CREATE TABLE IF NOT EXISTS `conteudo_frontend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `secao` varchar(100) NOT NULL COMMENT 'Identificador da seção (ex: hero, sobre, missao)',
  `chave` varchar(100) NOT NULL COMMENT 'Chave do conteúdo (ex: titulo, descricao, imagem)',
  `valor` text NOT NULL COMMENT 'Valor do conteúdo',
  `tipo` enum('texto','textarea','imagem','url','email','telefone') DEFAULT 'texto',
  `pagina` varchar(50) DEFAULT 'index' COMMENT 'Página onde aparece (index, quem-somos, etc)',
  `ordem` int(11) DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_secao_chave` (`secao`, `chave`, `pagina`),
  KEY `idx_pagina` (`pagina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserir conteúdos padrão
INSERT INTO `conteudo_frontend` (`secao`, `chave`, `valor`, `tipo`, `pagina`, `ordem`) VALUES
-- PÁGINA INDEX - Hero Section
('hero', 'titulo', 'Strong Woman', 'texto', 'index', 1),
('hero', 'subtitulo', 'Estamos Focados no Futuro das Mulheres', 'texto', 'index', 2),
('hero', 'descricao', 'Empoderamento, inspiração e ferramentas educativas para mulheres', 'textarea', 'index', 3),

-- PÁGINA INDEX - Sobre Section
('sobre_home', 'titulo', 'SOBRE NÓS', 'texto', 'index', 1),
('sobre_home', 'subtitulo', 'Strong Woman', 'texto', 'index', 2),
('sobre_home', 'descricao', 'Fundada por Palmira Mucavele, Strong Woman é um Projecto no ramo de desenvolvimento pessoal e profissional que visa motivar, inspirar e prover ferramentas educativas para as mulheres num contexto social de estigmatização, descriminação de gênero, exclusão social, e violência doméstica.', 'textarea', 'index', 3),

-- PÁGINA QUEM SOMOS
('quem_somos', 'titulo', 'Quem Somos', 'texto', 'quem-somos', 1),
('quem_somos', 'missao_titulo', 'Nossa Missão', 'texto', 'quem-somos', 2),
('quem_somos', 'missao_texto', 'Empoderar mulheres através da educação, capacitação e apoio emocional, criando oportunidades para o desenvolvimento pessoal e profissional.', 'textarea', 'quem-somos', 3),
('quem_somos', 'visao_titulo', 'Nossa Visão', 'texto', 'quem-somos', 4),
('quem_somos', 'visao_texto', 'Uma sociedade onde todas as mulheres tenham acesso igualitário a oportunidades, sejam livres de violência e discriminação, e possam realizar seu pleno potencial.', 'textarea', 'quem-somos', 5),
('quem_somos', 'valores_titulo', 'Nossos Valores', 'texto', 'quem-somos', 6),
('quem_somos', 'valores_texto', 'Respeito, Empoderamento, Inclusão, Educação, Solidariedade', 'textarea', 'quem-somos', 7),

-- CONTACTO
('contacto', 'titulo', 'Entre em Contacto', 'texto', 'contacto', 1),
('contacto', 'descricao', 'Estamos sempre disponíveis para ouvir você. Entre em contacto conosco!', 'textarea', 'contacto', 2),
('contacto', 'endereco', 'Maputo, Moçambique', 'texto', 'contacto', 3),
('contacto', 'telefone', '+258 84 000 0000', 'telefone', 'contacto', 4),
('contacto', 'email', 'contato@strongwoman.co.mz', 'email', 'contacto', 5),
('contacto', 'facebook', 'https://facebook.com/strongwoman', 'url', 'contacto', 6),
('contacto', 'instagram', 'https://instagram.com/strongwoman', 'url', 'contacto', 7),

-- RODAPÉ
('rodape', 'sobre_texto', 'Strong Woman é dedicada ao empoderamento feminino através da educação e desenvolvimento pessoal.', 'textarea', 'global', 1),
('rodape', 'copyright', '© 2024 Strong Woman. Todos os direitos reservados.', 'texto', 'global', 2)

ON DUPLICATE KEY UPDATE 
    `valor` = VALUES(`valor`),
    `tipo` = VALUES(`tipo`),
    `ordem` = VALUES(`ordem`);

-- =====================================================
-- Fim da Migration
-- =====================================================
