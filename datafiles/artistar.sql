-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.32-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para artistar
DROP DATABASE IF EXISTS `artistar`;
CREATE DATABASE IF NOT EXISTS `artistar` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `artistar`;

-- Copiando estrutura para tabela artistar.categoria_loja
DROP TABLE IF EXISTS `categoria_loja`;
CREATE TABLE IF NOT EXISTS `categoria_loja` (
  `categoria_id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_loja` int(11) NOT NULL DEFAULT 0,
  `categoria_nome` varchar(50) DEFAULT NULL,
  `categoria_ativa` tinyint(4) NOT NULL DEFAULT 0,
  `categoria_cor` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`categoria_id`),
  KEY `categoria_loja` (`categoria_loja`),
  CONSTRAINT `FK_CATEGORIA_LOJA` FOREIGN KEY (`categoria_loja`) REFERENCES `lojas` (`loja_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela artistar.categoria_loja: ~7 rows (aproximadamente)
DELETE FROM `categoria_loja`;
INSERT INTO `categoria_loja` (`categoria_id`, `categoria_loja`, `categoria_nome`, `categoria_ativa`, `categoria_cor`) VALUES
	(19, 30, 'Teste', 1, NULL),
	(20, 30, 'jojo', 1, NULL),
	(21, 30, 'anime', 1, NULL),
	(22, 30, 'gay', 1, NULL),
	(23, 30, 'Corporativo', 1, NULL),
	(24, 30, 'Infantil bebê', 1, NULL),
	(25, 30, 'menina', 1, NULL);

-- Copiando estrutura para tabela artistar.categoria_produtos
DROP TABLE IF EXISTS `categoria_produtos`;
CREATE TABLE IF NOT EXISTS `categoria_produtos` (
  `categoria_produto_id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_produto_produto` int(11) NOT NULL DEFAULT 0,
  `categoria_produto_categoria` int(11) NOT NULL DEFAULT 0,
  `categoria_produto_ordem` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`categoria_produto_id`),
  KEY `categoria_produto_produto` (`categoria_produto_produto`),
  KEY `categoria_produto_categoria` (`categoria_produto_categoria`),
  CONSTRAINT `FK_CATEGORIA_PRODUTO` FOREIGN KEY (`categoria_produto_produto`) REFERENCES `produtos` (`produto_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_PRODUTO_CATEGORIA` FOREIGN KEY (`categoria_produto_categoria`) REFERENCES `categoria_loja` (`categoria_id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela artistar.categoria_produtos: ~8 rows (aproximadamente)
DELETE FROM `categoria_produtos`;
INSERT INTO `categoria_produtos` (`categoria_produto_id`, `categoria_produto_produto`, `categoria_produto_categoria`, `categoria_produto_ordem`) VALUES
	(13, 33, 19, 0),
	(14, 34, 20, 0),
	(15, 34, 21, 0),
	(16, 34, 22, 0),
	(17, 35, 19, 0),
	(18, 35, 23, 0),
	(19, 36, 24, 0),
	(20, 36, 25, 0);

-- Copiando estrutura para tabela artistar.lojas
DROP TABLE IF EXISTS `lojas`;
CREATE TABLE IF NOT EXISTS `lojas` (
  `loja_id` int(11) NOT NULL AUTO_INCREMENT,
  `loja_dt_criacao` datetime NOT NULL DEFAULT current_timestamp(),
  `loja_ativa` tinyint(4) NOT NULL DEFAULT 0,
  `loja_nome` varchar(255) DEFAULT NULL,
  `loja_nome_unico` varchar(255) DEFAULT NULL,
  `loja_descricao` text DEFAULT NULL,
  `loja_foto` text DEFAULT NULL,
  `loja_proprietario` int(11) DEFAULT NULL,
  PRIMARY KEY (`loja_id`),
  KEY `FK_LOJA_PROPRIETARIO` (`loja_proprietario`),
  CONSTRAINT `FK_LOJA_PROPRIETARIO` FOREIGN KEY (`loja_proprietario`) REFERENCES `usuarios` (`usuario_id`) ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela artistar.lojas: ~1 rows (aproximadamente)
DELETE FROM `lojas`;
INSERT INTO `lojas` (`loja_id`, `loja_dt_criacao`, `loja_ativa`, `loja_nome`, `loja_nome_unico`, `loja_descricao`, `loja_foto`, `loja_proprietario`) VALUES
	(30, '2025-05-18 20:21:00', 0, 'deartcass', 'Deartcass', NULL, NULL, 1);

-- Copiando estrutura para tabela artistar.produtos
DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `produto_id` int(11) NOT NULL AUTO_INCREMENT,
  `produto_loja` int(11) NOT NULL,
  `produto_nome` varchar(50) NOT NULL,
  `produto_thumbnail` text DEFAULT NULL,
  `produto_descricao` text DEFAULT NULL,
  `produto_valor` decimal(10,2) NOT NULL DEFAULT 0.00,
  `produto_valor_desconto` decimal(10,2) DEFAULT 0.00,
  `produto_custo` decimal(10,2) DEFAULT 0.00,
  `produto_estoque` int(11) NOT NULL DEFAULT 0,
  `produto_estoque_minimo` int(11) NOT NULL DEFAULT 0,
  `produto_ultima_venda` datetime DEFAULT NULL,
  `produto_ativo` tinyint(1) NOT NULL DEFAULT 0,
  `produto_codigo_interno` varchar(50) DEFAULT NULL,
  `produto_original` int(11) DEFAULT NULL,
  `produto_palavras_chave` text DEFAULT NULL,
  PRIMARY KEY (`produto_id`) USING BTREE,
  KEY `produto_loja` (`produto_loja`),
  KEY `produto_original` (`produto_original`),
  CONSTRAINT `FK_LOJA_PRODUTO` FOREIGN KEY (`produto_loja`) REFERENCES `lojas` (`loja_id`) ON UPDATE NO ACTION,
  CONSTRAINT `FK_PRODUTO_ORIGINAL` FOREIGN KEY (`produto_original`) REFERENCES `produtos` (`produto_id`) ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela artistar.produtos: ~26 rows (aproximadamente)
DELETE FROM `produtos`;
INSERT INTO `produtos` (`produto_id`, `produto_loja`, `produto_nome`, `produto_thumbnail`, `produto_descricao`, `produto_valor`, `produto_valor_desconto`, `produto_custo`, `produto_estoque`, `produto_estoque_minimo`, `produto_ultima_venda`, `produto_ativo`, `produto_codigo_interno`, `produto_original`, `produto_palavras_chave`) VALUES
	(33, 30, 'Produto da cat', '/datafiles/uploads/products/33/thumbnail.png', '', 1000.00, 0.00, 10.00, 0, 0, NULL, 1, NULL, NULL, 'Uma palavra'),
	(34, 30, 'Produto do léo', '/datafiles/uploads/products/34/thumbnail.png', 'Uma descrição\r\n\r\ninteressante', 10.00, 0.00, 0.00, 0, 0, NULL, 1, NULL, NULL, 'jojo|jojoba|aaaa'),
	(35, 30, 'Produto do Pai', '/datafiles/uploads/products/35/thumbnail.png', 'Este form está muito profissional', 10.00, 2.00, 5.00, 6, 2, NULL, 1, NULL, NULL, 'Empresa|Casa'),
	(36, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(37, 30, 'Produto da cat', '/datafiles/uploads/products/33/thumbnail.png', '', 1000.00, 0.00, 10.00, 0, 0, NULL, 1, NULL, NULL, 'Uma palavra'),
	(38, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(39, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(40, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(41, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(42, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(43, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(44, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(45, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(46, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(47, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(48, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(49, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(50, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(51, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(52, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(53, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(54, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(55, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(56, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(57, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(58, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(59, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(60, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(61, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(62, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(63, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(64, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(65, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(66, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(67, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(68, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(69, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(70, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(71, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(72, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(73, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(74, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(75, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(76, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(77, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(78, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(79, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(80, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(81, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(82, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(83, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(84, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(85, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(86, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(87, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(88, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(89, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(90, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(91, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(92, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(93, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(94, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(95, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(96, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(97, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(98, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(99, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(100, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(101, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(102, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(103, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(104, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(105, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(106, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(107, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(108, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(109, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(110, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(111, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(112, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(113, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(114, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(115, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(116, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(117, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(118, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(119, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(120, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(121, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(122, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(123, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(124, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(125, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(126, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(127, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(128, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(129, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(130, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(131, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(132, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(133, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(134, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(135, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(136, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(137, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(138, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(139, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(140, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(141, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(142, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(143, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(144, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(145, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(146, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina'),
	(147, 30, 'Manta', '', 'Manta infantil menina bebê', 50.00, 2.00, 30.00, 10, 2, NULL, 1, NULL, NULL, 'bebê|infantil|manta|menina');

-- Copiando estrutura para tabela artistar.usuarios
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_cadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario_nome` varchar(100) NOT NULL,
  `usuario_nome_completo` varchar(50) NOT NULL DEFAULT 'CURRENT_TIMESTAMP()',
  `usuario_email` varchar(255) DEFAULT NULL,
  `usuario_senha` varchar(50) DEFAULT NULL,
  `usuario_foto` text DEFAULT NULL,
  `usuario_email_validado` tinyint(4) DEFAULT NULL,
  `usuario_codigo_validacao` varchar(10) DEFAULT NULL,
  `usuario_envio_validacao` datetime DEFAULT NULL,
  PRIMARY KEY (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela artistar.usuarios: ~0 rows (aproximadamente)
DELETE FROM `usuarios`;
INSERT INTO `usuarios` (`usuario_id`, `usuario_cadastro`, `usuario_nome`, `usuario_nome_completo`, `usuario_email`, `usuario_senha`, `usuario_foto`, `usuario_email_validado`, `usuario_codigo_validacao`, `usuario_envio_validacao`) VALUES
	(1, '2025-05-18 20:21:00', 'deartcass', 'Deartcass', 'leo.caselato@gmail.com', '1ba8fd32314216bc6e114087f0dfef95', NULL, 1, NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
