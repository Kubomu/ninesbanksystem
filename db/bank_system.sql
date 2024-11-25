
-- Database: `bank_system`
CREATE DATABASE IF NOT EXISTS `bank_system`;
USE `bank_system`;

-- --------------------------------------------------------

-- Table structure for `accounts`
CREATE TABLE `accounts` (
  `account_id` INT NOT NULL AUTO_INCREMENT,
  `customer_id` INT DEFAULT NULL,
  `account_number` VARCHAR(20) DEFAULT NULL,
  `account_balance` DECIMAL(15,2) DEFAULT '0.00',
  `account_open_date` DATE DEFAULT NULL,
  `status` ENUM('Active','Closed') DEFAULT 'Active',
  `account_type` ENUM('Savings','Current','Fixed Deposit') DEFAULT 'Savings',
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `account_number` (`account_number`),
  KEY `fk_customer` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

-- Table structure for `admins`
CREATE TABLE `admins` (
  `admin_id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('Loan Officer','Teller','Admin') DEFAULT 'Teller',
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

-- Table structure for `customers`
CREATE TABLE `customers` (
  `customer_id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(100) DEFAULT NULL,
  `last_name` VARCHAR(100) DEFAULT NULL,
  `gender` ENUM('Male','Female','Other') DEFAULT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `phone_number` VARCHAR(15) DEFAULT NULL,
  `address` TEXT,
  `date_of_birth` DATE DEFAULT NULL,
  `account_type` ENUM('Savings','Current','Fixed Deposit') NOT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

-- Table structure for `loans`
CREATE TABLE `loans` (
  `loan_id` INT NOT NULL AUTO_INCREMENT,
  `customer_id` INT DEFAULT NULL,
  `loan_amount` DECIMAL(15,2) NOT NULL,
  `loan_date` DATE DEFAULT NULL,
  `repayment_date` DATE DEFAULT NULL,
  `status` ENUM('Approved','Pending','Rejected') DEFAULT 'Pending',
  PRIMARY KEY (`loan_id`),
  KEY `fk_loans_customer` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------
CREATE TABLE `payments` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `loan_id` int DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_amount` decimal(10,2) DEFAULT NULL,
  `remaining_balance` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `loan_id` (`loan_id`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Sample data for `accounts`
INSERT INTO `accounts` (`account_id`, `customer_id`, `account_number`, `account_balance`, `account_open_date`, `status`, `account_type`) VALUES
(1, 1, '000123456789', 1000.00, '2024-01-01', 'Active', 'Savings');

-- Sample data for `admins`
INSERT INTO `admins` (`admin_id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$adminhashedpassword', 'Admin');

-- Sample data for `customers`
INSERT INTO `customers` (`customer_id`, `first_name`, `last_name`, `gender`, `email`, `phone_number`, `address`, `date_of_birth`, `account_type`) VALUES
(1, 'John', 'Doe', 'Male', 'john.doe@example.com', '1234567890', '123 Main St', '1990-01-01', 'Savings');

-- Sample data for `loans`
INSERT INTO `loans` (`loan_id`, `customer_id`, `loan_amount`, `loan_date`, `repayment_date`, `status`) VALUES
(1, 1, 5000.00, '2024-06-01', '2024-12-01', 'Approved');

-- Add foreign keys
ALTER TABLE `accounts`
  ADD CONSTRAINT `fk_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE SET NULL;

ALTER TABLE `loans`
  ADD CONSTRAINT `fk_loans_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE SET NULL;

-- Finish
COMMIT;
