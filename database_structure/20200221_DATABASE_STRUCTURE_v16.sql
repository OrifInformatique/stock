-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 21 fév. 2020 à 09:34
-- Version du serveur :  10.1.34-MariaDB
-- Version de PHP :  7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données :  `stock`
--
CREATE DATABASE IF NOT EXISTS `stock` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `stock`;

-- --------------------------------------------------------

--
-- Structure de la table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `inventory_control`
--

CREATE TABLE IF NOT EXISTS `inventory_control` (
  `inventory_control_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `controller_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`inventory_control_id`),
  KEY `fk_inventory_control_item_id` (`item_id`),
  KEY `fk_inventory_control_controller_id` (`controller_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_prefix` varchar(45) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `serial_number` varchar(45) DEFAULT NULL,
  `buying_price` float DEFAULT NULL,
  `buying_date` date DEFAULT NULL,
  `warranty_duration` int(11) DEFAULT NULL,
  `remarks` text,
  `linked_file` varchar(255) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `supplier_ref` varchar(45) DEFAULT NULL,
  `created_by_user_id` int(11) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by_user_id` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `checked_by_user_id` int(11) DEFAULT NULL,
  `checked_date` datetime DEFAULT NULL,
  `stocking_place_id` int(11) DEFAULT NULL,
  `item_condition_id` int(11) DEFAULT NULL,
  `item_group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_id`),
  KEY `fk_created_by_user_id_idx` (`created_by_user_id`),
  KEY `fk_stocking_place_id_idx` (`stocking_place_id`),
  KEY `fk_modified_by_user_id_idx` (`modified_by_user_id`),
  KEY `fk_item_condition_id_idx` (`item_condition_id`),
  KEY `fk_supplier_id_idx` (`supplier_id`),
  KEY `fk_checked_by_user_id_idx` (`checked_by_user_id`),
  KEY `fk_item_group_id_idx` (`item_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `item_condition`
--

CREATE TABLE IF NOT EXISTS `item_condition` (
  `item_condition_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`item_condition_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `item_condition`
--

INSERT INTO `item_condition` (`item_condition_id`, `name`) VALUES
(10, 'Fonctionnel'),
(30, 'Défectueux'),
(40, 'Plus disponible');

-- --------------------------------------------------------

--
-- Structure de la table `item_group`
--

CREATE TABLE IF NOT EXISTS `item_group` (
  `item_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `short_name` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`item_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `item_tag`
--

CREATE TABLE IF NOT EXISTS `item_tag` (
  `item_tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `short_name` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`item_tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `item_tag_link`
--

CREATE TABLE IF NOT EXISTS `item_tag_link` (
  `item_tag_link_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_tag_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY (`item_tag_link_id`),
  KEY `fk_item_tag_id_idx` (`item_tag_id`),
  KEY `fk_item_id_idx` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `loan`
--

CREATE TABLE IF NOT EXISTS `loan` (
  `loan_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `item_localisation` varchar(255) DEFAULT NULL,
  `remarks` text,
  `planned_return_date` date DEFAULT NULL,
  `real_return_date` date DEFAULT NULL,
  `item_id` int(11) NOT NULL,
  `loan_by_user_id` int(11) NOT NULL,
  `loan_to_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`loan_id`),
  KEY `fk_loan_item_id_idx` (`item_id`),
  KEY `fk_loan_by_user_id_idx` (`loan_by_user_id`),
  KEY `fk_loan_to_user_id_idx` (`loan_to_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `stocking_place`
--

CREATE TABLE IF NOT EXISTS `stocking_place` (
  `stocking_place_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `short` varchar(45) NOT NULL,
  PRIMARY KEY (`stocking_place_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `address_line1` varchar(100) DEFAULT NULL,
  `address_line2` varchar(100) DEFAULT NULL,
  `zip` varchar(45) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `tel` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(45) DEFAULT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_type_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`user_id`),
  KEY `fk_user_type_id_idx` (`user_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user_type`
--

CREATE TABLE IF NOT EXISTS `user_type` (
  `user_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `access_level` int(11) NOT NULL,
  PRIMARY KEY (`user_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user_type`
--

INSERT INTO `user_type` (`user_type_id`, `name`, `access_level`) VALUES
(1, 'Invite', 1),
(2, 'Observation', 2),
(3, 'Formation', 4),
(4, 'MSP', 8),
(5, 'Administrateur', 16);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `inventory_control`
--
ALTER TABLE `inventory_control`
  ADD CONSTRAINT `fk_inventory_control_controller_id` FOREIGN KEY (`controller_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `fk_inventory_control_item_id` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`);

--
-- Contraintes pour la table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `fk_checked_by_user_id` FOREIGN KEY (`checked_by_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_created_by_user_id` FOREIGN KEY (`created_by_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_item_condition_id` FOREIGN KEY (`item_condition_id`) REFERENCES `item_condition` (`item_condition_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_item_group_id` FOREIGN KEY (`item_group_id`) REFERENCES `item_group` (`item_group_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_modified_by_user_id` FOREIGN KEY (`modified_by_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_stocking_place_id` FOREIGN KEY (`stocking_place_id`) REFERENCES `stocking_place` (`stocking_place_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_supplier_id` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `item_tag_link`
--
ALTER TABLE `item_tag_link`
  ADD CONSTRAINT `fk_item_id` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_item_tag_id` FOREIGN KEY (`item_tag_id`) REFERENCES `item_tag` (`item_tag_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `loan`
--
ALTER TABLE `loan`
  ADD CONSTRAINT `fk_loan_by_user_id` FOREIGN KEY (`loan_by_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_loan_item_id` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_loan_to_user_id` FOREIGN KEY (`loan_to_user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_type_id` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`user_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;
