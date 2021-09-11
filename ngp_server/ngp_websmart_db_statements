-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2021 at 02:20 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ngp_websmart`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer_master`
--

CREATE TABLE `answer_master` (
  `answerid` int(10) UNSIGNED NOT NULL,
  `questionid` int(11) DEFAULT 0,
  `userid` int(11) DEFAULT 0,
  `answer` text DEFAULT NULL,
  `inserted_datetime` timestamp NULL DEFAULT current_timestamp(),
  `modified_datetime` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `answer_master`
--

INSERT INTO `answer_master` (`answerid`, `questionid`, `userid`, `answer`, `inserted_datetime`, `modified_datetime`) VALUES
(1, 1, 1, 'am good', '2021-09-11 10:39:02', '2021-09-11 10:39:02'),
(2, 3, 1, 'jhhjhjhj', '2021-09-11 10:48:57', '2021-09-11 10:48:57');

-- --------------------------------------------------------

--
-- Table structure for table `bookmark_master`
--

CREATE TABLE `bookmark_master` (
  `bookmarkid` int(10) UNSIGNED NOT NULL,
  `questionid` int(11) DEFAULT 0,
  `answerid` int(11) DEFAULT 0,
  `userid` int(11) DEFAULT 0,
  `bookmarked` tinyint(4) DEFAULT 0,
  `inserted_datetime` timestamp NULL DEFAULT current_timestamp(),
  `modified_datetime` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookmark_master`
--

INSERT INTO `bookmark_master` (`bookmarkid`, `questionid`, `answerid`, `userid`, `bookmarked`, `inserted_datetime`, `modified_datetime`) VALUES
(1, 1, 0, 1, 1, '2021-09-11 10:38:38', '2021-09-11 10:38:38'),
(2, 3, 0, 1, 1, '2021-09-11 10:48:20', '2021-09-11 10:48:20');

-- --------------------------------------------------------

--
-- Table structure for table `question_master`
--

CREATE TABLE `question_master` (
  `questionid` int(10) UNSIGNED NOT NULL,
  `question` text DEFAULT NULL,
  `userid` int(11) DEFAULT 0,
  `inserted_datetime` timestamp NULL DEFAULT current_timestamp(),
  `modified_datetime` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question_master`
--

INSERT INTO `question_master` (`questionid`, `question`, `userid`, `inserted_datetime`, `modified_datetime`) VALUES
(1, 'how are you?', 1, '2021-09-11 10:36:16', '2021-09-11 10:36:16'),
(2, 'where are you from?', 1, '2021-09-11 10:39:33', '2021-09-11 10:39:33'),
(3, 'jhjh jjhjbhjhkkb', 1, '2021-09-11 10:47:39', '2021-09-11 10:47:39');

-- --------------------------------------------------------

--
-- Table structure for table `vote_master`
--

CREATE TABLE `vote_master` (
  `voteid` int(10) UNSIGNED NOT NULL,
  `questionid` int(11) DEFAULT 0,
  `answerid` int(11) DEFAULT 0,
  `vote` int(11) DEFAULT 0,
  `userid` int(11) DEFAULT 0,
  `inserted_datetime` timestamp NULL DEFAULT current_timestamp(),
  `modified_datetime` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vote_master`
--

INSERT INTO `vote_master` (`voteid`, `questionid`, `answerid`, `vote`, `userid`, `inserted_datetime`, `modified_datetime`) VALUES
(1, 1, 0, 1, 1, '2021-09-11 10:39:27', '2021-09-11 10:39:27'),
(2, 3, 0, 1, 1, '2021-09-11 10:49:09', '2021-09-11 10:49:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer_master`
--
ALTER TABLE `answer_master`
  ADD PRIMARY KEY (`answerid`),
  ADD KEY `questionanswer` (`answerid`,`questionid`,`userid`) USING BTREE;

--
-- Indexes for table `bookmark_master`
--
ALTER TABLE `bookmark_master`
  ADD PRIMARY KEY (`bookmarkid`),
  ADD KEY `bookmarkquestionanswer` (`bookmarkid`,`questionid`,`answerid`,`userid`) USING BTREE;

--
-- Indexes for table `question_master`
--
ALTER TABLE `question_master`
  ADD PRIMARY KEY (`questionid`),
  ADD KEY `questions` (`questionid`,`userid`) USING BTREE;

--
-- Indexes for table `vote_master`
--
ALTER TABLE `vote_master`
  ADD PRIMARY KEY (`voteid`),
  ADD KEY `votequestion` (`voteid`,`questionid`,`answerid`,`userid`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer_master`
--
ALTER TABLE `answer_master`
  MODIFY `answerid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bookmark_master`
--
ALTER TABLE `bookmark_master`
  MODIFY `bookmarkid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `question_master`
--
ALTER TABLE `question_master`
  MODIFY `questionid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vote_master`
--
ALTER TABLE `vote_master`
  MODIFY `voteid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
