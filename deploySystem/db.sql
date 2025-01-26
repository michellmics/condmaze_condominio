-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 26/01/2025 às 00:13
-- Versão do servidor: 8.0.37
-- Versão do PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `inartcom_dbcondominio`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `CFG_CONFIGURACAO`
--

CREATE TABLE `CFG_CONFIGURACAO` (
  `CFG_DCPARAMETRO` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `CFG_DCVALOR` varchar(100) DEFAULT NULL,
  `CGF_DCDESC` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `CFG_CONFIGURACAO`
--

INSERT INTO `CFG_CONFIGURACAO` (`CFG_DCPARAMETRO`, `CFG_DCVALOR`, `CGF_DCDESC`) VALUES
('MAX_CONVIDADOS', '100', 'DEFINE O NÚMERO MÁXIMO DE CONVIDADOS QUE CADA APARTAMENTO PODE CADASTRAR NA LISTA DE PRESENÇA.'),
('EMAIL_ALERTAS', 'michell.oliveira@codemaze.com.br', 'E-MAIL ONDE SÃO ENVIADOS OS ALERTAS DO SISTEMA.'),
('NOME_CONDOMINIO', 'CONDOMÍNIO DOS MORADORES', NULL),
('QTDE_APARTAMENTOS', '344', NULL),
('QTDE_BLOCOS', '3', NULL),
('TELEFONE_SINDICO', NULL, NULL),
('TELEFONE_PORTARIA', NULL, NULL),
('ENDEREÇO', 'RUA DOS ESTUDANTES, 505 - HORTOLÂNDIA-SP', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `COC_COTACONDOMINIO`
--

CREATE TABLE `COC_COTACONDOMINIO` (
  `COC_DCMES` varchar(100) DEFAULT NULL,
  `COC_NRANO` int DEFAULT NULL,
  `COC_NRVALOR` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `CON_CONCILIACAO`
--

CREATE TABLE `CON_CONCILIACAO` (
  `CON_IDCONCILIACAO` int NOT NULL,
  `CON_DCTIPO` varchar(100) DEFAULT NULL COMMENT 'RECEITA OU DESPESA',
  `CON_DCMES_COMPETENCIA` varchar(100) DEFAULT NULL,
  `CON_DCDESC` varchar(200) DEFAULT NULL COMMENT 'DESCRICAO (CONDOMINIO, AGUA, ENERGIA, ETC...)',
  `CON_NMVALOR` float DEFAULT NULL,
  `CON_DTINSERT` datetime DEFAULT NULL,
  `CON_DCMES_COMPETENCIA_USUARIO` varchar(100) DEFAULT NULL,
  `CON_DCANO_COMPETENCIA_USUARIO` int DEFAULT NULL,
  `CON_DCANO_COMPETENCIA` int DEFAULT NULL,
  `CON_NMTITULO` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `CON_CONCILIACAO`
--

INSERT INTO `CON_CONCILIACAO` (`CON_IDCONCILIACAO`, `CON_DCTIPO`, `CON_DCMES_COMPETENCIA`, `CON_DCDESC`, `CON_NMVALOR`, `CON_DTINSERT`, `CON_DCMES_COMPETENCIA_USUARIO`, `CON_DCANO_COMPETENCIA_USUARIO`, `CON_DCANO_COMPETENCIA`, `CON_NMTITULO`) VALUES
(1, 'DESPESA', NULL, NULL, 6472.53, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'CPFL'),
(2, 'DESPESA', NULL, NULL, 1623.92, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'ALEX  SANDRO  TAVARES  DE  ALMEIDA  32757456890'),
(3, 'DESPESA', NULL, NULL, 2324.16, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'Bradesco  Auto/Re  Companhia  de  Seguros'),
(4, 'DESPESA', NULL, NULL, 1796, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'SN  Extintores'),
(5, 'DESPESA', NULL, NULL, 50.6, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'Prefeitura  Municipal  de  Hortolândia'),
(6, 'DESPESA', NULL, NULL, 500, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'Simei  Silva  Macedo'),
(7, 'DESPESA', NULL, NULL, 1071, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'Prefeitura  Municipal  de  Hortolândia'),
(8, 'DESPESA', NULL, NULL, 10240.9, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'Samekh  Services  Ltda'),
(9, 'DESPESA', NULL, NULL, 29041.9, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'Samekh  Security  Ltda'),
(10, 'DESPESA', NULL, NULL, 18, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'Prefeitura  Municipal  de  Limeira'),
(11, 'DESPESA', NULL, NULL, 32, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'Prefeitura  Municipal  de  Limeira'),
(12, 'DESPESA', NULL, NULL, 849.15, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'JM  Engenharia  Ltda'),
(13, 'DESPESA', NULL, NULL, 3440, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'Michelle  Cristina  da  Silva'),
(14, 'DESPESA', NULL, NULL, 26617.8, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'Companhia  de  Saneamento  Básico  do  Estado  de  SP'),
(15, 'DESPESA', NULL, NULL, 50.85, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'Secretaria  da  Receita  Federal  do  Brasil'),
(16, 'DESPESA', NULL, NULL, 72.54, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'Secretaria  da  Receita  Federal  do  Brasil'),
(17, 'DESPESA', NULL, NULL, 136.66, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'Secretaria  da  Receita  Federal  do  Brasil'),
(18, 'DESPESA', NULL, NULL, 1245.82, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'Secretaria  da  Receita  Federal  do  Brasil'),
(19, 'DESPESA', NULL, NULL, 1660.05, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'Secretaria  da  Receita  Federal  do  Brasil'),
(20, 'DESPESA', NULL, NULL, 3927, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'Secretaria  da  Receita  Federal  do  Brasil'),
(21, 'DESPESA', NULL, NULL, 4331.79, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'Puiatti  Administradora  de  Condomínios'),
(22, 'DESPESA', NULL, NULL, 3889.28, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'Bueno  Negrello  Sociedade  Individual  de  Advocacia'),
(23, 'DESPESA', NULL, NULL, 13483, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'Companhia  de  Saneamento  Básico  do  Estado  de  SP'),
(24, 'DESPESA', NULL, NULL, 677.4, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'Barueri  Atacadista  de  Mat  de  Construção'),
(25, 'DESPESA', NULL, NULL, 986.83, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'CPFL  Energia  S.A.'),
(26, 'DESPESA', NULL, NULL, 1035.78, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'CPFL  Energia  S.A.'),
(27, 'DESPESA', NULL, NULL, 1171.84, '2025-01-09 23:40:48', 'dezembro', 2024, NULL, 'CPFL  Energia  S.A.'),
(28, 'RECEITA', 'Nov', '23 cobranças', 6099.6, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Taxa Condominial'),
(29, 'RECEITA', 'Nov', '31 cobranças', 8221.2, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Taxa Condominial'),
(30, 'RECEITA', 'Dec', '254 cobranças', 67360.8, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Taxa Condominial'),
(31, 'RECEITA', 'Dec', '2 cobranças', 530.4, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Taxa Condominial'),
(32, 'RECEITA', 'Acordo', '1 cobrança', 11.27, '2025-01-09 23:41:03', 'dezembro', 2024, NULL, 'Multas'),
(33, 'RECEITA', 'Nov', '23 cobranças', 190.67, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Multas'),
(34, 'RECEITA', 'Nov', '1 cobrança', 9.49, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Multas'),
(35, 'RECEITA', 'Acordo', '7 cobranças', 88.64, '2025-01-09 23:41:03', 'dezembro', 2024, NULL, 'Multas'),
(36, 'RECEITA', 'Dec', '59 cobranças', 493.98, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Multas'),
(37, 'RECEITA', 'Acordo', '21 cobranças', 276.52, '2025-01-09 23:41:03', 'dezembro', 2024, NULL, 'Multas'),
(38, 'RECEITA', 'Acordo', '1 cobrança', 4.22, '2025-01-09 23:41:03', 'dezembro', 2024, NULL, 'Multas'),
(39, 'RECEITA', 'Acordo', '1 cobrança', 15.32, '2025-01-09 23:41:03', 'dezembro', 2024, NULL, 'Juros'),
(40, 'RECEITA', 'Nov', '23 cobranças', 346.84, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Juros'),
(41, 'RECEITA', 'Nov', '1 cobrança', 18.17, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Juros'),
(42, 'RECEITA', 'Acordo', '7 cobranças', 128.08, '2025-01-09 23:41:03', 'dezembro', 2024, NULL, 'Juros'),
(43, 'RECEITA', 'Dec', '59 cobranças', 259.16, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Juros'),
(44, 'RECEITA', 'Acordo', '21 cobranças', 586.26, '2025-01-09 23:41:03', 'dezembro', 2024, NULL, 'Juros'),
(45, 'RECEITA', 'Acordo', '1 cobrança', 13.24, '2025-01-09 23:41:03', 'dezembro', 2024, NULL, 'Juros'),
(46, 'RECEITA', 'Acordo', '1 cobrança', 52.58, '2025-01-09 23:41:03', 'dezembro', 2024, NULL, 'Honorários Advocaticios'),
(47, 'RECEITA', 'Acordo', '6 cobranças', 351.63, '2025-01-09 23:41:03', 'dezembro', 2024, NULL, 'Honorários Advocaticios'),
(48, 'RECEITA', 'Acordo', '1 cobrança HONORÁRIOS DE EXECUÇÃO', 26.32, '2025-01-09 23:41:03', 'dezembro', 2024, NULL, 'Honorários Advocaticios'),
(49, 'RECEITA', 'Acordo', '20 cobranças', 915.97, '2025-01-09 23:41:03', 'dezembro', 2024, NULL, 'Honorários Advocaticios'),
(50, 'RECEITA', 'Acordo', '1 cobrança HONORÁRIOS DE EXECUÇÃO', 26.32, '2025-01-09 23:41:03', 'dezembro', 2024, NULL, 'Honorários Advocaticios'),
(51, 'RECEITA', 'Acordo', '1 cobrança', 3.94, '2025-01-09 23:41:03', 'dezembro', 2024, NULL, 'Atualização Monetária'),
(52, 'RECEITA', 'Acordo', '5 cobranças', 17.56, '2025-01-09 23:41:03', 'dezembro', 2024, NULL, 'Atualização Monetária'),
(53, 'RECEITA', 'Acordo', '19 cobranças', 100.15, '2025-01-09 23:41:03', 'dezembro', 2024, NULL, 'Atualização Monetária'),
(54, 'RECEITA', 'Dec', '3 cobranças - TAG', 25.5, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Cartão de Acesso'),
(55, 'RECEITA', 'Dec', '2 cobranças - TAG AEF09C', 17, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Cartão de Acesso'),
(56, 'RECEITA', 'Dec', '1 cobrança - TAG AEF0A', 8.5, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Cartão de Acesso'),
(57, 'RECEITA', 'Dec', '1 cobrança - TAG AF5066', 8.5, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Cartão de Acesso'),
(58, 'RECEITA', 'Dec', '3 cobranças - Tag veicular', 25.5, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Cartão de Acesso'),
(59, 'RECEITA', 'Dec', '1 cobrança - Tag veicular - AEF024', 8.5, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Cartão de Acesso'),
(60, 'RECEITA', 'Dec', '1 cobrança - Tag veicular AEF068', 8.5, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Cartão de Acesso'),
(61, 'RECEITA', 'Dec', '1 cobrança - Tag veicular AEF084', 8.5, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Cartão de Acesso'),
(62, 'RECEITA', 'Dec', '1 cobrança Tag veicular', 8.5, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Cartão de Acesso'),
(63, 'RECEITA', 'Dec', 'Rendimento Aplicação F.O. 20241206004 - Rendimento aplicação', 0.03, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Rendimento Aplicação F.O.'),
(64, 'RECEITA', 'Dec', 'Rendimento Aplicação F.O. 20241213004 - Rend. Pago Aplic Aut Mais', 0.31, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Rendimento Aplicação F.O.'),
(65, 'RECEITA', 'Dec', 'Rendimento Aplicação F.O. 20241219005 - Rendimento aplicação', 0.6, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Rendimento Aplicação F.O.'),
(66, 'RECEITA', 'Nov', '23 cobranças', 609.96, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'F. Inadimplencia'),
(67, 'RECEITA', 'Nov', '31 cobranças', 822.12, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'F. Inadimplencia'),
(68, 'RECEITA', 'Dec', '254 cobranças', 6736.08, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'F. Inadimplencia'),
(69, 'RECEITA', 'Dec', '2 cobranças', 53.04, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'F. Inadimplencia'),
(70, 'RECEITA', 'Nov', '23 cobranças - Rateio Fatura R$ 24.451,11', 1634.61, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Consumo de água'),
(71, 'RECEITA', 'Nov', '31 cobranças - Rateio Fatura R$ 24.451,11', 2203.17, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Consumo de água'),
(72, 'RECEITA', 'Dec', '254 cobranças - Rateio Fatura R$ 24.596,01', 18161, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Consumo de água'),
(73, 'RECEITA', 'Dec', '2 cobranças - Rateio Fatura R$ 24.596,01', 143, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Consumo de água'),
(74, 'RECEITA', 'Nov', '23 cobranças - Negociação Débitos - Parc. 2/12', 880.44, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Parcelamento SABESP'),
(75, 'RECEITA', 'Nov', '31 cobranças - Negociação Débitos - Parc. 2/12', 1186.68, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Parcelamento SABESP'),
(76, 'RECEITA', 'Dec', '254 cobranças - Negociação Débitos - Parc. 3/12', 9723.12, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Parcelamento SABESP'),
(77, 'RECEITA', 'Dec', '2 cobranças - Negociação Débitos - Parc. 3/12', 76.56, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Parcelamento SABESP'),
(78, 'RECEITA', 'Nov', '1 cobrança (11/10/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Salao de Festa'),
(79, 'RECEITA', 'Nov', '1 cobrança (11/10/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Receitas de Eventos'),
(80, 'RECEITA', 'Dec', '1 cobrança (08/11/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Salao de Festa'),
(81, 'RECEITA', 'Dec', '1 cobrança (08/11/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Receitas de Eventos'),
(82, 'RECEITA', 'Dec', '1 cobrança (10/11/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Salao de Festa'),
(83, 'RECEITA', 'Dec', '1 cobrança (10/11/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Receitas de Eventos'),
(84, 'RECEITA', 'Dec', '1 cobrança (14/11/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Salao de Festa'),
(85, 'RECEITA', 'Dec', '1 cobrança (14/11/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Receitas de Eventos'),
(86, 'RECEITA', 'Dec', '1 cobrança (15/11/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Salao de Festa'),
(87, 'RECEITA', 'Dec', '1 cobrança (15/11/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Receitas de Eventos'),
(88, 'RECEITA', 'Dec', '1 cobrança (16/11/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Salao de Festa'),
(89, 'RECEITA', 'Dec', '1 cobrança (16/11/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Receitas de Eventos'),
(90, 'RECEITA', 'Dec', '1 cobrança (17/11/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Salao de Festa'),
(91, 'RECEITA', 'Dec', '1 cobrança (17/11/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Receitas de Eventos'),
(92, 'RECEITA', 'Dec', '1 cobrança (19/11/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Salao de Festa'),
(93, 'RECEITA', 'Dec', '1 cobrança (19/11/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Receitas de Eventos'),
(94, 'RECEITA', 'Dec', '1 cobrança (24/11/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Salao de Festa'),
(95, 'RECEITA', 'Dec', '1 cobrança (24/11/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Receitas de Eventos'),
(96, 'RECEITA', 'Dec', '1 cobrança (25/11/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Salao de Festa'),
(97, 'RECEITA', 'Dec', '1 cobrança (25/11/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Receitas de Eventos'),
(98, 'RECEITA', 'Dec', '1 cobrança (29/11/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Salao de Festa'),
(99, 'RECEITA', 'Dec', '1 cobrança (29/11/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Receitas de Eventos'),
(100, 'RECEITA', 'Dec', '1 cobrança (30/11/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Salao de Festa'),
(101, 'RECEITA', 'Dec', '1 cobrança (30/11/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:03', 'dezembro', 2024, 2024, 'Receitas de Eventos'),
(102, 'RECEITA', 'Acordo', '1 cobrança', 243.96, '2025-01-09 23:41:03', 'dezembro', 2024, NULL, 'Salao de Festa'),
(103, 'RECEITA', 'Acordo', '7 cobranças', 2832.85, '2025-01-09 23:41:03', 'dezembro', 2024, NULL, 'Salao de Festa'),
(104, 'RECEITA', 'Acordo', '21 cobranças', 12106.3, '2025-01-09 23:41:03', 'dezembro', 2024, NULL, 'Salao de Festa'),
(105, 'RECEITA', 'Acordo', '1 cobrança', 231.27, '2025-01-09 23:41:03', 'dezembro', 2024, NULL, 'Salao de Festa'),
(106, 'RECEITA', 'Oct', '14 cobranças', 3712.8, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Taxa Condominial'),
(107, 'RECEITA', 'Oct', '26 cobranças', 6895.2, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Taxa Condominial'),
(108, 'RECEITA', 'Nov', '247 cobranças', 65504.4, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Taxa Condominial'),
(109, 'RECEITA', 'Nov', '2 cobranças', 530.4, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Taxa Condominial'),
(110, 'RECEITA', 'Oct', '14 cobranças', 118.65, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Multas'),
(111, 'RECEITA', 'Acordo', '2 cobranças', 23.7, '2025-01-09 23:41:41', 'novembro', 2024, NULL, 'Multas'),
(112, 'RECEITA', 'Nov', '34 cobranças', 284.26, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Multas'),
(113, 'RECEITA', 'Acordo', '17 cobranças', 119.88, '2025-01-09 23:41:41', 'novembro', 2024, NULL, 'Multas'),
(114, 'RECEITA', 'Oct', '14 cobranças', 232.41, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Juros'),
(115, 'RECEITA', 'Acordo', '2 cobranças', 36.43, '2025-01-09 23:41:41', 'novembro', 2024, NULL, 'Juros'),
(116, 'RECEITA', 'Nov', '34 cobranças', 158.96, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Juros'),
(117, 'RECEITA', 'Acordo', '17 cobranças', 505.18, '2025-01-09 23:41:41', 'novembro', 2024, NULL, 'Juros'),
(118, 'RECEITA', 'Acordo', '1 cobrança', 23.64, '2025-01-09 23:41:41', 'novembro', 2024, NULL, 'Honorários Advocaticios'),
(119, 'RECEITA', 'Acordo', '1 cobrança HONORÁRIOS DE EXECUÇÃO', 36.31, '2025-01-09 23:41:41', 'novembro', 2024, NULL, 'Honorários Advocaticios'),
(120, 'RECEITA', 'Acordo', '15 cobranças', 716.85, '2025-01-09 23:41:41', 'novembro', 2024, NULL, 'Honorários Advocaticios'),
(121, 'RECEITA', 'Acordo', '1 cobrança', 3.86, '2025-01-09 23:41:41', 'novembro', 2024, NULL, 'Atualização Monetária'),
(122, 'RECEITA', 'Acordo', '14 cobranças', 29.78, '2025-01-09 23:41:41', 'novembro', 2024, NULL, 'Atualização Monetária'),
(123, 'RECEITA', 'Oct', '1 cobrança ref Cobr. 1153502 08/2024', 11.07, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Pagamento a menor'),
(124, 'RECEITA', 'Oct', '1 cobrança ref Cobr. 1153507 08/2024', 4.92, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Pagamento a menor'),
(125, 'RECEITA', 'Oct', '1 cobrança ref Cobr. 1153539 08/2024', 8.2, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Pagamento a menor'),
(126, 'RECEITA', 'Oct', '1 cobrança ref Cobr. 1153595 08/2024', 9.84, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Pagamento a menor'),
(127, 'RECEITA', 'Oct', '1 cobrança ref Cobr. 1153650 08/2024', 8.2, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Pagamento a menor'),
(128, 'RECEITA', 'Oct', '1 cobrança ref Cobr. 1153704 08/2024', 6.56, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Pagamento a menor'),
(129, 'RECEITA', 'Oct', '1 cobrança ref Cobr. 1153730 08/2024', 10.32, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Pagamento a menor'),
(130, 'RECEITA', 'Oct', '1 cobrança ref Cobr. 1153769 08/2024', 8.2, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Pagamento a menor'),
(131, 'RECEITA', 'Oct', '1 cobrança ref Cobr. 1153788 08/2024', 7.38, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Pagamento a menor'),
(132, 'RECEITA', 'Oct', '1 cobrança ref Cobr. 1153799 08/2024', 10.25, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Pagamento a menor'),
(133, 'RECEITA', 'Oct', '2 cobranças', 17, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Cartão de Acesso'),
(134, 'RECEITA', 'Oct', '1 cobrança', 8.5, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Cartão de Acesso'),
(135, 'RECEITA', 'Nov', '1 cobrança - 02 Tags', 17, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Cartão de Acesso'),
(136, 'RECEITA', 'Nov', '5 cobranças - TAG', 42.5, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Cartão de Acesso'),
(137, 'RECEITA', 'Nov', '1 cobrança -02 TAGS', 17, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Cartão de Acesso'),
(138, 'RECEITA', 'Nov', 'Outras Receitas - A identificar', 2711.09, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Outras Receitas'),
(139, 'RECEITA', 'Nov', '1 cobrança - Reembolso de multa por infração', -115.91, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Outras Receitas'),
(140, 'RECEITA', 'Nov', 'Reembolsos - Flash Benefícios', 813, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Outras Receitas'),
(141, 'RECEITA', 'Acordo', '1 cobrança CUSTAS PROCESSUAIS', 30.92, '2025-01-09 23:41:41', 'novembro', 2024, NULL, 'Outras Receitas'),
(142, 'RECEITA', 'Acordo', '1 cobrança custas', 26.5, '2025-01-09 23:41:41', 'novembro', 2024, NULL, 'Outras Receitas'),
(143, 'RECEITA', 'Nov', 'Rendimento Aplicação F.O. 20241118011 - Rend. Pago Aplic Aut Mais', 0.99, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Rendimento Aplicação F.O.'),
(144, 'RECEITA', 'Nov', 'Rendimento Aplicação F.O. 20241121007 - Rend. Pago Aplic Aut Mais', 0.2, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Rendimento Aplicação F.O.'),
(145, 'RECEITA', 'Oct', '14 cobranças', 371.28, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'F. Inadimplencia'),
(146, 'RECEITA', 'Oct', '26 cobranças', 689.52, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'F. Inadimplencia'),
(147, 'RECEITA', 'Nov', '247 cobranças', 6550.44, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'F. Inadimplencia'),
(148, 'RECEITA', 'Nov', '2 cobranças', 53.04, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'F. Inadimplencia'),
(149, 'RECEITA', 'Oct', '14 cobranças - Rateio Fatura R$ 23.885,80', 972.16, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Consumo de água'),
(150, 'RECEITA', 'Oct', '26 cobranças - Rateio Fatura R$ 23.885,80', 1805.44, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Consumo de água'),
(151, 'RECEITA', 'Nov', '247 cobranças - Rateio Fatura R$ 24.451,11', 17554.3, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Consumo de água'),
(152, 'RECEITA', 'Nov', '2 cobranças - Rateio Fatura R$ 24.451,11', 142.14, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Consumo de água'),
(153, 'RECEITA', 'Oct', '14 cobranças - Negociação Débitos - Parc. 1/12', 535.92, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Parcelamento SABESP'),
(154, 'RECEITA', 'Oct', '26 cobranças - Negociação Débitos - Parc. 1/12', 995.28, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Parcelamento SABESP'),
(155, 'RECEITA', 'Nov', '247 cobranças - Negociação Débitos - Parc. 2/12', 9455.16, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Parcelamento SABESP'),
(156, 'RECEITA', 'Nov', '2 cobranças - Negociação Débitos - Parc. 2/12', 76.56, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Parcelamento SABESP'),
(157, 'RECEITA', 'Oct', '1 cobrança (22/09/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Salao de Festa'),
(158, 'RECEITA', 'Oct', '1 cobrança (22/09/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Receitas de Eventos'),
(159, 'RECEITA', 'Oct', '1 cobrança (29/08/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Salao de Festa'),
(160, 'RECEITA', 'Oct', '1 cobrança (29/08/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Receitas de Eventos'),
(161, 'RECEITA', 'Nov', '1 cobrança (04/10/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Salao de Festa'),
(162, 'RECEITA', 'Nov', '1 cobrança (04/10/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Receitas de Eventos'),
(163, 'RECEITA', 'Nov', '1 cobrança (05/10/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Salao de Festa'),
(164, 'RECEITA', 'Nov', '1 cobrança (05/10/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Receitas de Eventos'),
(165, 'RECEITA', 'Nov', '1 cobrança (07/10/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Salao de Festa'),
(166, 'RECEITA', 'Nov', '1 cobrança (07/10/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Receitas de Eventos'),
(167, 'RECEITA', 'Nov', '1 cobrança (13/10/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Salao de Festa'),
(168, 'RECEITA', 'Nov', '1 cobrança (13/10/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Receitas de Eventos'),
(169, 'RECEITA', 'Nov', '1 cobrança (19/10/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Salao de Festa'),
(170, 'RECEITA', 'Nov', '1 cobrança (19/10/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Receitas de Eventos'),
(171, 'RECEITA', 'Nov', '1 cobrança (20/10/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Salao de Festa'),
(172, 'RECEITA', 'Nov', '1 cobrança (20/10/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Receitas de Eventos'),
(173, 'RECEITA', 'Nov', '1 cobrança (27/10/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Salao de Festa'),
(174, 'RECEITA', 'Nov', '1 cobrança (27/10/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:41', 'novembro', 2024, 2024, 'Receitas de Eventos'),
(175, 'RECEITA', 'Acordo', '2 cobranças', 521.84, '2025-01-09 23:41:41', 'novembro', 2024, NULL, 'Salao de Festa'),
(176, 'RECEITA', 'Acordo', '17 cobranças', 4881.47, '2025-01-09 23:41:41', 'novembro', 2024, NULL, 'Salao de Festa'),
(177, 'RECEITA', 'Sep', '9 cobranças', 2086.47, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Taxa Condominial'),
(178, 'RECEITA', 'Sep', '31 cobranças', 7186.73, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Taxa Condominial'),
(179, 'RECEITA', 'Oct', '260 cobranças', 68952, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Taxa Condominial'),
(180, 'RECEITA', 'Oct', '1 cobrança', 265.2, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Taxa Condominial'),
(181, 'RECEITA', 'Sep', '9 cobranças', 67.44, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Multas'),
(182, 'RECEITA', 'Acordo', '2 cobranças', 27.95, '2025-01-09 23:41:53', 'outubro', 2024, NULL, 'Multas'),
(183, 'RECEITA', 'Sep', '2 cobranças', 2.4, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Multas'),
(184, 'RECEITA', 'Oct', '35 cobranças', 293.56, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Multas'),
(185, 'RECEITA', 'Acordo', '23 cobranças', 158.47, '2025-01-09 23:41:53', 'outubro', 2024, NULL, 'Multas'),
(186, 'RECEITA', 'Acordo', '1 cobrança', 2.47, '2025-01-09 23:41:53', 'outubro', 2024, NULL, 'Multas'),
(187, 'RECEITA', 'Sep', '9 cobranças', 124.71, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Juros'),
(188, 'RECEITA', 'Acordo', '2 cobranças', 92.62, '2025-01-09 23:41:53', 'outubro', 2024, NULL, 'Juros'),
(189, 'RECEITA', 'Sep', '2 cobranças', 4.05, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Juros'),
(190, 'RECEITA', 'Oct', '35 cobranças', 191.33, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Juros'),
(191, 'RECEITA', 'Acordo', '23 cobranças', 821.28, '2025-01-09 23:41:53', 'outubro', 2024, NULL, 'Juros'),
(192, 'RECEITA', 'Acordo', '1 cobrança', 8.79, '2025-01-09 23:41:53', 'outubro', 2024, NULL, 'Juros'),
(193, 'RECEITA', 'Acordo', '2 cobranças', 109.53, '2025-01-09 23:41:53', 'outubro', 2024, NULL, 'Honorários Advocaticios'),
(194, 'RECEITA', 'Acordo', '20 cobranças', 1138.92, '2025-01-09 23:41:53', 'outubro', 2024, NULL, 'Honorários Advocaticios'),
(195, 'RECEITA', 'Acordo', '2 cobranças HONORÁRIOS DE EXECUÇÃO', 58.31, '2025-01-09 23:41:53', 'outubro', 2024, NULL, 'Honorários Advocaticios'),
(196, 'RECEITA', 'Acordo', '1 cobrança', 26.94, '2025-01-09 23:41:53', 'outubro', 2024, NULL, 'Honorários Advocaticios'),
(197, 'RECEITA', 'Acordo', '2 cobranças', 8.01, '2025-01-09 23:41:53', 'outubro', 2024, NULL, 'Atualização Monetária'),
(198, 'RECEITA', 'Acordo', '16 cobranças', 45.91, '2025-01-09 23:41:53', 'outubro', 2024, NULL, 'Atualização Monetária'),
(199, 'RECEITA', 'Acordo', '1 cobrança', 0.23, '2025-01-09 23:41:53', 'outubro', 2024, NULL, 'Atualização Monetária'),
(200, 'RECEITA', 'Oct', '1 cobrança ref Cobr. 1153550 08/2024', 4.92, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Pagamento a menor'),
(201, 'RECEITA', 'Oct', '1 cobrança ref Cobr. 1153577 08/2024', 10.25, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Pagamento a menor'),
(202, 'RECEITA', 'Oct', '1 cobrança ref Cobr. 1153589 08/2024', 5.33, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Pagamento a menor'),
(203, 'RECEITA', 'Oct', '1 cobrança ref Cobr. 1153605 08/2024', 7.79, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Pagamento a menor'),
(204, 'RECEITA', 'Oct', '1 cobrança ref Cobr. 1153665 08/2024', 7.79, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Pagamento a menor'),
(205, 'RECEITA', 'Oct', '1 cobrança ref Cobr. 1153671 08/2024', 11.07, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Pagamento a menor'),
(206, 'RECEITA', 'Oct', '1 cobrança ref Cobr. 1153707 08/2024', 9.84, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Pagamento a menor'),
(207, 'RECEITA', 'Oct', '1 cobrança ref Cobr. 1153713 08/2024', 9.43, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Pagamento a menor'),
(208, 'RECEITA', 'Oct', '1 cobrança ref Cobr. 1153731 08/2024', 4.92, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Pagamento a menor'),
(209, 'RECEITA', 'Oct', '7 cobranças', 67, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Cartão de Acesso'),
(210, 'RECEITA', 'Oct', '1 cobrança - Tag', 8.5, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Cartão de Acesso'),
(211, 'RECEITA', 'Oct', '1 cobrança 2ª TAG', 8.5, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Cartão de Acesso'),
(212, 'RECEITA', 'Oct', '1 cobrança 2° TAG - 8A5080', 8.5, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Cartão de Acesso'),
(213, 'RECEITA', 'Oct', '3 cobranças Tag veicular', 25.5, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Cartão de Acesso'),
(214, 'RECEITA', 'Oct', '1 cobrança Tag veicular 8A2CAC', 8.5, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Cartão de Acesso'),
(215, 'RECEITA', 'Oct', 'Outras Receitas - A Identificar', 2926.88, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Outras Receitas'),
(216, 'RECEITA', 'Oct', 'Outras Receitas - A Identificar', 611, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Outras Receitas'),
(217, 'RECEITA', 'Oct', 'Rendimento Aplicação F.O. 20241002010 - Rend. Pago Aplic Aut Mais', 0.37, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Rendimento Aplicação F.O.'),
(218, 'RECEITA', 'Oct', 'Rendimento Aplicação F.O. 20241014012 - Rendimento aplicação', 0.25, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Rendimento Aplicação F.O.'),
(219, 'RECEITA', 'Oct', 'Rendimento Aplicação F.O. 20241015002 - Rendimento aplicação', 0.09, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Rendimento Aplicação F.O.'),
(220, 'RECEITA', 'Oct', 'Rendimento Aplicação F.O. 20241016002 - Rend. Pago Aplic Aut Mais', 0.33, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Rendimento Aplicação F.O.'),
(221, 'RECEITA', 'Oct', 'Rendimento Aplicação F.O. 20241017002 - Rend. Pago Aplic Aut Mais', 0.1, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Rendimento Aplicação F.O.'),
(222, 'RECEITA', 'Oct', 'Rendimento Aplicação F.O. 20241018002 - Rend. Pago Aplic Aut Mais', 0.01, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Rendimento Aplicação F.O.'),
(223, 'RECEITA', 'Oct', 'Rendimento Aplicação F.O. 20241021006 - Rendimento aplicação', 0.08, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Rendimento Aplicação F.O.'),
(224, 'RECEITA', 'Oct', 'Rendimento Aplicação F.O. 20241024009 - Rend. Pago Aplic Aut Mais', 0.42, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Rendimento Aplicação F.O.'),
(225, 'RECEITA', 'Oct', 'Rendimento Aplicação F.O. 20241029006 - Rend. Pago Aplic Aut Mais', 0.36, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Rendimento Aplicação F.O.'),
(226, 'RECEITA', 'Oct', 'Rendimento Aplicação F.O. 20241030002 - Rend. Pago Aplic Aut Mais', 0.01, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Rendimento Aplicação F.O.'),
(227, 'RECEITA', 'Oct', '260 cobranças', 6895.2, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'F. Inadimplencia'),
(228, 'RECEITA', 'Oct', '1 cobrança', 26.52, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'F. Inadimplencia'),
(229, 'RECEITA', 'Oct', '260 cobranças - Rateio Fatura R$ 23.885,80', 18054.4, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Consumo de água'),
(230, 'RECEITA', 'Oct', '1 cobrança - Rateio Fatura R$ 23.885,80', 69.44, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Consumo de água'),
(231, 'RECEITA', 'Oct', '260 cobranças - Negociação Débitos - Parc. 1/12', 9952.8, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Parcelamento SABESP'),
(232, 'RECEITA', 'Oct', '1 cobrança - Negociação Débitos - Parc. 1/12', 38.28, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Parcelamento SABESP'),
(233, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(234, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(235, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(236, 'RECEITA', 'Oct', 'Receitas de Eventos', 30, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(237, 'RECEITA', 'Oct', 'Receitas de Eventos', 50, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(238, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(239, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(240, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(241, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(242, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(243, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(244, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(245, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(246, 'RECEITA', 'Oct', 'Receitas de Eventos', 20, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(247, 'RECEITA', 'Oct', 'Receitas de Eventos', 30, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(248, 'RECEITA', 'Oct', 'Receitas de Eventos', 30, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(249, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(250, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(251, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(252, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(253, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(254, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(255, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(256, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(257, 'RECEITA', 'Oct', 'Receitas de Eventos', 30, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(258, 'RECEITA', 'Oct', 'Receitas de Eventos', 45, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(259, 'RECEITA', 'Oct', 'Receitas de Eventos', 30, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(260, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(261, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(262, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(263, 'RECEITA', 'Oct', 'Receitas de Eventos', 165, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(264, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(265, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(266, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(267, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(268, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(269, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(270, 'RECEITA', 'Oct', 'Receitas de Eventos', 45, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(271, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(272, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(273, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(274, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(275, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(276, 'RECEITA', 'Oct', 'Receitas de Eventos', 30, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(277, 'RECEITA', 'Oct', 'Receitas de Eventos', 30, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(278, 'RECEITA', 'Oct', 'Receitas de Eventos', 15, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(279, 'RECEITA', 'Oct', 'Receitas de Eventos', 30, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(280, 'RECEITA', 'Oct', 'Receitas de Eventos', 30, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(281, 'RECEITA', 'Sep', '1 cobrança (03/08/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(282, 'RECEITA', 'Sep', '1 cobrança (03/08/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Receitas de Eventos'),
(283, 'RECEITA', 'Sep', '1 cobrança (18/08/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(284, 'RECEITA', 'Sep', '1 cobrança (18/08/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Receitas de Eventos'),
(285, 'RECEITA', 'Oct', '1 cobrança (01/09/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(286, 'RECEITA', 'Oct', '1 cobrança (01/09/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Receitas de Eventos'),
(287, 'RECEITA', 'Oct', '1 cobrança (13/09/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(288, 'RECEITA', 'Oct', '1 cobrança (13/09/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Receitas de Eventos'),
(289, 'RECEITA', 'Oct', '1 cobrança (14/09/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(290, 'RECEITA', 'Oct', '1 cobrança (14/09/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Receitas de Eventos'),
(291, 'RECEITA', 'Oct', '1 cobrança (21/09/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(292, 'RECEITA', 'Oct', '1 cobrança (21/09/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Receitas de Eventos'),
(293, 'RECEITA', 'Oct', '1 cobrança (23/08/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(294, 'RECEITA', 'Oct', '1 cobrança (23/08/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Receitas de Eventos'),
(295, 'RECEITA', 'Oct', '1 cobrança (25/08/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(296, 'RECEITA', 'Oct', '1 cobrança (25/08/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Receitas de Eventos'),
(297, 'RECEITA', 'Oct', '1 cobrança (27/09/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(298, 'RECEITA', 'Oct', '1 cobrança (27/09/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Receitas de Eventos'),
(299, 'RECEITA', 'Oct', '1 cobrança (28/09/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(300, 'RECEITA', 'Oct', '1 cobrança (28/09/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Receitas de Eventos'),
(301, 'RECEITA', 'Oct', '1 cobrança (31/08/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Salao de Festa'),
(302, 'RECEITA', 'Oct', '1 cobrança (31/08/2024-Salão de Festas e Churrasqueir)', 60, '2025-01-09 23:41:53', 'outubro', 2024, 2024, 'Receitas de Eventos'),
(303, 'RECEITA', 'Acordo', '2 cobranças', 585.87, '2025-01-09 23:41:53', 'outubro', 2024, NULL, 'Salao de Festa'),
(304, 'RECEITA', 'Acordo', '24 cobranças', 12449.5, '2025-01-09 23:41:53', 'outubro', 2024, NULL, 'Salao de Festa'),
(305, 'RECEITA', 'Acordo', '1 cobrança', 196.81, '2025-01-09 23:41:53', 'outubro', 2024, NULL, 'Salao de Festa');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ENC_ENCOMENDA`
--

CREATE TABLE `ENC_ENCOMENDA` (
  `ENC_IDENCOMENDA` varchar(10) NOT NULL,
  `ENC_STENCOMENDA` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'DISPONIVEL OU INDISPONIVEL',
  `USU_IDUSUARIO` int DEFAULT NULL,
  `ENC_DTENTREGA_PORTARIA` timestamp NULL DEFAULT NULL,
  `ENC_DTENTREGA_MORADOR` timestamp NULL DEFAULT NULL,
  `ENC_DCOBSERVACAO` varchar(200) DEFAULT NULL,
  `ENC_STENTREGA_MORADOR` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `ENC_ENCOMENDA`
--

INSERT INTO `ENC_ENCOMENDA` (`ENC_IDENCOMENDA`, `ENC_STENCOMENDA`, `USU_IDUSUARIO`, `ENC_DTENTREGA_PORTARIA`, `ENC_DTENTREGA_MORADOR`, `ENC_DCOBSERVACAO`, `ENC_STENTREGA_MORADOR`) VALUES
('BUEKL', 'DISPONIVEL', 352, '2025-01-24 12:21:52', '2025-01-24 12:22:41', 'SSDFDSFSD', 'ENTREGUE'),
('HFQU4', 'DISPONIVEL', 352, '2025-01-24 12:39:19', '2025-01-24 12:43:12', 'SADASDA', 'ENTREGUE'),
('Z618B', 'DISPONIVEL', 352, '2025-01-24 13:00:29', '2025-01-24 13:01:15', 'ASDADASD', 'ENTREGUE');

-- --------------------------------------------------------

--
-- Estrutura para tabela `eventos`
--

CREATE TABLE `eventos` (
  `id` int NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `inicio` datetime NOT NULL,
  `fim` datetime NOT NULL,
  `descricao` text,
  `categoria` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `eventos`
--

INSERT INTO `eventos` (`id`, `titulo`, `inicio`, `fim`, `descricao`, `categoria`) VALUES
(8, 'teste', '2025-01-16 13:30:00', '2025-01-16 15:30:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `FUR_FUNDO_RESERVA`
--

CREATE TABLE `FUR_FUNDO_RESERVA` (
  `FUR_IDFUNDO_RESERVA` int NOT NULL,
  `FUR_DCANO` int DEFAULT NULL,
  `FUR_DCMES` varchar(100) DEFAULT NULL,
  `FUR_DCVALUE` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `FUR_FUNDO_RESERVA`
--

INSERT INTO `FUR_FUNDO_RESERVA` (`FUR_IDFUNDO_RESERVA`, `FUR_DCANO`, `FUR_DCMES`, `FUR_DCVALUE`) VALUES
(1, 2024, 'outubro', 0),
(2, 2024, 'novembro', 0),
(3, 2024, 'dezembro', 17757.7),
(4, 2025, 'janeiro', 17757.7),
(5, 2025, 'fevereiro', NULL),
(6, 2025, 'março', NULL),
(7, 2025, 'abril', NULL),
(8, 2025, 'maio', NULL),
(9, 2025, 'junho', NULL),
(10, 2025, 'julho', NULL),
(11, 2025, 'agosto', NULL),
(12, 2025, 'setembro', NULL),
(13, 2025, 'outubro', NULL),
(14, 2025, 'novembro', NULL),
(15, 2025, 'dezembro', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `LIS_LISTACONVIDADOS`
--

CREATE TABLE `LIS_LISTACONVIDADOS` (
  `LIS_IDLISTACONVIDADOS` int NOT NULL,
  `USU_IDUSUARIO` int DEFAULT NULL,
  `LIS_DCNOME` varchar(100) DEFAULT NULL,
  `LIS_DCDOCUMENTO` varchar(100) DEFAULT NULL,
  `LIS_DTCADASTRO` datetime DEFAULT NULL,
  `LIS_STSTATUS` varchar(100) DEFAULT NULL,
  `LIS_DTULTIMA_ENTRADA` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `LIS_LISTACONVIDADOS`
--

INSERT INTO `LIS_LISTACONVIDADOS` (`LIS_IDLISTACONVIDADOS`, `USU_IDUSUARIO`, `LIS_DCNOME`, `LIS_DCDOCUMENTO`, `LIS_DTCADASTRO`, `LIS_STSTATUS`, `LIS_DTULTIMA_ENTRADA`) VALUES
(52, 352, 'RENNAN HENRIQUE DE MELO', '539005411', '2024-12-23 13:02:35', 'ATIVO', NULL),
(53, 352, 'KELVIANE KUASNE', '237661718', '2024-12-23 13:03:09', 'ATIVO', '2025-01-03 00:46:43'),
(54, 352, 'MARLENE KUASNE', '202314947', '2024-12-23 13:03:45', 'ATIVO', NULL),
(55, 352, 'JULIANO LUIZ ANDERMANN', '323096736', '2024-12-23 13:04:43', 'ATIVO', '2025-01-03 00:46:40'),
(56, 352, 'ALINE KUASNE', '484939221', '2024-12-23 13:05:18', 'INATIVO', '2025-01-03 00:46:33'),
(57, 352, 'ADEMAR DA COSTA', '234232520', '2024-12-23 13:17:12', 'INATIVO', NULL),
(58, 352, 'SANDRA RODRIGUES', '27651587898', '2024-12-23 13:17:56', 'ATIVO', NULL),
(59, 352, 'YASMIN GABRIELE', '05874134093', '2024-12-23 13:18:34', 'ATIVO', NULL),
(60, 352, 'RAYANE LORENA', '469601334', '2024-12-23 13:19:10', 'ATIVO', '2025-01-03 00:46:47'),
(67, 352, 'EDILENE CLAUDIA MAYRA', '8869608', '2025-01-02 18:47:33', 'ATIVO', '2025-01-03 20:35:24'),
(68, 352, 'LUIS CARLOS COUTO FELICIO', '21547288809', '2025-01-02 18:53:05', 'ATIVO', '2025-01-03 00:55:05'),
(69, 352, 'MARCELO ROGERIO NASCIMENTO', '413123298', '2025-01-02 18:53:57', 'ATIVO', '2025-01-04 23:52:19'),
(70, 352, 'EDUARDO OLIVEIRA DE MATTOS', '43066767X', '2025-01-02 18:54:37', 'INATIVO', '2025-01-04 23:52:06'),
(87, 352, 'ttttesreeeeedsfdsf', '345435', '2025-01-23 00:36:59', 'ATIVO', NULL),
(88, 352, 'TESTE', '82872822', '2025-01-24 11:07:26', 'INATIVO', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `LOG_LOGSISTEMA`
--

CREATE TABLE `LOG_LOGSISTEMA` (
  `LOG_IDLOG` int NOT NULL,
  `LOG_DCTIPO` varchar(100) DEFAULT NULL,
  `LOG_DCMSG` varchar(200) DEFAULT NULL,
  `LOG_DCUSUARIO` varchar(200) DEFAULT NULL,
  `LOG_DCAPARTAMENTO` varchar(200) DEFAULT NULL,
  `LOG_DTLOG` timestamp NULL DEFAULT NULL,
  `LOG_DCCODIGO` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `LOG_LOGSISTEMA`
--

INSERT INTO `LOG_LOGSISTEMA` (`LOG_IDLOG`, `LOG_DCTIPO`, `LOG_DCMSG`, `LOG_DCUSUARIO`, `LOG_DCAPARTAMENTO`, `LOG_DTLOG`, `LOG_DCCODIGO`) VALUES
(6, 'ENCOMENDA', 'Encomenda registrada no sistema para o apartamento 194 com código Z618B.', 'PORTARIA', '194', '2025-01-24 13:00:29', 'Z618B'),
(7, 'ENCOMENDA', 'Encomenda com id Z618B foi alterada seu status para DISPONIVEL', 'PORTARIA', ' ', '2025-01-24 13:00:45', 'Z618B'),
(8, 'ENCOMENDA', 'Encomenda com id Z618B foi alterada seu status para A RETIRAR', 'MORADOR', ' ', '2025-01-24 13:00:59', 'Z618B'),
(9, 'ENCOMENDA', 'Encomenda com id Z618B foi alterada seu status para ENTREGUE', 'PORTARIA', ' ', '2025-01-24 13:01:15', 'Z618B'),
(10, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', '352', '194', '2025-01-24 13:10:35', 'N/A'),
(11, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 13:16:00', 'N/A'),
(12, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 13:20:02', 'N/A'),
(13, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 13:21:14', 'N/A'),
(14, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 13:44:36', 'N/A'),
(15, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 14:06:50', 'N/A'),
(16, 'CADASTRO DE VISITANTE', 'O visitante TESTE foi cadastrado com sucesso.', '352', '194', '2025-01-24 14:07:26', 'N/A'),
(17, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 14:26:56', 'N/A'),
(18, 'LOGIN FAILED', 'Usuario ou senha incorretos', 'N/A', NULL, '2025-01-24 14:55:07', 'N/A'),
(19, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 15:02:20', 'N/A'),
(20, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 15:05:39', 'N/A'),
(21, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 15:06:38', 'N/A'),
(22, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 15:08:03', 'N/A'),
(23, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 15:08:48', 'N/A'),
(24, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 15:08:59', 'N/A'),
(25, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 15:17:37', 'N/A'),
(26, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 16:26:56', 'N/A'),
(27, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 16:27:14', 'N/A'),
(28, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 16:46:23', 'N/A'),
(29, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 16:46:53', 'N/A'),
(30, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 16:47:11', 'N/A'),
(31, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 16:49:28', 'N/A'),
(32, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 16:55:16', 'N/A'),
(33, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 17:01:52', 'N/A'),
(34, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 17:17:10', 'N/A'),
(35, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 17:17:37', 'N/A'),
(36, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 17:19:08', 'N/A'),
(37, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 17:20:58', 'N/A'),
(38, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 17:22:26', 'N/A'),
(39, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 17:26:06', 'N/A'),
(40, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 17:26:37', 'N/A'),
(41, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 17:29:26', 'N/A'),
(42, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 17:35:40', 'N/A'),
(43, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 17:37:42', 'N/A'),
(44, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 17:38:22', 'N/A'),
(45, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 17:38:34', 'N/A'),
(46, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 17:38:54', 'N/A'),
(47, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 17:39:44', 'N/A'),
(48, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 17:39:53', 'N/A'),
(49, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 17:41:48', 'N/A'),
(50, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 17:42:46', 'N/A'),
(51, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-24 22:43:28', 'N/A'),
(52, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-25 01:26:54', 'N/A'),
(53, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-25 14:37:39', 'N/A'),
(54, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-26 01:28:58', 'N/A'),
(55, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-26 02:10:04', 'N/A'),
(56, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-26 02:11:17', 'N/A'),
(57, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-26 02:13:08', 'N/A'),
(58, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-26 02:26:20', 'N/A'),
(59, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-26 02:36:33', 'N/A'),
(60, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-26 02:37:49', 'N/A'),
(61, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-26 02:38:10', 'N/A'),
(62, 'LOGIN', 'Usuário MICHELL DUARTE DE OLIVEIRA logado com sucesso.', 'MICHELL DUARTE DE OLIVEIRA', '194', '2025-01-26 02:38:52', 'N/A');

-- --------------------------------------------------------

--
-- Estrutura para tabela `PUB_PUBLICIDADE`
--

CREATE TABLE `PUB_PUBLICIDADE` (
  `PUB_IDPUBLICIDADE` int NOT NULL,
  `PUB_DTINI` datetime DEFAULT NULL,
  `PUB_DTFIM` datetime DEFAULT NULL,
  `PUB_DCIMG` varchar(250) DEFAULT NULL,
  `PUB_DCCLIENTEORIG` varchar(100) DEFAULT NULL,
  `PUB_STSTATUS` varchar(100) DEFAULT NULL,
  `PUB_DCDESC` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `MKT_IDMKTPUBLICIDADE` int DEFAULT NULL,
  `PUB_DCTIPO` varchar(100) DEFAULT NULL,
  `PUB_DCLINK` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `PUB_PUBLICIDADE`
--

INSERT INTO `PUB_PUBLICIDADE` (`PUB_IDPUBLICIDADE`, `PUB_DTINI`, `PUB_DTFIM`, `PUB_DCIMG`, `PUB_DCCLIENTEORIG`, `PUB_STSTATUS`, `PUB_DCDESC`, `MKT_IDMKTPUBLICIDADE`, `PUB_DCTIPO`, `PUB_DCLINK`) VALUES
(13, '2024-05-22 00:00:00', '2026-01-12 23:59:59', 'uploads/CODEMAZE/1737341229416_1737339651429_pop_campanha.png', 'CODEMAZE ', 'ATIVA', '<p>TESTE</p>', 35, 'IMAGEM', 'WWW.TESTE.COM.BR');

-- --------------------------------------------------------

--
-- Estrutura para tabela `REC_RECLAMACAO`
--

CREATE TABLE `REC_RECLAMACAO` (
  `REC_IDRECLAMACAO` int NOT NULL,
  `REC_DTDATA` timestamp NULL DEFAULT NULL,
  `REC_DCMSG` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `REC_RECLAMACAO`
--

INSERT INTO `REC_RECLAMACAO` (`REC_IDRECLAMACAO`, `REC_DTDATA`, `REC_DCMSG`) VALUES
(32, '2025-01-24 09:38:02', 'Tste teste teste'),
(33, '2025-01-24 11:51:47', 'sdffsdfsd');

-- --------------------------------------------------------

--
-- Estrutura para tabela `REP_REPORT`
--

CREATE TABLE `REP_REPORT` (
  `REP_IDREPORT` int NOT NULL,
  `REP_DCTIPO` varchar(100) DEFAULT NULL,
  `REP_DCDESC` varchar(100) DEFAULT NULL,
  `REP_DTDATE` date DEFAULT NULL,
  `REP_NMPRECO` float DEFAULT NULL,
  `REP_NMTITLE` varchar(100) DEFAULT NULL,
  `REP_NMVALOR` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `USU_USUARIO`
--

CREATE TABLE `USU_USUARIO` (
  `USU_IDUSUARIO` int NOT NULL,
  `USU_DCNOME` varchar(200) DEFAULT NULL,
  `USU_DCAPARTAMENTO` int DEFAULT NULL,
  `USU_DCBLOCO` int DEFAULT NULL,
  `USU_DCNIVEL` varchar(100) DEFAULT NULL,
  `USU_DTCADASTRO` datetime DEFAULT NULL,
  `USU_DCSENHA` varchar(100) DEFAULT NULL,
  `USU_DCEMAIL` varchar(100) DEFAULT NULL,
  `USU_DCREDEF_TOKEN` varchar(200) DEFAULT NULL,
  `USU_DTREDEF_TOKEN_EXP` timestamp NULL DEFAULT NULL,
  `USU_DCTOKEN` varchar(300) DEFAULT NULL,
  `USU_DTEXP_TOKEN` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `USU_USUARIO`
--

INSERT INTO `USU_USUARIO` (`USU_IDUSUARIO`, `USU_DCNOME`, `USU_DCAPARTAMENTO`, `USU_DCBLOCO`, `USU_DCNIVEL`, `USU_DTCADASTRO`, `USU_DCSENHA`, `USU_DCEMAIL`, `USU_DCREDEF_TOKEN`, `USU_DTREDEF_TOKEN_EXP`, `USU_DCTOKEN`, `USU_DTEXP_TOKEN`) VALUES
(17, 'PORTARIA', 1000, 0, 'PORTARIA', '2024-12-19 08:54:36', '$2y$10$FsgQA/nEbnHQ/UC2lmw/o.nNC4NrSsXUq09P7HCwEsTGcWfJccxtq', 'PORTARIA@PRQDASHORTENSIAS.COM.BR', NULL, NULL, NULL, NULL),
(23, 'MATHEUS AUGUSTO DE OLIVEIRA', 101, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$e0UdMSBbiuwbU2YQE0XaJuYJ7Q7FzZDocd6uCKBHDB.QSHky.I0yG', 'MA.1062001@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(24, 'ALINE BEATRIZ CELESTRINO', 102, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$RW/jIfm9mYJ53jHa1GTGNOAlr7hQ2xSeU7IMM1qv5Ipt86Mh0btuy', 'ALINE-BEATRIZ.CELESTRINO@OUTLOOK.COM', NULL, NULL, NULL, NULL),
(25, 'OZIEL DOS SANTOS SOUZA', 103, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$f8VQVIWxMlGR5ZKKsXziT.wyoj/pxcqurYN4DGx4sz6WMse.hsGEu', 'OZIELCODS@GMAIL.COM', NULL, NULL, NULL, NULL),
(26, 'JOYCE COSTA DA SILVA', 104, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$Hn8t.Qem.wpyYfELEgBBj.jxhN5m6Gpu4rFcOB0xJj1irE.w9BuAm', 'GABRIELKENEDYROSA@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(27, 'FELIPE NOGUEIRA LOPES', 105, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$Va6/Cr3zGCuKMIvZe0wQR.orsKWjYFHeCGRQPn1j516GVoeUlb7li', 'FELIPE_NOGUEIRA_LOPES@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(28, 'ANA ERIKA INACIO VIEIRA', 106, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$HJ13o9panLOYQhXivTz/jOzQjhEy3cst1WQvF15EwErKdwYlqgThO', 'ANAERIKAIVIEIRA@GMAIL.COM', NULL, NULL, NULL, NULL),
(29, 'DAVID ANDERSON RIBEIRO', 107, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$ewLADyl4/HXvonRAU5fB/usH7ZesbLyypm.wjlOZQ0MGVADoKVx56', 'RIBEIRODAVID.DR87@GMAIL.COM', NULL, NULL, NULL, NULL),
(30, 'LETICIA CRISTINA  DOS SANTOS', 108, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$FDlnvq50FEi4guda0jgTTuWLgycKGj29Sad1UxFZF2xJCXlK/CO/G', 'LETICIALFINITI@GMAIL.COM', NULL, NULL, NULL, NULL),
(31, 'CINTHIA LOPES RIBEIRO', 111, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$Pm5b6eVyFoyxUvqHd0JFIuqPH/CLv7sQT2wwdZIv2rpFR1GmNNN6S', 'CICINHOP2010@GMAIL.COM', NULL, NULL, NULL, NULL),
(32, 'CAMILA LEAL SOARES', 112, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$rdzpeZRzI4ON84uxhJDfZejCdJTxymZ.v9ADLaAMsZQyPj2bidAwq', 'MILAFRANCIOSI@YAHOO.COM.BR', NULL, NULL, NULL, NULL),
(33, 'KARINA ROBERTA NOGUEIRA', 113, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$1xhL3Rz204E837mQYr4bB.OIYiamsOwMq4KqaSP82KlaxJN6ast8i', 'KARINA.NOGUEIRA18@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(34, 'EVERTON HONORATO MOREIRA', 114, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$PLYvNKNdqREh1SvVIKRq0uT1PhVvP0vBwSwY1g8Mxt4Rjciu/CB2G', 'SANTOSIVAI2018@GMAIL.COM', NULL, NULL, NULL, NULL),
(35, 'ROSELAINE PORCINA DE SOUZA', 115, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$lhWfO9mJ3n7GIBi5NTF5den5RiRGM0syYVZbYxLaoArZGN0umr2MC', 'ROSELAINEPORCINA91@GMAIL.COM', NULL, NULL, NULL, NULL),
(36, 'ALEX DE LUCENA PERLUIZE', 116, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$PLzmIcKnnYdSyI5kHcSBneGGb9g6IB9oTVJJWwaRGyu2kZVLaCh92', 'ALP.ALEXMIL@GMAIL.COM', NULL, NULL, NULL, NULL),
(37, 'DANILO RIBEIRO MONTEIRO', 117, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$pi4weUA8fVOWrKMA76yhwe5xs37yHFcWa/NVEr/MX0wj4OWk0WZVe', '', NULL, NULL, NULL, NULL),
(38, 'KAUAN AUGUSTO DE MELO SOARES', 118, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$t5DOgfvwZv52KwWF6PhXTuJ6vNZ1LpHUvO5AFNe6aRi2A7atokwka', 'KAUUAN.SOARES@GMAIL.COM', NULL, NULL, NULL, NULL),
(39, 'RENATA APARECIDA BARON', 121, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$KW44.fHFNe1NQ0biMQ.Ee.1zzuPj42XnxCauUyjWOCd5dOw3q8TNm', 'RENATA.B.BADARO@GMAIL.COM', NULL, NULL, NULL, NULL),
(40, 'EMILLY MEI RECHI VELO', 122, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$wnZ1WHTNhYhQGY6N/1xA2ubg8Fz2IWG1rnyVuzT1ZcZ24xWor2Cy2', 'EMILLY.VELO08@ICLOUD.COM', NULL, NULL, NULL, NULL),
(41, 'FRANCIELE PEREIRA DE ANDRADE BATISTA', 123, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$AagwEwgbTsAaFpeFvDyZseZ.04Jhg/BFVyO6hp2DhQ41CripiLy/m', 'JSBTRICOLOR@GMAIL.COM', NULL, NULL, NULL, NULL),
(42, 'CRISTOFER CAMILO NERY', 124, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$/Nex1b5zQyWtOqlLazY1Q.DyO/l0R8Mfw3mbLXNjftJNFmqWNDRz.', 'CRISTOFER_NERY@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(43, 'LEANDRO OLIVEIRA DE BARROS', 125, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$zDK95RlKQeV0ShEE8d0O8uomK3o1jPEP33lVrSCAs0wMWxCQEpFOG', 'LUCIANABETA@GMAIL.COM', NULL, NULL, NULL, NULL),
(44, 'MAIARA CAROLINI BRIOCHI', 126, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$wBgghtQaSjAYDCKZ8pIxAeVrdS7NOWndT4PN6qoN1ZHw3nJ6SWmh2', 'MBRIOCHI@GMAIL.COM', NULL, NULL, NULL, NULL),
(45, 'CLAUDIA TEIXEIRA MACEDO', 127, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$CyNX2zpQHUGKH1v1wzcb0.MdxQCc/5Nx7OrTq.nYuqo2v7xrCoc.y', 'CLAUDIATMACEDO@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(46, 'HUEBER DE LIMA GARCIA', 128, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$siFEpta7rl7Q.EH3/MpH3eOYVNoINQhfkQtcz9M8ah130tfCF2Mom', 'HUEBER.TECNOLOGIA@GMAIL.COM', NULL, NULL, NULL, NULL),
(47, 'MARIA JOSE SANTOS PEREIRA', 131, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$RAaVaX.uuwZheZoVvvCTseLThTvLXa9iuAgMyByAsX7rgHYMotb6C', 'LYASANTOS1104@GMAIL.COM', NULL, NULL, NULL, NULL),
(48, 'MARIA ESTELA DA SILVA', 132, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$rhniVmziBi8DTnERYXa3lO/hJk0SI8QLjVDNx1qc/sEZmGdTFeTgm', 'MARIAESTELA1924@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(49, 'RENAN CASCARANO DE SOUZA', 134, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$nfR.9zwzQkEYJ6xo9ufpsecOJLxHVV377/ZbXrUbqISWO7Bzr6ayS', 'CANALDORENAN@GMAIL.COM', NULL, NULL, NULL, NULL),
(50, 'DOUGLAS KEVIN SILVA PEREIRA', 135, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$AXZTqXAwQQ7kBhM878KZXOCDHsuGrspJBZfjdy0A.FOcqOC0J8GN.', 'DOUGLASKEVIN22@OUTLOOK.COM.BR', NULL, NULL, NULL, NULL),
(51, 'ELAINE OLIVEIRA DE MATTOS', 136, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$/ngbmRxR9bdWAPXcqmCnUOKCyAph3qLRK5OzOGdqbsRRRojLhmEi2', 'EMATTOS.CELLCOM@HOTMAIL.COM', '3c3e5f13ec257eded8a7e29d36d3af91', '2025-01-02 16:30:30', NULL, NULL),
(52, 'DAVID DE JESUS CAMILLO ALMEIDA', 137, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$fq7pjAlQFzN9lA1/QVoHFe5.4.wcpxz6amXC6WbnXOiO5W7MPoC2a', 'CAMILADINIZG@GMAIL.COM', NULL, NULL, NULL, NULL),
(53, 'JULIANA AZARIAS LAGE', 138, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$G0InZW7tGBZV5LzzFVp3IeqwUvQGv4gLMsgSweGBBrTW9D8gXAe/a', 'JULIANAAZARIASLAGE@GMAIL.COM', NULL, NULL, NULL, NULL),
(54, 'JEFFERSON OLIVEIRA NOBRE', 141, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$lCddPmdYaxwOnpqZEzCeCOXQo62bP0m0mzTdyVAnIjhl2XJCZ5Tke', 'JEFFNOBRE189@GMAIL.COM', NULL, NULL, NULL, NULL),
(55, 'MANOEL FRANCISCO ALFINITI', 142, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$f1fnwJ13syMsIY7CNBaM8OFZ2se5szNdjQ7zEOt/zHeEsAURLiWbu', 'MANOELALFINITI0@GMAIL.COM', NULL, NULL, NULL, NULL),
(56, 'JESSICA MENEZES DE SOUSA', 144, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$Le5w98OAN96mkjr0J0/tU.VTvTfQFDx2vDXccZT1pgaWo6EPVgr5C', 'MNZSJEEE@GMAIL.COM', NULL, NULL, NULL, NULL),
(57, 'MARILIA PEREIRA SANTOS', 145, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$i.QIts5s5n.L.VmwOaIA.OIZJpWtTBPvrDl2DnYkgGT63UPnSLVzG', 'MARILIAPSANTOS@OUTLOOK.COM.BR', NULL, NULL, NULL, NULL),
(58, 'DAVI ALVES BARROS', 146, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$0jHeipcrOv9/teYmQcti3.VsFo6O5QMshS3pfIe5Xs/GRISwnwXv.', 'DAVIDTAUA@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(59, 'LUCAS FERNANDO BARBOSA', 147, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$wdhLZPp/5YcX3aXNJNLFXe5j1uTx2uCO6OcKNyJKf3xiTx58zJs4O', 'LUKAS@BSD.COM.BR', NULL, NULL, NULL, NULL),
(60, 'TAYNARA CRISTINA FERREIRA', 148, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$2jLtbGkR3yKCJmaaQzlxu.CsY1ntLC.t166tBBb6.kouQqsJkxq9q', 'TAYNARIINHAA2010@GMAIL.COM', NULL, NULL, NULL, NULL),
(61, 'LARISSA IRMAO DE OLIVEIRA', 151, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$iQfuHw0Vsq39UgN9dX0qGeWEyMuMT91zCQq.BEdd2Xq1fxv2yRUKK', 'LARI.IRMAOOLIVEIRA@GMAIL.COM', NULL, NULL, NULL, NULL),
(62, 'SILENE APARECIDA PINTO DE LIMA', 152, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$bbcrx2GU00dJD7jUTqy6YeKEGQ5VapY4JgnPaEsDzQsSMXs44KwlO', 'SILENELIMA999@GMAIL.COM', NULL, NULL, NULL, NULL),
(63, 'VITOR GABRIEL RIBEIRO PINTO', 153, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$5HN8Jb.AVNPbxLNrsLFPwuAB21EOfzleWMiB39IUrDjqFBGwXejEi', 'LARISSA.SANGI2805@GMAIL.COM', NULL, NULL, NULL, NULL),
(64, 'SERGIO BENTO DOS  SANTOS', 154, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$z3kltYEZfcDhjvARBYr99ua65kIwWhHZOOES/dMrqS.wWAclJesLa', 'PIRAMIDEGRAFICAEXPRESS@GMAIL.COM', NULL, NULL, NULL, NULL),
(65, 'KAICK SOUZA MARTINS DOS SANTOS', 155, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$U9rTt7BlpM9sTLBYVUHoW.ajRIHeisRgLVtWVGwc3uBVeKSr20okG', 'KAICK.MARTINS8@GMAIL.COM', NULL, NULL, NULL, NULL),
(66, 'ADRIANO LEMOS', 156, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$kelPx4dCkoW7fhtZLUwssueHlbdS5eSUxMF5iM8lpwlc4cw1Vt12q', 'ADRIIANOLEEMOS@GMAIL.COM', NULL, NULL, NULL, NULL),
(67, 'STEPHERSON GUSTAVO DE MORAES MINARI', 157, 1, 'SINDICO', '2024-12-18 00:49:28', '$2y$10$JaqCQq2eLs3Sr0p21vcou.Bje8U.gnySh4ZBsZW5LtMN2iM/hM4ha', 'WANESSA.ARAUJO036@GMAIL.COM', NULL, NULL, NULL, NULL),
(68, 'REGIANE DAMASIO DE MORAIS', 158, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$10fInNdeoamylm2.7Dvf/OFQYRl/UaDazRQEnR5G40XQijKaveGYq', 'REGIANEDAMASIOM@GMAIL.COM', NULL, NULL, NULL, NULL),
(69, 'FERNANDA DE OLIVEIRA MEDEIROS', 161, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$ES3VjQlhzp4ucZibgnqZ2Ob9e5z2YRzgKQ3BTjrydjaO5fqv9KiiW', 'NANDA.MEDEIROS777@LIVE.COM', NULL, NULL, NULL, NULL),
(70, 'JAMES JOSE DA SILVA', 162, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$/OBXrBlGd8x0OFHKLMXqIeOfnA20wfIUKb2ut2l2gdyY7DXXN5LCW', 'JAMESSILVA1516@GMAIL.COM', NULL, NULL, NULL, NULL),
(71, 'CAMILA DE CAMPOS', 163, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$kDCPLx0qzYmFSmAHRImP/e9brTchm9jOF9pYpJ7UxYxtxYDky2Nb.', 'CAMILA.DECAMPOS@GMAIL.COM', NULL, NULL, NULL, NULL),
(72, 'AGUINALDO RAMOS SOUTO', 164, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$UZyRdOE6TsBkoq.LS4et1.UQsUyIKXvHMEW8.u/u6f9V4nIGmm.5u', 'AGUINALDO.RAMOS20@GMAIL.COM', NULL, NULL, NULL, NULL),
(73, 'GABRIEL CARA RAPOSO', 166, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$8hbYugcPCWQR0VZNYXxD2euhsHYrRCFLomf54bSfIzc0whQwCp7ny', 'GABRIELCARARAPOSO@YAHOO.COM.BR', NULL, NULL, NULL, NULL),
(74, 'WAGNER RAMOS DE SOUZA', 167, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$8jBy86qfuHC9/M9DAxMrQOhX4Tx4FTtk7/Iw9fMoHvd0U6raVZC2y', 'WAGNERRAMOSDESOUZA1414@GMAIL.COM', NULL, NULL, NULL, NULL),
(75, 'THIAGO RODRIGUES DA CUNHA', 168, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$RwgssrVPzFNiM6jpllMI.e0l8JLxo6QBzQ3O0qaRmzc4mBHMDJjP.', 'TI.CUNHA@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(76, 'LUIS CLAUDIO DOS SANTOS JUNIOR', 171, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$HpwXXGEct6VFcLDIi1ZRB.5sKDlNf9TnMAENmr1uLUcnbTpOPYU2S', 'LUISCLAUDIOJR95@GMAIL.COM', NULL, NULL, NULL, NULL),
(77, 'SAMIA SANTANA HAMMAD NASCIMENTO', 172, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$BgYbA4dXrvlwUpwR849pw.Kt0TFPmSnkT0IHAyBSH0yEXXEpZFPny', 'SAMIA_HAMMAD01@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(78, 'LUIS FELIPE GONÇALVES MACHADO', 173, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$bkju3YvKIOSP7Tyq4ZiOxOBMmCyRz4TmGHdkMk9E7aRzLZ2QQy2u6', 'FELIPE.MACHADO2020@OUTLOOK.COM', NULL, NULL, NULL, NULL),
(79, 'LEONARDO CESTARI MENDES', 174, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$VKqgiwjUnm7j3xnGdRLg1OaMRP2IBqF6LCMbgQYP7ZPPQEEg5dDKm', 'LEONARDOCESTARIMENDES@GMAIL.COM', NULL, NULL, NULL, NULL),
(80, 'CRISTIANE DE JESUS ROCHA', 175, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$.6kuYVSw55CQqUDMxcIlYOPAJNNY2OPnHSAVGu3EPD6IiJzvHzCsq', 'RCRISTIANE27@GMAIL.COM', NULL, NULL, NULL, NULL),
(81, 'ANA CLAUDIA SILVA GONÇALVES ', 176, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$qgj2HvhQBU02u8T2pMPVH.jG2ZMiVvjjBUDS54DxfGDnFFpwABIpu', 'SILVA.CLAUDIA.AG@GMAIL.COM', NULL, NULL, NULL, NULL),
(82, 'MARTAN BERCE MEDEIROS DA COSTA', 177, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$llRFx5LJgfK7I9urIT6b1e2FLygj8qM0LAgobyc7xzX5XngaKd2vm', 'MARTAN.MEDEIROS@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(83, 'ELAINE CRISTINA SILVA RANDI', 178, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$O3CcuvmjvF.99SrllXQwHeWrX4JAB52/DryCIr.Mua8agpU4nmSuu', 'ECRISTINASP@GMAIL.COM', NULL, NULL, NULL, NULL),
(84, 'MARINA COLLIN PEDROSO', 181, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$vVY6N.aBl8OYskuT6ipO5OMeBzFPmfWMXxkQbZjgb8Sruo7431dnW', 'MARINACOLLIN12@GMAIL.COM', NULL, NULL, NULL, NULL),
(85, 'ROBERTA DUARTE DE SOUZA', 182, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$k1BLr7IET4bXtshNLsX.u.QKyK8fvMftqseg8NRn914/emE3djPeC', 'RODUARTEDESOUZA@GMAIL.COM', NULL, NULL, NULL, NULL),
(87, 'ISABEL REGINA MORELI', 184, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$hABIyTzhRoEC8pEGP/NwLOZUutTUJ7Tf64mPSYEAaeDxXFoJcW.2q', 'PRISCILA.ESCAMES@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(88, 'ZENILDA VIEIRA BATISTA', 185, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$l.NKIt5MlvWzMfcXHyJpsus.nzqUs8WRrR9yGr7.dhmmKIuQ3qcoa', 'RENATO_TECMOLD@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(89, 'LEONARDO ANTUNES SACHETI', 186, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$CuXy6x4npUzF.g5uOrIyyOeqKIzviL21bAxma950PGzR9P0S6MP7O', 'LEOSACHETI@GMAIL.COM', NULL, NULL, NULL, NULL),
(90, 'JORGE LUIS DA SILVA', 188, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$Rt0/.cXOSB9GzuKy5rPFbugoA15ngFIeYaOW6y0vC9ZDtx1IHCdNu', 'JORGE.SKETSILVA@OUTLOOK.COM', NULL, NULL, NULL, NULL),
(91, 'GABRIEL BATISTA DE SOUZA', 192, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$h4gYnq6rIP.fvjDr26KeYOVKIVkHhtpYwPklNaVmU5WdFvi.uYezy', 'GABRIELBSOUZ8@GMAIL.COM', NULL, NULL, NULL, NULL),
(92, 'MILENA DA FONTE LASELVA', 193, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$mlKu2m6KIFmj6uTwrMaCEOq3heuT9ZtVDG/PkGFWnyY39sE5P4aS6', 'MILENA.LASELVA@GMAIL.COM', NULL, NULL, NULL, NULL),
(94, 'JESSICA ELIZABETH VOLPE GANASSIN', 195, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$FMw49DCCQDq14DNq2PZWau1I66FB5UioUH0BQl15Yxeq1Bu9zf39G', 'JSSI2003@YAHOO.COM.BR', NULL, NULL, NULL, NULL),
(95, 'VIVIANE FERNANDES NUNES', 196, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$Slwcnr7N6HfNPc0n9QdtL.EMxtUEcOc1ApO.m54oz1cIbztoauLAq', 'VIVIANE_FNUNES@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(96, 'TANIA MOREIRA REGIS', 197, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$Ld6BMpIZU0qvaEN5yExg4uUoPEiVFHxbcC59Z2ml8dplg0F6J7IH2', 'TANIAMREGIS@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(97, 'IZA CHRISTIE DE MELO UEHARA', 198, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$ZGDu0Jl1H2qpM4/8tTsTAOwrk5Ow94yyKt1tLADD/DETjKXmStu8i', 'IZACHRISTIE20@GMAIL.COM', NULL, NULL, NULL, NULL),
(98, 'FERNANDO MARTINS DE MELLO', 201, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$eXYoMY5ZVNCID2iWS4TvQOy.CPT9hhQ4xwSRKoPX.Ob9Jk/EluSl.', 'FERNANDO.DEMELLO@IRCO.COM', NULL, NULL, NULL, NULL),
(99, 'PABLO HENRIQUE GOMES DE OLIVEIRA', 202, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$7E6S3APpPOXUnl0bsLdMoeQysUlfLzHn5d.upwX8TbhkWQwH/IMWy', 'CARRADORI.OLIVEIRA@GMAIL.COM', NULL, NULL, NULL, NULL),
(100, 'CLAUDINEI DE OLIVEIRA ISAIAS', 203, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$rrxURZrT.8D08nvrJNaLWuX1tL.UGBbq1NmLvVQiJ0rulEj8KgmMa', 'CLAUDINEIISAIAS1@GMAIL.COM', NULL, NULL, NULL, NULL),
(101, 'MICHAEL PEREIRA DA SILVA DOS SANTOS', 204, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$9vS0jbG5zKaWs2lRd//ITeB3EaV2Q6D225SEhshzOK/uQSLj.R8y6', 'MIKEPSS@ICLOUD.COM', NULL, NULL, NULL, NULL),
(102, 'RENAN RODRIGUES PAQUEROTI', 205, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$9h/.Dr/IcyaLZH/9sSOfveJMmIVulbfsyPpRRTOZRPHXXYOvg6JtK', 'RENANPAQUEROTI@GMAIL.COM', NULL, NULL, NULL, NULL),
(103, 'NATALIA VERONI DA SILVA', 206, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$cxRE8oJ1KMrVKdzPaVCA3OCIgCqQH0NiU25jdG3WmFlcbVgWdYEB2', 'NATALIA.VERONIS@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(104, 'ROSEMEIRE APARECIDA SILVA', 207, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$hWsiSGwOr9f4mCJlV7gpcOvFDLs8NJ8lA2ADit3Hr1fXNnRJ0MQJW', '74ROSE.APSILVA@GMAIL.COM', NULL, NULL, NULL, NULL),
(105, 'BEATRIZ VIEIRA VARINI', 208, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$kIzaf/9AesLPzOjDc1pzcu2nPI6S.bQ9IIR71Z0x/xO1fx97GsvHm', 'BVARINI@GMAIL.COM', NULL, NULL, NULL, NULL),
(106, 'ANA LUIZA CELER OLIVEIRA DIAS', 211, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$ZE6GtHPhluigwLTJ/hMuH.ClBeyfB.yb5ruFhr4whDvrb3A3wKByK', 'ANA.LUIZA.22K@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(107, 'TAYNA PORTELLA', 212, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$HMz5brPp7AQHw6yhOFL8/.RaRWuox14CahUze7Ezw09/bfYqyr8pK', 'PORTELLATAYNA@GMAIL.COM', NULL, NULL, NULL, NULL),
(108, 'ROBERSON APARECIDO PEREIRA', 213, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$lMqfJRYPoQ8kwUrYV/gZ0.RwZ.LEThaaFeZBQcJqpHQqfORfml9.W', 'ROBERSON.PEREIRA1425@OUTLOOK.COM', NULL, NULL, NULL, NULL),
(109, 'ANA CAROLINA DA SILVA MOITINHO', 214, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$KA9Bad3XBU9kCz2uZeHVseiWDNsz3bk2m7L83lh58aAHPv9ElMgFy', 'ANACAROLINAMOITINHO@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(110, 'PAULO HENRIQUE DE MOURA PEREIRA', 215, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$Wrk.JbwQAkr6kRguUJ/tAuq6AZeuxyu2sfQSmnJIn2nbHP2jo3ILi', 'MOURA.PHM@GMAIL.COM', NULL, NULL, NULL, NULL),
(111, 'INGRID NAIRA SANTOS DE QUEIROZ', 216, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$BDkU/zS02qdjXymMC8pwH..iVIob7BI2uBZcDTr3EugxxXTlvh5dW', 'WELLINGTONSR97@OUTLOOK.COM', NULL, NULL, NULL, NULL),
(112, 'LEONARDO CAVALCANTE DE OLIVERA', 217, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$uKUZk3amdIl9/cq.mZfXEugtp2vFx.2ePs1MY1aLRdUx8KuDeJK.6', 'LEOCAVALCANTE25@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(113, 'VILMA GONÇALVES CAMARGO', 218, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$IxvDFI05kwNblPxPzyV4Q..QPMuoaGNwbrwhbBVqItcTP8U75flKe', 'VILMACAMARGOO28@GMAIL.COM', NULL, NULL, NULL, NULL),
(114, 'MIGUEL LORENZON', 221, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$GHKISJrFC2afr9lNy5RB.uGx8tIAFfxPxkd0ICFqxBKSLIPlRcKIO', 'DANYZORGETTO@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(115, 'RODRIGO CARNEIRO SALVADORI', 222, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$SvYnvjWtXzvE7LuH8/NrqOB.Sz4BP2hpCGo1CLJUwPRx96NPfYNea', 'R.SALVADORIC@GMAIL.COM', NULL, NULL, NULL, NULL),
(116, 'LUCIANO RODRIGUES GOMES', 223, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$hNAXc1LBEfvzD429bhzCq.PiiFE6GnKk23PeMWOldJiZB4jxbwTiq', 'LUCIANO.RGOMES@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(117, 'MICHAEL JUNIO DE SOUZA FERREIRA', 225, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$038hc36K/vcAcUgUS9X8yudpzgXvZpYG5cLNQLsmNHpML8jhdDHke', 'MICHAELJUNIO@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(118, 'JULIANA CRISTINA RODRIGUES DE SOUZA', 226, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$5yQ5hp5upxAEDrtSUdVOIejy2xH8qiBp6Bwbkazg8/fEZLABY3L/2', 'JUSOUZAH@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(119, 'THIAGO PINHEIRO DASCENZE', 227, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$cdPGbA4WKM01Qk9ZTA0RLeK/9Mb9JdM8OQqJ9.cIaISRyIBHmHIRa', 'DASCENZEDIREITO@GMAIL.COM', NULL, NULL, NULL, NULL),
(120, 'GUSTHAVO HENRIQUE VILELA MAGALHAES', 228, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$BmXA7ACZ6dHF9EDI3IoeoO8SiLBVnEn61Fcw7DKUzNS1.4zjRNSmq', 'GUGAGUSTHAVO@GMAIL.COM', NULL, NULL, NULL, NULL),
(121, 'CAMILA BATISTA DE ARAUJO', 231, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$UizMKy7TJPFXkfNnWEKTZ.Ut3TQ51ExMbR6QvlHhFJ6j.no92n2c6', 'CAPAUSINI@GMAIL.COM', NULL, NULL, NULL, NULL),
(122, 'GUSTAVO PORTO PADOVANI', 233, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$fvWrL1QiZri5u2QUNX0j1eGYuxB2FRAcQw3vpSYO5fEmSqjCD6xH.', 'G.PORTO95@GMAIL.COM', NULL, NULL, NULL, NULL),
(123, 'RODRIGO GOMES DE LIMA', 234, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$cMUXu5uh..BuVv.wtSuxiuhoRFXWj/bufrqYAMPkFrxvJjZbdI3eu', 'RODRIGO_GOMES48@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(124, 'JOSE ADRIANO TADEU DE SOUZA', 235, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$d4HeMtxlCm/IlOzt.7WURuCneZnSHTx079XoXLorkIyd34XzKN52O', 'ADRIANOSOUZA1110@GMAIL.COM', NULL, NULL, NULL, NULL),
(125, 'DEBORA KELLI DE MELO', 236, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$hELZ928DYD16pp7N4g/JyejH2oKchYf9VPHoIIcEdRcmKYXgOP2Km', 'OPSBINHA@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(126, 'VERIDIANE ELZA DE OLIVEIRA', 237, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$7.D3PXxydwJ/jBa1vHH5K.eCA9yPDGRkJM8sNL5aExG9laPFJFLze', 'VERIDIANEE.OLIVEIRA@GMAIL.COM', NULL, NULL, NULL, NULL),
(127, 'ANA PAULA DE MEIRA', 238, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$94RGuezW5Xt92jpkbSQn1u5tjBRpB5E4ZVFTtworKlk9BWSR79yLO', 'ANAPAULA.MEIRA@OUTLOOK.COM', NULL, NULL, NULL, NULL),
(128, 'ADILSON SABATINE JUNIOR', 241, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$AptK.MkeO4nT1t4pHvA8k.mMjL54HxXHcfbwVoSfO7xfjSglqcqHm', 'ADILSONSABATINEJUNIOR@GMAIL.COM', NULL, NULL, NULL, NULL),
(129, 'GLEIZE APARECIDA CARDOSO SANTOS', 242, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$9YcJJDEsBjkBnmdAQ9dOveu/PLIrlSO3QLGJyLCXbVpc6KG3ip6NO', 'GLEIZESANTOS@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(130, 'ANILTON JESUS DOS  SANTOS', 243, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$WCq.KlConrg/Qt6g3J.Yj.fIBX9Q.Tf6ewz/xYbsKWRrmwPtbC4sq', 'SANTOS161982@GMAIL.COM', NULL, NULL, NULL, NULL),
(131, 'ANDREIA GUILHERMETTI', 244, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$W83hqTXlKHNui5CD/RDM4uO5WUZ9a.fKPiby9Wqwob1y5rM8bn.zW', 'ANDREIAGUILHERMETTI@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(132, 'MYRIAN CRISTHINA DOS SANTOS', 245, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$i6RyI6vVb2HiEqiAUdWU8.a6xlDx64c4bk9g91NFDIoOQ6ct/Ka.W', 'MYRIAN.CRISTHINA@OUTLOOK.COM', NULL, NULL, NULL, NULL),
(133, 'MARCELA RODRIGUES DE SOUZA SANTOS', 246, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$HdubJnBWreRvC4GncNVj4.Ecgj89T8wU7c1ykVpybFfCeIH.6fDDG', 'MARCELA_RODRIGUES27@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(134, 'SAMUEL WAGNER BRILHANTE DE FRANÇA', 247, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$Usla.RJuUBmz/4wW1A.y5u3FoHAingi6eRYBVXBlZ3Mt2Z7gR2Hma', 'BRILHANTE.ENGC@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(135, 'MARIA APARECIDA CARREIRO DE SOUSA', 248, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$RpaV0qCQQZX1uhmbnDOVx.Uml0AA5w1TsrbO/rtVqHBuMR950DCS6', 'CIDA.CARREIRO79@GMAIL.COM', NULL, NULL, NULL, NULL),
(136, 'DANILO GABRIEL DA SILVA FOGA', 251, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$.9kcKlTQLczeYzrLiwPql.8wue3KdFx/VT6Pk269NciKNjwupvBzy', 'DANILO.FOGA93@GMAIL.COM', NULL, NULL, NULL, NULL),
(137, 'KATIA APARECIDA DA SILVA', 252, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$jgJS56TPXBTEn6YxD1zAtuiwgNLY5U4fXZkQImsrCguFvMmlOIKSu', 'SILVAKATHIA@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(138, 'GUSTAVO DA SILVA VALENCA', 253, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$nVSh7TL2zvyvGa5fY1iPR.uWRbmlhaCNTfql7Q8jk1xWUNVryAcNq', 'GUSTAVU_SV@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(139, 'THIAGO ODILON TEIXEIRA', 254, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$PLVM5ckaCz8qq3PPqmHbpexzut2OS0xnOOPThxHbeYqhAPe5XoIpq', 'THIODILON@YAHOO.COM.BR', NULL, NULL, NULL, NULL),
(140, 'LEONICIO DE SOUSA NASCIMENTO', 255, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$P8cjnvsQC90GB/zL3K/IW.GhaRgKZIDon8Rv/4MWQv5ReE5CAkYTu', 'LEOSOUSANASCIMENTO1301@GMAIL.COM', NULL, NULL, NULL, NULL),
(141, 'RICARDO ALEX DA CUNHA', 256, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$1yTv/pb2xmMDJ5os7et2QO3C6EM2PkT1JgByPaofdcR38HXD16VG6', 'RICARDOALEX.RAC@GMAIL.COM', NULL, NULL, NULL, NULL),
(142, 'PAULO HENRIQUE RODRIGUES DOS SANTOS', 257, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$3TUisAKPEB6gWnv85tvJI.ESJFe4ES1nzmdX.czDdTaiXZaCeFfLC', 'TAISDELIMA24@GMAIL.COM', NULL, NULL, NULL, NULL),
(143, 'JULIANA DE JESUS BASILIO', 258, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$XSJr/G9udnwAvkzdfjGSjeT5gm2QzDrrMDd5giXfduCSA2k9Pd3o.', 'JUH.BASILIO@YAHOO.COM.BR', NULL, NULL, NULL, NULL),
(144, 'EDSON KELVIN MENDES TIBURCIO', 261, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$AIrqUn0/h.FQmavf/UHzkO6TEOp0QFgplXtJelJ5.wqjoIXePvpZi', 'LUCIANOBERLOTTI@GMAIL.COM', NULL, NULL, NULL, NULL),
(145, 'GABRIEL CAMARGO DA VITORIA', 262, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$3.IUA2w5kHEekK0uPQZHkuIWEMj6u3hWDC2g2Yc/olkJOO38U/YsW', 'CAMARGOGABRIEL.V@GMAIL.COM', NULL, NULL, NULL, NULL),
(146, 'VALERIA DA COSTA CALDEIRON', 263, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$EmH4fNRq966QM320xIkhCu6r6ClcI5sqcoxN.G06uwxQ0eE8izZRS', 'VALERIACALDEIRON@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(147, 'ILMA CARVALHO DE BRITO', 264, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$UBGs727v3U42w0oiTpiZSedZCQUvdMP7y13rYv46EmPwJPy43XGXG', 'ILMENAIDE@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(148, 'GERSON BARBOSA SAMPAIO', 265, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$rNNVVFLeNt6re3TrErM0YOCLcAnCUkLsRMjw0gz7guHEF813JPyIy', 'G7SAMPAIO@GMAIL.COM', NULL, NULL, NULL, NULL),
(149, 'VINICIUS DE SOUZA SILVA', 266, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$V5Viq3iTNGLcsZJX/5jDBOkiH2z3B.gAF.Mx5guHGXU2SdxOxldZi', 'SOUZA.VINICIUS.SILVA@GMAIL.COM', NULL, NULL, NULL, NULL),
(150, 'ELISANGELA POLVORA DA SILVEIRA', 267, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$uW3U33Hmt09e4/a5kApm5OnUL6RL2NLb/smou4QH1czxrGGoeMDWO', 'SILVEIRA@LMSCARGAS.COM.BR', NULL, NULL, NULL, NULL),
(151, 'PAULA GABRIELA JACOB', 268, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$AGon.oQ1SLBpbSQjMJkgxuDgM1P3UzpNn0AYJJukh7OIMfiYHS3AS', 'PAULAGJACOB@GMAIL.COM', NULL, NULL, NULL, NULL),
(152, 'LEANDRO JOSE BARBOSA', 271, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$Zy36B/HnAdQYPlUSmQax3OFP7Hd5Ap0f1DK3J.P/bVR99bLPGfjX2', 'LEANDROBFISIO@GMAIL.COM', NULL, NULL, NULL, NULL),
(153, 'JULIANO SANT ANNA DE OLIVEIRA', 272, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$wb5j8/iYgJTTd1YCR.VMfeg2DaGEaB53laGPUP5GlYT9YHyAu0Avu', 'JULIANO_CPZ@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(154, 'ROZIRENE CHARAO DA SILVA', 273, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$7aq9cbah3p8oDzCZKuGbje56nduYHlCV07e/SK.MSGxY6fUIFjQVm', 'ROSICHARON@GMAIL.COM', NULL, NULL, NULL, NULL),
(155, 'EDMAR DE SOUZA CEZAR', 274, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$ySBypW6c9YTKAa5/w.hf6Og2ax6XnbOW3ujNEyYMp0mNwZb/CHkR2', 'EDMARSOUZACEZAR@GMAIL.COM', NULL, NULL, NULL, NULL),
(156, 'LUCAS VIEIRA DA ENCARNAÇAO', 275, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$sYB/e75z2lb0uyxoWyc3Be/EcTpBrNac5VCMhpuOhPu8WmafnAJNS', 'LUCASVIEIRA_15@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(157, 'VERA LUCIA DINIZ VILLELA', 277, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$37funbu0MIF.DZgULrUymu8bM0tWcJ/EnxjMzHLgcFBA2CTmwr7JC', 'VLDVILLELA@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(158, 'NAJMA FRIZLAR', 278, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$YW3u9xc1MZE5PBEbxcEmoOtbeVcIWpZoBkwJtKshO8/jNdSwi6D4e', 'NAD.FRIZLAR@GMAIL.COM', NULL, NULL, NULL, NULL),
(159, 'LEONARDO SAVIOLLI SILVESTRIM', 281, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$cXmLgYrwxyl/3InoFrY4geeyd/x5726.iA2lYTHAl9Hlsj5rxjpq6', 'LEONARDO.SAVIOLLI7@GMAIL.COM', NULL, NULL, NULL, NULL),
(160, 'DIEGO ZANETTI', 282, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$p4OdlQ5sWhZboI8078380eVbavJlzMzePo9DZUcKDqdlxFhvR2Jre', 'ZANETTIDIH@GMAIL.COM', NULL, NULL, NULL, NULL),
(161, 'CICERA CRISTINA RODRIGUES', 283, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$IDeBalC2wBUY9Fmupwc45uC/RCjjv07084yMflaVuYTUbdkgw1G6m', 'CICERARODRIGUES319@GMAIL.COM', NULL, NULL, NULL, NULL),
(162, 'LUANA SANTOS DE AZEVEDO', 284, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$n2QZEdA3wupM.feZ9sHg/uGNF15SH9FHBz5pNE6r2Sfh3k7geD8o.', 'LAZEVEDO114@GMAIL.COM', NULL, NULL, NULL, NULL),
(163, 'CRISTIANE APARECIDA SILVESTRE', 285, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$mkRD3zq5A.2xmJqnk0H13uO1FZRrVprl3tZi.A7vZ2Q9wgQbcrgLe', 'CRISTIANE.SILVESTRE@OUTLOOK.COM.BR', NULL, NULL, NULL, NULL),
(164, 'MARCIO LUIS FERREIRA', 286, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$Vv33DkYANuRLyqaboCWYF.v4dGR.Qgcrs/oD6V8zZA3YHkp3PYBqu', 'MARCIOMLF@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(165, 'JOSIENE KELLY  FORTOLAN ARREGATIERI', 287, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$BNiWeslq0RL3pfG5WHNrFeRf.GRCmcXG0mDfoZT2SvlGdgqDKwQW2', 'ARREGATIERI@YAHOO.COM.BR', NULL, NULL, NULL, NULL),
(166, 'MANOEL DE LUCAS QUEIROZ', 288, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$gdnXhxnuZt1Z2YJDQ3M7OuRdOwNPdkq7u/3whEAuE92RQb6gRDMq6', 'MANOELLUCASQUEIROZ@GMAIL.COM', NULL, NULL, NULL, NULL),
(167, 'DOUGLAS HENRIQUE OVANDO', 291, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$NBKNyS8KbfG1Gayf76OElOyYYXMeZUKwYb6pMIDaMvZMKzMG3IU4u', 'DOUGLAS_HENRIQUE03@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(168, 'MARCOS JOSE MATHEUS SANCHEZ', 292, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$CJHqGIcpDk/dFLMvVfPP0e6GQ/ry9HymzTTNepuicEtiAv3QHwh/u', 'MJM_SANZ@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(169, 'MARIA ELIANA SANTOS OLIVEIRA', 293, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$WUaR.ffPdhtBpaedmulWMe88gBdVF6rreApa6iJWVWHTNC/VI7cym', 'MARIAELIANASANTOSOLIVEIRA@GMAIL.COM', NULL, NULL, NULL, NULL),
(170, 'JURACI DA SILVA VIRGENS', 294, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$mK4pxGN5LvYlHWxSz90.aedrWkSc1mwbyIG0d59VWP9eOuPuyaSdG', 'JURASILVA377@GMAIL.COM', NULL, NULL, NULL, NULL),
(171, 'BIANCA MIGLIACCIO GRANDOLFO', 295, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$jOoT543kLnC2Uu79beTRdOQma/dUNhFm1fiOTO17P5vumJJ.VyvqG', 'BIANCA.MIGLIACCIO@GMAIL.COM', NULL, NULL, NULL, NULL),
(172, 'RE/MAX FORT', 296, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$gzdFH5Af/nILoHinyWb2we503SKNUAF9lkc1/Xrgkpf/EiS.ovwF.', 'MARQUES@MAXXIFORTCAMPINAS.COM.BR', NULL, NULL, NULL, NULL),
(173, 'DENNIS FRANK REZENDE', 297, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$Rti8J8S6RtU4Y4BuR9WuZ.ulrEQSPlgKtyJumbHxSPiZxJj1Vm9Q.', 'DFRANK_REZENDE@YAHOO.COM.BR', NULL, NULL, NULL, NULL),
(174, 'ALINE LOUISE NASCIMENTO MARQUES', 298, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$HXygmxj0.f9CZm2NPmcQoeGIiKrEBpEoEgJ8/.UOWLcODXh97R6qS', 'ALINELOUISE1@GMAIL.COM', NULL, NULL, NULL, NULL),
(175, 'ROBERTO JOSE DA CUNHA', 301, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$pVyw1MKB936kwFEj74wDDuKtfuIvCPuhT5/go66y9iLunQkPbYDx.', 'RM15112008@GMAIL.COM', NULL, NULL, NULL, NULL),
(176, 'DANIELA APARECIDA TRINDADE', 302, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$wqVs9DcE0fkVMk/dYFajputPh3ZXQUXrlR8lTdfR0njRZn0INgjmm', 'DANIELA.AP.TRINDADE@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(177, 'RAFAEL ISSIBACHI SILVA', 303, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$rns.TKe7EPl6p4IqpLhiRe2ugntjtpKSZh0xoifwwna6vDfbO.BYq', 'RAFAELISSIBACHI@YAHOO.COM.BR', NULL, NULL, NULL, NULL),
(178, 'BRUNA RIBEIRO DE GRECCI', 304, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$StNPbxu9q37Ly2EGpeagPOD3yzbW.50UBTsB0A9jLXeeMdWcw8Bm2', 'RB.BRUNA@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(179, 'CAIO FELIPE LOBO RAMALHO', 305, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$66czQ/Mi.JeiuWQSLonjP.F5d19TlfekvJ6F4AphckSM3BXQOT4Hi', 'CAIOFELIPELOBO@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(180, 'GIANLUCCA TENORIO DE ALBUQUERQUE', 306, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$/7hVgXaMNLDTrwzDevUYg.quRk7K.p8Ra4mp5QzBjggmvRgfyDH3K', 'GIANLUCCALBUQUERQUE@GMAIL.COM', NULL, NULL, NULL, NULL),
(181, 'MATHEUS DE FARIAS MARTINS', 307, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$w50kICGct7gHpspKk/l7gOiv9x9D6P1l771fNy4Et/O8iiV7fffii', 'MATHEUS2MTS2@GMAIL.COM', NULL, NULL, NULL, NULL),
(182, 'THATIANE MAFRA SIMAO', 308, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$NUqpCsl48YVg3.NM5rMZseZpWsfausm13dDSOuaatHUGCo2XPw696', 'THATIANEMAFRASIMAO@GMAIL.COM', NULL, NULL, NULL, NULL),
(183, 'GIOVANNA ROMERA ELIAS', 311, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$qac/w6hATLJqq08NM7UjMeSwm.rlDsig5c8lBzy4R.VYLwrlAdR6q', 'GIOVANNA_ROMERA@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(184, 'DEBORA EVELYN MIGUEL', 312, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$EJsLSwgzkdxvz4Ajnz/2kOQrdS96YH5In47rB4uQDaG3PRIa.nuV2', 'DEBORA-MIGUEL@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(185, 'DOUGLAS DARMANI MARQUES LIMA', 313, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$.vXyx2lk1k6eLJdzT8duDOsxiinUChvfyuUq/K.Bv.p4LHLmwqWsu', 'D.DARMANI@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(186, 'LUCCA BRITO', 314, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$jvM9S0NoyOzY503ov4eY1.SACC1TridfMxlTwsXQPeJ902TSAsGLq', 'LUCCABRITO93@GMAIL.COM', NULL, NULL, NULL, NULL),
(187, 'SABRINA RAFAELA DA SILVA PASSOS', 315, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$uKL1m/vQ2M3sS8grqSmaWOIHH/DMjKo0VH6G0gENeD8.7456.mUV.', 'SRSABRINA72@ICLOUD.COM', NULL, NULL, NULL, NULL),
(188, 'ANNE ARIELLE SILVA ARAUJO', 316, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$/vb7MKliUQwgYqfvThG1YerAqvMx2p8RAtoBDBllluKo.DMGfmG/O', 'ANNE.ARIELLE@GMAIL.COM', NULL, NULL, NULL, NULL),
(189, 'HELOISA HELENA DA SILVA', 317, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$09nXb80bpAC9jI9f8x3b6ug4YVVnnbjkys0ABh.tv4n44byWhfjJi', 'HELOISASILVA3@ICLOUD.COM', NULL, NULL, NULL, NULL),
(190, 'JOSUE DE ANDRADE E SILVA', 318, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$cD7h/JgPvz7cD9WA7NPUfuOSacJPYhDee3i8tM0iBoenxIV0qWF6W', 'JOSUEMUNDIAL.27@GMAIL.COM', NULL, NULL, NULL, NULL),
(191, 'JANAINA SOARES  MACIEL', 321, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$tbeM4HtTCjFb44fPDke60uLB29Nvg1LbgB/Ghyrq4pYxZ7xYcXVGe', 'JAN.J-G@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(192, 'ISABELLA APARECIDA RODRIGUES DOS SANTOS', 322, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$R9Ysvpb.4D52AImiXdVZjenRSVWInS54o3I5MyMACRE01JSIVYoLe', 'ISABELLA.RODRIGUES95@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(193, 'RENATO APARECIDO SALDANHA', 323, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$nwD/FuZwA41kaxTFBd4hpeVJbxV2KvP0bMZhjKtz..MmGWP.NMV.2', 'RENATO.SALDANHA85@GMAIL.COM', NULL, NULL, NULL, NULL),
(194, 'MATHEUS CARVALHO DA SILVA', 324, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$FPW/4g2Drt8BGZG0YeGT7e75Id6rJwvtmv1ZlomcXSj.nW9FwACLu', 'MATHEUSCARVALHO01@LIVE.COM', NULL, NULL, NULL, NULL),
(195, 'GUSTAVO LUIS DE SOUZA CARDOSO', 325, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$VhqPKOoxMnzMxxmVpMQ.CufJz8EmmGRRsRvhxLeX49Bth64PsaQAy', 'GU1802@ICLOUD.COM', NULL, NULL, NULL, NULL),
(196, 'GABRIELLI NOARA MATTOS NOLLE', 326, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$pJ0YdrW09ya6GjZAGmmePuyHfyjun4qvjM1BxoKn0rbxgwzDhLFge', 'GABYNMATTOS96@GMAIL.COM', NULL, NULL, NULL, NULL),
(197, 'JOAQUIM FELIPE NETO', 327, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$bYVVgzzW8rsr9WSqRCJzZunUWD.YJhxrKZI6WgpTuLLMtLkTM2.Ki', 'JOAQUIMFELIPE@HOTMAIL.COM.BR', NULL, NULL, NULL, NULL),
(198, 'CARLOS FERNANDO SOARES DA SILVA', 328, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$bi6G.uj..JSFLFjgwGK3NOQzLeDsRIx89qbqm4a2gqj25dRRlYKjy', 'FERNANDONADJA@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(199, 'CAROLINE FERREIRA LIMA ANDRADE', 331, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$bF1XPYVcb6E6N3gELdbUuef4X13seTaEG.JzlvquZqCp9Qa3.Vhzq', 'CAROLINE.FERREIRALIMA@YAHOO.COM.BR', NULL, NULL, NULL, NULL),
(200, 'WILLIAN BELCHIOR  GAZETA', 332, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$C.JcNBn6unAAkhfDSysnXuEU22K6nm/GP2tke7StCSupA1DHdF.p6', 'WILLIANGAZETA@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(201, 'EDNA MARIA DOS SANTOS', 333, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$jYYmQ1I0PFgn5bm21Jl/hOGfOpFKY6SRvfaKgTQF9vviaW2DGaUEK', 'EDNASANTOS773@GMAIL.COM', NULL, NULL, NULL, NULL),
(202, 'CAIO CESAR PEREIRA COSTA', 334, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$Ea12N5svVahyTDQN4hMmr.LoseYWDTWEoRHhYJCmh2ZCwIScbxQJu', 'CAIOCESAR07@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(203, 'ANTONIO JIMENEZ NETO', 335, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$TYcXutdClrDkGWUuaGrdVOOchKRCbrg4SrqRaSI.b2K4O2V6GBj4W', 'ANTONIOJIMENEZNETO@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(204, 'GUSTAVO HENRIQUE DA SILVA', 336, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$fTfjOuaAv8vCqIGNmqXp3.AMc0CVfbLHT7dRqJjuNoEh93UiddkHO', 'GUSTAVO.HENRIQUESILVA@OUTLOOK.COM.BR', NULL, NULL, NULL, NULL),
(205, 'SIMONE BERNASCONI DE AQUINO', 337, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$Gv.bhAU6KGBbrJ6cJyNlZeOcjOik12uUD7alUG8DWLREnijMXulMe', 'BERNASCONI.SIMO@GMAIL.COM', NULL, NULL, NULL, NULL),
(206, 'MAIRA THAMIRES LOPES', 338, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$Y6mkSDuF7jd2i/RkMnuEROVgythg5DH04hrGVrYRq4.EG1otSptD2', 'MAIRA.THAMIRES.LOPES@GMAIL.COM', NULL, NULL, NULL, NULL),
(207, 'ISABELLE LOISE MILITAO LIMEIRA', 341, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$tEIJ./miByba8.64WdlR/.CvcTva26TJ2VNLfilunZ16Ec8IlFxF.', 'ISABELLELOISE91@GMAIL.COM', NULL, NULL, NULL, NULL),
(208, 'JOAO CARLOS DE ALMEIDA FILHO', 342, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$f8JHJR1ucxiXLe5GuBtWR.rKj4V91p2PDMuJLvHfqqZmrLwuTqsJS', 'JOAOCARLOSALMEIDA09@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(209, 'KATHERINE OLIVEIRA  ALVES', 343, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$jhFy4Unt9u/rOYnKFjWqKOY5FboJSA6Bjm.oLvcAUcUFU90I1X4By', 'KOLIVEIRAALVES@YAHOO.COM.BR', NULL, NULL, NULL, NULL),
(210, 'RICARDO VIDOTTO FELIPE', 345, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$iPJiwQiNd2SlcsK3z7v9Lu1pX7kJQtnDDrL4Z410rKG/lgDAmMDbm', 'RICARDOVIDOTTO@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(211, 'JOAO VICTOR BELO FIDELIS', 346, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$e/XFzgSWEHq8Xy2fOK8rYe.Bs0llM8E7N6i8Yyb2Fcqa81xBqjf.S', 'JBELOFIDELIS@GMAIL.COM', NULL, NULL, NULL, NULL),
(212, 'ALINE DANIELE STOCCO SILVA', 347, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$aorNqRmeLBuX97HrHDM3TeI5w1kS/LzGEZFoWHOKDrgL5YpqgkMvS', 'ALINE.STOCCO94@GMAIL.COM', NULL, NULL, NULL, NULL),
(213, 'ESTEIFANE DE PAULA VIEIRA', 348, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$X1nRXvDISHsGpoD6TPGVQu0itX7JhKPdHp9in7GuGRrlD3Mifz8wO', 'ESTEIFANE@OUTLOOK.COM', NULL, NULL, NULL, NULL),
(214, 'MARCIO ROCHA CARVALHO', 351, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$EemU3LClsuOx6iLPva8OGuP6epcBLyQammmZFvEzkPJPp22wwSyTC', 'ROCHA658@YAHOO.COM.BR', NULL, NULL, NULL, NULL),
(215, 'RODRIGO DE OLIVEIRA FLORINDO ', 352, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$twI.4/A9CHr2uFT3Zz.VjONozUSjmnxCyLsqB0HBTQo2BQLt02MKS', 'ANALUIZAMDFARIA@GMAIL.COM', NULL, NULL, NULL, NULL),
(216, 'KARYNE HELENA SIQUEIRA DOS REIS SANTOS', 353, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$9tmkVgDxhr/y5j6vPCDxte0E/XC90g3Iz0CWO7O6nLDX1k1hresiu', 'KARYNE.HELENA@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(217, 'ANTONIO EUSTAQUIO RIBEIRO JUNIOR', 354, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$Op/VHi3EJBwRNJ3v672lj.oJUkpWIGy1TRMqs.JtKU2iDbnsG1W3y', 'JR-RIB@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(218, 'DAVID FERNANDES DIAS', 355, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$8WUAQZ089Jg5Zru4xXMljemR/HUbs.7ewIe0yRKHVruF.lGkM5bMO', 'ERIKAFERNANDADACOSTA@GMAIL.COM', NULL, NULL, NULL, NULL),
(219, 'GABRIELA VALINE DE ABREU', 356, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$28.nDxZD0AS/IR65QsO.0edGU4u/HvTdFhZg1.ip3gXAKZbiaTmZ6', 'GABRIELA.VALINE.12@GMAIL.COM', NULL, NULL, NULL, NULL),
(220, 'MARLY APARECIDA BENTO', 357, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$oTwOhQ3Ysm1nXkWqoMqGPesM4KwJhyKdvOnberAn1rbNE8XXP3Uv.', 'MARLYMEEL@GMAIL.COM', NULL, NULL, NULL, NULL),
(221, 'ANDERSON LUIZ MAESTRI', 358, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$lPK1FcLBZVUu0PjkaneNXufYvmecLQXziYkTJazmKIRnJncKNVUb.', 'LUIZ30679@GMAIL.COM', NULL, NULL, NULL, NULL),
(222, 'REGINA CELIA DE CARVALHO', 361, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$fSAqcdt8A9o3DZAtj9E8KeVe67yRuaqTgveRNY1q958aJyylxw7He', 'CCARVALHO.CELIA@GMAIL.COM', NULL, NULL, NULL, NULL),
(223, 'SOLANGE RIBEIRO DA SILVA', 362, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$iAK6mgZSjKB1EF6RlBz8QegZhB.1IdaCSqQ8lLszVrWPBmFr.ZRve', 'SOLANGERIBEIRO.EDU@GMAIL.COM', NULL, NULL, NULL, NULL),
(224, 'ASTHOR KRATUS ARAUJO', 363, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$v/KcgiID7KVkJD/5ZSIcb.CWCDbON4A/LDbghH/j.FidSoZKtp8N6', 'ASTHOR.ARAUJO@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(225, 'LUANA CRISTINA SOARES CALDERARI', 364, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$h2aoASsfDJB9Dsf9SDkVW.dshEVUmGT7MfcOB6WqeLN9jcFjTxOBi', 'LUANACALDERARI@OUTLOOK.COM', NULL, NULL, NULL, NULL),
(226, 'DEUSDEDITH RIBEIRO DE SOUSA', 365, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$VOiJQE2vD5c9Hw8L2..gKeFk/yYJL7jWVLIVqP1RwkxNSPcgjNIUu', 'DEUSDEDITH@GMAIL.COM', NULL, NULL, NULL, NULL),
(227, 'ZELZIANNE CARDOSO BATISTA', 366, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$GzPVOD5UNIRiHYM6v1uMN.YP81047QkGQwIRM9rUt2jl1cgASGrLW', 'ZELZIANNE@GMAIL.COM', NULL, NULL, NULL, NULL),
(228, 'MOISES DE SANTANA', 367, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$.oqCeUVX.pS1hRL46.ZaguasvpttBQmwClZLEMktZ1DatAh2Q490K', 'YAMA_SNT@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(229, 'JANAINA DE PAULA SOUZA SOARES DE OLIVEIRA', 368, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$oeRxd18tZIPGEnIkZj8L0eAIsOYp8p.5Kip.6X/UzlL0cnLEoEv3C', 'JANAINA_OLIVEIRA1997@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(230, 'WILIAN ALVES DOS SANTOS', 371, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$JkCKqn3aHgR7UDRcy4iNMu6ttjlIwSNfVUyGWJbTJBKxnmucXNyYq', 'WILIAN.ALVESDOSSANTOS180@GMAIL.COM', NULL, NULL, NULL, NULL),
(231, 'GABRIEL TRUBANO DA SILVA', 372, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$3cdX7UHJTPw4enGSFP59gOBkQIXAC1ggCW7uxU7sxrhJJ9do.bL/2', 'GABRIELTRUBANO01@GMAIL.COM', NULL, NULL, NULL, NULL),
(232, 'RAISA HELENA GARCIA DA SILVA', 373, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$WcucfCXJcih6Yp39wqL1mOjXstXzYZ7Z/SCSu3wrm62JrgQCPO3iG', 'RAYGARCIAG6@GMAIL.COM', NULL, NULL, NULL, NULL),
(233, 'GABRIEL DE OLIVEIRA AMARO', 374, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$lJoZqx8L55u5ubolvqB7ke1mmBHAFAaKqRIQWirJiqCNETfUgeKHK', 'GABRIEL.AMARO19@GMAIL.COM', NULL, NULL, NULL, NULL),
(234, 'ALLAN MATEUS SOUZA AMARAL', 375, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$mtM2uwrqhXqYtSW7QIMAv.7QpjtghrNxY3YR.Kk/wt.1XkDx2lUyq', 'ALLAN.MATEUS@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(235, 'JOHNERICK MARTINS DE SOUZA', 377, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$87g9S6GBJ/6vOjBE4q3dW.3J9YUcXVJYauYLC36T85Z1qc/UusJ/O', 'JOHNERICKSOUZA@OUTLOOK.COM', NULL, NULL, NULL, NULL),
(236, 'WELLINGTON DOS SANTOS CARDOSO', 378, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$9Dz6CiAznuQfWCe8Y8aLIO9I4NOSkmFQkcL/qZF0GfRO1ykD.vp0W', 'WELLINGTONCAR118@GMAIL.COM', NULL, NULL, NULL, NULL),
(237, 'ALICE MELO BRAGA', 381, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$M8oKlA1dc.qpjYPwhD8oGO2z8Elll1ffmV3ez.1PjEOD8MEGDDRLC', 'LICEBRAGAA@GMAIL.COM', NULL, NULL, NULL, NULL),
(238, 'MARCOS PAULO CANDIDO DOS SANTOS', 382, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$AQs.r5yKcH2hAmycPnLDgO8J8yFFDIKDF3J42x1UONk6w7sxim49.', 'M.P_SANTOS@OUTLOOK.COM', NULL, NULL, NULL, NULL),
(239, 'JOSE ROBERTO SILVA RODRIGUES', 383, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$g8hNMVxMn0KTMDEgnARHzeZ7Iy5CW4K.4hXGmgFx5cRy6E1BNjl7a', 'KLOPES2BETO@GMAIL.COM', NULL, NULL, NULL, NULL),
(240, 'FELIPE DANIEL COSTA', 384, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$m2DDZKdFF1t1o6V7SHRv3.E5NNg3X2FaXmimPaU1D3/CPi70p0yBa', 'PITSVT@GMAIL.COM', NULL, NULL, NULL, NULL),
(241, 'RAFAEL CANDIDO MARQUES', 385, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$j3qSnJ53qmfC9.pAzYGUs.UiXHAiDpQC0Lrlwc4UqyY3qC1rf3lSi', 'FA.E.2@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(242, 'BRUNO HENRIQUE DA CONCEIÇAO', 386, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$9l43d0INq6AgqFxPC1jMxO9xcl2hZDaYD3FzIjJvcUh4kEsVLlnWO', 'BHC07@OUTLOOK.COM', NULL, NULL, NULL, NULL),
(243, 'WILSON MARCONDES  MINARI JUNIOR', 387, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$xufSUK.ohBA9047VRvrYv.w2iuxo4hn4BrjT6/JDX5.a9K/rYpcy2', 'MINARIJUNIOR@GMAIL.COM', NULL, NULL, NULL, NULL),
(244, 'DEBORAH VILELA DOS SANTOS', 388, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$ofXWKgkH92n/mJFLzADBcOxJl2xsm7lV7h73fa6DQMA0sYZ1YexhG', 'DEBORAHVILELA@YMAIL.COM', NULL, NULL, NULL, NULL),
(245, 'DANIELA CASSIA  NAVARRO ZORGETTO', 391, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$nJNw9.ncN5aF74kVOy79ReZss4jkZ3zpymEEeVF0Aclqme6/.18Y6', 'DANICNZORGETTO@GMAIL.COM', NULL, NULL, NULL, NULL),
(246, 'TIAGO AZEVEDO DOS SANTOS', 392, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$/10B0hwlEDTBXqm160ahJeKrR6WrLKtBiQaTKEMhgWIphzZyy4Xm6', 'TIAGO_AZSANTOS@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(247, 'TIAGO SANTOS MATOS', 393, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$ZAkFb7gCa6R7X5KrNbaSqOSHXieOL.9soFMJQrEnbxgn6NK1SKos.', 'TIAGOSANTOSMATOS2@GMAIL.COM', NULL, NULL, NULL, NULL),
(248, 'JOSIANE APARECIDA DE ANDRADE ', 394, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$6Ef/vcqWFbF4HogQ598/Xu0AWeuIl3ubpSJmo.BMaZ.gGQ5FtGZUq', 'JOSIDEANDRADE1@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(249, 'ERIC MICHEL FERREIRA SILVA', 395, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$DEPvq4FOnjDoLQrvjyRLQ.HuKvQSaDrlk.7kFdv4P4xWsN5IacPkG', 'ERICMICHEL.SILVA@GMAIL.COM', NULL, NULL, NULL, NULL),
(250, 'MONIC HELLEN DOS SANTOS TORRES', 396, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$K0CvGvS1Ver8fY6VK3r6C.c69g.SRhyS1jvb7npEWO3ej2kd7Rx1i', 'MONIC.HELLEN1990@GMAIL.COM', NULL, NULL, NULL, NULL),
(251, 'NELSON BRAMBILLA JUNIOR', 397, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$8pLfgZQ3Zk0.8Azzb/yuM.wWS86YfKNbQPS60ZrhQVkVFdvxLfHF2', 'NELSON.BRAMBILLA@GMAIL.COM', NULL, NULL, NULL, NULL),
(252, 'JESSICA FERREIRA DE  SOUSA', 398, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$j2n2I0jmN1MhT3gnIT7Yjurnuk8CZtxqNTTKOE4UeD/oRdoPIX04a', 'JESSICA.SOUSA1412@GMAIL.COM', NULL, NULL, NULL, NULL),
(253, 'FABIANA VIANA NOVAIS', 1101, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$0flxknRCULNYfuiKzlhriOie4SSzULAXnja8hZl6rTEWdJpw729U.', 'NOVAIS.FABIANA@HOTMAIL.COM', '9ef1b3bc1969bf33e590901d5526fd2f', '2025-01-04 17:50:50', NULL, NULL),
(254, 'FABIO GILBERTO REIS', 1103, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$Fn/88BAD/oMO53352zURMO18bCtlBshw5qinT1oqZG2lM/Rht40Um', 'HAYESZ08@YAHOO.COM', NULL, NULL, NULL, NULL),
(255, 'SILEIDE FERREIRA LIMA', 1104, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$Gthp3ELIjXZDnBNLI6AbreoNmWoiFKsNNLfkRDUtowH28ilEdEcgm', 'SILEIDELIMA16@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(256, 'JAQUELINE MOREIRA GOMES AZEVEDO', 1105, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$YEmgNn50YU8tscuXANTSRepkXkN3SKoTf..JUqTkDyyMOrxrRCYSC', 'JAQUELINE.MOREIRA1995@GMAIL.COM', NULL, NULL, NULL, NULL),
(257, 'JAQUES OLIVEIRA DO NASCIMENTO', 1106, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$gGhfFC3qlVgJ.UkIVRUMd.SKQLQ60fQo2TBfFpEv0IvWmrIiyAj2e', 'JAQUES_ON@YAHOO.COM.BR', NULL, NULL, NULL, NULL),
(258, 'LEONARDO FERREIRA DE ALMEIDA', 1107, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$ohxHvKVhqPxlOpRpS4nmNuwjDB2o3Q1dPmMOp2nhmMk1Ts8GNUnnO', 'LFERREIRADEALMEIDA@GMAIL.COM', NULL, NULL, NULL, NULL),
(259, 'EDUARDO DE BRITO', 1108, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$HlolFzCUzH.IRmtI7fnhTOuF9DTRp2/7wAiEWFkxZ0HMKnxWqGHsu', 'DUKBRITO@GMAIL.COM', NULL, NULL, NULL, NULL),
(260, 'ANTONIO BLUMER DE OLIVEIRA', 1111, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$cKWTbJhm9AXQ.NjQaG/fy.9dOLsz.zm7HN1XKF.mbaQQks1IMTahG', 'ANTONIOBLUMER2204@GMAIL.COM', NULL, NULL, NULL, NULL),
(261, 'KELLY CRISTINA NUNES SEGUNDO', 1112, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$pwdNdOjjp0GVXUtv9lA.bOICtx8V5gWHIPat6o796t7zB2euubHvi', 'KELLYSEGUNDO24@GMAIL.COM', NULL, NULL, NULL, NULL),
(262, 'DORIVAL MINGUINI', 1113, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$zo.TmzYLq7UPX6XqG7DcKe16xe9LWLpNVfIh4h/kp0xUONfYKRZCu', 'LETICIASMINGUINI@GMAIL.COM', NULL, NULL, NULL, NULL),
(263, 'JOSUE GOMES RODRIGUES', 1114, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$8rpTKgeSFqvynZYtsrwjBeQ7zDOO.pawtzrXjVYSZzr/OKzSlUd3e', 'JGDRODRIGUESS@GMAIL.COM', NULL, NULL, NULL, NULL),
(264, 'MARCELO TADEU TEIXEIRA BRAGA', 1115, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$pap1tg09euJfBt/.Q2mBkukwLzctFnH5MnnQGzknoKnajhGTCdSSC', 'MARCELOTTBRAGA@GMAIL.COM', '40b0a1ce1f20c200bd4a6f4d3e327025', '2025-01-02 15:28:00', NULL, NULL),
(265, 'VIVIANE KATLEN DO NASCIMENTO', 1116, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$nC9o0neoHHJ3vTHIszQ8EOtMEfVyiY/Xerqlx85fVg29d95mqUX76', 'VKATLEN@GMAIL.COM', NULL, NULL, NULL, NULL),
(266, 'CAROLINE RUYS RODRIGUES', 1117, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$XePpTP8ldS26J1nvZAmYLe/RgWr1vqQVtx4Os70XjWQ.E/4Qdbdw.', 'CAROLINERRODRIGUES@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(267, 'TUANY PEREIRA QUIRINO', 1118, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$IqDn2hPY8vr3dp/UT87meuxU1UkKZ.l0artgNQPLv99J93iike.0S', 'TUANY_QUIRINO@OUTLOOK.COM', NULL, NULL, NULL, NULL),
(268, 'RAFAEL RIBEIRO DE SOUSA', 1121, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$fnOqQW0TU31Gr.AvWa1TouEEuSUKJe3WFeaDecP9r2OwyRLA/jPie', 'RAFAEL.RIBEIRO09@GMAIL.COM', NULL, NULL, NULL, NULL),
(269, 'ALEXANDRE PEREIRA CRUZ', 1122, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$.t0BnJugPqOyv8vGCZfTM.ch85cMy2TnpA7uQGzgyM39Qg3gRowN6', 'LAINE.SCRUZ@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(270, 'CATARINA MENDES DE JESUS SANCHEZ', 1123, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$Pkp1TR4AQmjZ7ajLQNgIMuSymC6wsGdbDtoDPGO5RgOwwr1GBn/PS', 'CMENDESJESUS@GMAIL.COM', NULL, NULL, NULL, NULL),
(271, 'JOSE FRANCISCO DUTRA DA SILVA', 1124, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$dZ/zMX.MjKhvzbulK0PvfObPJYQQTiQCuzHO0Ya2ioZGGMPEZXeT6', 'DUTRAMAX2005@GMAIL.COM', NULL, NULL, NULL, NULL),
(272, 'FERNANDO MATHEUS DIAS MUNHOZ', 1125, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$nd5i3Am/ChRZWQ.eKGBlVOg2G4Z4jyIrJcKqxTKqrXPpUksf2jtim', 'FERMUNHOZ31@GMAIL.COM', NULL, NULL, NULL, NULL),
(273, 'JULIO FRANCISCO VIEIRA', 1126, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$88sX0Ta3DyS2rMulooIuTuq6hCff/TfePSuF6aXBHOBDf7Snwijpi', 'JULIOFVIEIRANV@GMAIL.COM', NULL, NULL, NULL, NULL),
(274, 'PEDRO ACACIO AMERICO MIRANDA SILVA', 1127, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$viwqw6FhJQLdxMK/xOvJm.Pjh6r4f3BSFjmBhE68BDdW/YqxtRANW', 'KARLAROCHA22@YAHOO.COM.BR', NULL, NULL, NULL, NULL),
(275, 'ROGERIO GOMES REIS', 1128, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$rykdze261CT0JKilmPI9CeWXSBAkHcwvLXwNS5Pg1FcoGiN05rEHG', 'ROGERIOGREIS@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(276, 'RAFAEL FERREIRA DE CASTRO', 1131, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$DsCIjhhvebWcXdZs9FJDCeNbA9HbXSK/vWE99jyqRbMxsHrsBb0Gu', 'RAFAEL.CASTRO@IGARATIBA.COM.BR', NULL, NULL, NULL, NULL),
(277, 'BRUNO APARECIDO DE OLIVEIRA', 1132, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$z5WcRPX4UDcR/D0UbH/NMu3VsXGqMsuGWzA0lXq3WLmkOjiSgLBBG', 'BOY_BRUNINHO08@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(278, 'MARIA APARECIDA MENDES', 1133, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$1U4zsiD6oWaZjTy2b/g8y.IpVM4cNnUbcLyAAftqR0SHsEj7VoyZu', 'MENDES13732@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(279, 'JOILDO CORREIA SOUZA', 1134, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$bvY9OXZm/DsSZNfOA6Cv2ukzmd.hNIciPqQYMsXKl1misDu9PTGpu', 'JOILDOCSOUZA@IG.COM.BR', NULL, NULL, NULL, NULL),
(280, 'CARLOS EDUARDO SILVA ', 1135, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$0iU3YQ2pZQvIWdhLpgkIyuxNh360uQNWsKc7NCIRlmVP/cPFFit0K', 'NAYLOPES@OUTLOOK.COM', NULL, NULL, NULL, NULL),
(281, 'GUILHERME PAES DE SOUZA', 1136, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$IzGHzYepQI1cunl14Coxt.Z.8phJdNjlkTwnnFCLv7KNAHbgaNzLO', 'GUI.PAES1@OUTLOOK.COM', NULL, NULL, NULL, NULL);
INSERT INTO `USU_USUARIO` (`USU_IDUSUARIO`, `USU_DCNOME`, `USU_DCAPARTAMENTO`, `USU_DCBLOCO`, `USU_DCNIVEL`, `USU_DTCADASTRO`, `USU_DCSENHA`, `USU_DCEMAIL`, `USU_DCREDEF_TOKEN`, `USU_DTREDEF_TOKEN_EXP`, `USU_DCTOKEN`, `USU_DTEXP_TOKEN`) VALUES
(282, 'REGINALDO RIBEIRO DOS SANTOS', 1137, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$6mbXyyTEZt2v/dPEKkvy..SeHd4FsHYmZz6arz0q0NCi4SxQFl25i', 'GILTRANSPORTE1@GMAIL.COM', NULL, NULL, NULL, NULL),
(283, 'THAIS CAROLINE DE ALBUQUERQUE ALMEIDA', 1138, 1, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$vryLM5jdqg7mrpCnc3YayedLW6d9/.1tMDpE4X8210R4V./hc/3ma', 'THAIS.C.ALMEIDA@OUTLOOK.COM', NULL, NULL, NULL, NULL),
(284, 'ANDERSON FABBIO', 2101, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$dKvN548BcmS2GgVEDSe0iuAbeXD0yytnD808Nlfy1fb85SgtRkqqK', 'ANDERSON.FABBIO@YAHOO.COM.BR', NULL, NULL, NULL, NULL),
(285, 'GABRIEL MULLER SOARES', 2102, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$T/yMJMfqk/vSIFp7LyTppunG5kRtZyR3Uw9Y1tud.H9Bes81ugfli', 'GABRIELMULLER2016@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(286, 'JEFFERSON VICENTE VALDEVINO', 2103, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$Tw7oQpBHcaVIzwBZhzhV1OhRNqGYCx2N1NAyAiphwWbtUJajkzsP.', 'JEH-85@BOL.COM.BR', NULL, NULL, NULL, NULL),
(287, 'GABRIELA CLARA OLIVEIRA', 2104, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$ApQ1AHhjnJoCct2lv/XIpOmw.kt3BAlxQ6AxC.jr1zBh2cO8./ud.', 'GABRIELA_OLIVEIRA05@YAHOO.COM.BR', NULL, NULL, NULL, NULL),
(288, 'UBYRATAN MASSAROTTO BAPTISTA LORENA', 2105, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$dhuuIbxuRXlhwLpb8/.0CuXWrSGuC.A4y8kx6lR8UOIiOKzDukLnS', 'INFO@UBYRATANLORENA.COM', NULL, NULL, NULL, NULL),
(289, 'LUCAS GONÇALVES ARGENTIN', 2106, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$jPsZo.m3lVkB9hPNb6xUpO4W/5QL.f28V5kRzMslTzeSwzqn9nFFu', 'LUCASARGENTIN12@GMAIL.COM', NULL, NULL, NULL, NULL),
(290, 'FELIPE VARGAS SALOMAO', 2107, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$jodYNYgaIm6mzGKmrwpYCeQC6bixnoMUa.PCCsG71Np55bgcbnVZK', 'FEH.VARGAS@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(291, 'RONE PETERSON DIAS', 2108, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$2dyMISqsWnRdOR09qimURuViYY/EPYWUeYam8VR1kgFzC9837wmrq', 'RONEPETERSONDIAS@GMAIL.COM', NULL, NULL, NULL, NULL),
(292, 'RAKLA PIMENTA DA SILVA', 2111, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$dCb02alj0jwGa0KKwfxg.ugxFTqFZ9gJ6L3fip42Ok6caJrKasM/u', 'RAKLAPIMENTA@GMAIL.COM', NULL, NULL, NULL, NULL),
(293, 'WANDER RODRIGUES DOS SANTOS', 2112, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$zHksjcFmEvglUQIHGLzXVeMjkMtpyIlPjeP1khRQpxOyJUoRvuGD6', 'WANDERDOSSANTOSRODRIGUES@GMAIL.COM', NULL, NULL, NULL, NULL),
(294, 'DAYENNE ALVES PEREIRA', 2113, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$pA7BFGO4mRFq.DpqFKBA8eVymhTTbQ9vQyrPQ/2LGupiFrUgtseki', 'FELIPEDEMOLIN@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(295, 'BRUNO RICARDO DE SOUZA', 2115, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$yW8d0UqIxHsjiahm9WLf/uztKe4AfY7.IkgOfKWMWgF6C3kZUMNDu', 'BRSO@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(296, 'CLEVISON LAMAS VELOSO', 2116, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$vHqssi9veE6Qtk7JY4OMt.5W.ZJmA9JDh6eq.OLYRiFBi/ywqAeR.', 'CLEVISONLAMAS@YAHOO.COM.BR', NULL, NULL, NULL, NULL),
(297, 'ELIZANDRO CARDOSO RODRIGUES', 2117, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$FA8K/wcUluc0XN69AQaxZeFTxWbG.gzRFwt28Y2ACncfU9.B5LKDS', 'PFELIZANDRO@GMAIL.COM', NULL, NULL, NULL, NULL),
(298, 'RENATO VIEIRA BATISTA DOS SANTOS', 2118, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$MZewPDpOI1hq70CBbR0ShuqwSUWau55kvtTYsJho4KAtRSZOu3Zpy', 'RENATO_TECMOLD@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(299, 'HELIO PEREIRA NEVES', 2121, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$uXi6p4Kx/8FN6x688HLJWeOT9yIqdbkUgW6S..hb6yD1BIbzdTk1y', 'NEVESHELIO619@GMAIL.COM', NULL, NULL, NULL, NULL),
(300, 'GUILHERME PAFFARO', 2122, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$9kuPJdwKmxFgVxj/8NrH2ul4qnnhuA68UZ8VciU5HGVrIvwRKR9Xm', 'PAFFAROG@GMAIL.COM', NULL, NULL, NULL, NULL),
(301, 'RAFAEL PEDROSA DE MOURA', 2123, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$3WpUOB69SISDmRuTq3vZZ.gXkpEWrBZbWFj4TrLVcM7Ii2DON3eF2', 'RAFAELPEDROSADEMOURA@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(302, 'EDUARDO LOPES DOS SANTOS', 2125, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$yNTPdrbUrai.26/zrHFjxOB3MaiJS9jT3sJwqr57zfsRGVjsoMnXS', 'EDUARDO07.LOPESS@GMAIL.COM', NULL, NULL, NULL, NULL),
(303, 'EDIMAR TAVARES DA SILVA JUNIOR', 2126, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$gFSaO4KElQyqG0UQ.s2RiuUnxyK1wdTEnbjHIDbMa7.OD0ea9fgZu', 'EDIMAR97TAVAES@GMAIL.COM', NULL, NULL, NULL, NULL),
(304, 'GUILHERME ALVES LIMA', 2127, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$DZUJrgh.Ujyyfq9rDpQJHuOJ0NTkeV2OkwmswhZyaNhYVKLz8x/My', 'ALVESLIMA.GUILHERME@GMAIL.COM', NULL, NULL, NULL, NULL),
(305, 'BRUNA GRAZIELLE MACIEL SERENO', 2128, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$guYssPNW6XZgkWn.Ta2JN.bBZZdv0kPnb6sH1Q40rogx1tJLWtP4i', 'BGRAZIELLEMACIELSERENO@YAHOO.COM', NULL, NULL, NULL, NULL),
(306, 'JOYCE MESSIAS DUTRA', 2131, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$jkqMcgYQtaKNq4iuGi7qeu2Di.Oy2.vATmxRZq0jGYEpxk4ZQLqo6', 'JOYCE_MESSIAS@LIVE.COM', NULL, NULL, NULL, NULL),
(307, 'CAMILA CRISTINA MENSATO', 2132, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$wIJNHmEQLdPFfELeBntEZ.QIS2k0og71ktG7RZ7InmkZzsN.FaMrK', 'CAMILAMENSATO@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(308, 'FERNANDO AUGUSTO MINETO DE FARIA', 2133, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$BDYZGEOPE7jNX7nG3GU55uKSiGp0J5yauIThcQUxSuP4TPfhCaYi.', 'FERNANDOAMFARIA@GMAIL.COM', NULL, NULL, NULL, NULL),
(309, 'NATASHA ARYJADNE DE OLIVEIRA BENSON', 2134, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$ydzNqc8jwrhGw8q1sUJ7y.Bs9im7oPpe7VFFk6C1pqVsJZtHMEeEa', 'NATASHAARYJADNE@OUTLOOK.COM', NULL, NULL, NULL, NULL),
(310, 'ALESSANDRO ALVES PEREIRA', 2135, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$63bDG7XuwhoU421xthTiI.NsC/MZHEfpLuMe4P4BAzkKDy4896Tra', 'ALESSANDRO.APEREIRA@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(311, 'THAIS CAVALCANTE COLLIN', 2136, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$daP4oLqYHMLT0z6XeEVire/4j4io9v5MhKq.PFnjjS8BvFYnQVTUm', 'THAIS.C.COLLIN@GMAIL.COM', NULL, NULL, NULL, NULL),
(312, 'ALLAN RICHARD RODRIGUES', 2137, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$IkUX9Xflbw59rIFhrag33uV7mLAcxnwoqEkinmA8jF5iJFTxYaHbS', 'ALLANRODRIGUES@GMAIL.COM', NULL, NULL, NULL, NULL),
(313, 'MIRIAM DE SOUZA AGUIAR', 2138, 2, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$.U9QjUk0thwTk9pya.26Wu0NFCHKWieSjbSthKl2sK0DCvtoKcub6', 'MIKA_SOUZA13@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(314, 'ELICE DE FATIMA FERMIM SANTOS', 3101, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$5KWwKto665FpyhFn.TXiceKmHX5izxYiAk6xOzQhCzmi1fGzF6XPu', 'EFFERMIM@YAHOO.COM.BR', NULL, NULL, NULL, NULL),
(315, 'MARCELO GONÇALVES CASARIN', 3103, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$OEnFjZv8U764vt5Y5I6/4.eE3qKidE5f5x5YQg.2YrwPkq2XooV0S', 'MARE230416@GMAIL.COM', NULL, NULL, NULL, NULL),
(316, 'JOICE GUIMARAES DE OLIVEIRA', 3104, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$O3chOUHV2WtIp1swSOzD8.b4GJnY/NR0YB123dBr.rN1htKpA05dq', 'JOICEGOLIVER@GMAIL.COM', NULL, NULL, NULL, NULL),
(317, 'FERNANDO MENEGASSI DE SOUSA', 3105, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$5BdEhXRwk8raC3rFu0d0J.aFkrjqWnDezHGQxl/hPc.UqWCWsWzJ6', 'NANDO_MENEGASSI@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(318, 'MARINA MAYR', 3106, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$4dC98WTrgxkpevtM22MdPuaLAVD7wVhEOsYxnuu6aah1bYurXwS2i', 'MAYR.MARINA1308@GMAIL.COM', NULL, NULL, NULL, NULL),
(319, 'MICHELLE CRISTINA DA SILVA', 3107, 3, 'SINDICO', '2024-12-18 00:49:28', '$2y$10$FZkpMf17HnJyACsKYjyv6O35blrW9JvYLHea4Igdh/CQDgMc52nv.', 'MICHSILV215@GMAIL.COM', NULL, NULL, NULL, NULL),
(320, 'RICARDO LUIZ DOS SANTOS', 3108, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$khDf4ce8L3NI8UFtldrrzuCfOLXkycV2wpeJQY1sAaqiY9GhHZu8K', 'RICARDO.SANTOSIFSP@GMAIL.COM', NULL, NULL, NULL, NULL),
(321, 'ANNE CAROLINE DA SILVA', 3111, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$YasZq1g8BWRdw/OinpBml.BH1Qjw1iROwaAhXi2FEAMIzql/J5ZrK', 'ACS.ANNESILVA@GMAIL.COM', NULL, NULL, NULL, NULL),
(322, 'JEFITENCIR SILVA RIBEIRO DE OLIVEIRA', 3112, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$FWN0.bvrh.S1/Y8JQh67..nvrjDzngelZioGhHzVBDy1WDZFLVN3u', 'JEFITENCIR.SR@GMAIL.COM', NULL, NULL, NULL, NULL),
(323, 'LUIS FERNANDO ADEGAS', 3113, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$PAV4z.13UBAmTqx8dkS4Ou3UQ6a1qJykmC9VKqm./NFDpY0gzEG4q', 'LUISF.ADEGAS@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(324, 'MANOEL BERNARDINO DA SILVA', 3114, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$AmaeTuMNlb1AWAeFmGEQKeH.96dPJ1R6oLEgkUzEYUZcp5xJD82PS', 'MANOEL.BERNARDINO1961@GMAIL.COM', NULL, NULL, NULL, NULL),
(325, 'ROMARIO FREIRES DE MORAIS', 3115, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$9veFA0h17ge6CHIe4HdB/uJchhAcJZ4TO09jf2usMfPwS0pQ8QuVq', 'ROMARIO.FREIRES@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(326, 'DANIEL GOMES FERREIRA', 3116, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$fK.z2mFFIkQFZMOwNgeJDO9Ub/DPMQoF..Jv/lhVgHDNuEX1LkRdW', 'DANIEL15.GOMES@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(327, 'EDUARDO BECK', 3117, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$CyMEObWcPnT5XCDGvrnT1ei0vnmGlD1HPQBjgaL3t.iw//s2ZwoiG', 'BECKEDUARDARDO@OUTLOOK.COM', NULL, NULL, NULL, NULL),
(328, 'SERGIO HENRIQUE FERNANDES CUSTODIO', 3118, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$dTYZhnoR2Sysws5zMOP/xOO.Y44.RaAVVPsU/2DCTzJjjexPCdJO2', 'SERGIO.HFCUSTODIO@GMAIL.COM', NULL, NULL, NULL, NULL),
(329, 'THIAGO RODRIGUES', 3121, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$Fw1Jxegb1Jz1gmJLlkPreONbTtvhtZCVZsAkwTXCMcCuPKcErq.lW', 'THIAGOR97@YAHOO.COM.BR', NULL, NULL, NULL, NULL),
(330, 'RODRIGO DA SILVA ARRUDA', 3122, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$yvdpYRIfO2T1C8Uqq70b5ey6zsJWpqbQu0nnU6ZcLSszOkLplCPDW', 'RODRIGO-ARRUDA@OUTLOOK.COM', NULL, NULL, NULL, NULL),
(331, 'JONATHAN DIAS DE SOUZA', 3123, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$S3dy9zWdZQ0IZDT8Tfzpe.isLelt57zJuHCM31.Jkas/5iTyWo1lm', 'JONATHAN.SOUZAS@OUTLOOK.COM', NULL, NULL, NULL, NULL),
(332, 'KLEBER MACHADO TOLOMEOTTI', 3125, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$k4xFOEW..aXO2QZ4.DIN9.oT9l5O3gxRX4kCKZNRw5j7d0kkgijxe', 'KLEBER_TOLOMEOTTI@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(333, 'MARCOS EDUARDO BARBOSA PIZZOL', 3126, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$CPRcq4WysgY5L0UFG0N8L.kdOuKLDFUTIN.z4FFp6/l1uSHCpPxKu', 'MARCOSEBPIZZOL@GMAIL.COM', NULL, NULL, NULL, NULL),
(334, 'FLAVIA REGINA CAVALIERI', 3127, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$OQcwPc9dnoHVZwfd7x.p5O7p2Jwb2pRo53hPXSGw.u2t8TsfaVWUm', 'FLAVIACAVALIERI230@GMAIL.COM', NULL, NULL, NULL, NULL),
(335, 'MAURISA IVANA SILVA MARTINS', 3128, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$NQA.rhqX4pTFhWMWmIjh1.bDpXsX3SUGZ04XYpQUtYsBTmRYqo4si', 'MAURISAIVANA3399@GMAIL.COM', NULL, NULL, NULL, NULL),
(336, 'JOAO CARLOS SANTANA MANHAES', 3131, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$2CxvSN5j8UPB/6lCi8CRC..PqRTkXtZSWtSVUPE1PjFCZSE7kR41a', 'JAOZINHO0709@GMAIL.COM', NULL, NULL, NULL, NULL),
(337, 'RICARDO CUNHA DE MIRANDA', 3132, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$xTZNLhdd63zwG4cLpW945Oys4OVs4lBzxbwX.VYoNU6MUurlQI96K', 'RICARDOCUNHA29@GMAIL.COM', NULL, NULL, NULL, NULL),
(338, 'DAYANA DA SILVA PEREIRA', 3133, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$vIMVRf0cwU2xyLUQGase5eLze90KXpie9yFwGSDR7wWN447EEUGhW', 'DAYANAPEREIRA87@GMAIL.COM', NULL, NULL, NULL, NULL),
(339, 'LEONARDO FERNANDO DE MORAIS SILVA', 3134, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$lmE8C8S.6mek3DqcmNql8Oc0gtQo8iagvCyxSaSA94xFyltKZ87PS', 'LEOTHEVINE@GMAIL.COM', NULL, NULL, NULL, NULL),
(340, 'LAURA OLIVEIRA VICCO', 3135, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$w76ChX9pZIMdq53Wq/SZzuGQ1U4gz/RgDkpNBBer4vIp6YFB0hdCS', 'L.VICCO@GMAIL.COM', NULL, NULL, NULL, NULL),
(341, 'FLAVIO RODRIGUES GOMES', 3136, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$EqyRh5Mj5IAEv1hUccSxc.ZbgRT7AuCgAG..ce2Co/Jbx5WWxVn4a', 'FLAVIO.RODRIGUESGOMES@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(342, 'LEANDRO DIONISIO DA SILVA', 3137, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$MUe.4Q4ljEuxCqTHLEw.7.DGt/kQbd/N6/UUf7EDw9r7d0xkrv84i', 'CRISTINA.SILVA.PERRI@GMAIL.COM', NULL, NULL, NULL, NULL),
(343, 'ROGERIO JOSE DA COSTA', 3138, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$J9PtWlEw4N4o6a8z3lawDe3CHbi8fOJI/GC.iJ159ceHYtN4e307i', 'ROGERIOJCOSTA@YAHOO.COM.BR', NULL, NULL, NULL, NULL),
(344, 'LEANDRO DE VIETRO', 3141, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$SvoeKuPUGSh2xvEJ7JoCTOm5mCRPnymAAhxbY28m38VxbUlVTUsB6', 'LVIETRO@HOTMAIL.COM', NULL, NULL, NULL, NULL),
(345, 'RUI MARIO GOMES TEIXEIRA', 3142, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$vk6vPd0oigVc9Qzy2SkY0emcX1BsJ2tc.7JIeb874m1L3hXsb6..G', 'RUIMARIOGOMES@GMAIL.COM', NULL, NULL, NULL, NULL),
(346, 'JOSE CARLOS DE OLIVEIRA', 3143, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$lQvkzZFBCvYn4XCmlpHp0.47NP2zv6Xe6hOc7uetaABTwzUocYzb2', 'JOSE.OLIVEIRA@MMCM.COM.BR', NULL, NULL, NULL, NULL),
(347, 'GISSELE DE DEUS PEREIRA', 3144, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$b.68l7QTpbWkIe49JTBKI.dHtus52ybbGGOfOPU4bN8mpctCOjcNW', 'GISSELE.DDP@GMAIL.COM', NULL, NULL, NULL, NULL),
(348, 'ANA CARLA BORGES AMBROSIO', 3145, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$bAFVYTsor.zpM07JxHtbW.062uMvpcdd2gUo.YGf8l0Q.MrEXxDpK', 'ANACARLAAMBROSIO@GMAIL.COM', NULL, NULL, NULL, NULL),
(349, 'DOUGLAS JOSE PEREZ DA SILVA', 3147, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$HfgPKPZ/xoAT1vdLfs02ZOHs7jaB7o3I2lmyFfDo2aJuNW3UC7oEy', 'DOUGLASJPEREZSILVA@GMAIL.COM', NULL, NULL, NULL, NULL),
(350, 'MARCUS VINICIUS SANTOS SALLES', 3148, 3, 'MORADOR', '2024-12-18 00:49:28', '$2y$10$FTlkz9HlJJGYEindUG6zzuPrSctEFmEf6dcixK29AATMJTKusuccK', 'VINNYSALLES240790@GMAIL.COM', NULL, NULL, NULL, NULL),
(352, 'MICHELL DUARTE DE OLIVEIRA', 194, 1, 'SINDICO', '2024-12-23 06:52:48', '$2y$10$p9CXSmR3ZWDn53hzo62WK.Ncc5C8bXpKH2gV.PSs.ND6mviJGyDWm', 'MICHELL.OLIVEIRA@CODEMAZE.COM.BR', '', NULL, 'eyJ1c2VyX2lkIjozNTIsImV4cCI6MTc0MDQ1MTEzMn0uNmQ0NDFkZmEzYzVhMGY0NjRmNGJiZjFiY2NjNjY4ZDZlNmI0MmNmOTE5YjU0ZDY2Y2IxMjg4MmJhOTlmNWVkMQ==', NULL),
(354, 'PARCEIRO', 2000, 1, 'PARCEIRO', '2025-01-01 11:36:27', '$2y$10$FST.W/BEWIR9ufb8ll11YOmQphCri9ftXwEQi9NffasMUEJvPXCtG', 'PARCEIRO@CODEMAZE.COM.BR', NULL, NULL, NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `CON_CONCILIACAO`
--
ALTER TABLE `CON_CONCILIACAO`
  ADD PRIMARY KEY (`CON_IDCONCILIACAO`);

--
-- Índices de tabela `ENC_ENCOMENDA`
--
ALTER TABLE `ENC_ENCOMENDA`
  ADD PRIMARY KEY (`ENC_IDENCOMENDA`);

--
-- Índices de tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `FUR_FUNDO_RESERVA`
--
ALTER TABLE `FUR_FUNDO_RESERVA`
  ADD PRIMARY KEY (`FUR_IDFUNDO_RESERVA`);

--
-- Índices de tabela `LIS_LISTACONVIDADOS`
--
ALTER TABLE `LIS_LISTACONVIDADOS`
  ADD PRIMARY KEY (`LIS_IDLISTACONVIDADOS`);

--
-- Índices de tabela `LOG_LOGSISTEMA`
--
ALTER TABLE `LOG_LOGSISTEMA`
  ADD PRIMARY KEY (`LOG_IDLOG`);

--
-- Índices de tabela `PUB_PUBLICIDADE`
--
ALTER TABLE `PUB_PUBLICIDADE`
  ADD PRIMARY KEY (`PUB_IDPUBLICIDADE`);

--
-- Índices de tabela `REC_RECLAMACAO`
--
ALTER TABLE `REC_RECLAMACAO`
  ADD PRIMARY KEY (`REC_IDRECLAMACAO`);

--
-- Índices de tabela `REP_REPORT`
--
ALTER TABLE `REP_REPORT`
  ADD PRIMARY KEY (`REP_IDREPORT`);

--
-- Índices de tabela `USU_USUARIO`
--
ALTER TABLE `USU_USUARIO`
  ADD PRIMARY KEY (`USU_IDUSUARIO`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `CON_CONCILIACAO`
--
ALTER TABLE `CON_CONCILIACAO`
  MODIFY `CON_IDCONCILIACAO` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=306;

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `FUR_FUNDO_RESERVA`
--
ALTER TABLE `FUR_FUNDO_RESERVA`
  MODIFY `FUR_IDFUNDO_RESERVA` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `LIS_LISTACONVIDADOS`
--
ALTER TABLE `LIS_LISTACONVIDADOS`
  MODIFY `LIS_IDLISTACONVIDADOS` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT de tabela `LOG_LOGSISTEMA`
--
ALTER TABLE `LOG_LOGSISTEMA`
  MODIFY `LOG_IDLOG` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de tabela `PUB_PUBLICIDADE`
--
ALTER TABLE `PUB_PUBLICIDADE`
  MODIFY `PUB_IDPUBLICIDADE` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `REC_RECLAMACAO`
--
ALTER TABLE `REC_RECLAMACAO`
  MODIFY `REC_IDRECLAMACAO` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `REP_REPORT`
--
ALTER TABLE `REP_REPORT`
  MODIFY `REP_IDREPORT` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `USU_USUARIO`
--
ALTER TABLE `USU_USUARIO`
  MODIFY `USU_IDUSUARIO` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=355;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
