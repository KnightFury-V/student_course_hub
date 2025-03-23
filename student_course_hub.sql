-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 23, 2025 at 02:08 PM
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
-- Database: `student_course_hub`
--
CREATE DATABASE IF NOT EXISTS `student_course_hub` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `student_course_hub`;

-- --------------------------------------------------------

--
-- Table structure for table `Admins`
--

CREATE TABLE `Admins` (
  `AdminID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `IsSuperuser` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Admins`
--

INSERT INTO `Admins` (`AdminID`, `Username`, `Password`, `IsSuperuser`) VALUES
(1, 'bhupendra', '$2y$10$bmRlapYqFSciHYxDC/PAAepyMlDtmGTZRSARXkmLAmRK5Q.DUlH6a', 1),
(2, 'admin', '$2y$10$TjhOoX2yMxQRdA7ksK8fwOmZ0LDe.kIKLSy.EVRGHeTHZmXOz4Dv6', 0);

-- --------------------------------------------------------

--
-- Table structure for table `InterestedStudents`
--

CREATE TABLE `InterestedStudents` (
  `InterestID` int(11) NOT NULL,
  `ProgrammeID` int(11) NOT NULL,
  `StudentName` varchar(100) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `RegisteredAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `InterestedStudents`
--

INSERT INTO `InterestedStudents` (`InterestID`, `ProgrammeID`, `StudentName`, `Email`, `RegisteredAt`) VALUES
(1, 1, 'John Doe', 'john.doe@example.com', '2025-03-10 17:46:03'),
(2, 4, 'Jane Smith', 'jane.smith@example.com', '2025-03-10 17:46:03'),
(3, 6, 'Alex Brown', 'alex.brown@example.com', '2025-03-10 17:46:03'),
(4, 9, 'Priya Patel', 'priya.patel@example.com', '2025-03-10 17:46:03');

-- --------------------------------------------------------

--
-- Table structure for table `Levels`
--

CREATE TABLE `Levels` (
  `LevelID` int(11) NOT NULL,
  `LevelName` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Levels`
--

INSERT INTO `Levels` (`LevelID`, `LevelName`) VALUES
(1, 'Undergraduate'),
(2, 'Postgraduate');

-- --------------------------------------------------------

--
-- Table structure for table `Modules`
--

CREATE TABLE `Modules` (
  `ModuleID` int(11) NOT NULL,
  `ModuleName` text NOT NULL,
  `ModuleLeaderID` int(11) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Modules`
--

INSERT INTO `Modules` (`ModuleID`, `ModuleName`, `ModuleLeaderID`, `Description`, `Image`) VALUES
(1, 'Introduction to Programming ', 1, 'Covers the fundamentals of programming using Python and Java.', 'module1.jpeg'),
(2, 'Mathematics for Computer Science', 2, 'Teaches discrete mathematics, linear algebra, and probability theory.', 'module2.jpeg'),
(3, 'Computer Systems & Architecture', 3, 'Explores CPU design, memory management, and assembly language.', 'module3.jpeg'),
(4, 'Databases', 4, 'Covers SQL, relational database design, and NoSQL systems.', 'module4.jpeg'),
(5, 'Software Engineering', 5, 'Focuses on agile development, design patterns, and project management.', 'module5.jpeg'),
(6, 'Algorithms & Data Structures', 6, 'Examines sorting, searching, graphs, and complexity analysis.', 'module6.jpeg'),
(7, 'Cyber Security Fundamentals', 7, 'Provides an introduction to network security, cryptography, and vulnerabilities.', 'module7.jpeg'),
(8, 'Artificial Intelligence', 8, 'Introduces AI concepts such as neural networks, expert systems, and robotics.', 'module8.jpeg'),
(9, 'Machine Learning', 9, 'Explores supervised and unsupervised learning, including decision trees and clustering.', 'module9.jpeg'),
(10, 'Ethical Hacking', 10, 'Covers penetration testing, security assessments, and cybersecurity laws.', 'module10.jpeg'),
(11, 'Computer Networks', 1, 'Teaches TCP/IP, network layers, and wireless communication.', 'module11.jpeg'),
(12, 'Software Testing & Quality Assurance', 2, 'Focuses on automated testing, debugging, and code reliability.', 'module12.jpeg'),
(13, 'Embedded Systems', 3, 'Examines microcontrollers, real-time OS, and IoT applications.', 'module13.jpeg'),
(14, 'Human-Computer Interaction', 4, 'Studies UI/UX design, usability testing, and accessibility.', 'module14.jpeg'),
(15, 'Blockchain Technologies', 5, 'Covers distributed ledgers, consensus mechanisms, and smart contracts.', 'module15.jpeg'),
(16, 'Cloud Computing', 6, 'Introduces cloud services, virtualization, and distributed systems.', 'module16.jpeg'),
(17, 'Digital Forensics', 7, 'Teaches forensic investigation techniques for cybercrime.', 'module17.jpeg'),
(18, 'Final Year Project', 8, 'A major independent project where students develop a software solution.', 'module18.jpeg'),
(19, 'Advanced Machine Learning', 11, 'Covers deep learning, reinforcement learning, and cutting-edge AI techniques.', 'module19.jpeg'),
(20, 'Cyber Threat Intelligence', 12, 'Focuses on cybersecurity risk analysis, malware detection, and threat mitigation.', 'module20.jpeg'),
(21, 'Big Data Analytics', 13, 'Explores data mining, distributed computing, and AI-driven insights.', 'module21.jpeg'),
(22, 'Cloud & Edge Computing', 14, 'Examines scalable cloud platforms, serverless computing, and edge networks.', 'module22.jpeg'),
(23, 'Blockchain & Cryptography', 15, 'Covers decentralized applications, consensus algorithms, and security measures.', 'module23.jpeg'),
(24, 'AI Ethics & Society', 16, 'Analyzes ethical dilemmas in AI, fairness, bias, and regulatory considerations.', 'module24.jpeg'),
(25, 'Quantum Computing', 17, 'Introduces quantum algorithms, qubits, and cryptographic applications.', 'module25.jpeg'),
(26, 'Cybersecurity Law & Policy', 18, 'Explores digital privacy, GDPR, and international cyber law.', 'module26.jpeg'),
(27, 'Neural Networks & Deep Learning', 19, 'Delves into convolutional networks, GANs, and AI advancements.', 'module27.jpeg'),
(28, 'Human-AI Interaction', 20, 'Studies AI usability, NLP systems, and social robotics.', 'module28.jpeg'),
(29, 'Autonomous Systems', 11, 'Focuses on self-driving technology, robotics, and intelligent agents.', 'module29.jpeg'),
(30, 'Digital Forensics & Incident Response', 12, 'Teaches forensic analysis, evidence gathering, and threat mitigation.', 'module30.jpeg'),
(31, 'Postgraduate Dissertation', 13, 'A major research project where students explore advanced topics in computing.', 'module31.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `ProgrammeModules`
--

CREATE TABLE `ProgrammeModules` (
  `ProgrammeModuleID` int(11) NOT NULL,
  `ProgrammeID` int(11) DEFAULT NULL,
  `ModuleID` int(11) DEFAULT NULL,
  `Year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ProgrammeModules`
--

INSERT INTO `ProgrammeModules` (`ProgrammeModuleID`, `ProgrammeID`, `ModuleID`, `Year`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(3, 1, 3, 1),
(4, 1, 4, 1),
(5, 2, 1, 1),
(6, 2, 2, 1),
(7, 2, 3, 1),
(8, 2, 4, 1),
(9, 3, 1, 1),
(10, 3, 2, 1),
(11, 3, 3, 1),
(12, 3, 4, 1),
(13, 4, 1, 1),
(14, 4, 2, 1),
(15, 4, 3, 1),
(16, 4, 4, 1),
(17, 5, 1, 1),
(18, 5, 2, 1),
(19, 5, 3, 1),
(20, 5, 4, 1),
(21, 1, 5, 2),
(22, 1, 6, 2),
(23, 1, 7, 2),
(24, 1, 8, 2),
(25, 2, 5, 2),
(26, 2, 6, 2),
(27, 2, 12, 2),
(28, 2, 14, 2),
(29, 3, 5, 2),
(30, 3, 9, 2),
(31, 3, 8, 2),
(32, 3, 10, 2),
(33, 4, 7, 2),
(34, 4, 10, 2),
(35, 4, 11, 2),
(36, 4, 17, 2),
(37, 5, 5, 2),
(38, 5, 6, 2),
(39, 5, 9, 2),
(40, 5, 16, 2),
(41, 1, 11, 3),
(42, 1, 13, 3),
(43, 1, 15, 3),
(44, 1, 18, 3),
(45, 2, 13, 3),
(46, 2, 15, 3),
(47, 2, 16, 3),
(48, 2, 18, 3),
(49, 3, 13, 3),
(50, 3, 15, 3),
(51, 3, 16, 3),
(52, 3, 18, 3),
(53, 4, 15, 3),
(54, 4, 16, 3),
(55, 4, 17, 3),
(56, 4, 18, 3),
(57, 5, 9, 3),
(58, 5, 14, 3),
(59, 5, 16, 3),
(60, 5, 18, 3),
(61, 6, 19, 1),
(62, 6, 24, 1),
(63, 6, 27, 1),
(64, 6, 29, 1),
(65, 6, 31, 1),
(66, 7, 20, 1),
(67, 7, 26, 1),
(68, 7, 30, 1),
(69, 7, 23, 1),
(70, 7, 31, 1),
(71, 8, 21, 1),
(72, 8, 22, 1),
(73, 8, 27, 1),
(74, 8, 28, 1),
(75, 8, 31, 1),
(76, 9, 19, 1),
(77, 9, 24, 1),
(78, 9, 28, 1),
(79, 9, 29, 1),
(80, 9, 31, 1),
(81, 10, 23, 1),
(82, 10, 22, 1),
(83, 10, 25, 1),
(84, 10, 26, 1),
(85, 10, 31, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Programmes`
--

CREATE TABLE `Programmes` (
  `ProgrammeID` int(11) NOT NULL,
  `ProgrammeName` text NOT NULL,
  `LevelID` int(11) DEFAULT NULL,
  `ProgrammeLeaderID` int(11) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Programmes`
--

INSERT INTO `Programmes` (`ProgrammeID`, `ProgrammeName`, `LevelID`, `ProgrammeLeaderID`, `Description`, `Image`) VALUES
(1, 'BSc Computer Science', 1, 1, 'A broad computer science degree covering programming, AI,  cybersecurity, and software engineering.', 'program1.jpeg'),
(2, 'BSc Software Engineering', 1, 2, 'A specialized degree focusing on the development and lifecycle of software applications.', 'program2.jpeg'),
(3, 'BSc Artificial Intelligence', 1, 3, 'Focuses on machine learning, deep learning, and AI applications.', 'program3.jpeg'),
(4, 'BSc Cyber Security', 1, 4, 'Explores network security, ethical hacking, and digital forensics.', 'program4.jpeg'),
(5, 'BSc Data Science', 1, 5, 'Covers big data, machine learning, and statistical computing.', 'program5.jpeg'),
(6, 'MSc Machine Learning', 2, 11, 'A postgraduate degree focusing on deep learning, AI ethics, and neural networks.', 'program6.jpeg'),
(7, 'MSc Cyber Security', 2, 12, 'A specialized programme covering digital forensics, cyber threat intelligence, and security policy.', 'program7.jpeg'),
(8, 'MSc Data Science', 2, 13, 'Focuses on big data analytics, cloud computing, and AI-driven insights.', 'program8.jpeg'),
(9, 'MSc Artificial Intelligence', 2, 14, 'Explores autonomous systems, AI ethics, and deep learning technologies.', 'program9.jpeg'),
(10, 'MSc Software Engineering', 2, 15, 'Emphasizes software design, blockchain applications, and cutting-edge methodologies.', 'program10.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `Staff`
--

CREATE TABLE `Staff` (
  `StaffID` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Staff`
--

INSERT INTO `Staff` (`StaffID`, `Name`, `Password`) VALUES
(1, 'Dr. Alice Johnson', '$2y$10$lo5L4TxzVPPIxT6VYF6FZeSDfTjosS/ZHAElJk7GJEtzsiNOA.atG'),
(2, 'Dr. Brian Lee', '$2y$10$sUUaInaXPcHuSXUyuCPe6OQAdVyDxM4N3xiIEzb3VF3oz34YnJrO2'),
(3, 'Dr. Carol White', '$2y$10$ZmPRtr9Oo.5rMyLDb270I.eg36WQoqeDteBBzFsRwrgc0ElThG7Oy'),
(4, 'Dr. David Green', '$2y$10$SQEexNJJ7P04A0rpxSGgL.PFjIUzM5Xa/RSBso33pvcIPcCNaxXbS'),
(5, 'Dr. Emma Scott', '$2y$10$C.C9C1lNVd9PJxbqCgb11.Jb5FMiQ6phWk21uLnRx3nRLE6WYQtMe'),
(6, 'Dr. Frank Moore', '$2y$10$H3J23gFcuvAYUB9idFAivOhB73GbAdKuGpjktK.5BN2pWt94tW36q'),
(7, 'Dr. Grace Adams', '$2y$10$uB9NEoekGuXSyL1zxS3JIOKuB84qFHe/8ZlxUkDyZE71.97Q9G.ga'),
(8, 'Dr. Henry Clark', '$2y$10$F3JU/XHz0rH6ZGR96Q2eKejSNw3f7TfA1Jn/p7DJb16eGVEKNG8dO'),
(9, 'Dr. Irene Hall', NULL),
(10, 'Dr. James Wright', NULL),
(11, 'Dr. Sophia Miller', NULL),
(12, 'Dr. Benjamin Carter', NULL),
(13, 'Dr. Chloe Thompson', NULL),
(14, 'Dr. Daniel Robinson', NULL),
(15, 'Dr. Emily Davis', NULL),
(16, 'Dr. Nathan Hughes', NULL),
(17, 'Dr. Olivia Martin', NULL),
(18, 'Dr. Samuel Anderson', NULL),
(19, 'Dr. Victoria Hall', NULL),
(20, 'Dr. William Scott', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admins`
--
ALTER TABLE `Admins`
  ADD PRIMARY KEY (`AdminID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `InterestedStudents`
--
ALTER TABLE `InterestedStudents`
  ADD PRIMARY KEY (`InterestID`),
  ADD KEY `ProgrammeID` (`ProgrammeID`);

--
-- Indexes for table `Levels`
--
ALTER TABLE `Levels`
  ADD PRIMARY KEY (`LevelID`);

--
-- Indexes for table `Modules`
--
ALTER TABLE `Modules`
  ADD PRIMARY KEY (`ModuleID`),
  ADD KEY `ModuleLeaderID` (`ModuleLeaderID`);

--
-- Indexes for table `ProgrammeModules`
--
ALTER TABLE `ProgrammeModules`
  ADD PRIMARY KEY (`ProgrammeModuleID`),
  ADD KEY `ProgrammeID` (`ProgrammeID`),
  ADD KEY `ModuleID` (`ModuleID`);

--
-- Indexes for table `Programmes`
--
ALTER TABLE `Programmes`
  ADD PRIMARY KEY (`ProgrammeID`),
  ADD KEY `LevelID` (`LevelID`),
  ADD KEY `ProgrammeLeaderID` (`ProgrammeLeaderID`);

--
-- Indexes for table `Staff`
--
ALTER TABLE `Staff`
  ADD PRIMARY KEY (`StaffID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Admins`
--
ALTER TABLE `Admins`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `InterestedStudents`
--
ALTER TABLE `InterestedStudents`
  MODIFY `InterestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `ProgrammeModules`
--
ALTER TABLE `ProgrammeModules`
  MODIFY `ProgrammeModuleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `Programmes`
--
ALTER TABLE `Programmes`
  MODIFY `ProgrammeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `InterestedStudents`
--
ALTER TABLE `InterestedStudents`
  ADD CONSTRAINT `interestedstudents_ibfk_1` FOREIGN KEY (`ProgrammeID`) REFERENCES `Programmes` (`ProgrammeID`) ON DELETE CASCADE;

--
-- Constraints for table `Modules`
--
ALTER TABLE `Modules`
  ADD CONSTRAINT `modules_ibfk_1` FOREIGN KEY (`ModuleLeaderID`) REFERENCES `Staff` (`StaffID`);

--
-- Constraints for table `ProgrammeModules`
--
ALTER TABLE `ProgrammeModules`
  ADD CONSTRAINT `programmemodules_ibfk_1` FOREIGN KEY (`ProgrammeID`) REFERENCES `Programmes` (`ProgrammeID`),
  ADD CONSTRAINT `programmemodules_ibfk_2` FOREIGN KEY (`ModuleID`) REFERENCES `Modules` (`ModuleID`);

--
-- Constraints for table `Programmes`
--
ALTER TABLE `Programmes`
  ADD CONSTRAINT `programmes_ibfk_1` FOREIGN KEY (`LevelID`) REFERENCES `Levels` (`LevelID`),
  ADD CONSTRAINT `programmes_ibfk_2` FOREIGN KEY (`ProgrammeLeaderID`) REFERENCES `Staff` (`StaffID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
