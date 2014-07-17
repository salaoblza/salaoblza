-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Jul 06, 2012 as 01:38 
-- Versão do Servidor: 5.5.8
-- Versão do PHP: 5.3.5



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `salaoblza`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `etapas`
--

CREATE TABLE IF NOT EXISTS "etapas" (
  "id_etapa" int(11) NOT NULL AUTO_INCREMENT,
  "id_servico" int(11) NOT NULL,
  "tipo" varchar(1) NOT NULL,
  "descricao" varchar(140) NOT NULL,
  "tempo" datetime NOT NULL,
  PRIMARY KEY ("id_etapa")
) AUTO_INCREMENT=9 ;

--
-- Extraindo dados da tabela `etapas`
--

INSERT INTO `etapas` (`id_etapa`, `id_servico`, `tipo`, `descricao`, `tempo`) VALUES
(1, 0, '1', 'fs', '0000-00-00 00:00:00'),
(3, 12, '1', 'a324', '0000-00-00 00:00:00'),
(4, 12, '2', 'a1111', '0000-00-00 00:00:00'),
(6, 13, '2', 'a22222', '0000-00-00 00:00:00'),
(8, 13, '2', 'a4444', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `servicos`
--

CREATE TABLE IF NOT EXISTS "servicos" (
  "id_servico" int(11) NOT NULL AUTO_INCREMENT,
  "nome" varchar(30) NOT NULL,
  "descricao" varchar(140) NOT NULL,
  "preco" decimal(10,2) NOT NULL,
  PRIMARY KEY ("id_servico")
) AUTO_INCREMENT=17 ;

--
-- Extraindo dados da tabela `servicos`
--

INSERT INTO `servicos` (`id_servico`, `nome`, `descricao`, `preco`) VALUES
(1, 'Corte Masculino', 'Corte de Cabelo Masculino', 10.00),
(3, 'Corte Feminino', 'Corte de Cabelo Feminino', 20.00),
(4, 'Corte Gay', 'Corte de Cabelo Gay', 120.00),
(12, 'Corte Muito Gay', 'Corte de Cabelo Gay', 120.00),
(13, 'Pintura', 'Usar tintura de cabelo', 100.00),
(14, 'Pintura 2', 'Usar tintura de cabelo', 100.00),
(15, 'Pintura 3', 'Usar tintura de cabelo', 100.00),
(16, 'Pintura 4', 'Usar tintura de cabelo amarelo', 22.00);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS "usuarios" (
  "id_usuario" int(8) NOT NULL AUTO_INCREMENT,
  "login" varchar(32) NOT NULL,
  "senha" varchar(64) NOT NULL,
  "nome" varchar(100) NOT NULL,
  "telefone" varchar(20) NOT NULL,
  "email" varchar(80) NOT NULL,
  "dt_nasc" date NOT NULL,
  "sexo" varchar(1) NOT NULL,
  "facebook" varchar(100) NOT NULL,
  "twitter" varchar(100) NOT NULL,
  PRIMARY KEY ("id_usuario"),
  UNIQUE KEY "uk_login" ("login")
) AUTO_INCREMENT=39 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `login`, `senha`, `nome`, `telefone`, `email`, `dt_nasc`, `sexo`, `facebook`, `twitter`) VALUES
(1, 'fabriciopaiva', '3232323', 'Fabricio Paiva', '8399140287', 'fabriciopaiva@gmail.com', '0000-00-00', 'M', 'fabriciopaiva', 'fabriciopaiva'),
(11, 'mamah', 'mamah', 'mamah', '888888', 'jalmaratan@gmail.com', '0000-00-00', 'M', 'teste', 'teste'),
(12, 'maaaa', 'sdsdfsd', '45', '675', '76576', '0000-00-00', 'M', '876786', '8797'),
(33, 'robinho', 'robinhorob', 'robinho', 'rob', 'rob', '0000-00-00', 'f', '', ''),
(34, 'fafafafa', 'fafafafafa', 'faafafafa', 'afafafa', '', '0000-00-00', '', '', ''),
(36, 'mamaragang', 'mamaragang', 'mamaragand', '8888222222', 'mamaragang@gmail.com', '0000-00-00', 'm', 'facebook.com/mamaragang', '@mamaragang'),
(38, 'teste2', 'teste2', 'teste2', '191991919', 'teste2@pop.com', '0000-00-00', 'm', '', '');
