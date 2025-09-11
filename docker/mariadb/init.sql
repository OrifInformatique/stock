-- Create test database if not exists
CREATE DATABASE IF NOT EXISTS stock_test_db;

-- Drop user if it already exists
DROP USER IF EXISTS 'stock_test_user'@'%';

-- Create user with mysql_native_password
CREATE USER 'stock_test_user'@'%' IDENTIFIED BY 'stock_test_password';

-- Grant privileges
GRANT ALL PRIVILEGES ON stock_test_db.* TO 'stock_test_user'@'%';
FLUSH PRIVILEGES;


-- Create main database if not exists
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
