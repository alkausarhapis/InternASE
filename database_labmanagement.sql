-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2024 at 10:50 AM
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
-- Database: `database_labmanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `agenda`
--

CREATE TABLE `agenda` (
  `id_agenda` int(10) NOT NULL,
  `agenda_name` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `type` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agenda`
--

INSERT INTO `agenda` (`id_agenda`, `agenda_name`, `date`, `type`, `description`) VALUES
(4, 'Weekly meeting', '2024-09-25 13:23:00', 'Meet', 'aw');

-- --------------------------------------------------------

--
-- Table structure for table `borrow`
--

CREATE TABLE `borrow` (
  `id` varchar(13) NOT NULL,
  `return_time` date NOT NULL,
  `id_user` int(13) DEFAULT NULL,
  `id_document` varchar(13) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrow`
--

INSERT INTO `borrow` (`id`, `return_time`, `id_user`, `id_document`) VALUES
('1811270703565', '2024-09-27', 123, '66f2cab86b9ed'),
('1811270710199', '2024-09-27', 123, '66f2cab86b9ed'),
('2147483647', '2024-09-21', 123, '66ecd17a579f7');

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE `document` (
  `id` varchar(13) NOT NULL,
  `tittle` varchar(80) NOT NULL,
  `author` varchar(70) NOT NULL,
  `status` enum('available','borrowed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `document`
--

INSERT INTO `document` (`id`, `tittle`, `author`, `status`) VALUES
('66ecd17a579f7', 'Harry Potter : Chamber Secret', 'J. K. Rowling', 'borrowed'),
('66f2c9ab277d4', 'gorengan', 'yanto', 'available'),
('66f2cab86b9ed', 'asdfasdf', 'asdfasdf', 'borrowed'),
('66f577926c8ae', 'Test buku', 'agus', 'borrowed');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` varchar(10) NOT NULL,
  `item` varchar(70) NOT NULL,
  `unit` int(4) NOT NULL,
  `date` date NOT NULL,
  `picture` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `item`, `unit`, `date`, `picture`, `description`) VALUES
('PC-123', 'PC', 12, '2024-09-25', 'assets/uploads/inventaris/1727426973.jpg', 'pc gaming');

-- --------------------------------------------------------

--
-- Table structure for table `meeting`
--

CREATE TABLE `meeting` (
  `id` char(13) NOT NULL,
  `title` varchar(70) NOT NULL,
  `speaker` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `meeting_link` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meeting`
--

INSERT INTO `meeting` (`id`, `title`, `speaker`, `date`, `start_time`, `end_time`, `meeting_link`, `description`) VALUES
('66ed30e1c5893', 'seminar', 'dandi', '2024-09-20', '15:22:00', '15:22:00', 'https://www.geeksforgeeks.org/singly-linked-list-definition-meaning-dsa/?ref=shm', 'hehe');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `nim` varchar(15) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `entry_year` int(4) NOT NULL,
  `age` int(3) NOT NULL,
  `major` varchar(50) NOT NULL,
  `faculty` varchar(5) NOT NULL,
  `picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`nim`, `fullname`, `entry_year`, `age`, `major`, `faculty`, `picture`) VALUES
('1174017434', 'John Doe', 2022, 22, 'S1 Rekayasa Perangkat Lunak', 'FIF', 'assets/uploads/members/1727426953.png');

-- --------------------------------------------------------

--
-- Table structure for table `room_schedule`
--

CREATE TABLE `room_schedule` (
  `id_activity` int(10) NOT NULL,
  `meeting_name` varchar(70) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `color` enum('105AB4','2c514c','a42cd6','890620') DEFAULT '105AB4'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_schedule`
--

INSERT INTO `room_schedule` (`id_activity`, `meeting_name`, `start_time`, `end_time`, `color`) VALUES
(29, 'Head of study Program inspection', '2024-09-10 17:59:00', '2024-09-12 17:59:00', 'a42cd6'),
(30, 'Weekly Meet', '2024-09-18 18:00:00', '2024-09-19 18:00:00', '2c514c'),
(31, 'Offline Workshop', '2024-09-15 18:01:00', '2024-09-15 18:01:00', '890620'),
(0, 'Turu brutal', '2024-09-25 23:18:00', '2024-09-27 23:18:00', '890620');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(13) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` char(60) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` enum('admin','anggota','dosen','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`, `role`) VALUES
(123, 'admin', '$2y$10$bl8/uigq5chp1L2pyRUQVO1Jctm6.ownbqnJy5YtCj4uYDEazXoZe', 'admin', 'admin'),
(1414, 'mahasiswa', '$2y$10$w02fW6NJzOSNmBknCy7MZuj1okiida5QGMl57feEcMwGan38aT4iS', 'mahasiswa', 'anggota'),
(13213, 'dosen', '$2y$10$HQk0XmxSzBk0X.6TANzF0OwneAEegH3W8PYeHyk4tRiYFrnIkk.iq', 'dosen', 'dosen');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id_agenda`);

--
-- Indexes for table `borrow`
--
ALTER TABLE `borrow`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_document` (`id_document`);

--
-- Indexes for table `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meeting`
--
ALTER TABLE `meeting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id_agenda` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrow`
--
ALTER TABLE `borrow`
  ADD CONSTRAINT `borrow_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `borrow_ibfk_2` FOREIGN KEY (`id_document`) REFERENCES `document` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
