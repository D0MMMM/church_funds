-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 02:03 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `church_funds`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetFilteredFunds` (IN `start_date` DATE, IN `end_date` DATE, IN `depositor_name` VARCHAR(255))   BEGIN
    SET @sql = 'SELECT * FROM funds WHERE 1=1';
    
    IF start_date IS NOT NULL THEN
        SET @sql = CONCAT(@sql, ' AND date >= "', start_date, '"');
    END IF;
    
    IF end_date IS NOT NULL THEN
        SET @sql = CONCAT(@sql, ' AND date <= "', end_date, '"');
    END IF;
    
    IF depositor_name IS NOT NULL THEN
        SET @sql = CONCAT(@sql, ' AND depositor_name LIKE "%', depositor_name, '%"');
    END IF;
    
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetTotalFunds` (OUT `total_funds` DECIMAL(10,2))   BEGIN
    SELECT SUM(amount) INTO total_funds FROM funds;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(5, 'Daily expense'),
(6, 'Food'),
(7, 'Church needs'),
(8, 'Medicine');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `expenses_name` varchar(500) DEFAULT NULL,
  `expenses_amount` int(11) DEFAULT NULL,
  `expenses_date` date DEFAULT current_timestamp(),
  `spender_name` varchar(500) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `expenses_name`, `expenses_amount`, `expenses_date`, `spender_name`, `category_id`) VALUES
(33, 'Floorwax', 100, '2024-12-09', 'Cristina Perez', 7),
(35, 'Crispy pata', 250, '2024-12-09', 'Marjorie Bebanco', 6),
(36, 'BioFlu', 10, '2024-12-09', 'Marjorie Bebanco', 8),
(37, 'Saging', 5, '2024-12-09', 'Reca Corcelles', 6),
(38, 'Fare', 50, '2024-12-09', 'Cristina Perez', 5),
(39, 'Jolly evening', 250, '2023-12-09', 'Cristina Perez', 6);

--
-- Triggers `expenses`
--
DELIMITER $$
CREATE TRIGGER `after_expense_delete` AFTER DELETE ON `expenses` FOR EACH ROW BEGIN
    UPDATE total_balance SET balance = balance + OLD.expenses_amount;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_expense_insert` AFTER INSERT ON `expenses` FOR EACH ROW BEGIN
    UPDATE total_balance SET balance = balance - NEW.expenses_amount;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_expense_update` AFTER UPDATE ON `expenses` FOR EACH ROW BEGIN
    UPDATE total_balance SET balance = balance + OLD.expenses_amount - NEW.expenses_amount;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `funds`
--

CREATE TABLE `funds` (
  `id` int(11) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `depositor_name` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
PARTITION BY RANGE (year(`date`))
(
PARTITION p2020 VALUES LESS THAN (2021) ENGINE=InnoDB,
PARTITION p2021 VALUES LESS THAN (2022) ENGINE=InnoDB,
PARTITION p2022 VALUES LESS THAN (2023) ENGINE=InnoDB,
PARTITION p2023 VALUES LESS THAN (2024) ENGINE=InnoDB,
PARTITION p2024 VALUES LESS THAN (2025) ENGINE=InnoDB,
PARTITION p_future VALUES LESS THAN MAXVALUE ENGINE=InnoDB
);

--
-- Dumping data for table `funds`
--

INSERT INTO `funds` (`id`, `amount`, `date`, `depositor_name`) VALUES
(19, 250, '2023-12-09', 'Cristina Perez'),
(9, 200, '2024-12-07', 'Reca Corcelles'),
(11, 50, '2024-12-09', 'Cristina Perez'),
(12, 1000, '2024-12-09', 'Cristina Perez'),
(13, 150, '2024-12-09', 'Reca Corcelles'),
(14, 100, '2024-12-09', 'Marjorie Bebanco'),
(15, 250, '2024-12-09', 'Hazel Yray'),
(16, 100, '2024-12-09', 'Domz'),
(18, 500, '2024-12-09', 'Domzkie'),
(20, 100, '2024-12-15', 'asda');

--
-- Triggers `funds`
--
DELIMITER $$
CREATE TRIGGER `after_fund_delete` AFTER DELETE ON `funds` FOR EACH ROW BEGIN
    UPDATE total_balance SET balance = balance - OLD.amount;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_fund_insert` AFTER INSERT ON `funds` FOR EACH ROW BEGIN
    UPDATE total_balance SET balance = balance + NEW.amount;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_fund_update` AFTER UPDATE ON `funds` FOR EACH ROW BEGIN
    UPDATE total_balance SET balance = balance - OLD.amount + NEW.amount;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `total_balance`
--

CREATE TABLE `total_balance` (
  `id` int(11) NOT NULL,
  `balance` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `total_balance`
--

INSERT INTO `total_balance` (`id`, `balance`) VALUES
(1, 100.00);

-- --------------------------------------------------------

--
-- Stand-in structure for view `total_funds_view`
-- (See below for the actual view)
--
CREATE TABLE `total_funds_view` (
`total_funds` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Table structure for table `treasurer`
--

CREATE TABLE `treasurer` (
  `id` int(11) NOT NULL,
  `name` varchar(500) DEFAULT NULL,
  `image_path` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `treasurer`
--

INSERT INTO `treasurer` (`id`, `name`, `image_path`) VALUES
(1, NULL, '../assets/img/meow.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(500) DEFAULT NULL,
  `password` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(2, 'admin', '$2y$10$xo2z6.bH3vBhP3V6EspNve7DoD9iYZO4qUjnZc1zOxMwyTT4YlXra'),
(3, 'tina_pewex1', '$2y$10$dhbH.DKr/d4gQG0lsmGIS.LOw0JYsM6Xf6.s8u1qbvkaGOMmrqUfK'),
(4, 'reca_corcelles', '$2y$10$nCq5lhKd6vc7uR6QwNZfaeihlDc9QmyxI7.A2Ur5z/ILB9qNBXAK6'),
(5, 'tina_rec123', '$2y$10$6LSJ2VXFwtroAY5RZDoPUe//1pTy9dAKXzvn2AAXwsO6/FNFC9oia');

-- --------------------------------------------------------

--
-- Structure for view `total_funds_view`
--
DROP TABLE IF EXISTS `total_funds_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `total_funds_view`  AS SELECT sum(`funds`.`amount`) AS `total_funds` FROM `funds` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `funds`
--
ALTER TABLE `funds`
  ADD PRIMARY KEY (`id`,`date`);

--
-- Indexes for table `total_balance`
--
ALTER TABLE `total_balance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `treasurer`
--
ALTER TABLE `treasurer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `funds`
--
ALTER TABLE `funds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `total_balance`
--
ALTER TABLE `total_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `treasurer`
--
ALTER TABLE `treasurer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
