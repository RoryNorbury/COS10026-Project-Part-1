-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 16, 2025 at 02:36 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `meowmeows_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `eoi`
--

CREATE TABLE `eoi` (
  `EOInumber` int(11) NOT NULL,
  `JobReferenceNumber` varchar(5) NOT NULL,
  `FirstName` varchar(20) NOT NULL,
  `LastName` varchar(20) NOT NULL,
  `DateOfBirth` varchar(10) NOT NULL,
  `Gender` varchar(20) NOT NULL,
  `StreetAddress` varchar(40) NOT NULL,
  `SuburbTown` varchar(40) NOT NULL,
  `State` varchar(3) NOT NULL,
  `Postcode` varchar(4) NOT NULL,
  `EmailAddress` varchar(255) NOT NULL,
  `PhoneNumber` varchar(12) NOT NULL,
  `Skill1` tinyint(1) DEFAULT 0,
  `Skill2` tinyint(1) DEFAULT 0,
  `Skill3` tinyint(1) DEFAULT 0,
  `OtherSkills` text DEFAULT NULL,
  `Status` enum('New','Current','Final') DEFAULT 'New',
  `ApplicationTimestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `eoi`
--

INSERT INTO `eoi` (`EOInumber`, `JobReferenceNumber`, `FirstName`, `LastName`, `DateOfBirth`, `Gender`, `StreetAddress`, `SuburbTown`, `State`, `Postcode`, `EmailAddress`, `PhoneNumber`, `Skill1`, `Skill2`, `Skill3`, `OtherSkills`, `Status`, `ApplicationTimestamp`) VALUES
(1, 'MM26C', 'Oscar', 'Schmidt', '20/08/2005', 'Male', '14 test street', 'melbourne', 'VIC', '3000', 'meowmeows@test.com', '0401000000', 1, 0, 1, 'Rahhhhh', 'New', '2025-05-16 00:34:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eoi`
--
ALTER TABLE `eoi`
  ADD PRIMARY KEY (`EOInumber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eoi`
--
ALTER TABLE `eoi`
  MODIFY `EOInumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
