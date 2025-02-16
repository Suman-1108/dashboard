-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2025 at 11:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `course_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bloomy`
--

CREATE TABLE `bloomy` (
  `id` int(50) NOT NULL,
  `course_code` varchar(100) NOT NULL,
  `blooms_taxonomy` varchar(100) NOT NULL,
  `ca_first` varchar(100) NOT NULL,
  `ca_second` varchar(100) NOT NULL,
  `end_of_semester` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chapter`
--

CREATE TABLE `chapter` (
  `id` int(150) NOT NULL,
  `course_code` varchar(200) NOT NULL,
  `unit` varchar(100) NOT NULL,
  `chapter` varchar(150) NOT NULL,
  `book` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` int(100) NOT NULL,
  `course_code` varchar(200) NOT NULL,
  `unit` varchar(150) NOT NULL,
  `content` varchar(500) NOT NULL,
  `hour` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(50) NOT NULL,
  `course_code` varchar(50) NOT NULL,
  `course_title` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `l` varchar(100) NOT NULL,
  `t` varchar(100) NOT NULL,
  `p` varchar(100) NOT NULL,
  `credit` varchar(100) NOT NULL,
  `year` varchar(50) NOT NULL,
  `semester` varchar(100) NOT NULL,
  `internal` varchar(100) NOT NULL,
  `external` varchar(100) NOT NULL,
  `total` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_designer`
--

CREATE TABLE `course_designer` (
  `id` int(100) NOT NULL,
  `course_code` varchar(150) NOT NULL,
  `course_designer` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_outcome`
--

CREATE TABLE `course_outcome` (
  `id` int(100) NOT NULL,
  `course_code` varchar(150) NOT NULL,
  `course_outcome` varchar(150) NOT NULL,
  `expected_proficiency` varchar(150) NOT NULL,
  `expected_attainment` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_outcomes`
--

CREATE TABLE `course_outcomes` (
  `id` int(100) NOT NULL,
  `course_code` varchar(150) NOT NULL,
  `course_outcomes` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(100) NOT NULL,
  `course_code` varchar(150) NOT NULL,
  `department` varchar(200) NOT NULL,
  `content` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mapping_pos`
--

CREATE TABLE `mapping_pos` (
  `id` int(150) NOT NULL,
  `course_code` varchar(200) NOT NULL,
  `po1` varchar(200) NOT NULL,
  `po2` varchar(200) NOT NULL,
  `po3` varchar(200) NOT NULL,
  `po4` varchar(200) NOT NULL,
  `po5` varchar(200) NOT NULL,
  `po6` varchar(200) NOT NULL,
  `po7` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mapping_psos`
--

CREATE TABLE `mapping_psos` (
  `id` int(100) NOT NULL,
  `course_code` varchar(200) NOT NULL,
  `po1` varchar(200) NOT NULL,
  `po2` varchar(200) NOT NULL,
  `po3` varchar(200) NOT NULL,
  `po4` varchar(200) NOT NULL,
  `po5` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `preamble`
--

CREATE TABLE `preamble` (
  `id` int(100) NOT NULL,
  `course_code` varchar(150) NOT NULL,
  `preamble` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pre_requisite`
--

CREATE TABLE `pre_requisite` (
  `id` int(100) NOT NULL,
  `course_code` varchar(150) NOT NULL,
  `pre_requisite` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reference_book`
--

CREATE TABLE `reference_book` (
  `id` int(100) NOT NULL,
  `course_code` varchar(150) NOT NULL,
  `reference_book` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `text_book`
--

CREATE TABLE `text_book` (
  `id` int(100) NOT NULL,
  `course_code` varchar(100) NOT NULL,
  `text_book` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `web_resources`
--

CREATE TABLE `web_resources` (
  `id` int(100) NOT NULL,
  `course_code` varchar(150) NOT NULL,
  `web_resources` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bloomy`
--
ALTER TABLE `bloomy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chapter`
--
ALTER TABLE `chapter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_designer`
--
ALTER TABLE `course_designer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_outcome`
--
ALTER TABLE `course_outcome`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_outcomes`
--
ALTER TABLE `course_outcomes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mapping_pos`
--
ALTER TABLE `mapping_pos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mapping_psos`
--
ALTER TABLE `mapping_psos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `preamble`
--
ALTER TABLE `preamble`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pre_requisite`
--
ALTER TABLE `pre_requisite`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reference_book`
--
ALTER TABLE `reference_book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `text_book`
--
ALTER TABLE `text_book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `web_resources`
--
ALTER TABLE `web_resources`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bloomy`
--
ALTER TABLE `bloomy`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `chapter`
--
ALTER TABLE `chapter`
  MODIFY `id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `course_designer`
--
ALTER TABLE `course_designer`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `course_outcome`
--
ALTER TABLE `course_outcome`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `course_outcomes`
--
ALTER TABLE `course_outcomes`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mapping_pos`
--
ALTER TABLE `mapping_pos`
  MODIFY `id` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mapping_psos`
--
ALTER TABLE `mapping_psos`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `preamble`
--
ALTER TABLE `preamble`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pre_requisite`
--
ALTER TABLE `pre_requisite`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reference_book`
--
ALTER TABLE `reference_book`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `text_book`
--
ALTER TABLE `text_book`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `web_resources`
--
ALTER TABLE `web_resources`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
