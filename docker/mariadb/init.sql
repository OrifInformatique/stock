-- Create database if not exists
CREATE DATABASE IF NOT EXISTS stock_db;

-- Drop user if it already exists
DROP USER IF EXISTS 'stock_user'@'%';

-- Create user with mysql_native_password
CREATE USER 'stock_user'@'%' IDENTIFIED BY 'stock_password';

-- Grant privileges
GRANT ALL PRIVILEGES ON stock_db.* TO 'stock_user'@'%';
FLUSH PRIVILEGES;

-- Switch to the created database
USE stock_db;

-- Add your table creation statements here
-- Example:
-- CREATE TABLE users (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     username VARCHAR(50) NOT NULL,
--     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
-- );