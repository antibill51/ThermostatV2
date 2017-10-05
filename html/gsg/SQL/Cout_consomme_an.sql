-- phpMyAdmin SQL Dump
-- version 4.4.13.1
-- http://www.phpmyadmin.net
--
-- Client :  
-- Généré le :  Mar 20 Octobre 2015 à 14:15
-- Version du serveur :  5.5.43-0+deb7u1-log
-- Version de PHP :  5.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `domotique`
--

-- --------------------------------------------------------

--
-- Structure de la vue `Cout_consomme_an`
--

CREATE ALGORITHM=UNDEFINED VIEW `Cout_consomme_an` AS select year(`domotique_granules_conso`.`time`) AS `annee`,sum(`domotique_granules_conso`.`value`) AS `totalconso`,sum(`domotique_granules_stock`.`prixsac`) AS `totalcout` from (`domotique_granules_conso` join `domotique_granules_stock` on((`domotique_granules_conso`.`id_stock` = `domotique_granules_stock`.`id`))) group by year(`domotique_granules_conso`.`time`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
