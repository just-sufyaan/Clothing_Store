-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 03, 2024 at 07:53 AM
-- Server version: 5.7.40
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clothingstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `orderline`
--

DROP TABLE IF EXISTS `orderline`;
CREATE TABLE IF NOT EXISTS `orderline` (
  `OrderLineID` int(11) NOT NULL AUTO_INCREMENT,
  `OrderID` int(11) NOT NULL,
  `ClothingID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  PRIMARY KEY (`OrderLineID`),
  KEY `OrderID` (`OrderID`),
  KEY `ClothingID` (`ClothingID`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderline`
--

INSERT INTO `orderline` (`OrderLineID`, `OrderID`, `ClothingID`, `Quantity`) VALUES
(24, 52, 7, 5),
(23, 52, 6, 5),
(22, 52, 5, 5),
(21, 52, 4, 5),
(20, 52, 3, 5),
(19, 52, 2, 5),
(18, 52, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

DROP TABLE IF EXISTS `tbladmin`;
CREATE TABLE IF NOT EXISTS `tbladmin` (
  `AdminID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  PRIMARY KEY (`AdminID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`AdminID`, `Username`, `Email`, `Password`) VALUES
(1, 'admin@gmail.com', 'admin123@gmail.com', '$2y$10$UU8gYNsiTRCgO6J2HzeOTeaLvsRvegwvdcKiJVaMpWDFcFSXc5Mca'),
(2, 'admin1', 'admin1@gmail.com', '$2y$10$9oPCbYS4EohPFG29ucdjRu1auR3FUBKkCX9N1DpYYgjPQeYb7Yvki'),
(3, 'admin2', 'admin2@gmail.com', '$2y$10$uxirBuQ5cW/TzbPJdDSx4.NFoYN7uV9JqOhjXaOL1ET1smQjMQCqK'),
(4, 'admin3', 'admin3@gmail.com', '$2y$10$D4qQD6EJotgHlV79UNZVm.RytPBdE0UJgP1z7UMysK9RiOb.fW.nq'),
(5, 'admin4', 'admin4@gmail.com', '$2y$10$wAEViF1snLAWr6ZZ9hR4YOVZMRM8jWRygE5I/FW8EFZjBMvS1r4Ne'),
(6, 'admin5', 'admin5@gmail.com', '$2y$10$akq4TOcCTP3G8rYj/gwHrO4Rw8BMVb5kAxJHM.ZFWJ6AM2/KwL1KC'),
(7, 'admin6', 'admin6@gmail.com', '$2y$10$ohoyq0J1pDZrTJiOYho5q.3M2gVdD3k0uhW2.7v6rFYFvG2HwJf1y');

-- --------------------------------------------------------

--
-- Table structure for table `tblaorder`
--

DROP TABLE IF EXISTS `tblaorder`;
CREATE TABLE IF NOT EXISTS `tblaorder` (
  `OrderID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) DEFAULT NULL,
  `OrderDate` date DEFAULT NULL,
  `OrderTime` time DEFAULT NULL,
  `TotalAmount` decimal(10,2) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`OrderID`),
  KEY `UserID` (`UserID`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblaorder`
--

INSERT INTO `tblaorder` (`OrderID`, `UserID`, `OrderDate`, `OrderTime`, `TotalAmount`, `Status`) VALUES
(1, 4, '2024-04-01', '12:00:00', '367.47', 'Processing'),
(2, 4, '2024-04-02', '10:30:00', '514.30', 'Processing'),
(3, 1, '2024-04-03', '15:45:00', '800.50', 'Processing'),
(4, 2, '2024-04-04', '09:00:00', '1250.20', 'Processing'),
(5, 5, '2024-04-05', '14:20:00', '400.00', 'Processing'),
(6, 6, '2024-04-06', '11:10:00', '775.00', 'Processing'),
(7, 7, '2024-04-07', '08:30:00', '250.00', 'Delivered'),
(52, 7, '2024-06-03', '06:51:59', '25299.65', 'Processing');

-- --------------------------------------------------------

--
-- Table structure for table `tblclothes`
--

DROP TABLE IF EXISTS `tblclothes`;
CREATE TABLE IF NOT EXISTS `tblclothes` (
  `ClothingID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(100) NOT NULL,
  `Description` text,
  `Size` varchar(20) DEFAULT NULL,
  `Brand` varchar(50) DEFAULT NULL,
  `Price` decimal(10,2) NOT NULL,
  `QuantityAvailable` int(11) NOT NULL,
  `ImageURL` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ClothingID`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblclothes`
--

INSERT INTO `tblclothes` (`ClothingID`, `Title`, `Description`, `Size`, `Brand`, `Price`, `QuantityAvailable`, `ImageURL`) VALUES
(38, 'Cool Jersey', 'Nice jersey to wear for style.', 'SS', 'Calvin Klein', '568.00', 20, 'Images/item4.jpg'),
(37, 'White and Blue dress', 'Nice dress in good condition for summer days', '32', 'Levi\'s', '800.00', 62, 'Images/item3.jpg'),
(36, 'Blue Denim jeans', 'Good quality jeans for every occasion.', '38', 'Calvin Klein', '870.00', 17, 'Images/item2.jpg'),
(35, 'Black Jacket', 'Nice style jacket for fancy occasions', 'L', 'Barbour', '1450.00', 35, 'Images/item1.jpg'),
(39, 'A variety of polo T-Shirts', 'All colour\'s and styles of polo T-Shirts for sale.', 'M', 'Luca Faloni', '450.00', 200, 'Images/item5.jpg'),
(40, 'Black Denim jeans', 'Great quality jeans for outside ocassions', 'L', 'Levi\'s', '970.00', 46, 'Images/item6.jpg'),
(41, 'White Nike Airforces', 'New quality Airforce 1\'s in excellent condition.', '7', 'Nike', '1200.00', 25, 'Images/item7.jpg'),
(42, 'Grey oversized hoodie', 'Great quality hoodies for sale.', '30', 'Adidas', '800.00', 7, 'Images/item8.jpg'),
(43, 'White Sundress', 'Still good quality dress for hot days', '28', 'Brown Thomas', '1780.00', 10, 'Images/item9.jpg'),
(44, 'Winter Black Jacket', 'Cozy winter jacket for sale', 'L', 'Calvin Klein', '860.00', 28, 'Images/item10.jpg'),
(45, 'Cool Denim Shorts', 'Goof quality shorts for sale.', '42', 'Levi\'s', '420.00', 27, 'Images/item11.jpg'),
(46, 'Blue denim jeans', 'Great quality jeans for sale.', '36', 'Levi\'s', '1200.00', 36, 'Images/item12.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tblmessages`
--

DROP TABLE IF EXISTS `tblmessages`;
CREATE TABLE IF NOT EXISTS `tblmessages` (
  `MessageID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) DEFAULT NULL,
  `ItemName` varchar(255) DEFAULT NULL,
  `UserEmail` varchar(255) DEFAULT NULL,
  `MessageText` text,
  `ResponseText` text,
  `Status` enum('Pending','Responded') DEFAULT 'Pending',
  `Timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`MessageID`),
  KEY `UserID` (`UserID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblsellerrequests`
--

DROP TABLE IF EXISTS `tblsellerrequests`;
CREATE TABLE IF NOT EXISTS `tblsellerrequests` (
  `RequestID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(255) DEFAULT NULL,
  `Description` text,
  `Size` varchar(50) DEFAULT NULL,
  `Brand` varchar(100) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `QuantityAvailable` int(11) DEFAULT NULL,
  `ImageURL` varchar(255) DEFAULT NULL,
  `ApprovalStatus` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `UserID` int(11) DEFAULT NULL,
  PRIMARY KEY (`RequestID`),
  KEY `fk_user_id` (`UserID`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

DROP TABLE IF EXISTS `tbluser`;
CREATE TABLE IF NOT EXISTS `tbluser` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `RegistrationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Status` varchar(20) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`UserID`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`UserID`, `Username`, `Email`, `Password`, `RegistrationDate`, `Status`) VALUES
(1, 'John Doe', 'johndoe@freemail.com', '$2y$10$Pl3.ylvC9Yipv.TTVswf/eNIewluofdBLtTW4Fqh4bHB8SBeZGS4u', '2024-04-30 11:52:06', 'approved'),
(2, 'Bob Smith', 'bobsmith@freemail.com', '$2y$10$QQB5xJ1B1JoZuQPRSIYSTuPaRHjMFvuQDckfSnD1rBQvP89HqZtoO', '2024-04-30 11:52:06', 'approved'),
(3, 'Levi Ackerman', 'leviackerman@freemail.com', '$2y$10$6O2UQgZb1BpblD/6VamTJeu7QyEgzeoEl6aafK.O.T2aQAEewGFOO', '2024-04-30 11:52:06', 'pending'),
(4, 'Eve Shakes', 'eveshakes@freemail.com', '$2y$10$FVffKicWhB5CKFUuOGAah.fu2DzCKdwbnt5VIGVpQjHW8B4vi4c0m', '2024-04-30 11:52:06', 'pending'),
(5, 'Collin Wills', 'collinwills@freemail.com', '$2y$10$crJex6srIDtUKnEXJ.h7Ce0dIGE9h1ianiKkv3kM22gRFsNypRv1m', '2024-04-30 11:52:06', 'approved'),
(6, 'sufi', 'sufyaan123@gmail.com', '$2y$10$5zUI0ERnUvtRLeN2byHw8OST0LOMVckn.thbfN1vTh0HMRvsVjVb2', '2024-05-06 19:35:51', 'pending'),
(7, 'max', 'max123@gmail.com', '$2y$10$VxMifTTEKC.BfrGgCdxTEO5165TomNaxwJm/57fxmgBShkHznFgpC', '2024-05-06 19:48:41', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `tblwishlist`
--

DROP TABLE IF EXISTS `tblwishlist`;
CREATE TABLE IF NOT EXISTS `tblwishlist` (
  `WishlistID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `ClothingID` int(11) NOT NULL,
  `AddedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`WishlistID`),
  UNIQUE KEY `unique_wishlist` (`UserID`,`ClothingID`),
  KEY `ClothingID` (`ClothingID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
