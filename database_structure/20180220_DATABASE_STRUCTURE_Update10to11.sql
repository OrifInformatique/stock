-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 20 fév. 2018 à 10:26
-- Version du serveur :  10.1.25-MariaDB
-- Version de PHP :  7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `stock`
--

-- --------------------------------------------------------

--
-- Structure de la table `inventory_control`
--

CREATE TABLE `inventory_control` (
  `inventory_control_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `controller_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour la table `inventory_control`
--
ALTER TABLE `inventory_control`
  ADD PRIMARY KEY (`inventory_control_id`),
  ADD KEY `fk_inventory_control_item_id` (`item_id`),
  ADD KEY `fk_inventory_control_controller_id` (`controller_id`);

--
-- AUTO_INCREMENT pour la table `inventory_control`
--
ALTER TABLE `inventory_control`
  MODIFY `inventory_control_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour la table `inventory_control`
--
ALTER TABLE `inventory_control`
  ADD CONSTRAINT `fk_inventory_control_controller_id` FOREIGN KEY (`controller_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `fk_inventory_control_item_id` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
