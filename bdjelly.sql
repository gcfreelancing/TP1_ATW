-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08-Fev-2024 às 16:51
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bdjelly`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores`
--

CREATE TABLE `utilizadores` (
  `codigo` int(4) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `data` date NOT NULL,
  `password` varchar(50) NOT NULL,
  `cargo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `utilizadores`
--

INSERT INTO `utilizadores` (`codigo`, `nome`, `email`, `data`, `password`, `cargo`) VALUES
(1013, 'José Monteiro', 'jaam@ispgaya.pt', '1974-04-25', 'ola123', 'manager'),
(1014, 'Gabriel Gomes Costa', 'ispg2021100493@ispgaya.pt', '2001-11-02', '123456789', 'user'),
(1031, 'Margarida Fazenda', 'ispg2021101983@ispgaya.pt', '2001-11-06', '12345', 'user'),
(1035, 'Leonardo Moraes', 'ispg2021104395@ispgaya.pt', '2001-11-05', '12345', 'user'),
(1036, 'Hugo Monteiro', 'ispg2021101763@ispgaya.pt', '2001-06-12', '12345', 'user'),
(1037, 'Ítalo Francisco', 'ispg20210000@ispgaya.pt', '2002-03-20', '12345', 'user'),
(1038, 'Luís Lima', 'luislimalimao@gmail.pt', '2002-12-02', '12345', 'user'),
(1039, 'Lurdes Maria', 'lurdesm@gmail.pt', '1965-12-12', '12345', 'user'),
(1040, 'Maria Antonietta', 'Antonietta@maria.pt', '1755-11-21', '12345', 'user'),
(1041, 'Leonardo DiCaprio', 'Leonardo@DiCaprio.pt', '1974-11-11', '12345', 'user'),
(1042, 'Johnny Depp', 'Johnny@Depp.pt', '1963-06-09', '12345', 'user'),
(1043, 'Leonardo da Vinci', 'Vinci@Leonardo.pt', '1452-04-15', '12345', 'user'),
(1044, 'Angelina Jolie', 'Jolie@hotmail.pt', '1975-07-04', '12345', 'user'),
(1045, 'George Clooney', 'PatoClooney@hotmail.com', '1961-05-06', '12345', 'user'),
(1046, 'Pato Donald', 'trueduck@disney.pt', '1354-04-13', '12345', 'user'),
(1047, 'Snoopy', 'Snoopy@dog.pt', '1542-04-23', '12345', 'user'),
(1048, 'Tio Patinhas', 'ricalhaco@dinheiro.pt', '1743-12-23', '12345', 'user'),
(1049, 'Homem Aranha', 'spider@fear.pt', '1367-05-24', '12345', 'user'),
(1050, 'Batman', 'Batman@dc.pt', '1967-12-23', '12345', 'user'),
(1051, 'Deadpool', 'Deadpool@pooldead.pt', '1876-11-23', '12345', 'user'),
(1052, 'Slade Wilson', 'Slade@slade.pt', '1875-09-10', '12345', 'user'),
(1053, 'Robin', 'Robin@original.pt', '1936-11-06', '12345', 'user'),
(1054, 'Blue', 'azul@cor.pt', '1983-06-23', '12345', 'user'),
(1055, 'Audrey Hepburn', 'audrey@hollywood.pt', '1929-05-04', '12345', 'user'),
(1056, 'Jenna Ortega', 'jenna@gmail.pt', '2003-02-15', '12345', 'user'),
(1057, 'Billie Eilish', 'Eilish@outlook.pt', '2001-12-18', '12345', 'user'),
(1058, 'Madison Beer', 'bear@cute.pt', '1922-04-14', '12345', 'user'),
(1059, 'Avril Lagvine', 'AL@hotmail.pt', '1999-08-27', '12345', 'user'),
(1060, 'Selena Gomez', 'gomez@gmail.pt', '1998-12-22', '12345', 'user');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`codigo`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `codigo` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1065;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
