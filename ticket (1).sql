-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 13 fév. 2023 à 08:45
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ticket`
--

-- --------------------------------------------------------

--
-- Structure de la table `table_admin`
--

DROP TABLE IF EXISTS `table_admin`;
CREATE TABLE IF NOT EXISTS `table_admin` (
  `Admin_ID` int(10) NOT NULL AUTO_INCREMENT,
  `Admin_Email` varchar(150) NOT NULL,
  `Admin_Password` varchar(200) NOT NULL,
  `Admin_Date` datetime NOT NULL,
  `Admin_Update` datetime NOT NULL,
  PRIMARY KEY (`Admin_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `table_admin`
--

INSERT INTO `table_admin` (`Admin_ID`, `Admin_Email`, `Admin_Password`, `Admin_Date`, `Admin_Update`) VALUES
(1, 'florian.mancieri@campuscci18.fr', 'a0b846f22d7a99c6daf25cf8e03472114dcb4744', '2023-01-27 11:41:47', '2023-01-27 11:41:47');

-- --------------------------------------------------------

--
-- Structure de la table `table_categorie`
--

DROP TABLE IF EXISTS `table_categorie`;
CREATE TABLE IF NOT EXISTS `table_categorie` (
  `Categorie_ID` int(10) NOT NULL AUTO_INCREMENT,
  `Categorie_Nom` varchar(250) NOT NULL,
  PRIMARY KEY (`Categorie_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `table_categorie`
--

INSERT INTO `table_categorie` (`Categorie_ID`, `Categorie_Nom`) VALUES
(2, 'démo');

-- --------------------------------------------------------

--
-- Structure de la table `table_client`
--

DROP TABLE IF EXISTS `table_client`;
CREATE TABLE IF NOT EXISTS `table_client` (
  `Client_ID` int(10) NOT NULL AUTO_INCREMENT,
  `Client_Nom` varchar(250) NOT NULL,
  `Client_Prenom` varchar(250) NOT NULL,
  `Client_Email` varchar(250) NOT NULL,
  `Client_Password` varchar(250) NOT NULL,
  `Client_Credit` int(10) NOT NULL,
  PRIMARY KEY (`Client_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `table_client`
--

INSERT INTO `table_client` (`Client_ID`, `Client_Nom`, `Client_Prenom`, `Client_Email`, `Client_Password`, `Client_Credit`) VALUES
(2, 'Deroche', 'Maxime', 'maxime@cci18.fr', '335d7c6c2b62dff18ff1aeb61095a024a9cb3414', 150),
(3, 'Op', 'Pascal', 'pascal.op@gmail.com', 'waLisQPb1PFXj', 5353);

-- --------------------------------------------------------

--
-- Structure de la table `table_commande`
--

DROP TABLE IF EXISTS `table_commande`;
CREATE TABLE IF NOT EXISTS `table_commande` (
  `Commande_ID` int(10) NOT NULL AUTO_INCREMENT,
  `Commande_Client_ID` int(10) NOT NULL,
  `Commande_Date` date NOT NULL,
  `Commande_Montant` int(10) NOT NULL,
  `Commande_Etat` enum('en attente','valide','annule') DEFAULT NULL,
  PRIMARY KEY (`Commande_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `table_partie`
--

DROP TABLE IF EXISTS `table_partie`;
CREATE TABLE IF NOT EXISTS `table_partie` (
  `Partie_ID` int(10) NOT NULL AUTO_INCREMENT,
  `Partie_Ticket_ID` int(10) NOT NULL,
  `Partie_Valeur` int(10) NOT NULL,
  `Partie_Date` date DEFAULT NULL,
  `Partie_Etat` enum('0','1') DEFAULT NULL,
  PRIMARY KEY (`Partie_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `table_partie`
--

INSERT INTO `table_partie` (`Partie_ID`, `Partie_Ticket_ID`, `Partie_Valeur`, `Partie_Date`, `Partie_Etat`) VALUES
(1, 10, 5, '2023-01-31', '0'),
(2, 10, 5, '2023-01-31', '0'),
(3, 10, 5, '2023-01-31', '0'),
(4, 10, 5, '2023-01-31', '0'),
(5, 10, 5, '2023-01-31', '0'),
(6, 10, 5, '2023-01-31', '0'),
(7, 10, 5, '2023-01-31', '0'),
(8, 10, 5, '2023-01-31', '0'),
(9, 10, 5, '2023-01-31', '0'),
(10, 10, 5, '2023-01-31', '0'),
(11, 10, 5, '2023-01-31', '0'),
(12, 10, 1, '2023-01-31', '0'),
(13, 10, 1, '2023-01-31', '0'),
(14, 10, 1, '2023-01-31', '0'),
(15, 10, 1, '2023-01-31', '0'),
(16, 10, 1, '2023-01-31', '0'),
(17, 10, 1, '2023-01-31', '0'),
(18, 10, 1, '2023-01-31', '0'),
(19, 10, 1, '2023-01-31', '0'),
(20, 10, 1, '2023-01-31', '0'),
(21, 10, 1, '2023-01-31', '0'),
(22, 10, 1, '2023-01-31', '0'),
(23, 10, 1, '2023-01-31', '0'),
(24, 10, 1, '2023-01-31', '0'),
(25, 10, 1, '2023-01-31', '0'),
(26, 10, 1, '2023-01-31', '0'),
(27, 10, 1, '2023-01-31', '0'),
(28, 10, 1, '2023-01-31', '0'),
(29, 10, 1, '2023-01-31', '0'),
(30, 10, 1, '2023-01-31', '0'),
(31, 10, 1, '2023-01-31', '0'),
(32, 10, 1, '2023-01-31', '0');

-- --------------------------------------------------------

--
-- Structure de la table `table_ticket`
--

DROP TABLE IF EXISTS `table_ticket`;
CREATE TABLE IF NOT EXISTS `table_ticket` (
  `Ticket_ID` int(10) NOT NULL AUTO_INCREMENT,
  `Ticket_Categorie_ID` int(10) NOT NULL,
  `Ticket_Nom` varchar(250) NOT NULL,
  `Ticket_Prix` int(10) NOT NULL,
  `Ticket_Nombre` int(10) DEFAULT NULL,
  PRIMARY KEY (`Ticket_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `table_ticket`
--

INSERT INTO `table_ticket` (`Ticket_ID`, `Ticket_Categorie_ID`, `Ticket_Nom`, `Ticket_Prix`, `Ticket_Nombre`) VALUES
(1, 2, 'Test', 10, 500),
(2, 2, 'Test', 10, 500),
(3, 2, 'demo', 50, 10),
(4, 2, 'demo', 50, 10),
(5, 2, 'demo', 50, 10),
(6, 2, 'demo', 50, 10),
(7, 2, 'demo', 50, 10),
(8, 2, 'demo', 50, 10),
(9, 2, 'demo', 50, 10),
(10, 2, 'demo', 50, 10);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
