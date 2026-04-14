-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2026 at 05:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `progettophp2`
--

-- --------------------------------------------------------

--
-- Table structure for table `anagrafica`
--

CREATE TABLE IF NOT EXISTS `anagrafica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `cognome` varchar(100) DEFAULT NULL,
  `sesso` varchar(1) NOT NULL,
  `data_nascita` date NOT NULL,
  `indirizzo` varchar(100) NOT NULL,
  `cap` varchar(100) NOT NULL,
  `citta` varchar(100) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `cellulare` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `attivo` int(11) NOT NULL DEFAULT 1,
  `canc` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anagrafica`
--

INSERT INTO `anagrafica` (`id`, `nome`, `cognome`, `sesso`, `data_nascita`, `indirizzo`, `cap`, `citta`, `provincia`, `telefono`, `cellulare`, `email`, `attivo`, `canc`) VALUES
(1, '', '', '', '0000-00-00', '', '', '', '', '', '', '', 1, 1),
(2, 'Lazar', 'Ionut-Narcis', 'M', '2003-06-08', 'Via Madoninna 2, 2', '33010', 'TAVAGNACCO', 'UD', '3513702085', '3513702085', 'lazarnarcis1337@gmail.com', 1, 0),
(3, '', '', '', '0000-00-00', '', '', '', '', '', '', '', 1, 1),
(4, 'Narcis', 'Narcis', 'M', '2001-01-01', 'Via Umbria, 70', '65100', 'Pescara', 'PE', '3884706065', '', 'lazarnarcis1337@gmail.com', 1, 1),
(5, '', '', '', '0000-00-00', '', '', '', '', '', '', '', 1, 1),
(6, 'Narcis2', 'Narcis3', 'M', '2003-12-12', 'Via Umbria, 70', '65100', 'Pescara', 'PE', '3884706111', '', 'lazarnarcis1337@gmail.com', 1, 0),
(7, '1', '1', '1', '0000-00-00', '1', '1', '1', '1', '1', '1', '1', 1, 1),
(8, 'Prova', '1', '1', '0000-00-00', '1', '1', '1', '1', '1', '1', '1', 1, 1),
(9, 'Prova2', 'Prova2', 'F', '2003-06-08', 'Via Umbria, 70', '65100', 'Pescara', 'PE', '3884706065', '', 'lazarnarcis1337@gmail.com', 1, 0),
(10, 'Prova2', 'Prova2', '', '0000-00-00', 'Via Umbria, 70', '65100', 'Pescara', 'PE', '3884706065', '', 'lazarnarcis1337@gmail.com', 1, 1),
(11, 'Prova3', 'Prova3', '', '0000-00-00', 'Via Umbria, 70', '65100', 'Pescara', 'PE', '3884706065', '', 'lazarnarcis1337@gmail.com', 1, 1),
(12, 'Prova4', 'Prova4', '', '0000-00-00', 'Via Umbria, 70', '65100', 'Pescara', 'PE', '3884706065', '', 'lazarnarcis1337@gmail.com', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voce` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `attivo` int(11) NOT NULL,
  `canc` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `voce`, `url`, `attivo`, `canc`) VALUES
(1, 'Anagrafica', 'anagrafica.php', 1, 0),
(2, 'Contatti', 'contatti.php', 1, 0),
(3, 'Utenti', 'utenti.php', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `utenti`
--

CREATE TABLE IF NOT EXISTS `utenti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `attivo` int(11) NOT NULL DEFAULT 1,
  `canc` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utenti`
--

INSERT INTO `utenti` (`id`, `username`, `password`, `email`, `attivo`, `canc`) VALUES
(1, 'fabio', '*3A726CE5CD4E18999556021402F915ABECFBD77F', 'fabio.brigazzi@slashschool.it', 1, 0),
(2, 'narcis', '*EAD9B0CBCA3C1CDE806F6DDBC7D9E30F8648D013', 'lazarnarcis1337@gmail.com', 1, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
