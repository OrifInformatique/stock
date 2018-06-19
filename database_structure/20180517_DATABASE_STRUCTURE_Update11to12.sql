-- Update gestion de stock version 1.1 à version 1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


--
-- Add short_name field in item_tag table
--
ALTER TABLE `item_tag` ADD `short_name` VARCHAR(3) NULL AFTER `name`;

--
-- Add short_name field in item_group table
--
ALTER TABLE `item_group` ADD `short_name` VARCHAR(2) NULL AFTER `name`;

--
-- Autorize null value in loan_to_user_id field
--
ALTER TABLE `loan` CHANGE `loan_to_user_id` `loan_to_user_id` INT(11) NULL;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
