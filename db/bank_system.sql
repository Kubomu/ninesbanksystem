-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 20, 2024 at 09:57 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bank_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `account_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `account_number` varchar(20) DEFAULT NULL,
  `account_balance` decimal(15,2) DEFAULT '0.00',
  `account_open_date` date DEFAULT NULL,
  `status` enum('Active','Closed') DEFAULT 'Active',
  `account_type` enum('Savings','Current','Fixed Deposit') DEFAULT 'Savings',
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `account_number` (`account_number`),
  KEY `fk_customer` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `customer_id`, `account_number`, `account_balance`, `account_open_date`, `status`, `account_type`) VALUES
(36, 22, '0210820011', 476749771.00, '2024-09-29', 'Active', 'Current'),
(34, 16, '0210820007', 252232677.00, '2024-09-29', 'Active', 'Savings'),
(32, 20, '0210820003', 700000000.00, '2024-09-29', 'Active', 'Current'),
(33, 17, '0210820005', 77777216832.00, '2024-09-29', 'Active', 'Savings'),
(31, 19, '0210820002', 20121356.00, '2000-08-08', 'Active', 'Fixed Deposit'),
(30, 18, '0210820001', 4357653.00, '2006-08-12', 'Closed', 'Current'),
(35, 21, '0210820009', 8908923989.00, '2024-09-29', 'Active', 'Fixed Deposit'),
(37, 23, '0210820013', 72002000.00, '2024-09-30', 'Active', 'Savings'),
(38, 24, '0210820015', 630000000.00, '2024-09-30', 'Active', 'Savings'),
(39, 25, '0210820017', 692981280.00, '2024-09-30', 'Active', 'Savings'),
(40, 26, '0210820019', 77777777777.00, '2024-09-30', 'Active', 'Savings'),
(41, 27, '0210820021', 700000000.00, '2024-10-01', 'Active', 'Savings'),
(42, 28, '0210820023', 699999334.00, '2024-10-02', 'Active', 'Current'),
(43, 29, '0210820025', 20015111.00, '2024-10-02', 'Active', 'Current'),
(44, 30, '0210820027', 80000000000.00, '2024-10-06', 'Active', 'Savings'),
(45, 41, '0210820029', 23456789.00, '2024-10-06', 'Active', 'Savings'),
(46, 42, '0210820031', 700000000.00, '2024-10-06', 'Active', 'Savings'),
(47, 43, '0210820033', 20000000.00, '2024-10-07', 'Active', 'Savings'),
(48, 44, '0210820035', 2000000000.00, '2024-10-18', 'Active', 'Current'),
(49, 45, '0210820037', 79999980000.00, '2024-11-14', 'Active', 'Fixed Deposit'),
(50, 46, '0210820039', 300000.00, '2024-11-15', 'Active', 'Current');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('Loan Officer','Teller','Admin') DEFAULT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`, `role`) VALUES
(5, 'ADMIN', '$2y$10$OVJGqZRr.I/ITu2Z6w5XTO7GhhFi7dBbwp4UOWe6yw3YmiGcOag/a', 'Admin'),
(7, 'TELLER', '$2y$10$B.tDPTzG6uuvmElPJPHheuo68Dky2ea5fCGsSRX3pX3FVDZTXcg.O', 'Teller'),
(9, 'LOAN OFFICER', '$2y$10$wBFmxAiMZjkyTmb9tZpo3O7/W0sbnAXxmLUh/cLFPMseAuIN9Bi/G', 'Loan Officer'),
(11, 'Lambert@Loans', '$2y$10$qpS9XqrsfrQHngD8W2oDguGhAlvcf4hcV0M4onYyd/UGNuvgAbOpm', 'Loan Officer'),
(12, 'Elvis@Teller', '$2y$10$/DV/t2OhHzwd7iFK03c5Ju3MY5Zyr5udmftn.uq/QjTH5pCErwsi2', 'Teller'),
(13, 'Kubomu@Admin', '$2y$10$pN7r/etiWJO14n1O8xHC4uQFYrj71M87Ta0kf25ksscRcfLBTY07O', 'Admin'),
(14, 'Vivian@Teller', '$2y$10$aTdzxsff/3/cken3JK.7..VaEh6j1ByLXSiwiJHl70cy8m2PNMr6K', 'Teller'),
(15, 'Bryson@Teller', '$2y$10$hdbMxs4f8G4wXlbX3yDDKux0oXrwH8Mu0undg7t9pFGReJ5Hbmswm', 'Teller'),
(16, 'Ronald@teller', '$2y$10$Vf.cB2Yy1GbRURkb0NAbC.kLLO3WrN1Ru.lIyXTRrb14Rc247.fPG', 'Teller');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `address` text,
  `date_of_birth` date DEFAULT NULL,
  `account_type` enum('Savings','Current','Fixed Deposit') NOT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `first_name`, `last_name`, `gender`, `email`, `phone_number`, `address`, `date_of_birth`, `account_type`) VALUES
(18, 'Amra', 'Namata', 'Female', 'Namata@gmail.com', '0772865123', 'Bunga', '2000-08-14', 'Current'),
(25, 'Raphael', 'Nadal', 'Male', 'nadal@gmail.com', '0789937828', 'Gulu, Uganda', '2003-08-14', 'Savings'),
(16, 'Kubomu', 'Edwin', 'Male', 'kubomuedwin@gmail.com', '0753422056', 'Gulu, Uganda', '2000-08-21', 'Savings'),
(17, 'Kubomu ', 'Herbert', 'Male', 'Herbert@gmail.com', '0772996151', 'Bundibugyo', '1995-03-21', 'Savings'),
(20, 'Sifuna', 'Sharif', 'Male', 'Sharif@gmail.com', '0753422567', 'Jinja', '1998-02-15', 'Current'),
(21, 'Bazalaki', 'Timothy', 'Male', 'Bazalaki@gmail.com', '0788159876', 'Jinja', '2000-02-14', 'Fixed Deposit'),
(22, 'Nambozo', 'Betty', 'Female', 'Bakileke@gmail.com', '0701010123', 'Mukono', '1987-08-21', 'Current'),
(23, 'Byamukama', 'Elvis', 'Male', 'Elvis@gmail.com', '0789873663', 'Laro', '1999-09-09', 'Savings'),
(42, 'Ndugga', 'Adrian', 'Male', 'Ndugga@gmail.com', '0799862056', 'Gulu, Uganda', '1999-02-22', 'Savings'),
(27, 'Wandera ', 'Arafat', 'Male', 'Arafat@gmail.com', '0789123456', 'Mukono', '1999-03-22', 'Savings'),
(28, 'Moris', 'Omaido', 'Male', 'Moris@gmail.com', '0789373636', 'Soroti', '2000-02-09', 'Current'),
(29, 'Owen', 'Lamar', 'Male', 'Owen@gmail.com', '0763636638', 'Gulu, Uganda', '2000-09-09', 'Current'),
(30, 'Basajja', 'Ibrahim', 'Male', 'Basajja@gmail.com', '0753123456', 'Gulu, Uganda', '2000-08-21', 'Current'),
(41, 'Wakoko', 'Samuel', 'Male', 'Wakoko@gmail.com', '0753987656', 'Mbale, Uganda', '1988-02-05', 'Savings'),
(43, 'Wilobo', 'Vincent', 'Male', 'Wilobo@gmail.com', '0791222056', 'Gulu, Uganda', '1986-08-21', 'Savings'),
(44, 'Kidega', 'Ronald', 'Male', 'Ronald@gmail.com', '0788125765', 'Gulu, Uganda', '1998-02-12', 'Current'),
(45, 'Mugisha', 'Eugene', 'Male', 'Mugisha@gmail.com', '0772123456', 'Gulu, Uganda', '2003-08-14', 'Fixed Deposit'),
(46, 'Wokorach', 'James', 'Male', 'James@gmail.com', '07896545443', '256\r\nLaaro', '2003-08-15', 'Current');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

DROP TABLE IF EXISTS `loans`;
CREATE TABLE IF NOT EXISTS `loans` (
  `loan_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `loan_type` enum('Personal','Mortgage','Auto','Education') NOT NULL,
  `loan_amount` decimal(10,2) DEFAULT NULL,
  `loan_start_date` date DEFAULT NULL,
  `interest_rate` decimal(5,2) DEFAULT NULL,
  `loan_status` enum('Pending','Approved','Paid Off') DEFAULT 'Pending',
  `total_amount_payable` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`loan_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`loan_id`, `customer_id`, `loan_type`, `loan_amount`, `loan_start_date`, `interest_rate`, `loan_status`, `total_amount_payable`) VALUES
(59, 46, 'Education', 300000.00, '2024-11-15', 2.00, 'Paid Off', 306000.00),
(58, 45, 'Education', 3000000.00, '2024-11-14', 2.00, 'Paid Off', 3060000.00),
(57, 44, 'Education', 5000000.00, '2024-10-18', 12.00, 'Paid Off', 5600000.00),
(56, 43, 'Personal', 99999.98, '2024-10-07', 12.00, 'Paid Off', 111999.98),
(55, 42, 'Personal', 123345.00, '2024-10-06', 1.98, 'Paid Off', 125787.23),
(54, 30, 'Personal', 23456.00, '2024-10-06', 2.00, 'Paid Off', 23925.12),
(53, 41, 'Personal', 12345.00, '2024-10-06', 2.00, 'Paid Off', 12591.90);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `loan_id` int DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_amount` decimal(10,2) DEFAULT NULL,
  `remaining_balance` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `loan_id` (`loan_id`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `loan_id`, `payment_date`, `payment_amount`, `remaining_balance`) VALUES
(77, 59, '2024-11-15', 106000.00, 0.00),
(76, 59, '2024-11-15', 200000.00, 106000.00),
(75, 58, '2024-11-14', 3000000.00, 0.00),
(74, 58, '2024-11-14', 60000.00, 3000000.00),
(73, 57, '2024-10-18', 5000000.00, 0.00),
(72, 57, '2024-10-18', 600000.00, 5000000.00),
(71, 56, '2024-10-08', 900.00, -0.02),
(70, 56, '2024-10-07', 111100.00, 899.98),
(69, 53, '2024-10-06', 12592.00, -0.10),
(68, 55, '2024-10-06', 1.00, -0.77),
(67, 54, '2024-10-06', 23926.00, -0.88),
(66, 55, '2024-10-06', 125787.00, 0.23);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `transaction_id` int NOT NULL AUTO_INCREMENT,
  `source_account_id` int NOT NULL,
  `destination_account_id` int NOT NULL,
  `transaction_date` datetime DEFAULT NULL,
  `transaction_type` enum('Deposit','Withdrawal','Transfer') DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`transaction_id`),
  KEY `source_account_id` (`source_account_id`),
  KEY `destination_account_id` (`destination_account_id`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `source_account_id`, `destination_account_id`, `transaction_date`, `transaction_type`, `amount`, `description`) VALUES
(54, 34, 33, '2024-09-29 07:48:30', 'Transfer', 234.00, 'Teller'),
(53, 34, 35, '2024-09-29 07:46:46', 'Transfer', 5667.00, 'Teller'),
(52, 34, 35, '2024-09-29 07:44:51', 'Transfer', 5667.00, 'Teller'),
(51, 34, 35, '2024-09-29 07:44:15', 'Transfer', 5667.00, 'Teller'),
(50, 34, 33, '2024-09-29 07:36:34', 'Transfer', 444444.00, 'Teller'),
(49, 30, 33, '2024-09-29 07:34:37', 'Transfer', 44.00, 'Teller'),
(48, 30, 31, '2024-09-29 07:32:42', 'Transfer', 45678.00, 'Teller'),
(47, 30, 31, '2024-09-29 07:26:35', 'Transfer', 45678.00, 'Teller'),
(55, 36, 34, '2024-09-29 14:54:50', 'Transfer', 7.00, 'Teller'),
(56, 36, 34, '2024-09-29 14:55:37', 'Transfer', 99999999.99, 'Teller'),
(57, 37, 36, '2024-09-30 08:21:07', 'Transfer', 10000.00, 'Teller'),
(58, 36, 37, '2024-09-30 10:10:36', 'Transfer', 4000.00, 'Teller'),
(59, 36, 37, '2024-09-30 10:11:30', 'Transfer', 4000.00, 'Teller'),
(60, 36, 31, '2024-09-30 11:15:14', 'Transfer', 30000.00, 'Teller'),
(61, 38, 37, '2024-09-30 12:37:45', 'Transfer', 70000000.00, 'Teller'),
(62, 39, 34, '2024-09-30 13:24:26', 'Transfer', 7000000.00, 'Sendwave'),
(63, 39, 30, '2024-09-30 15:22:58', 'Transfer', 23.00, 'Teller'),
(64, 39, 30, '2024-10-01 08:52:35', 'Transfer', 33.00, 'Teller'),
(65, 39, 30, '2024-10-01 08:54:45', 'Transfer', 6666.00, 'Teller'),
(66, 39, 30, '2024-10-01 08:56:06', 'Transfer', 4000.00, 'Sendwave'),
(67, 39, 30, '2024-10-01 09:05:06', 'Transfer', 666.00, 'Teller'),
(68, 39, 30, '2024-10-01 09:14:31', 'Transfer', 666.00, 'Teller'),
(69, 42, 37, '2024-10-02 08:05:12', 'Transfer', 4000.00, 'Teller'),
(70, 43, 42, '2024-10-02 08:44:55', 'Transfer', 4000.00, 'Teller'),
(71, 30, 43, '2024-10-04 01:14:23', 'Transfer', 7777.00, 'Sendwave'),
(72, 33, 43, '2024-10-06 09:53:43', 'Transfer', 5667.00, 'Teller'),
(73, 30, 43, '2024-10-06 10:11:17', 'Transfer', 5667.00, 'Sendwave'),
(74, 33, 37, '2024-10-07 05:07:02', 'Transfer', 1000000.00, 'Teller'),
(75, 49, 34, '2024-11-14 18:43:20', 'Transfer', 20000.00, 'Sendwave');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
