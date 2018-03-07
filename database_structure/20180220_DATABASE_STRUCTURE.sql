-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 21 fév. 2018 à 14:13
-- Version du serveur :  10.1.29-MariaDB
-- Version de PHP :  7.1.12

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
CREATE DATABASE IF NOT EXISTS `stock` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `stock`;

-- --------------------------------------------------------

--
-- Structure de la table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

CREATE TABLE `item` (
  `item_id` int(11) NOT NULL,
  `inventory_number` varchar(45) DEFAULT NULL,
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
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_by_user_id` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `checked_by_user_id` int(11) DEFAULT NULL,
  `checked_date` datetime DEFAULT NULL,
  `stocking_place_id` int(11) DEFAULT NULL,
  `item_condition_id` int(11) DEFAULT NULL,
  `item_group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `item_condition`
--

CREATE TABLE `item_condition` (
  `item_condition_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `item_group`
--

CREATE TABLE `item_group` (
  `item_group_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `item_tag`
--

CREATE TABLE `item_tag` (
  `item_tag_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `item_tag_link`
--

CREATE TABLE `item_tag_link` (
  `item_tag_link_id` int(11) NOT NULL,
  `item_tag_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `loan`
--

CREATE TABLE `loan` (
  `loan_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `item_localisation` varchar(255) DEFAULT NULL,
  `remarks` text,
  `planned_return_date` date DEFAULT NULL,
  `real_return_date` date DEFAULT NULL,
  `item_id` int(11) NOT NULL,
  `loan_by_user_id` int(11) NOT NULL,
  `loan_to_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `stocking_place`
--

CREATE TABLE `stocking_place` (
  `stocking_place_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `short` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address_line1` varchar(100) DEFAULT NULL,
  `address_line2` varchar(100) DEFAULT NULL,
  `zip` varchar(45) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `tel` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_type_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user_type`
--

CREATE TABLE `user_type` (
  `user_type_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `access_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Index pour la table `inventory_control`
--
ALTER TABLE `inventory_control`
  ADD PRIMARY KEY (`inventory_control_id`),
  ADD KEY `fk_inventory_control_item_id` (`item_id`),
  ADD KEY `fk_inventory_control_controller_id` (`controller_id`);

--
-- Index pour la table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `fk_created_by_user_id_idx` (`created_by_user_id`),
  ADD KEY `fk_stocking_place_id_idx` (`stocking_place_id`),
  ADD KEY `fk_modified_by_user_id_idx` (`modified_by_user_id`),
  ADD KEY `fk_item_condition_id_idx` (`item_condition_id`),
  ADD KEY `fk_supplier_id_idx` (`supplier_id`),
  ADD KEY `fk_checked_by_user_id_idx` (`checked_by_user_id`),
  ADD KEY `fk_item_group_id_idx` (`item_group_id`);

--
-- Index pour la table `item_condition`
--
ALTER TABLE `item_condition`
  ADD PRIMARY KEY (`item_condition_id`);

--
-- Index pour la table `item_group`
--
ALTER TABLE `item_group`
  ADD PRIMARY KEY (`item_group_id`);

--
-- Index pour la table `item_tag`
--
ALTER TABLE `item_tag`
  ADD PRIMARY KEY (`item_tag_id`);

--
-- Index pour la table `item_tag_link`
--
ALTER TABLE `item_tag_link`
  ADD PRIMARY KEY (`item_tag_link_id`),
  ADD KEY `fk_item_tag_id_idx` (`item_tag_id`),
  ADD KEY `fk_item_id_idx` (`item_id`);

--
-- Index pour la table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`loan_id`),
  ADD KEY `fk_loan_item_id_idx` (`item_id`),
  ADD KEY `fk_loan_by_user_id_idx` (`loan_by_user_id`),
  ADD KEY `fk_loan_to_user_id_idx` (`loan_to_user_id`);

--
-- Index pour la table `stocking_place`
--
ALTER TABLE `stocking_place`
  ADD PRIMARY KEY (`stocking_place_id`);

--
-- Index pour la table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_user_type_id_idx` (`user_type_id`);

--
-- Index pour la table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`user_type_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `inventory_control`
--
ALTER TABLE `inventory_control`
  MODIFY `inventory_control_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `item_condition`
--
ALTER TABLE `item_condition`
  MODIFY `item_condition_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `item_group`
--
ALTER TABLE `item_group`
  MODIFY `item_group_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `item_tag`
--
ALTER TABLE `item_tag`
  MODIFY `item_tag_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `item_tag_link`
--
ALTER TABLE `item_tag_link`
  MODIFY `item_tag_link_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `loan`
--
ALTER TABLE `loan`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `stocking_place`
--
ALTER TABLE `stocking_place`
  MODIFY `stocking_place_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `user_type_id` int(11) NOT NULL AUTO_INCREMENT;

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
