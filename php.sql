-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2019 at 01:27 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php`
--

-- --------------------------------------------------------

--
-- Table structure for table `canbo`
--

CREATE TABLE `canbo` (
  `MaCB` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `TenCB` varchar(9999) COLLATE utf8_unicode_ci NOT NULL,
  `TaiKhoan` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `MatKhau` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `GioChuan` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nghibu`
--

CREATE TABLE `nghibu` (
  `MaCB` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `Lop` int(11) NOT NULL,
  `Tu` time NOT NULL,
  `Den` time NOT NULL,
  `LiDo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `SoGio` int(11) NOT NULL,
  `Ngay` date NOT NULL,
  `IDTuan` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tuan`
--

CREATE TABLE `tuan` (
  `ID` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `Tuan` int(11) NOT NULL,
  `Thang` int(11) NOT NULL,
  `Nam` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `canbo`
--
ALTER TABLE `canbo`
  ADD PRIMARY KEY (`MaCB`);

--
-- Indexes for table `nghibu`
--
ALTER TABLE `nghibu`
  ADD PRIMARY KEY (`MaCB`,`IDTuan`),
  ADD KEY `IDTuan` (`IDTuan`);

--
-- Indexes for table `tuan`
--
ALTER TABLE `tuan`
  ADD PRIMARY KEY (`ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nghibu`
--
ALTER TABLE `nghibu`
  ADD CONSTRAINT `nghibu_ibfk_1` FOREIGN KEY (`MaCB`) REFERENCES `canbo` (`MaCB`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `nghibu_ibfk_2` FOREIGN KEY (`IDTuan`) REFERENCES `tuan` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
