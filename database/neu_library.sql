-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Mar 20, 2026 at 02:21 PM
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
-- Database: `neu_library`
--

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `login_time` datetime NOT NULL,
  `status` varchar(20) DEFAULT 'active',
  `user_type` varchar(20) DEFAULT 'Student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `name`, `email`, `department`, `purpose`, `login_time`, `status`, `user_type`) VALUES
(1, 'Ashley Dennise B. Alberto', 'ashleydennise@neu.edu.ph', 'cics', 'Research', '2026-03-17 11:58:33', 'active', 'Student'),
(2, 'Ashley Dennise B. Alberto', 'ashley@neu.edu.ph', 'CICS', 'Borrowing Books', '2026-03-17 11:59:23', 'active', 'Student'),
(4, 'Ashley Dennise B. Alberto', 'ashleydennise.alberto@neu.edu.ph', 'CICS', 'Computer Use', '2026-03-17 17:16:18', 'active', 'Student'),
(5, 'JEREMIAS C. ESPERANZA ', 'jcesperanza@neu.edu.ph', 'CICS', 'Computer Use', '2026-03-18 10:52:04', 'active', 'Employee'),
(18, 'JEREMIAS C. ESPERANZA ', 'jcesperanza@neu.edu.ph', 'CICS', 'Computer Use', '2026-03-18 17:57:12', 'active', 'EMPLOYEE'),
(21, 'Ashley Dennise B. Alberto', 'ashleydennise.alberto@neu.edu.ph', 'CICS', 'Admin Access', '2026-03-18 18:23:42', 'active', 'EMPLOYEE'),
(22, 'Ashley Dennise B. Alberto', 'ashleydennise.alberto@neu.edu.ph', 'CICS', 'Borrowing Books', '2026-03-18 19:16:38', 'active', 'STUDENT'),
(23, 'Faith Dablo', 'faith.dablo@neu.edu.ph', 'College of Medical Technology', 'Study Group', '2026-03-18 22:24:23', 'active', 'STUDENT'),
(24, 'Ashley Dennise B. Alberto', 'ashleydennise.alberto@neu.edu.ph', 'College of Informatics & Computing Studies', 'Study', '2026-03-20 10:27:06', 'active', 'STUDENT'),
(25, 'Ashley Dennise B. Alberto', 'ashleydennise.alberto@neu.edu.ph', 'College of Informatics & Computing Studies', 'Research', '2026-03-20 10:42:12', 'active', 'STUDENT'),
(26, 'Ashley Dennise B. Alberto', 'ashleydennise.alberto@neu.edu.ph', 'College of Informatics & Computing Studies', 'Computer Use', '2026-03-20 10:44:42', 'active', 'STUDENT'),
(27, 'Ashley Dennise B. Alberto', 'ashleydennise.alberto@neu.edu.ph', 'College of Informatics & Computing Studies', 'Writing', '2026-03-20 10:45:11', 'active', 'STUDENT'),
(28, 'Ashley Dennise B. Alberto', 'ashleydennise.alberto@neu.edu.ph', 'College of Informatics & Computing Studies', 'Reading', '2026-03-20 10:49:19', 'active', 'STUDENT'),
(29, 'Ashley Dennise B. Alberto', 'ashleydennise.alberto@neu.edu.ph', 'College of Informatics & Computing Studies', 'Borrowing Books', '2026-03-20 10:54:15', 'active', 'STUDENT'),
(30, 'JEREMIAS C. ESPERANZA ', 'jcesperanza@neu.edu.ph', 'College of Informatics & Computing Studies', 'Computer Use', '2026-03-20 10:57:57', 'active', 'Employee'),
(31, 'Ashley Dennise B. Alberto', 'ashleydennise.alberto@neu.edu.ph', 'College of Informatics & Computing Studies', 'Writing', '2026-03-20 11:00:29', 'active', 'STUDENT'),
(32, 'Ashley Dennise B. Alberto', 'ashleydennise.alberto@neu.edu.ph', 'College of Informatics & Computing Studies', 'Research', '2026-03-20 11:14:07', 'active', 'EMPLOYEE'),
(33, 'Faith Dablo', 'faith.dablo@neu.edu.ph', 'College of Physical Therapy', 'Reading', '2026-03-20 13:12:57', 'active', 'STUDENT'),
(34, 'Ashley Dennise B. Alberto', 'ashleydennise.alberto@neu.edu.ph', 'College of Music', 'Study', '2026-03-20 13:13:53', 'active', 'STUDENT'),
(35, 'Eunice', 'eunice@neu.edu.ph', 'College of Engineering and Architecture', 'Borrowing Books', '2026-03-20 13:15:17', 'active', 'STUDENT'),
(36, 'Nathaniel', 'nathaniel@neu.edu.ph', 'College of Medical Technology', 'Reviewing', '2026-03-20 13:27:43', 'active', 'STUDENT'),
(37, 'Ashley Dennise B. Alberto', 'ashleydennise.alberto@neu.edu.ph', 'College of Informatics & Computing Studies', 'Research', '2026-03-20 13:28:38', 'active', 'EMPLOYEE'),
(38, 'Ana', 'ana@neu.edu.ph', 'College of Music', 'Reviewing', '2026-03-20 13:38:25', 'active', 'EMPLOYEE'),
(39, 'Ashley Dennise B. Alberto', 'ashley@neu.edu.ph', 'College of Midwifery', 'Writing', '2026-03-20 14:07:18', 'active', 'STUDENT'),
(40, 'Ashley Dennise B. Alberto', 'ashleydennise.alberto@neu.edu.ph', 'College of Informatics & Computing Studies', 'Research', '2026-03-20 15:03:45', 'active', 'STUDENT'),
(41, 'Ashley Dennise B. Alberto', 'ashleydennise.alberto@neu.edu.ph', 'College of Informatics & Computing Studies', 'Computer Use', '2026-03-20 15:34:43', 'active', 'EMPLOYEE'),
(42, 'Faith Dablo', 'faith.dablo@neu.edu.ph', 'College of Physical Therapy', 'Writing', '2026-03-20 15:39:28', 'active', 'STUDENT'),
(43, 'Ashley Dennise B. Alberto', 'ashleydennise.alberto@neu.edu.ph', 'College of Nursing', 'Study Group', '2026-03-20 15:40:11', 'active', 'STUDENT'),
(44, 'Ashley Dennise B. Alberto', 'ashleydennise.alberto@neu.edu.ph', 'College of Informatics & Computing Studies', 'Computer Use', '2026-03-20 15:42:47', 'active', 'STUDENT'),
(45, 'Faith Dablo', 'faith.dablo@neu.edu.ph', 'College of Respiratory Therapy', 'Reviewing', '2026-03-20 15:44:00', 'active', 'STUDENT'),
(46, 'Faith Dablo', 'faith.dablo@neu.edu.ph', 'College of Respiratory Therapy', 'Research', '2026-03-20 15:46:32', 'active', 'STUDENT'),
(47, 'JEREMIAS C. ESPERANZA ', 'jcesperanza@neu.edu.ph', 'College of Informatics & Computing Studies', 'Computer Use', '2026-03-20 16:45:34', 'active', 'EMPLOYEE'),
(48, 'Ashley Dennise B. Alberto', 'ashleydennise.alberto@neu.edu.ph', 'College of Informatics & Computing Studies', 'Reading', '2026-03-20 16:52:07', 'active', 'STUDENT'),
(51, 'Ashley Dennise B. Alberto', 'ashleydennise.alberto@neu.edu.ph', 'College of Informatics & Computing Studies', 'Computer Use', '2026-03-20 17:06:47', 'active', 'STUDENT'),
(52, 'Ashley Dennise B. Alberto', 'ashleydennise.alberto@neu.edu.ph', 'College of Informatics & Computing Studies', 'Study', '2026-03-20 17:34:34', 'active', 'STUDENT'),
(53, 'Ashley Dennise B. Alberto', 'ashleydennise.alberto@neu.edu.ph', 'College of Criminology', 'Reviewing', '2026-03-20 17:35:16', 'active', 'STUDENT'),
(54, 'Ashley Dennise B. Alberto', 'ashleydennise.alberto@neu.edu.ph', 'College of Informatics & Computing Studies', 'Research', '2026-03-20 17:38:13', 'active', 'STUDENT'),
(55, 'Ashley Dennise B. Alberto', 'ashleydennise.alberto@neu.edu.ph', 'College of Informatics & Computing Studies', 'Reading', '2026-03-20 21:11:38', 'active', 'STUDENT');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
