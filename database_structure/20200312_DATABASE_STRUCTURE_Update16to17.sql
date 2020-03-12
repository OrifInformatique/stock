-- Update gestion de stock version 1.6 à version 1.7

-- Rename is_active to archive and reverse its values
ALTER TABLE `user` CHANGE `is_active` `archive` TINYINT(1) NULL DEFAULT '0'; 
UPDATE `user` SET `archive` = !`archive`;