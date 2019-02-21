-- Update gestion de stock version 1.4 à version 1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


--
-- Rename inventory_number to inventory_prefix
--
ALTER TABLE `item` CHANGE `inventory_number` `inventory_prefix` VARCHAR(45)
    CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

--
-- Change datetime creation fields to timestamp to make possible to use
-- default value CURRENT_TIMESTAMP in MySQL 5.5
--
ALTER TABLE `item` CHANGE `created_date` `created_date` TIMESTAMP
    NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `user` CHANGE `created_date` `created_date` TIMESTAMP
    NOT NULL DEFAULT CURRENT_TIMESTAMP;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
