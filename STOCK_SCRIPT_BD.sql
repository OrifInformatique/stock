-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema stock
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema stock
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `stock` DEFAULT CHARACTER SET utf8 ;
USE `stock` ;

-- -----------------------------------------------------
-- Table `stock`.`user_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stock`.`user_type` (
  `user_type_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `access_level` INT NOT NULL,
  PRIMARY KEY (`user_type_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `stock`.`department`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stock`.`department` (
  `department_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`department_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `stock`.`user_state`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stock`.`user_state` (
  `user_state_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`user_state_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `stock`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stock`.`user` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `lastname` VARCHAR(45) NULL,
  `firstname` VARCHAR(45) NULL,
  `initials` VARCHAR(45) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `user_type_id` INT NULL,
  `department_id` INT NULL,
  `user_state_id` INT NULL,
  PRIMARY KEY (`user_id`),
  INDEX `fk_department_id_idx` (`department_id` ASC),
  INDEX `fk_user_type_id_idx` (`user_type_id` ASC),
  INDEX `fk_user_state_id_idx` (`user_state_id` ASC),
  UNIQUE INDEX `initials_UNIQUE` (`initials` ASC),
  CONSTRAINT `fk_user_type_id`
    FOREIGN KEY (`user_type_id`)
    REFERENCES `stock`.`user_type` (`user_type_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_department_id`
    FOREIGN KEY (`department_id`)
    REFERENCES `stock`.`department` (`department_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_state_id`
    FOREIGN KEY (`user_state_id`)
    REFERENCES `stock`.`user_state` (`user_state_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `stock`.`stocking_place`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stock`.`stocking_place` (
  `stocking_place_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `short` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`stocking_place_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `stock`.`item_state`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stock`.`item_state` (
  `item_state_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`item_state_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `stock`.`supplier`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stock`.`supplier` (
  `supplier_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `address_line1` VARCHAR(256) NULL,
  `address_line2` VARCHAR(256) NULL,
  `zip` VARCHAR(45) NULL,
  `city` VARCHAR(45) NULL,
  `country` VARCHAR(45) NULL,
  `tel` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  PRIMARY KEY (`supplier_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `stock`.`item`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stock`.`item` (
  `item_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `description` TEXT NULL,
  `supplier_id` INT NULL,
  `supplier_ref` VARCHAR(45) NULL,
  `buying_price` FLOAT NULL,
  `buying_date` DATE NULL,
  `warranty_duration` INT NULL,
  `file_number` VARCHAR(45) NULL,
  `serial_number` VARCHAR(45) NULL,
  `remarks` TEXT NULL,
  `image` VARCHAR(256) NULL,
  `created_by_user_id` INT NOT NULL,
  `created_date` DATE NOT NULL,
  `modified_by_user_id` INT NULL,
  `modified_date` DATE NULL,
  `control_by_user_id` INT NULL,
  `control_date` DATE NULL,
  `stocking_place_id` INT NULL,
  `item_state_id` INT NULL,
  PRIMARY KEY (`item_id`),
  INDEX `fk_created_by_user_id_idx` (`created_by_user_id` ASC),
  INDEX `fk_stocking_place_id_idx` (`stocking_place_id` ASC),
  INDEX `fk_modified_by_user_id_idx` (`modified_by_user_id` ASC),
  INDEX `fk_item_state_id_idx` (`item_state_id` ASC),
  INDEX `fk_supplier_id_idx` (`supplier_id` ASC),
  INDEX `fk_control_by_user_id_idx` (`control_by_user_id` ASC),
  CONSTRAINT `fk_created_by_user_id`
    FOREIGN KEY (`created_by_user_id`)
    REFERENCES `stock`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_modified_by_user_id`
    FOREIGN KEY (`modified_by_user_id`)
    REFERENCES `stock`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_stocking_place_id`
    FOREIGN KEY (`stocking_place_id`)
    REFERENCES `stock`.`stocking_place` (`stocking_place_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_item_state_id`
    FOREIGN KEY (`item_state_id`)
    REFERENCES `stock`.`item_state` (`item_state_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_supplier_id`
    FOREIGN KEY (`supplier_id`)
    REFERENCES `stock`.`supplier` (`supplier_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_control_by_user_id`
    FOREIGN KEY (`control_by_user_id`)
    REFERENCES `stock`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `stock`.`loan`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stock`.`loan` (
  `loan_id` INT NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `item_localisation` VARCHAR(45) NULL,
  `remarks` TEXT NULL,
  `return_delay` DATE NULL,
  `real_return_date` DATE NULL,
  `item_id` INT NOT NULL,
  `loan_by_user_id` INT NOT NULL,
  `loan_to_user_id` INT NOT NULL,
  PRIMARY KEY (`loan_id`),
  INDEX `fk_item_id_idx` (`item_id` ASC),
  INDEX `fk_loan_by_user_id_idx` (`loan_by_user_id` ASC),
  INDEX `fk_loan_to_user_id_idx` (`loan_to_user_id` ASC),
  CONSTRAINT `fk_item_id`
    FOREIGN KEY (`item_id`)
    REFERENCES `stock`.`item` (`item_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_loan_by_user_id`
    FOREIGN KEY (`loan_by_user_id`)
    REFERENCES `stock`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_loan_to_user_id`
    FOREIGN KEY (`loan_to_user_id`)
    REFERENCES `stock`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `stock`.`item_tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stock`.`item_tag` (
  `item_tag_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`item_tag_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `stock`.`item_tag_link`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stock`.`item_tag_link` (
  `item_tag_link_id` INT NOT NULL AUTO_INCREMENT,
  `item_id` INT NOT NULL,
  `item_tag_id` INT NOT NULL,
  PRIMARY KEY (`item_tag_link_id`),
  INDEX `fk_item_id_lnk_idx` (`item_id` ASC),
  INDEX `fk_item_tag_id_idx` (`item_tag_id` ASC),
  CONSTRAINT `fk_item_lnk_id`
    FOREIGN KEY (`item_id`)
    REFERENCES `stock`.`item` (`item_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_item_tag_id`
    FOREIGN KEY (`item_tag_id`)
    REFERENCES `stock`.`item_tag` (`item_tag_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `stock`.`user_type`
-- -----------------------------------------------------
START TRANSACTION;
USE `stock`;
INSERT INTO `stock`.`user_type` (`user_type_id`, `name`, `access_level`) VALUES (1, 'Invité', 0);
INSERT INTO `stock`.`user_type` (`user_type_id`, `name`, `access_level`) VALUES (2, 'Observation', 0);
INSERT INTO `stock`.`user_type` (`user_type_id`, `name`, `access_level`) VALUES (3, 'Formation', 5);
INSERT INTO `stock`.`user_type` (`user_type_id`, `name`, `access_level`) VALUES (4, 'MSP', 10);
INSERT INTO `stock`.`user_type` (`user_type_id`, `name`, `access_level`) VALUES (5, 'Administrateur', 10);
INSERT INTO `stock`.`user_type` (`user_type_id`, `name`, `access_level`) VALUES (6, 'Autre', 0);

COMMIT;


-- -----------------------------------------------------
-- Data for table `stock`.`department`
-- -----------------------------------------------------
START TRANSACTION;
USE `stock`;
INSERT INTO `stock`.`department` (`department_id`, `name`) VALUES (1, 'Observation');
INSERT INTO `stock`.`department` (`department_id`, `name`) VALUES (2, 'Formation');
INSERT INTO `stock`.`department` (`department_id`, `name`) VALUES (3, 'Autre');

COMMIT;


-- -----------------------------------------------------
-- Data for table `stock`.`user_state`
-- -----------------------------------------------------
START TRANSACTION;
USE `stock`;
INSERT INTO `stock`.`user_state` (`user_state_id`, `name`) VALUES (1, 'Inactif');
INSERT INTO `stock`.`user_state` (`user_state_id`, `name`) VALUES (2, 'Actif');
INSERT INTO `stock`.`user_state` (`user_state_id`, `name`) VALUES (3, 'Fin de stage');
INSERT INTO `stock`.`user_state` (`user_state_id`, `name`) VALUES (4, 'Autre');

COMMIT;


-- -----------------------------------------------------
-- Data for table `stock`.`user`
-- -----------------------------------------------------
START TRANSACTION;
USE `stock`;
INSERT INTO `stock`.`user` (`user_id`, `lastname`, `firstname`, `initials`, `password_hash`, `user_type_id`, `department_id`, `user_state_id`) VALUES (1, 'Doe', 'John', 'dojo', '$2y$10$LbBUtfQ1.MhVYoO5IyYeUu/uHQgGSZE6PN/2NgzMWVmUhp.stVHTC', 2, 1, 2);
INSERT INTO `stock`.`user` (`user_id`, `lastname`, `firstname`, `initials`, `password_hash`, `user_type_id`, `department_id`, `user_state_id`) VALUES (2, 'NULL', 'NULL', 'admin', '$2y$10$lZeKO0wJT4.kqAXCfHtfCe/87GCPtx3OrgAlYG6wqzPhlVVgH.gm2', 5, 3, 2);
INSERT INTO `stock`.`user` (`user_id`, `lastname`, `firstname`, `initials`, `password_hash`, `user_type_id`, `department_id`, `user_state_id`) VALUES (3, 'NULL', 'NULL', 'MSP', '$2y$10$F2AA2BRZj5quOh1ixBm0DeQUOgaQdxFKwmt5Xr9o0i6.XrDyv.nS2', 4, 2, 2);
INSERT INTO `stock`.`user` (`user_id`, `lastname`, `firstname`, `initials`, `password_hash`, `user_type_id`, `department_id`, `user_state_id`) VALUES (4, 'NULL', 'NULL', 'Apprenti1', '$2y$10$EoKJWBPZvfePiURl8vaq1eY5wVZUS5MYMsH/b6KI51CaSDqEP/qkm', 3, 2, 2);

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
-- Data for table `stock`.`item_state`
-- -----------------------------------------------------
START TRANSACTION;
USE `stock`;
INSERT INTO `stock`.`item_state` (`item_state_id`, `name`) VALUES (1, 'En stock');
INSERT INTO `stock`.`item_state` (`item_state_id`, `name`) VALUES (2, 'Vendu');
INSERT INTO `stock`.`item_state` (`item_state_id`, `name`) VALUES (3, 'Deffecteux');
INSERT INTO `stock`.`item_state` (`item_state_id`, `name`) VALUES (4, 'Débarrassé');

COMMIT;


-- -----------------------------------------------------
-- Data for table `stock`.`supplier`
-- -----------------------------------------------------
START TRANSACTION;
USE `stock`;
INSERT INTO `stock`.`supplier` (`supplier_id`, `name`, `address_line1`, `address_line2`, `zip`, `city`, `country`, `tel`, `email`) VALUES (1, 'Digitec', 'addr11', 'addr21', 'z1', 'c1', 'cy1', 't1', 'e1');
INSERT INTO `stock`.`supplier` (`supplier_id`, `name`, `address_line1`, `address_line2`, `zip`, `city`, `country`, `tel`, `email`) VALUES (2, 'STEG', 'addr12', 'addr21', 'z2', 'c2', 'cy2', 't2', 'e2');
INSERT INTO `stock`.`supplier` (`supplier_id`, `name`, `address_line1`, `address_line2`, `zip`, `city`, `country`, `tel`, `email`) VALUES (3, '1000ordi', 'addr13', 'addr22', 'z3', 'c3', 'cy2', 't3', 'e3');
INSERT INTO `stock`.`supplier` (`supplier_id`, `name`, `address_line1`, `address_line2`, `zip`, `city`, `country`, `tel`, `email`) VALUES (4, 'Autre', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `stock`.`item`
-- -----------------------------------------------------
START TRANSACTION;
USE `stock`;
INSERT INTO `stock`.`item` (`item_id`, `name`, `description`, `supplier_id`, `supplier_ref`, `buying_price`, `buying_date`, `warranty_duration`, `file_number`, `serial_number`, `remarks`, `image`, `created_by_user_id`, `created_date`, `modified_by_user_id`, `modified_date`, `control_by_user_id`, `control_date`, `stocking_place_id`, `item_state_id`) VALUES (13, 'Ordinateur HP complet', 'set complet', 3, '90954.453', 1500, '2012-07-12', 48, NULL, NULL, NULL, 'acomp.png', 2, '2015-07-01', NULL, NULL, NULL, NULL, 2, 1);
INSERT INTO `stock`.`item` (`item_id`, `name`, `description`, `supplier_id`, `supplier_ref`, `buying_price`, `buying_date`, `warranty_duration`, `file_number`, `serial_number`, `remarks`, `image`, `created_by_user_id`, `created_date`, `modified_by_user_id`, `modified_date`, `control_by_user_id`, `control_date`, `stocking_place_id`, `item_state_id`) VALUES (14, 'Ecran Claxan', 'résolution 1680x1050', 4, NULL, 0, '2014-06-12', 0, NULL, NULL, NULL, 'lcd_monitor.png', 2, '2015-07-10', NULL, '2015-07-10', NULL, NULL, 1, 1);
INSERT INTO `stock`.`item` (`item_id`, `name`, `description`, `supplier_id`, `supplier_ref`, `buying_price`, `buying_date`, `warranty_duration`, `file_number`, `serial_number`, `remarks`, `image`, `created_by_user_id`, `created_date`, `modified_by_user_id`, `modified_date`, `control_by_user_id`, `control_date`, `stocking_place_id`, `item_state_id`) VALUES (15, 'Souris Logitech', NULL, NULL, NULL, 0, '2015-03-12', 12, NULL, NULL, NULL, NULL, 2, '2015-07-10', NULL, NULL, NULL, NULL, 1, NULL);
INSERT INTO `stock`.`item` (`item_id`, `name`, `description`, `supplier_id`, `supplier_ref`, `buying_price`, `buying_date`, `warranty_duration`, `file_number`, `serial_number`, `remarks`, `image`, `created_by_user_id`, `created_date`, `modified_by_user_id`, `modified_date`, `control_by_user_id`, `control_date`, `stocking_place_id`, `item_state_id`) VALUES (16, 'Switch netlink D-500', '100 mbps', NULL, NULL, 0, '2014-09-17', 0, NULL, NULL, NULL, NULL, 2, '2015-07-10', NULL, '2015-07-10', NULL, NULL, 1, NULL);

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