-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24/05/2024 às 22:56
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `delta`
--
CREATE DATABASE IF NOT EXISTS `delta` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `delta`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `administrador`
--

CREATE TABLE `administrador` (
  `ADM_ID` int(11) NOT NULL,
  `ADM_NOME` varchar(500) NOT NULL,
  `ADM_EMAIL` varchar(500) NOT NULL,
  `ADM_SENHA` varchar(500) NOT NULL,
  `ADM_ATIVO` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `administrador`
--

INSERT INTO `administrador` (`ADM_ID`, `ADM_NOME`, `ADM_EMAIL`, `ADM_SENHA`, `ADM_ATIVO`) VALUES
(7, 'Leticia Alves', 'leticia@gmail.com', '12345', 1),
(8, 'Gabriel Martins', 'gabriel@gmail.com', '12345', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria`
--

CREATE TABLE `categoria` (
  `CATEGORIA_ID` int(11) NOT NULL,
  `CATEGORIA_NOME` varchar(500) NOT NULL,
  `CATEGORIA_DESC` varchar(8000) NOT NULL,
  `CATEGORIA_ATIVO` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categoria`
--

INSERT INTO `categoria` (`CATEGORIA_ID`, `CATEGORIA_NOME`, `CATEGORIA_DESC`, `CATEGORIA_ATIVO`) VALUES
(1, 'ps5', 'Tudo sobre ps5', 1),
(2, 'xbox', 'Tudo sobre xbox', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `PRODUTO_ID` int(11) NOT NULL,
  `PRODUTO_NOME` varchar(500) NOT NULL,
  `PRODUTO_DESC` varchar(8000) NOT NULL,
  `PRODUTO_PRECO` decimal(5,2) NOT NULL,
  `PRODUTO_DESCONTO` decimal(5,2) NOT NULL,
  `CATEGORIA_ID` int(11) NOT NULL,
  `PRODUTO_ATIVO` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`PRODUTO_ID`, `PRODUTO_NOME`, `PRODUTO_DESC`, `PRODUTO_PRECO`, `PRODUTO_DESCONTO`, `CATEGORIA_ID`, `PRODUTO_ATIVO`) VALUES
(36, 'God of War', 'Baseada em distintas mitologias, a história segue Kratos, um guerreiro espartano que foi levado a matar sua família por seu antigo mestre, o deus da guerra Ares.', 200.00, 20.00, 1, 0),
(37, 'Grand Theft Auto', 'A jogabilidade foca em um mundo aberto onde o jogador pode completar missões para progredir em uma história geral, bem como engajar em várias atividades secundárias. A maior parte da jogabilidade gira em torno de dirigir e atirar, com ocasionais elementos furtivos e role-playing', 300.00, 25.00, 1, 1),
(38, 'Minecraft', 'Seu objetivo é coletar recursos (madeira, rochas, minérios, carvão, alimentos) e construir ferramentas e abrigos cada vez melhores para sobreviver e se salvar dos monstros que surgem durante a noite. Mas não é só de sobrevivência que o jogo se trata. Minecraft é também sobre exploração e constante evolução.', 100.00, 20.00, 2, 1),
(39, 'Sonic', 'Sonic é notório por ser extremamente rápido, aventureiro, corajoso e extrovertido. Luta sempre pela justiça, liberdade, compaixão e pelos indefesos. Enfrenta todos os perigos para ajudar os outros, encarando tudo como um desafio. Mas gosta também de relaxar e descansar, mostrando-se também preguiçoso.', 100.00, 15.00, 2, 1),
(40, 'The Last of Us', 'The Last of Us é um jogo eletrônico pós-apocalíptico de ação-aventura e sobrevivência apresentado a partir de uma perspectiva em terceira pessoa. O jogador atravessa uma série de ambientes arruinados, passando por locais variados como cidades, florestas, edifícios e esgotos a fim de avançar pela história.', 300.00, 50.00, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto_estoque`
--

CREATE TABLE `produto_estoque` (
  `PRODUTO_ID` int(11) NOT NULL,
  `PRODUTO_QTD` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto_estoque`
--

INSERT INTO `produto_estoque` (`PRODUTO_ID`, `PRODUTO_QTD`) VALUES
(36, 100),
(37, 200),
(38, 300),
(39, 100),
(40, 200);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto_imagem`
--

CREATE TABLE `produto_imagem` (
  `IMAGEM_ID` int(11) NOT NULL,
  `IMAGEM_ORDEM` int(11) NOT NULL,
  `PRODUTO_ID` int(11) NOT NULL,
  `IMAGEM_URL` varchar(8000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto_imagem`
--

INSERT INTO `produto_imagem` (`IMAGEM_ID`, `IMAGEM_ORDEM`, `PRODUTO_ID`, `IMAGEM_URL`) VALUES
(35, 1, 36, 'https://upload.wikimedia.org/wikipedia/pt/7/7e/God_of_War_2_capa.png'),
(36, 2, 36, 'https://upload.wikimedia.org/wikipedia/pt/5/53/God_of_War_2005_capa.png'),
(37, 3, 36, 'https://upload.wikimedia.org/wikipedia/pt/a/a5/God_of_War_Ragnar%C3%B6k_capa.jpg'),
(38, 4, 37, 'https://upload.wikimedia.org/wikipedia/pt/6/68/Grand_Theft_Auto_Vice_City_capa.png'),
(39, 5, 37, 'https://upload.wikimedia.org/wikipedia/pt/d/d3/Grand_Theft_Auto_San_Andreas_capa.png'),
(40, 6, 37, 'https://s2-techtudo.glbimg.com/emive1thVR6x2SyhvaOZ5_kR-EY=/0x0:300x371/984x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_08fbf48bc0524877943fe86e43087e7a/internal_photos/bs/2021/1/9/8cOmg9TkaB2PgkS1sUjQ/2013-04-02-gta5-capa-rockstar-.jpg'),
(41, 7, 38, 'https://upload.wikimedia.org/wikipedia/pt/9/9c/Minecraft_capa.png'),
(42, 8, 39, 'https://upload.wikimedia.org/wikipedia/pt/8/84/Sonic_Lost_World_capa.png'),
(43, 9, 40, 'https://upload.wikimedia.org/wikipedia/pt/b/be/The_Last_of_Us_capa.png');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`ADM_ID`);

--
-- Índices de tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`CATEGORIA_ID`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`PRODUTO_ID`);

--
-- Índices de tabela `produto_estoque`
--
ALTER TABLE `produto_estoque`
  ADD UNIQUE KEY `PRODUTO_ID` (`PRODUTO_ID`);

--
-- Índices de tabela `produto_imagem`
--
ALTER TABLE `produto_imagem`
  ADD PRIMARY KEY (`IMAGEM_ID`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `administrador`
--
ALTER TABLE `administrador`
  MODIFY `ADM_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `CATEGORIA_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `PRODUTO_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `produto_imagem`
--
ALTER TABLE `produto_imagem`
  MODIFY `IMAGEM_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
