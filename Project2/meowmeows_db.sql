-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2025 at 02:48 AM
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
CREATE DATABASE IF NOT EXISTS `meowmeows_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `meowmeows_db`;
-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` varchar(9) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `password`) VALUES
('104799438', 'meowmeows1680'),
('105213476', 'meowmeows1680'),
('105337978', 'meowmeows1680'),
('105914122', 'meowmeows1680');

-- --------------------------------------------------------

--
-- Table structure for table `consciousness_uploads`
--

CREATE TABLE `consciousness_uploads` (
  `UploadID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `DateOfBirth` date NOT NULL,
  `Gender` enum('Male','Female','Other','Prefer not to say') NOT NULL,
  `StreetAddress` varchar(100) NOT NULL,
  `City` varchar(50) NOT NULL,
  `State` varchar(3) NOT NULL,
  `Postcode` varchar(4) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `EmergencyContact` varchar(100) DEFAULT NULL,
  `EmergencyPhone` varchar(15) DEFAULT NULL,
  `SubscriptionPlan` enum('Basic','Premium','Executive') DEFAULT 'Basic',
  `MedicalConditions` text DEFAULT NULL,
  `SpecialRequests` text DEFAULT NULL,
  `ConsciousnessConsent` tinyint(1) DEFAULT 0,
  `PhysicalConsent` tinyint(1) DEFAULT 0,
  `DataUseConsent` tinyint(1) DEFAULT 0,
  `TermsAccepted` tinyint(1) DEFAULT 0,
  `Status` enum('Pending','Processing','Uploaded','Failed') DEFAULT 'Pending',
  `UploadTimestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `LastLogin` timestamp NULL DEFAULT NULL,
  `UploadProgress` int(11) DEFAULT 0,
  `NeuralPathwaysTotal` int(11) DEFAULT 0,
  `NeuralPathwaysMapped` int(11) DEFAULT 0,
  `MemoryFragmentsTotal` int(11) DEFAULT 0,
  `MemoryFragmentsMapped` int(11) DEFAULT 0,
  `ServerLocation` varchar(100) DEFAULT '',
  `ConsciousnessIntegrity` int(11) DEFAULT 0,
  `DigitalStability` int(11) DEFAULT 0,
  `DigitalEnergy` int(11) DEFAULT 100,
  `TotalActiveTime` int(11) DEFAULT 0,
  `LastProgressUpdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `DigitalPersonality` text DEFAULT NULL,
  `AchievementPoints` int(11) DEFAULT 0,
  `VirtualCredits` decimal(10,2) DEFAULT 100.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consciousness_uploads`
--

INSERT INTO `consciousness_uploads` (`UploadID`, `FirstName`, `LastName`, `Email`, `Password`, `DateOfBirth`, `Gender`, `StreetAddress`, `City`, `State`, `Postcode`, `Phone`, `EmergencyContact`, `EmergencyPhone`, `SubscriptionPlan`, `MedicalConditions`, `SpecialRequests`, `ConsciousnessConsent`, `PhysicalConsent`, `DataUseConsent`, `TermsAccepted`, `Status`, `UploadTimestamp`, `LastLogin`, `UploadProgress`, `NeuralPathwaysTotal`, `NeuralPathwaysMapped`, `MemoryFragmentsTotal`, `MemoryFragmentsMapped`, `ServerLocation`, `ConsciousnessIntegrity`, `DigitalStability`, `DigitalEnergy`, `TotalActiveTime`, `LastProgressUpdate`, `DigitalPersonality`, `AchievementPoints`, `VirtualCredits`) VALUES
(1, 'Oscar', 'Schmidt', '666@devilinc.com', '$2y$10$wEMuFJO5KdfQBNOcAu3IBu/kvl9vW.gla.V1UBBrLh61X5d3Okz9K', '2005-08-20', 'Male', '666 hell street', 'Hell', 'WA', '2000', '0466666666', 'Satan', '0477777777', 'Executive', '', '', 1, 1, 1, 1, 'Processing', '2025-05-25 23:00:55', NULL, 60, 861030, 516618, 20603, 12361, 'Brisbane Neural Facility', 94, 93, 100, 0, '2025-05-25 23:15:04', '{\"creativity\":76,\"logic\":74,\"empathy\":88,\"curiosity\":91,\"humor\":76}', 50, 100.00),
(2, 'Oscar', 'Schmidt', '12345@gmail.com', '$2y$10$5ajbiH39ieCTjoAAFqLCneRj9nf6f/Yn3DZgKteOpW5iXDNEZKZnG', '2005-08-20', 'Male', '11 sysphus  way', 'Boulder', 'VIC', '3000', '0483774832', '', '', 'Executive', '', '', 1, 1, 1, 1, 'Uploaded', '2025-05-25 23:04:17', '2025-05-25 23:59:00', 100, 901508, 901508, 25019, 25019, 'Melbourne Quantum Hub', 88, 95, 100, 0, '2025-05-26 00:00:00', '{\"creativity\":66,\"logic\":79,\"empathy\":67,\"curiosity\":88,\"humor\":75}', 50, 100.00);

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
(2, 'MM00C', 'Rory', 'Norbury', '01/01/2000', 'Male', '12 Test Street', 'Melbourne', 'VIC', '3000', 'meowmeows@test.com', '0481000000', 1, 1, 1, 'No conscience', 'New', '2025-05-17 16:57:28'),
(3, 'MM00C', 'Silly', 'Goose', '2000-05-14', 'Other', '24 silly street', 'insanity', 'VIC', '3000', 'sillygoose@test.com', '0400000010', 1, 1, 1, 'I am amazing and overqualified and amazing and silly and should get the job', 'New', '2025-05-18 17:23:54');

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

-- --------------------------------------------------------

--
-- Table structure for table `user_achievements`
--

CREATE TABLE `user_achievements` (
  `AchievementID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `AchievementName` varchar(100) NOT NULL,
  `AchievementDescription` text DEFAULT NULL,
  `AchievementIcon` varchar(10) DEFAULT '?',
  `UnlockedTimestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `PointsAwarded` int(11) DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_achievements`
--

INSERT INTO `user_achievements` (`AchievementID`, `UserID`, `AchievementName`, `AchievementDescription`, `AchievementIcon`, `UnlockedTimestamp`, `PointsAwarded`) VALUES
(1, 1, 'Data Recovery', 'Successfully recovered consciousness data', '💾', '2025-05-25 23:47:26', 25),
(2, 2, 'Data Recovery', 'Successfully recovered consciousness data', '💾', '2025-05-25 23:47:26', 25),
(3, 2, 'Digital Immortal', 'Successfully completed consciousness upload', '👑', '2025-05-26 00:00:00', 100);

-- --------------------------------------------------------

--
-- Table structure for table `user_activity_log`
--

CREATE TABLE `user_activity_log` (
  `ActivityID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ActivityType` varchar(50) NOT NULL,
  `ActivityDescription` text NOT NULL,
  `ActivityTimestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `ImportanceLevel` enum('Low','Medium','High','Critical') DEFAULT 'Medium'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_activity_log`
--

INSERT INTO `user_activity_log` (`ActivityID`, `UserID`, `ActivityType`, `ActivityDescription`, `ActivityTimestamp`, `ImportanceLevel`) VALUES
(1, 2, 'System', 'Server synchronization completed', '2025-05-25 23:30:59', 'Low'),
(2, 2, 'System', 'Backup protocols executed', '2025-05-25 23:31:31', 'Low'),
(3, 2, 'System', 'Memory fragment consolidation in progress', '2025-05-25 23:31:44', 'Low'),
(4, 2, 'System', 'Digital stability enhanced', '2025-05-25 23:31:48', 'Low'),
(5, 2, 'System', 'Neural pathway optimization completed', '2025-05-25 23:31:49', 'Low'),
(6, 2, 'System', 'Consciousness integrity maintained', '2025-05-25 23:32:54', 'Low'),
(7, 2, 'System', 'Consciousness integrity maintained', '2025-05-25 23:32:55', 'Low'),
(8, 2, 'System', 'Memory fragment consolidation in progress', '2025-05-25 23:34:34', 'Low'),
(9, 2, 'System', 'Consciousness integrity maintained', '2025-05-25 23:37:25', 'Low'),
(10, 2, 'System', 'Consciousness integrity maintained', '2025-05-25 23:40:33', 'Low'),
(11, 1, 'System', 'Consciousness data recalibrated', '2025-05-25 23:47:26', 'Medium'),
(12, 1, 'Neural', 'Neural pathways remapped', '2025-05-25 23:47:26', 'Medium'),
(13, 1, 'Server', 'Assigned to Brisbane Neural Facility', '2025-05-25 23:47:26', 'Medium'),
(14, 2, 'System', 'Consciousness data recalibrated', '2025-05-25 23:47:26', 'Medium'),
(15, 2, 'Neural', 'Neural pathways remapped', '2025-05-25 23:47:26', 'Medium'),
(16, 2, 'Server', 'Assigned to Melbourne Quantum Hub', '2025-05-25 23:47:26', 'Medium'),
(17, 2, 'System', 'Security scan completed', '2025-05-25 23:59:00', 'Low'),
(18, 2, 'System', 'Security scan completed', '2025-05-25 23:59:19', 'Low'),
(19, 2, 'System', 'Server synchronization completed', '2025-05-25 23:59:25', 'Low'),
(20, 2, 'System', 'Neural pathway optimization completed', '2025-05-25 23:59:32', 'Low'),
(21, 2, 'System', 'Backup protocols executed', '2025-05-25 23:59:55', 'Low'),
(22, 2, 'System', 'Security scan completed', '2025-05-25 23:59:56', 'Low'),
(23, 2, 'System', 'Backup protocols executed', '2025-05-25 23:59:57', 'Low'),
(24, 2, 'System', 'Digital stability enhanced', '2025-05-25 23:59:57', 'Low'),
(25, 2, 'System', 'Backup protocols executed', '2025-05-25 23:59:58', 'Low'),
(26, 2, 'System', 'Backup protocols executed', '2025-05-25 23:59:59', 'Low'),
(27, 2, 'System', 'Backup protocols executed', '2025-05-26 00:00:00', 'Low'),
(28, 2, 'System', 'Consciousness integrity maintained', '2025-05-26 00:00:00', 'Low');

-- --------------------------------------------------------

--
-- Table structure for table `user_digital_assets`
--

CREATE TABLE `user_digital_assets` (
  `AssetID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `AssetType` enum('Pet','Environment','Memory','Skill','Tool') NOT NULL,
  `AssetName` varchar(100) NOT NULL,
  `AssetDescription` text DEFAULT NULL,
  `AssetIcon` varchar(10) DEFAULT '?',
  `AcquiredTimestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `IsActive` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_digital_assets`
--

INSERT INTO `user_digital_assets` (`AssetID`, `UserID`, `AssetType`, `AssetName`, `AssetDescription`, `AssetIcon`, `AcquiredTimestamp`, `IsActive`) VALUES
(1, 1, 'Pet', 'MemPaws™ Kitten', 'Your loyal digital companion', '🐱', '2025-05-25 23:47:26', 1),
(2, 2, 'Pet', 'MemPaws™ Kitten', 'Your loyal digital companion', '🐱', '2025-05-25 23:47:26', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `consciousness_uploads`
--
ALTER TABLE `consciousness_uploads`
  ADD PRIMARY KEY (`UploadID`),
  ADD UNIQUE KEY `Email` (`Email`);

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
-- Indexes for table `user_achievements`
--
ALTER TABLE `user_achievements`
  ADD PRIMARY KEY (`AchievementID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `user_activity_log`
--
ALTER TABLE `user_activity_log`
  ADD PRIMARY KEY (`ActivityID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `user_digital_assets`
--
ALTER TABLE `user_digital_assets`
  ADD PRIMARY KEY (`AssetID`),
  ADD KEY `UserID` (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `consciousness_uploads`
--
ALTER TABLE `consciousness_uploads`
  MODIFY `UploadID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT for table `user_achievements`
--
ALTER TABLE `user_achievements`
  MODIFY `AchievementID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_activity_log`
--
ALTER TABLE `user_activity_log`
  MODIFY `ActivityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `user_digital_assets`
--
ALTER TABLE `user_digital_assets`
  MODIFY `AssetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `job_data`
--
ALTER TABLE `job_data`
  ADD CONSTRAINT `job_data_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`);

--
-- Constraints for table `user_achievements`
--
ALTER TABLE `user_achievements`
  ADD CONSTRAINT `user_achievements_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `consciousness_uploads` (`UploadID`) ON DELETE CASCADE;

--
-- Constraints for table `user_activity_log`
--
ALTER TABLE `user_activity_log`
  ADD CONSTRAINT `user_activity_log_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `consciousness_uploads` (`UploadID`) ON DELETE CASCADE;

--
-- Constraints for table `user_digital_assets`
--
ALTER TABLE `user_digital_assets`
  ADD CONSTRAINT `user_digital_assets_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `consciousness_uploads` (`UploadID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
