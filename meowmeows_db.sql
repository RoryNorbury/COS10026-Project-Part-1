-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2025 at 07:57 AM
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
(1, 'MM26C', 'Oscar', 'Schmidt', '20/08/2005', 'Male', '14 test street', 'melbourne', 'VIC', '3000', 'meowmeows@test.com', '0401000000', 1, 0, 1, 'Rahhhhh', 'New', '2025-05-15 14:34:12'),
(2, 'MM00C', 'Rory', 'Norbury', '01/01/2000', 'Male', '12 Test Street', 'Melbourne', 'VIC', '3000', 'meowmeows@test.com', '0481000000', 1, 1, 1, 'No conscience', 'New', '2025-05-17 16:57:28');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Reference_number` varchar(6) NOT NULL,
  `Salary` varchar(50) NOT NULL,
  `Reports_to` varchar(50) DEFAULT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `Name`, `Reference_number`, `Salary`, `Reports_to`, `Description`) VALUES
(1, 'Data Analyst', 'MM26C', '$80,000 – $110,000 AUD per annum', 'Lead Data Scientist', 'Transform data into insights for decision-making across our global platform.'),
(2, 'Transition Technician', 'MM00C', '$70,000 – $95,000 AUD per annum', 'Upload Operations Manager', 'Support clients through the secure upload of their consciousness.');

-- --------------------------------------------------------

--
-- Table structure for table `job_data`
--

CREATE TABLE `job_data` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `info_type` enum('Responsibility','Essential_qualification','Preferable_qualification') NOT NULL,
  `info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_data`
--

INSERT INTO `job_data` (`id`, `job_id`, `info_type`, `info`) VALUES
(6, 1, 'Responsibility', 'Analyze and interpret large datasets'),
(7, 1, 'Responsibility', 'Create reports and dashboards'),
(8, 1, 'Responsibility', 'Identify trends and patterns'),
(9, 1, 'Responsibility', 'Work with product and engineering teams'),
(10, 1, 'Responsibility', 'Communicate insights clearly to stakeholders'),
(11, 2, 'Responsibility', 'Assist with the upload process'),
(12, 2, 'Responsibility', 'Troubleshoot issues during transitions'),
(13, 2, 'Responsibility', 'Communicate clearly with clients'),
(14, 2, 'Responsibility', 'Work with internal teams to improve the experience'),
(15, 2, 'Responsibility', 'Maintain data accuracy and privacy'),
(16, 1, 'Essential_qualification', 'Bachelor’s in Data Science or related field'),
(17, 1, 'Essential_qualification', '3+ years in data analytics'),
(18, 1, 'Essential_qualification', 'Proficient in SQL and Python'),
(19, 1, 'Essential_qualification', 'Strong analytical and communication skills'),
(20, 2, 'Essential_qualification', 'Diploma or degree in IT or Biomedical Tech'),
(21, 2, 'Essential_qualification', '2+ years in technical support roles'),
(22, 2, 'Essential_qualification', 'Excellent interpersonal skills'),
(23, 2, 'Essential_qualification', 'Experience with troubleshooting'),
(24, 2, 'Essential_qualification', 'Familiar with privacy and security protocols'),
(25, 1, 'Preferable_qualification', 'Master’s degree'),
(26, 1, 'Preferable_qualification', 'Experience with cloud platforms'),
(27, 1, 'Preferable_qualification', 'Understanding of data privacy regulations'),
(28, 2, 'Preferable_qualification', 'Neurotech or medtech experience'),
(29, 2, 'Preferable_qualification', 'Basic scripting skills'),
(30, 2, 'Preferable_qualification', 'A calm and steady demeanor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eoi`
--
ALTER TABLE `eoi`
  ADD PRIMARY KEY (`EOInumber`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_data`
--
ALTER TABLE `job_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eoi`
--
ALTER TABLE `eoi`
  MODIFY `EOInumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `job_data`
--
ALTER TABLE `job_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `job_data`
--
ALTER TABLE `job_data`
  ADD CONSTRAINT `job_data_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
