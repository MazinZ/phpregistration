-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 08, 2015 at 12:53 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `courseregister`
--

-- --------------------------------------------------------

--
-- Table structure for table `Courses`
--

CREATE TABLE IF NOT EXISTS `Courses` (
  `CourseName` varchar(100) NOT NULL,
  `Description` varchar(500) NOT NULL,
  `Credits` tinyint(4) NOT NULL,
  `Teacher` varchar(80) NOT NULL,
  `ClassDays` varchar(10) NOT NULL,
  `Hours` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Courses`
--

INSERT INTO `Courses` (`CourseName`, `Description`, `Credits`, `Teacher`, `ClassDays`, `Hours`) VALUES
('CS 100 THE COMPUTER SCIENCE PROFESSION', 'An introductory seminar which covers the fundamental activities, principles, and ethics of the computer science profession. An overview\r\nof the discipline of computer science, examples of careers, the history of computing and experience with elementary computing tools\r\nare included.', 1, 'Seales', 'T', '1'),
('CS 115 INTRODUCTION TO COMPUTER PROGRAMMING.', 'This course teaches introductory skills in computer programming using a high-level computer programming language. There is an emphasis\r\non both the principles and practice of computer programming. Covers principles of problem solving by computer and requires completion\r\nof a number of programming assignments.', 3, 'Keen', 'MWF', '1'),
('CS 215 INTRODUCTION TO PROGRAM DESIGN, ABSTRACTION, AND PROBLEM SOLVING.', 'The course covers introductory object-oriented problem solving, design, and programming engineering. Fundamental elements of data\r\nstructures and algorithm design will be addressed. An equally balanced effort will be devoted to the three main threads in the course: concepts, programming language skills, and rudiments of object-oriented programming and software engineering.', 3, 'Pike', 'MWF', '3'),
('CS 216 INTRODUCTION TO SOFTWARE ENGINEERING TECHNIQUES.', 'Implementation of large programming projects using object-oriented design techniques and software tools in a modern development\r\nenvironment. Software engineering topics to include: life cycles, metrics, requirements specifications, design methodologies, validation and verification, testing, reliability and project planning.', 3, 'Pike', 'MWF', '3'),
('CS 275 DISCRETE MATHEMATICS', 'Topics in discrete math aimed at applications in Computer Science. Fundamental principles: set theory, induction, relations, functions, Boolean algebra. Techniques of counting: permutations, combinations, recurrences, algorithms to generate them. Introduction to graphs and trees.', 3, 'Wasilkowski', 'TR', '3');

-- --------------------------------------------------------

--
-- Table structure for table `StudentCourses`
--

CREATE TABLE IF NOT EXISTS `StudentCourses` (
  `EmailAddress` varchar(85) NOT NULL DEFAULT '',
  `CourseName` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Students`
--

CREATE TABLE IF NOT EXISTS `Students` (
  `EmailAddress` varchar(85) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `MiddleName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) NOT NULL,
  `StreetAddress` varchar(255) NOT NULL,
  `City` varchar(50) NOT NULL,
  `State` varchar(50) NOT NULL,
  `Zip` mediumint(5) unsigned zerofill NOT NULL,
  `HomePhone` varchar(10) NOT NULL,
  `CellPhone` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Courses`
--
ALTER TABLE `Courses`
 ADD PRIMARY KEY (`CourseName`);

--
-- Indexes for table `StudentCourses`
--
ALTER TABLE `StudentCourses`
 ADD PRIMARY KEY (`EmailAddress`,`CourseName`);

--
-- Indexes for table `Students`
--
ALTER TABLE `Students`
 ADD PRIMARY KEY (`EmailAddress`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
