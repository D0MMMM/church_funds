-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2024 at 03:46 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

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

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(500) DEFAULT NULL,
  `password` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `expenses_name` varchar(500) DEFAULT NULL,
  `expenses_amount` int(11) DEFAULT NULL,
  `expenses_date` date DEFAULT current_timestamp(),
  `spender_name` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `expenses_name`, `expenses_amount`, `expenses_date`, `spender_name`) VALUES
(1, 'Floorwax', 150, '2024-05-23', 'Cristina gwapa kaayo as in');

-- --------------------------------------------------------

--
-- Table structure for table `funds`
--

CREATE TABLE `funds` (
  `id` int(11) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `date` date DEFAULT current_timestamp(),
  `depositor_name` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `funds`
--

INSERT INTO `funds` (`id`, `amount`, `date`, `depositor_name`) VALUES
(1, 500, '2024-05-25', 'Cristina perez'),
(2, 1000, '2024-05-22', 'Marjorie bebanco'),
(3, 250, '2024-05-25', 'Reca Corcelles'),
(4, 1250, '2024-05-20', 'Domenick Cute');

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
(1, 'Cristina Perez', 'assets/img/tina.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `funds`
--
ALTER TABLE `funds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `treasurer`
--
ALTER TABLE `treasurer`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `funds`
--
ALTER TABLE `funds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `treasurer`
--
ALTER TABLE `treasurer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
