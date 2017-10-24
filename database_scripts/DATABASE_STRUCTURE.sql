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
-- Table `stock`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stock`.`user` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `lastname` VARCHAR(45) NULL,
  `firstname` VARCHAR(45) NULL,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NULL,
  `created_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_type_id` INT NULL,
  `is_active` TINYINT(1) NULL DEFAULT 1,
  PRIMARY KEY (`user_id`),
  INDEX `fk_user_type_id_idx` (`user_type_id` ASC),
  CONSTRAINT `fk_user_type_id`
    FOREIGN KEY (`user_type_id`)
    REFERENCES `stock`.`user_type` (`user_type_id`)
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
-- Table `stock`.`item_condition`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stock`.`item_condition` (
  `item_condition_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`item_condition_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `stock`.`supplier`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stock`.`supplier` (
  `supplier_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `address_line1` VARCHAR(100) NULL,
  `address_line2` VARCHAR(100) NULL,
  `zip` VARCHAR(45) NULL,
  `city` VARCHAR(100) NULL,
  `country` VARCHAR(45) NULL,
  `tel` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  PRIMARY KEY (`supplier_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `stock`.`item_group`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stock`.`item_group` (
  `item_group_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`item_group_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `stock`.`item`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `stock`.`item` (
  `item_id` INT NOT NULL AUTO_INCREMENT,
  `inventory_number` VARCHAR(45) NULL,
  `name` VARCHAR(100) NULL,
  `description` TEXT NULL,
  `image` VARCHAR(255) NULL,
  `serial_number` VARCHAR(45) NULL,
  `buying_price` FLOAT NULL,
  `buying_date` DATE NULL,
  `warranty_duration` INT NULL,
  `remarks` TEXT NULL,
  `linked_file` VARCHAR(255) NULL,
  `supplier_id` INT NULL,
  `supplier_ref` VARCHAR(45) NULL,
  `created_by_user_id` INT NULL,
  `created_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by_user_id` INT NULL,
  `modified_date` DATETIME NULL,
  `checked_by_user_id` INT NULL,
  `checked_date` DATETIME NULL,
  `stocking_place_id` INT NULL,
  `item_condition_id` INT NULL,
  `item_group_id` INT NULL,
  PRIMARY KEY (`item_id`),
  INDEX `fk_created_by_user_id_idx` (`created_by_user_id` ASC),
  INDEX `fk_stocking_place_id_idx` (`stocking_place_id` ASC),
  INDEX `fk_modified_by_user_id_idx` (`modified_by_user_id` ASC),
  INDEX `fk_item_condition_id_idx` (`item_condition_id` ASC),
  INDEX `fk_supplier_id_idx` (`supplier_id` ASC),
  INDEX `fk_checked_by_user_id_idx` (`checked_by_user_id` ASC),
  INDEX `fk_item_group_id_idx` (`item_group_id` ASC),
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
  CONSTRAINT `fk_item_condition_id`
    FOREIGN KEY (`item_condition_id`)
    REFERENCES `stock`.`item_condition` (`item_condition_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_supplier_id`
    FOREIGN KEY (`supplier_id`)
    REFERENCES `stock`.`supplier` (`supplier_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_checked_by_user_id`
    FOREIGN KEY (`checked_by_user_id`)
    REFERENCES `stock`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_item_group_id`
    FOREIGN KEY (`item_group_id`)
    REFERENCES `stock`.`item_group` (`item_group_id`)
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
  `planned_return_date` DATE NULL,
  `real_return_date` DATE NULL,
  `item_id` INT NOT NULL,
  `loan_by_user_id` INT NOT NULL,
  `loan_to_user_id` INT NOT NULL,
  PRIMARY KEY (`loan_id`),
  INDEX `fk_loan_item_id_idx` (`item_id` ASC),
  INDEX `fk_loan_by_user_id_idx` (`loan_by_user_id` ASC),
  INDEX `fk_loan_to_user_id_idx` (`loan_to_user_id` ASC),
  CONSTRAINT `fk_loan_item_id`
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
  `item_tag_id` INT NOT NULL,
  `item_id` INT NOT NULL,
  PRIMARY KEY (`item_tag_link_id`),
  INDEX `fk_item_tag_id_idx` (`item_tag_id` ASC),
  INDEX `fk_item_id_idx` (`item_id` ASC),
  CONSTRAINT `fk_item_tag_id`
    FOREIGN KEY (`item_tag_id`)
    REFERENCES `stock`.`item_tag` (`item_tag_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_item_id`
    FOREIGN KEY (`item_id`)
    REFERENCES `stock`.`item` (`item_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
