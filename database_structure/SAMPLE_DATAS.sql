-- -----------------------------------------------------
-- Data for table `stock`.`user_type`
-- -----------------------------------------------------
START TRANSACTION;
USE `stock`;
INSERT INTO `stock`.`user_type` (`user_type_id`, `name`, `access_level`) VALUES (1, 'Invite', 1);
INSERT INTO `stock`.`user_type` (`user_type_id`, `name`, `access_level`) VALUES (2, 'Observation', 2);
INSERT INTO `stock`.`user_type` (`user_type_id`, `name`, `access_level`) VALUES (3, 'Formation', 4);
INSERT INTO `stock`.`user_type` (`user_type_id`, `name`, `access_level`) VALUES (4, 'MSP', 8);
INSERT INTO `stock`.`user_type` (`user_type_id`, `name`, `access_level`) VALUES (5, 'Administrateur', 16);

COMMIT;


-- -----------------------------------------------------
-- Data for table `stock`.`user`
-- -----------------------------------------------------
START TRANSACTION;
USE `stock`;
INSERT INTO `stock`.`user` (`user_id`, `lastname`, `firstname`, `username`, `password`, `email`, `user_type_id`, `is_active`) VALUES (1, 'Orif', 'invité', 'orif', '$2y$10$MnRW5O.3LSHmoTSFA2YA9OWy0zNGInULQ5dsKVjxmhtmNZYNVa222', NULL, 1, 1);
INSERT INTO `stock`.`user` (`user_id`, `lastname`, `firstname`, `username`, `password`, `email`, `user_type_id`, `is_active`) VALUES (2, 'Orif', 'administrateur', 'admin', '$2y$10$MnRW5O.3LSHmoTSFA2YA9OWy0zNGInULQ5dsKVjxmhtmNZYNVa222', NULL, 5, 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `stock`.`stocking_place`
-- -----------------------------------------------------
START TRANSACTION;
USE `stock`;
INSERT INTO `stock`.`stocking_place` (`stocking_place_id`, `name`, `short`) VALUES (1, 'Salle Info', 'INFO');
INSERT INTO `stock`.`stocking_place` (`stocking_place_id`, `name`, `short`) VALUES (2, 'Atelier1', 'AT01');
INSERT INTO `stock`.`stocking_place` (`stocking_place_id`, `name`, `short`) VALUES (3, 'Atelier2', 'AT02');

COMMIT;


-- -----------------------------------------------------
-- Data for table `stock`.`item_condition`
-- -----------------------------------------------------
START TRANSACTION;
USE `stock`;
INSERT INTO `stock`.`item_condition` (`item_condition_id`, `name`) VALUES (10, 'Fonctionnel');
INSERT INTO `stock`.`item_condition` (`item_condition_id`, `name`) VALUES (30, 'Défectueux');
INSERT INTO `stock`.`item_condition` (`item_condition_id`, `name`) VALUES (40, 'Plus disponible');

COMMIT;


-- -----------------------------------------------------
-- Data for table `stock`.`item_group`
-- -----------------------------------------------------
START TRANSACTION;
USE `stock`;
INSERT INTO `stock`.`item_group` (`item_group_id`, `name`) VALUES (1, 'Observation');
INSERT INTO `stock`.`item_group` (`item_group_id`, `name`) VALUES (2, 'Formation');
INSERT INTO `stock`.`item_group` (`item_group_id`, `name`) VALUES (3, 'Moyens auxiliaires');
INSERT INTO `stock`.`item_group` (`item_group_id`, `name`) VALUES (4, 'Matériel de prêt');

COMMIT;


-- -----------------------------------------------------
-- Data for table `stock`.`item_tag`
-- -----------------------------------------------------
START TRANSACTION;
USE `stock`;
INSERT INTO `stock`.`item_tag` (`item_tag_id`, `name`) VALUES (1, 'Ordinateur');
INSERT INTO `stock`.`item_tag` (`item_tag_id`, `name`) VALUES (2, 'Souris');
INSERT INTO `stock`.`item_tag` (`item_tag_id`, `name`) VALUES (3, 'Clavier');
INSERT INTO `stock`.`item_tag` (`item_tag_id`, `name`) VALUES (4, 'Lecteur');
INSERT INTO `stock`.`item_tag` (`item_tag_id`, `name`) VALUES (5, 'Périphérique de saisie');
INSERT INTO `stock`.`item_tag` (`item_tag_id`, `name`) VALUES (6, 'Imprimante');
INSERT INTO `stock`.`item_tag` (`item_tag_id`, `name`) VALUES (7, 'Scanner');
INSERT INTO `stock`.`item_tag` (`item_tag_id`, `name`) VALUES (8, 'Ecran');

COMMIT;


USE `stock` ;

-- SUPPLIERS -------------------------------------------------------------------
INSERT INTO `supplier` (`supplier_id`, `name`, `address_line1`, `address_line2`, `zip`, `city`, `country`, `tel`, `email`) VALUES
(1, 'Digitec', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'ARP', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- ITEMS -----------------------------------------------------------------------
INSERT INTO `item` (`item_id`, `inventory_number`, `name`, `description`, `image`, `serial_number`, `buying_price`, `buying_date`, `warranty_duration`, `remarks`, `linked_file`, `supplier_id`, `supplier_ref`, `created_by_user_id`, `created_date`, `modified_by_user_id`, `modified_date`, `checked_by_user_id`, `checked_date`, `stocking_place_id`, `item_condition_id`, `item_group_id`) VALUES
(1, 'formation-00017', 'PC portable HP Pavillon', 'PC portable du bureau informatique', 'acomp.png', NULL, 550, '2014-04-30', 24, 'Va bientôt être remplacé par un nouveau (installation en cours par BhJe)', NULL, 1, '078928', 1, '2016-02-18 11:48:37', NULL, NULL, NULL, NULL, 2, 10, 2),
(2, 'formation-00045', 'Imprimante Canon LaserJet', 'Imprimante section informatique', NULL, NULL, 1200, '2010-04-13', 12, 'Les toners pour cette imprimante sont gérés par la section informatique', NULL, 2, '', 1, '2016-02-18 11:48:37', NULL, NULL, NULL, NULL, 1, 10, 2),
(3, 'formation-00518', 'Mini serveur HP', 'Mini serveur pour ateliers Infobs', 'lcd_monitor.png', NULL, 800, '2014-05-10', 48, '', NULL, 1, '9863321789456123', 1, '2016-02-18 11:48:37', NULL, NULL, NULL, NULL, 3, 10, 1);

-- ITEM TAG LINKS --------------------------------------------------------------
INSERT INTO `item_tag_link` (`item_tag_link_id`, `item_tag_id`, `item_id`) VALUES
(1, 1, 1),
(2, 8, 1),
(3, 6, 2);

-- LOANS -----------------------------------------------------------------------
INSERT INTO `loan` (`loan_id`, `date`, `item_localisation`, `remarks`, `planned_return_date`, `real_return_date`, `item_id`, `loan_by_user_id`, `loan_to_user_id`) VALUES
(1, '2016-02-10', 'Poste OR000000 (SIBEC, Mme Ramirez)', NULL, '2016-02-29', '2016-02-26', 1, 1, 1),
(2, '2016-03-01', 'Poste OR111111 (Pro Pulsion, M. Curchod)', NULL, '2016-03-31', NULL, 1, 1, 1),
(3, '2016-04-04', 'Poste OR222222 (Informatique, M. Bolomey)', NULL, NULL, NULL, 1, 1, 1),
(4, '2016-03-01', 'Poste OR222222 (Informatique, M. Bolomey)', NULL, NULL, NULL, 2, 1, 1);