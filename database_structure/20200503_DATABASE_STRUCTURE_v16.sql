-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 05 mars 2020 à 11:07
-- Version du serveur :  10.4.6-MariaDB
-- Version de PHP :  7.3.9

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
-- Structure de la table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('2ov58j012isvulgcn12ffnfkoaskscal', '::1', 1583398954, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538333339383935343b6974656d735f6c6973745f75726c7c733a33353a22687474703a2f2f6c6f63616c686f73742f73746f636b2f6974656d2f696e6465782f31223b61667465725f6c6f67696e5f72656469726563747c733a32333a22687474703a2f2f6c6f63616c686f73742f73746f636b2f223b757365725f69647c693a323b757365726e616d657c733a353a2261646d696e223b757365725f6163636573737c693a31363b6c6f676765645f696e7c623a313b706963747572655f7072656669787c733a343a2230353834223b7375626d69745f696d6167657c623a303b706963747572655f63616c6c6261636b7c733a33383a22687474703a2f2f6c6f63616c686f73742f73746f636b2f6974656d2f6d6f646966792f353834223b6974656d5f69647c733a333a22353836223b),
('4228o8i4g8o2qn6eqlhjcis6si6upj0s', '::1', 1583394274, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538333339343237343b6974656d735f6c6973745f75726c7c733a33353a22687474703a2f2f6c6f63616c686f73742f73746f636b2f6974656d2f696e6465782f31223b),
('5sb6pbihn12i09fnj45nli0g1v3vui9b', '::1', 1583394627, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538333339343632373b6974656d735f6c6973745f75726c7c733a35353a22687474703a2f2f6c6f63616c686f73742f73746f636b2f6974656d2f696e6465782f313f74733d26635b5d3d3130266f3d302661643d30223b61667465725f6c6f67696e5f72656469726563747c733a32333a22687474703a2f2f6c6f63616c686f73742f73746f636b2f223b757365725f69647c693a323b757365726e616d657c733a353a2261646d696e223b757365725f6163636573737c693a31363b6c6f676765645f696e7c623a313b),
('av42fdkbsvg5s4j8jmm5pto23imtrf9q', '::1', 1583395849, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538333339353834393b6974656d735f6c6973745f75726c7c733a33353a22687474703a2f2f6c6f63616c686f73742f73746f636b2f6974656d2f696e6465782f31223b61667465725f6c6f67696e5f72656469726563747c733a32333a22687474703a2f2f6c6f63616c686f73742f73746f636b2f223b757365725f69647c693a323b757365726e616d657c733a353a2261646d696e223b757365725f6163636573737c693a31363b6c6f676765645f696e7c623a313b706963747572655f7072656669787c733a343a2230343939223b7375626d69745f696d6167657c623a303b706963747572655f63616c6c6261636b7c733a33383a22687474703a2f2f6c6f63616c686f73742f73746f636b2f6974656d2f6d6f646966792f343939223b6974656d5f69647c733a333a22353836223b),
('ctu4hp3v987jnb4968uaea4vn9hammq7', '::1', 1583402038, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538333430323033383b6974656d735f6c6973745f75726c7c733a33353a22687474703a2f2f6c6f63616c686f73742f73746f636b2f6974656d2f696e6465782f31223b61667465725f6c6f67696e5f72656469726563747c733a32333a22687474703a2f2f6c6f63616c686f73742f73746f636b2f223b757365725f69647c693a323b757365726e616d657c733a353a2261646d696e223b757365725f6163636573737c693a31363b6c6f676765645f696e7c623a313b706963747572655f7072656669787c733a343a2230353739223b7375626d69745f696d6167657c623a303b706963747572655f63616c6c6261636b7c733a33383a22687474703a2f2f6c6f63616c686f73742f73746f636b2f6974656d2f6d6f646966792f353739223b6974656d5f69647c733a333a22353836223b),
('jsbnmiq4ba8qc7l1nbqrbcspliogjs4i', '::1', 1583395025, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538333339353032353b6974656d735f6c6973745f75726c7c733a33353a22687474703a2f2f6c6f63616c686f73742f73746f636b2f6974656d2f696e6465782f31223b61667465725f6c6f67696e5f72656469726563747c733a32333a22687474703a2f2f6c6f63616c686f73742f73746f636b2f223b757365725f69647c693a323b757365726e616d657c733a353a2261646d696e223b757365725f6163636573737c693a31363b6c6f676765645f696e7c623a313b706963747572655f7072656669787c733a343a2230343937223b7375626d69745f696d6167657c623a303b6974656d5f69647c733a333a22353835223b706963747572655f63616c6c6261636b7c733a33353a22687474703a2f2f6c6f63616c686f73742f73746f636b2f6974656d2f6372656174652f223b),
('m5ljcvpjm3vc5651vanc107rkgn78l45', '::1', 1583400204, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538333430303230343b6974656d735f6c6973745f75726c7c733a36373a22687474703a2f2f6c6f63616c686f73742f73746f636b2f6974656d2f696e6465782f313f74733d446f6e6e254333254139657326635b5d3d3130266f3d302661643d30223b61667465725f6c6f67696e5f72656469726563747c733a32333a22687474703a2f2f6c6f63616c686f73742f73746f636b2f223b757365725f69647c693a323b757365726e616d657c733a353a2261646d696e223b757365725f6163636573737c693a31363b6c6f676765645f696e7c623a313b706963747572655f7072656669787c733a343a2230353739223b7375626d69745f696d6167657c623a303b706963747572655f63616c6c6261636b7c733a33383a22687474703a2f2f6c6f63616c686f73742f73746f636b2f6974656d2f6d6f646966792f353739223b6974656d5f69647c733a333a22353836223b),
('opkat9qbanrnq8v8gl74ha1vjf4upn72', '::1', 1583402135, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538333430323033383b6974656d735f6c6973745f75726c7c733a33353a22687474703a2f2f6c6f63616c686f73742f73746f636b2f6974656d2f696e6465782f31223b61667465725f6c6f67696e5f72656469726563747c733a32333a22687474703a2f2f6c6f63616c686f73742f73746f636b2f223b757365725f69647c693a323b757365726e616d657c733a353a2261646d696e223b757365725f6163636573737c693a31363b6c6f676765645f696e7c623a313b706963747572655f7072656669787c733a343a2230353739223b7375626d69745f696d6167657c623a303b706963747572655f63616c6c6261636b7c733a33383a22687474703a2f2f6c6f63616c686f73742f73746f636b2f6974656d2f6d6f646966792f353739223b6974656d5f69647c733a333a22353836223b),
('u9g7ifp4p4al8ptfroloe4bu1bus7a14', '::1', 1583399364, 0x5f5f63695f6c6173745f726567656e65726174657c693a313538333339393336343b6974656d735f6c6973745f75726c7c733a33353a22687474703a2f2f6c6f63616c686f73742f73746f636b2f6974656d2f696e6465782f31223b61667465725f6c6f67696e5f72656469726563747c733a32333a22687474703a2f2f6c6f63616c686f73742f73746f636b2f223b757365725f69647c693a323b757365726e616d657c733a353a2261646d696e223b757365725f6163636573737c693a31363b6c6f676765645f696e7c623a313b706963747572655f7072656669787c733a343a2230353739223b7375626d69745f696d6167657c623a303b706963747572655f63616c6c6261636b7c733a33383a22687474703a2f2f6c6f63616c686f73742f73746f636b2f6974656d2f6d6f646966792f353739223b6974656d5f69647c733a333a22353836223b);

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
  `inventory_prefix` varchar(45) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `serial_number` varchar(45) DEFAULT NULL,
  `buying_price` float DEFAULT NULL,
  `buying_date` date DEFAULT NULL,
  `warranty_duration` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `linked_file` varchar(255) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `supplier_ref` varchar(45) DEFAULT NULL,
  `created_by_user_id` int(11) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_by_user_id` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `checked_by_user_id` int(11) DEFAULT NULL,
  `checked_date` datetime DEFAULT NULL,
  `stocking_place_id` int(11) DEFAULT NULL,
  `item_condition_id` int(11) DEFAULT NULL,
  `item_group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `item`
--

INSERT INTO `item` (`item_id`, `inventory_prefix`, `name`, `description`, `image`, `serial_number`, `buying_price`, `buying_date`, `warranty_duration`, `remarks`, `linked_file`, `supplier_id`, `supplier_ref`, `created_by_user_id`, `created_date`, `modified_by_user_id`, `modified_date`, `checked_by_user_id`, `checked_date`, `stocking_place_id`, `item_condition_id`, `item_group_id`) VALUES
(1, 'formation-00017', 'PC portable HP Pavillon', 'PC portable du bureau informatique', 'acomp.png', NULL, 550, '2014-04-30', 24, 'Va bientôt être remplacé par un nouveau (installation en cours par BhJe)', NULL, 1, '078928', 1, '2016-02-18 10:48:37', NULL, NULL, NULL, NULL, 2, 10, 2),
(2, 'formation-00045', 'Imprimante Canon LaserJet', 'Imprimante section informatique', NULL, NULL, 1200, '2010-04-13', 12, 'Les toners pour cette imprimante sont gérés par la section informatique', NULL, 2, '', 1, '2016-02-18 10:48:37', NULL, NULL, NULL, NULL, 1, 10, 2),
(3, 'formation-00518', 'Mini serveur HP', 'Mini serveur pour ateliers Infobs', 'lcd_monitor.png', NULL, 800, '2014-05-10', 48, '', NULL, 1, '9863321789456123', 1, '2016-02-18 10:48:37', NULL, NULL, NULL, NULL, 3, 10, 1),
(494, 'ORP,20', 'Test upload Image Change', '', 'A-Hat-in-Time-Rift-1000x563.png', '', 0, '2020-01-15', 0, '', NULL, 1, '', 2, '2020-01-15 06:46:58', NULL, NULL, NULL, NULL, 1, 10, 2),
(495, 'ORP,20', 'Test', '', 'AllbotOnClickSwitch.PNG', '', 0, '2020-01-16', 0, '', NULL, 1, '', 2, '2020-01-16 09:16:12', NULL, NULL, NULL, NULL, 1, 10, 2),
(496, 'ORP,[20', 'Test Données', '', '8ce72a87e603769b19e681c9ed2dbea0.jpg', '', 0, '2020-01-16', 0, '', NULL, 1, '', 2, '2020-01-16 12:56:48', NULL, NULL, NULL, NULL, 1, 10, 2),
(497, 'ORP,20', 'Test Modify Image', '', '0497_picture.png', '', 0, '2020-02-04', 0, '', NULL, 1, '', 2, '2020-02-04 09:21:59', NULL, NULL, NULL, NULL, 1, 10, 2),
(499, 'ORP,20', 'Test', '', '0499_picture.png', '', 0, '2020-02-04', 0, '', NULL, 1, '', 2, '2020-02-04 09:40:57', NULL, NULL, NULL, NULL, 1, 10, 2),
(500, 'ORP,20', 'Test GB Test', '', '0500_picture.png', '', 0, '2020-02-04', 0, '', NULL, 1, '', 2, '2020-02-04 09:42:02', NULL, NULL, NULL, NULL, 1, 10, 2),
(501, 'ORPMPPdS20', 'Test No Inventaire', '', 'no_image.png', '', 0, '2020-02-20', 0, '', NULL, 1, '', 2, '2020-02-20 07:24:44', NULL, NULL, NULL, NULL, 1, 10, 4),
(502, 'ORP.FO20', 'Test No Inventaire', '', 'ORP_502_TMP', '', 0, '2020-02-25', 0, '', NULL, 1, '', 2, '2020-02-25 08:05:37', NULL, NULL, NULL, NULL, 1, 10, 2),
(503, 'ORPO20', 'Test JPG', '', 'IMG_20170818_103219.jpg', '', 0, '2020-02-26', 0, '', NULL, 1, '', 2, '2020-02-26 07:38:55', NULL, NULL, NULL, NULL, 1, 10, 2),
(504, 'ORP.FO20', 'Test Photo Temporaire', '', 'ORP_504_TMP.png', '', 0, '2020-02-26', 0, '', NULL, 1, '', 2, '2020-02-26 13:05:20', NULL, NULL, NULL, NULL, 1, 10, 2),
(506, 'ORP.FO20', 'Test Renommage Image', '', 'ORP_506.png', '', 0, '2020-02-26', 0, '', NULL, 1, '', 2, '2020-02-26 13:16:48', NULL, NULL, NULL, NULL, 1, 10, 2),
(507, 'ORP.FO20', 'Test Renommage Image', '', 'ORP_507.png', '', 0, '2020-02-26', 0, '', NULL, 1, '', 2, '2020-02-26 13:18:23', NULL, NULL, NULL, NULL, 1, 10, 2),
(508, 'ORP.FO20', 'Test Renommage Upload', '', 'ORP_508.png', '', 0, '2020-02-26', 0, '', NULL, 1, '', 2, '2020-02-26 13:19:39', NULL, NULL, NULL, NULL, 1, 10, 2),
(509, 'ORP.FO20', 'Test Suppression picture_path', '', 'ORP_509.png', '', 0, '2020-02-26', 0, '', NULL, 1, '', 2, '2020-02-26 13:22:30', NULL, NULL, NULL, NULL, 1, 10, 2),
(539, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(540, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(541, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(542, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(543, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(544, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(545, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(546, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(547, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(548, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(549, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(550, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(551, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(552, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(553, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(554, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(555, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(556, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(557, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(558, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(559, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(560, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(561, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(562, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(563, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(564, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(565, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(566, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(567, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(568, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(569, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(570, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(571, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(572, 'ORPPAG20', 'Test Pagination', '', '', '', 0, '2020-03-03', 0, '', NULL, 1, '', 2, '2020-03-03 13:05:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(573, 'ORP.FO20', 'Test picture_path', '', '573_picture_tmp.png', '', 0, '2020-03-04', 0, '', NULL, 1, '', 2, '2020-03-04 07:12:11', NULL, NULL, NULL, NULL, 1, 10, 2),
(574, 'ORP.FO20', 'Test picture_path', '', '574_picture_tmp.png', '', 0, '2020-03-04', 0, '', NULL, 1, '', 2, '2020-03-04 07:14:22', NULL, NULL, NULL, NULL, 1, 10, 2),
(575, 'ORP.FO20', 'Test picture_path', '', 'uploads/images/575_picture.png', '', 0, '2020-03-04', 0, '', NULL, 1, '', 2, '2020-03-04 07:15:20', NULL, NULL, NULL, NULL, 1, 10, 2),
(576, 'ORP.FO20', 'Test picture_path', '', 'uploads/images/576_picture.png', '', 0, '2020-03-04', 0, '', NULL, 1, '', 2, '2020-03-04 07:16:22', NULL, NULL, NULL, NULL, 1, 10, 2),
(577, 'ORP.FO20', 'Test picture_path', '', '577_picture.png', '', 0, '2020-03-04', 0, '', NULL, 1, '', 2, '2020-03-04 07:23:40', NULL, NULL, NULL, NULL, 1, 10, 2),
(578, 'ORP.FO20', 'Test picture_path', '', '578_picture.png', '', 0, '2020-03-04', 0, '', NULL, 1, '', 2, '2020-03-04 07:23:54', NULL, NULL, NULL, NULL, 1, 10, 2),
(579, 'ORP.FO20', 'Test Test', '', '0579_picture.png', '', 0, '2020-03-04', 0, '', NULL, 1, '', 2, '2020-03-04 08:42:51', NULL, NULL, NULL, NULL, 1, 10, 2),
(580, 'ORP.FO20', 'Test', '', '580_picture.png', '', 0, '2020-03-04', 0, '', NULL, 1, '', 2, '2020-03-04 08:43:10', NULL, NULL, NULL, NULL, 1, 10, 2),
(581, 'ORP.FO20', 'Test', '', '0494_picture.png', '', 0, '2020-03-04', 0, '', NULL, 1, '', 2, '2020-03-04 10:36:37', NULL, NULL, NULL, NULL, 1, 10, 2),
(582, 'ORP.FO20', 'Test inventory prefix', '', '5820_picture.png', '', 0, '2020-03-04', 0, '', NULL, 1, '', 2, '2020-03-04 10:51:19', NULL, NULL, NULL, NULL, 1, 10, 2),
(583, 'ORP.FO20', 'Test Prefix', '', '0583_picture.png', '', 0, '2020-03-04', 0, '', NULL, 1, '', 2, '2020-03-04 11:57:50', NULL, NULL, NULL, NULL, 1, 10, 2),
(584, 'ORP.FO20', 'Test Ajout Test', '', '0584_picture.png', '', 0, '2020-03-04', 0, '', NULL, 1, '', 2, '2020-03-04 12:30:53', NULL, NULL, NULL, NULL, 1, 10, 2),
(585, 'ORP.FO20', 'Test Prefix Ajout', '', '0585_picture.png', '', 0, '2020-03-05', 0, '', NULL, 1, '', 2, '2020-03-05 07:52:11', NULL, NULL, NULL, NULL, 1, 10, 2);

-- --------------------------------------------------------

--
-- Structure de la table `item_condition`
--

CREATE TABLE `item_condition` (
  `item_condition_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `item_group` (
  `item_group_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `short_name` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `item_group`
--

INSERT INTO `item_group` (`item_group_id`, `name`, `short_name`) VALUES
(1, 'Observation', 'OB'),
(2, 'Formation', 'FO'),
(3, 'Moyens auxiliaires', 'MA'),
(4, 'Matériel de prêt', 'MP'),
(5, 'Test', 'TE');

-- --------------------------------------------------------

--
-- Structure de la table `item_tag`
--

CREATE TABLE `item_tag` (
  `item_tag_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `short_name` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `item_tag`
--

INSERT INTO `item_tag` (`item_tag_id`, `name`, `short_name`) VALUES
(1, 'Ordinateur', 'ORD'),
(2, 'Souris', 'SOU'),
(3, 'Clavier', 'CLA'),
(4, 'Lecteur', 'LEC'),
(5, 'Périphérique de saisie', 'PdS'),
(6, 'Imprimante', 'IMP'),
(7, 'Scanner', 'SCA'),
(8, 'Ecran', 'ECR'),
(20, 'Test', 'TES');

-- --------------------------------------------------------

--
-- Structure de la table `item_tag_link`
--

CREATE TABLE `item_tag_link` (
  `item_tag_link_id` int(11) NOT NULL,
  `item_tag_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `item_tag_link`
--

INSERT INTO `item_tag_link` (`item_tag_link_id`, `item_tag_id`, `item_id`) VALUES
(1, 1, 1),
(2, 8, 1),
(3, 6, 2),
(362, 1, 496),
(363, 2, 496),
(364, 3, 496),
(365, 4, 496),
(366, 5, 496),
(367, 6, 496),
(368, 7, 496),
(369, 8, 496),
(370, 4, 494),
(371, 5, 494),
(373, 5, 501),
(376, 4, 500);

-- --------------------------------------------------------

--
-- Structure de la table `loan`
--

CREATE TABLE `loan` (
  `loan_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `item_localisation` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `planned_return_date` date DEFAULT NULL,
  `real_return_date` date DEFAULT NULL,
  `item_id` int(11) NOT NULL,
  `loan_by_user_id` int(11) NOT NULL,
  `loan_to_user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `loan`
--

INSERT INTO `loan` (`loan_id`, `date`, `item_localisation`, `remarks`, `planned_return_date`, `real_return_date`, `item_id`, `loan_by_user_id`, `loan_to_user_id`) VALUES
(1, '2016-02-10', 'Poste OR000000 (SIBEC, Mme Ramirez)', NULL, '2016-02-29', '2016-02-26', 1, 1, 1),
(2, '2016-03-01', 'Poste OR111111 (Pro Pulsion, M. Curchod)', NULL, '2016-03-31', NULL, 1, 1, 1),
(3, '2016-04-04', 'Poste OR222222 (Informatique, M. Bolomey)', NULL, NULL, NULL, 1, 1, 1),
(4, '2016-03-01', 'Poste OR222222 (Informatique, M. Bolomey)', NULL, NULL, NULL, 2, 1, 1),
(5, '2020-03-03', 'Test Lieu', NULL, '2020-03-10', NULL, 2, 2, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `stocking_place`
--

CREATE TABLE `stocking_place` (
  `stocking_place_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `short` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `stocking_place`
--

INSERT INTO `stocking_place` (`stocking_place_id`, `name`, `short`) VALUES
(1, 'Salle Info', 'INFO'),
(2, 'Atelier1', 'AT01'),
(3, 'Atelier2', 'AT02'),
(12, 'Test', 'TESTTEST');

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

--
-- Déchargement des données de la table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `name`, `address_line1`, `address_line2`, `zip`, `city`, `country`, `tel`, `email`) VALUES
(1, 'Digitec', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'ARP', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Test', 'Test', 'Test', '1234', 'Test', NULL, 'Test', 'test@test.test');

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
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_type_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`user_id`, `lastname`, `firstname`, `username`, `password`, `email`, `created_date`, `user_type_id`, `is_active`) VALUES
(1, 'Orif', 'invité', 'orif', '$2y$10$MnRW5O.3LSHmoTSFA2YA9OWy0zNGInULQ5dsKVjxmhtmNZYNVa222', NULL, '2019-10-01 06:03:54', 1, 1),
(2, 'Orif', 'administrateur', 'admin', '$2y$10$MnRW5O.3LSHmoTSFA2YA9OWy0zNGInULQ5dsKVjxmhtmNZYNVa222', NULL, '2019-10-01 06:03:54', 5, 1),
(6, 'Test', 'Test', 'test', '$2y$10$KoxOK2mDcYVP3Bs5gruw.uUgd82Q83uhEXQKKRE9EgoZeeraDh4Ne', 'test@test.test', '2020-03-05 09:54:24', 2, 0);

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
-- Déchargement des données de la table `user_type`
--

INSERT INTO `user_type` (`user_type_id`, `name`, `access_level`) VALUES
(1, 'Invite', 1),
(2, 'Observation', 2),
(3, 'Formation', 4),
(4, 'MSP', 8),
(5, 'Administrateur', 16);

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
  MODIFY `inventory_control_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=586;

--
-- AUTO_INCREMENT pour la table `item_condition`
--
ALTER TABLE `item_condition`
  MODIFY `item_condition_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `item_group`
--
ALTER TABLE `item_group`
  MODIFY `item_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `item_tag`
--
ALTER TABLE `item_tag`
  MODIFY `item_tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `item_tag_link`
--
ALTER TABLE `item_tag_link`
  MODIFY `item_tag_link_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=377;

--
-- AUTO_INCREMENT pour la table `loan`
--
ALTER TABLE `loan`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `stocking_place`
--
ALTER TABLE `stocking_place`
  MODIFY `stocking_place_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `user_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
