-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 06-Abr-2018 às 13:36
-- Versão do servidor: 5.7.18-1
-- PHP Version: 7.0.20-2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `texto` varchar(200) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT '0',
  `dislikes` int(11) NOT NULL DEFAULT '0',
  `id_autor` int(10) UNSIGNED NOT NULL,
  `id_comentario` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_publicacao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `comentarios`
--

INSERT INTO `comentarios` (`id`, `texto`, `likes`, `dislikes`, `id_autor`, `id_comentario`, `id_publicacao`) VALUES
(1, 'cheguei', 1, 0, 1, 0, 1),
(2, 'cheguei chegando', 1, 0, 2, 1, 1),
(3, 'ninguem responde?', 1, 0, 2, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentarios_likes`
--

CREATE TABLE `comentarios_likes` (
  `id` int(11) NOT NULL,
  `id_comentario` int(11) NOT NULL,
  `id_autor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `comentarios_likes`
--

INSERT INTO `comentarios_likes` (`id`, `id_comentario`, `id_autor`) VALUES
(1, 32, 3),
(2, 34, 3),
(4, 25, 3),
(6, 32, 2),
(7, 32, 1),
(8, 35, 1),
(10, 25, 1),
(11, 42, 1),
(13, 38, 1),
(14, 37, 1),
(15, 44, 1),
(17, 44, 2),
(20, 25, 2),
(21, 47, 3),
(22, 2, 1),
(25, 1, 1),
(26, 1, 2),
(27, 2, 2),
(28, 3, 2);

--
-- Acionadores `comentarios_likes`
--
DELIMITER $$
CREATE TRIGGER `acrescenta_like_comentario` BEFORE INSERT ON `comentarios_likes` FOR EACH ROW BEGIN
	UPDATE comentarios SET likes = likes+1 WHERE id = NEW.id_comentario;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `decrementa_like_comentario` AFTER DELETE ON `comentarios_likes` FOR EACH ROW BEGIN
	UPDATE comentarios SET likes = likes-1 WHERE id = OLD.id_comentario;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `midia_publicacao`
--

CREATE TABLE `midia_publicacao` (
  `id` int(11) NOT NULL,
  `id_publicacao` int(11) NOT NULL,
  `url` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `publicacao`
--

CREATE TABLE `publicacao` (
  `id` int(11) NOT NULL,
  `id_autor` int(10) UNSIGNED NOT NULL,
  `text` varchar(200) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT '0',
  `dislikes` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `publicacao`
--

INSERT INTO `publicacao` (`id`, `id_autor`, `text`, `likes`, `dislikes`, `created_at`, `updated_at`) VALUES
(1, 1, '', 3, 0, '2018-04-06 01:42:34', '2018-04-06 01:42:34');

-- --------------------------------------------------------

--
-- Estrutura da tabela `publicacao_likes`
--

CREATE TABLE `publicacao_likes` (
  `id` int(11) NOT NULL,
  `id_publicacao` int(11) NOT NULL,
  `id_autor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `publicacao_likes`
--

INSERT INTO `publicacao_likes` (`id`, `id_publicacao`, `id_autor`) VALUES
(8, 1, 2),
(9, 1, 1),
(11, 1, 3);

--
-- Acionadores `publicacao_likes`
--
DELIMITER $$
CREATE TRIGGER `update_likes_publicacao` BEFORE INSERT ON `publicacao_likes` FOR EACH ROW BEGIN
	UPDATE publicacao SET likes = likes+1 WHERE id = NEW.id_publicacao;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_likes_publicacao_delete` AFTER DELETE ON `publicacao_likes` FOR EACH ROW BEGIN
	UPDATE publicacao SET likes = likes-1 WHERE id = OLD.id_publicacao;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(40) NOT NULL,
  `img` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `img`) VALUES
(1, 'Gabriel', '../assets/img/eu.jpg'),
(2, 'Ana', '../assets/img/ana.png'),
(3, 'Roberto', '../assets/img/roberto.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comentarios_likes`
--
ALTER TABLE `comentarios_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `midia_publicacao`
--
ALTER TABLE `midia_publicacao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `publicacao`
--
ALTER TABLE `publicacao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `publicacao_likes`
--
ALTER TABLE `publicacao_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `comentarios_likes`
--
ALTER TABLE `comentarios_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `midia_publicacao`
--
ALTER TABLE `midia_publicacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `publicacao`
--
ALTER TABLE `publicacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `publicacao_likes`
--
ALTER TABLE `publicacao_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
