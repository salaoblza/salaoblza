-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 08/12/2013 às 22h33min
-- Versão do Servidor: 5.5.16
-- Versão do PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `salaoblza`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `atendimento`
--

CREATE TABLE IF NOT EXISTS `atendimento` (
  `id_atendimento` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `cliente` varchar(30) NOT NULL,
  `entrada` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `saida` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `situacao` int(1) NOT NULL,
  PRIMARY KEY (`id_atendimento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=132 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `endereco`
--

CREATE TABLE IF NOT EXISTS `endereco` (
  `id_endereco` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `rua` varchar(140) COLLATE latin1_general_ci NOT NULL,
  `numero` smallint(5) unsigned DEFAULT NULL,
  `bairro` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `cidade` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `estado` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `cep` int(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_endereco`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `etapa`
--

CREATE TABLE IF NOT EXISTS `etapa` (
  `id_etapa` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `id_servico` int(12) unsigned NOT NULL,
  `tipo` char(1) COLLATE latin1_general_ci NOT NULL,
  `descricao` varchar(140) COLLATE latin1_general_ci NOT NULL,
  `tempo` smallint(3) unsigned NOT NULL,
  PRIMARY KEY (`id_etapa`),
  KEY `fk_servico` (`id_servico`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=9 ;

--
-- Extraindo dados da tabela `etapa`
--

INSERT INTO `etapa` (`id_etapa`, `id_servico`, `tipo`, `descricao`, `tempo`) VALUES
(1, 1, '1', 'fssds4', 10),
(3, 12, '1', 'a3244', 15),
(4, 12, '2', 'a1111', 45),
(6, 13, '2', 'a22222', 5),
(8, 13, '2', 'a4444', 30);

-- --------------------------------------------------------

--
-- Estrutura da tabela `processo_atendimento`
--

CREATE TABLE IF NOT EXISTS `processo_atendimento` (
  `id_processo_atendimento` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `cliente` varchar(30) NOT NULL,
  `entrada` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `hora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `situacao` int(1) NOT NULL,
  PRIMARY KEY (`id_processo_atendimento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `salao`
--

CREATE TABLE IF NOT EXISTS `salao` (
  `id_salao` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `imagem` blob,
  `id_endereco` int(12) unsigned NOT NULL,
  `website` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `facebook` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `twitter` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `id_usuario_dono` int(12) unsigned NOT NULL,
  PRIMARY KEY (`id_salao`),
  KEY `fk_endereco` (`id_endereco`),
  KEY `fk_usuario` (`id_usuario_dono`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `servico`
--

CREATE TABLE IF NOT EXISTS `servico` (
  `id_servico` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `descricao` varchar(140) COLLATE latin1_general_ci NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `observacao` varchar(1000) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_servico`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=17 ;

--
-- Extraindo dados da tabela `servico`
--

INSERT INTO `servico` (`id_servico`, `nome`, `descricao`, `preco`, `observacao`) VALUES
(1, 'Corte Masculino', 'Corte de Cabelo Masculino', 10.00, NULL),
(3, 'Corte Feminino', 'Corte de Cabelo Feminino', 20.00, NULL),
(4, 'Corte Gay', 'Corte de Cabelo Gay', 120.00, NULL),
(12, 'Corte Muito Gay', 'Corte de Cabelo Gay', 120.00, NULL),
(13, 'Pintura', 'Usar tintura de cabelo', 100.00, NULL),
(14, 'Pintura 2', 'Usar tintura de cabelo', 100.00, NULL),
(15, 'Pintura 3', 'Usar tintura de cabelo', 100.00, NULL),
(16, 'Pintura 4', 'Usar tintura de cabelo amarelo', 22.00, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `situacao`
--

CREATE TABLE IF NOT EXISTS `situacao` (
  `id_situacao` int(1) unsigned NOT NULL AUTO_INCREMENT,
  `situacao` varchar(20) NOT NULL,
  PRIMARY KEY (`id_situacao`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `situacao`
--

INSERT INTO `situacao` (`id_situacao`, `situacao`) VALUES
(1, 'Em espera'),
(2, 'Em atendimento'),
(3, 'Encerrado'),
(4, 'Retornado'),
(5, 'Desistência');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(32) COLLATE latin1_general_ci NOT NULL,
  `senha` varchar(64) COLLATE latin1_general_ci NOT NULL,
  `nome` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `telefone` varchar(11) COLLATE latin1_general_ci DEFAULT NULL,
  `email` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `dt_nasc` date NOT NULL,
  `sexo` varchar(1) COLLATE latin1_general_ci NOT NULL,
  `facebook` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `twitter` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `imagem` blob,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `uk_login` (`login`),
  UNIQUE KEY `uk_email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=18 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `login`, `senha`, `nome`, `telefone`, `email`, `dt_nasc`, `sexo`, `facebook`, `twitter`, `imagem`) VALUES
(10, 'fabricio', 'fabricio', 'Fabricio Paiva', '8399140287', 'fabriciopaiva@gmail.com', '2012-01-01', 'M', 'fabriciopaiva', 'fabriciopaiva', NULL),
(11, 'mamah', 'mamah', 'Jalmaratan Luis', '8396138065', 'jalmaratan@gmail.com', '1983-03-16', 'M', 'mamah', 'mamah', NULL),
(12, 'robinho', 'robinho', 'Robson Ytallo', '8399256768', 'robson.ytallo@gmail.com', '1983-12-11', 'M', 'robson', 'robson', NULL),
(14, 'pacheco', 'pacheco', 'Ronaldo', '98999', 'pacheco@gmail.com', '0001-11-11', 'm', '', '', NULL),
(16, 'root', 'root', 'root', '191991919', 'root@gmail.com', '0000-00-00', 'm', '', '', NULL),
(17, 'diego', 'diego', 'Diego JÃ´nio', '9999999', 'diego@gmail.com', '1985-11-11', 'm', 'Â ', 'Â ', NULL);

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `etapa`
--
ALTER TABLE `etapa`
  ADD CONSTRAINT `fk_servico` FOREIGN KEY (`id_servico`) REFERENCES `servico` (`id_servico`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para a tabela `salao`
--
ALTER TABLE `salao`
  ADD CONSTRAINT `fk_endereco` FOREIGN KEY (`id_endereco`) REFERENCES `endereco` (`id_endereco`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario_dono`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
