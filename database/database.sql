CREATE DATABASE IF NOT EXISTS eceitas_db DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE eceitas_db;

DROP TABLE IF EXISTS eceitas;

CREATE TABLE eceitas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  	itulo VARCHAR(255) NOT NULL,
  ingredientes TEXT NOT NULL,
  modo_preparo TEXT NOT NULL,
  	empo_preparo_minutos INT DEFAULT NULL,
  categoria VARCHAR(100) DEFAULT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO eceitas (	itulo, ingredientes, modo_preparo, 	empo_preparo_minutos, categoria) VALUES
('Bolo de Cenoura', 'Cenoura, açúcar, ovos, farinha, óleo, fermento', 'Bata tudo no liquidificador, acrescente a farinha e asse por 40 min', 45, 'Sobremesa'),
('Panqueca de Carne', 'Farinha, leite, ovos, carne moída, molho de tomate', 'Prepare as panquecas na frigideira, recheie com carne e cubra com molho', 30, 'Prato Principal');
