-- Update from patch 0.8 to patch 0.10

ALTER TABLE `loan` CHANGE `item_localisation` `item_localisation` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;