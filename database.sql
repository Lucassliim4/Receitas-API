Nome do banco de dados: receitas_api

Npme da tabela: receitas

  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `titulo` VARCHAR(255) NOT NULL,
  `ingredientes` TEXT NOT NULL,
  `modo_preparo` TEXT NOT NULL,
  `tempo_preparo_minutos` INT DEFAULT NULL,
  `categoria` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP()
