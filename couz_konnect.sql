-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2023 at 06:17 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `couz_konnect`
--

-- --------------------------------------------------------

--
-- Table structure for table `action_logs`
--

CREATE TABLE `action_logs` (
  `id` int(11) NOT NULL,
  `msg` varchar(255) NOT NULL,
  `type` varchar(10) NOT NULL,
  `dCreated` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `action_logs`
--

INSERT INTO `action_logs` (`id`, `msg`, `type`, `dCreated`) VALUES
(1, 'CKA_7286 activated role (Owner)', 'mgmt', '2022-05-28 16:22:55'),
(2, 'CKA_7286 deactivated role (Admin)', 'mgmt', '2022-05-28 16:22:56'),
(3, 'CKA_7286 activated role (Admin)', 'mgmt', '2022-06-03 11:18:55'),
(4, 'CKA_7286 activated role (Admin)', 'mgmt', '2022-06-03 11:26:54'),
(5, 'CKA_2409 deactivated role (Owner)', 'mgmt', '2022-06-03 11:52:31'),
(6, 'nasman registered as a member', 'mgmt', '2022-06-11 13:37:54'),
(7, 'nasman registered as a member', 'public', '2022-06-11 13:42:31');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `adminID` varchar(10) NOT NULL,
  `username` varchar(40) NOT NULL,
  `fName` varchar(40) NOT NULL,
  `mName` varchar(40) NOT NULL,
  `lName` varchar(40) NOT NULL,
  `email` varchar(60) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `about` text NOT NULL,
  `company` varchar(100) NOT NULL,
  `job` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `country` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'default.png',
  `twurl` varchar(100) NOT NULL,
  `fburl` varchar(100) NOT NULL,
  `igurl` varchar(100) NOT NULL,
  `lkurl` varchar(100) NOT NULL,
  `dCreated` varchar(20) NOT NULL,
  `dUpdated` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `adminID`, `username`, `fName`, `mName`, `lName`, `email`, `phone`, `about`, `company`, `job`, `address`, `country`, `password`, `role`, `image`, `twurl`, `fburl`, `igurl`, `lkurl`, `dCreated`, `dUpdated`, `status`) VALUES
(1, 'CKA_7286', 'nisan', 'Nisan', 'Adriano', 'Dave', 'nisan@nisan.com', '08068781278', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis exercitationem sint fugiat, veniam molestiae saepe architecto temporibus. Esse incidunt doloremque accusamus temporibus perferendis quae a accusantium cum numquam dolore, corporis aliquam natus assumenda porro consequuntur sint rem ducimus est odio neque nemo autem laboriosam necessitatibus repellendus! Quo, cupiditate amet itaque dolorem officiis esse optio, nesciunt quas quam consequatur libero totam nulla facilis, rerum sint velit.', 'AfriHUB', 'Web Developer', '6 Gongola Street Garki Area 2', 'Norway', 'a1610c2fb0ab70d6d78e6ed4f4a5014b', 1, 'nisan.jpg', '', 'https://web.facebook.com/Tioluwalope15', '', '', '2022-05-24 22:52:02', '2022-06-03 11:52:07', 'Active'),
(2, 'CKA_12', 'admin', '', '', '', 'admin@admin.com', '', '', '', '', '', '', '21232f297a57a5a743894a0e4a801fc3', 2, 'admin.png', '', '', '', '', '2022-06-03 11:27:18', '2023-08-29 14:27:02', 'Active'),
(3, 'CKA_7342', 'superad', '', '', '', 'super@super.com', '', '', '', '', '', '', 'e293fe8824b629c2d70066f62e1536cd', 3, 'default.png', '', '', '', '', '2022-06-03 11:28:09', '2022-06-03 11:28:12', 'Active'),
(4, 'CKA_2409', 'user', '', '', '', 'user@user.com', '', '', '', '', '', '', 'ee11cbb19052e40b07aac0ca060c23ee', 4, 'default.png', '', '', '', '', '2022-06-03 11:28:30', '2022-06-03 11:28:34', 'Active'),
(5, 'CKA_1861', 'bignas', '', '', '', 'bignas@gmail.com', '', '', '', '', '', '', '3191a9b8815b9bec7d5613215cfc5ca0', 4, 'default.png', '', '', '', '', '2022-06-11 12:42:34', '2022-06-11 13:04:16', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `memberID` varchar(15) NOT NULL,
  `username` varchar(40) NOT NULL,
  `fName` varchar(40) NOT NULL,
  `mName` varchar(40) NOT NULL,
  `lName` varchar(40) NOT NULL,
  `email` varchar(60) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `image` varchar(100) NOT NULL DEFAULT 'default.png',
  `address` varchar(255) NOT NULL,
  `country` varchar(40) NOT NULL,
  `about` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `dCreated` varchar(20) NOT NULL,
  `dUpdated` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `memberID`, `username`, `fName`, `mName`, `lName`, `email`, `phone`, `image`, `address`, `country`, `about`, `password`, `dCreated`, `dUpdated`, `status`) VALUES
(1, 'CKM_1419', 'steve100', 'Steve', '', 'Afaor', 'steve@gmails.com', '', 'default.png', '', '', '', 'd0a2c5815b1bff7ef939c971103f49ef', '2022-06-09 17:02:12', '2022-06-11 13:19:21', 'Active'),
(2, 'CKA_3304', 'nasir', 'nasirudeen', '', 'arikewuyo', 'arikewuyonasiru@gmail.com', '07081438300', 'default.png', '', '', '', '78e96b7de2cfaa6d3743781169c32680', '2022-06-11 12:34:27', '2022-06-11 13:19:23', 'Active'),
(4, 'CKM_16', 'nasman', 'oluwatosin', '', 'opeyemi', 'nasman@gmail.com', '', 'default.png', '', '', '', 'f8becbe4deb4a6614f1f3887c0d53691', '2022-06-11 13:42:31', '2022-06-11 14:35:32', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `dCreated` varchar(20) NOT NULL,
  `dUpdated` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `dCreated`, `dUpdated`, `status`) VALUES
(1, 'Owner', '2022-05-24 22:50:25', '2022-06-03 11:52:31', 'Active'),
(2, 'Admin', '2022-05-24 22:50:30', '2022-06-03 11:26:54', 'Active'),
(3, 'Super Admin', '2022-05-24 22:50:36', '2022-05-28 15:52:40', 'Active'),
(4, 'User', '2022-05-24 22:50:43', '2022-05-28 15:52:30', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `action_logs`
--
ALTER TABLE `action_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `adminID` (`adminID`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `action_logs`
--
ALTER TABLE `action_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
