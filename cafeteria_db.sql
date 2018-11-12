-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2016 at 08:59 AM
-- Server version: 5.6.21
-- PHP Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cafeteria_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE IF NOT EXISTS `tbl_admin` (
  `Username` text NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`Username`, `Name`, `Password`) VALUES
('masteraamie', 'Admin', 'e02e9ef0a48688a50a1e59c3465185c6');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance`
--

CREATE TABLE IF NOT EXISTS `tbl_attendance` (
  `ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Status` text NOT NULL,
  `Day` int(11) NOT NULL,
  `Month` int(11) NOT NULL,
  `Year` int(11) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_attendance`
--

INSERT INTO `tbl_attendance` (`ID`, `Name`, `Status`, `Day`, `Month`, `Year`, `Date`) VALUES
(1, 'Aamir Amin', 'Absent', 10, 2, 2016, '2016-02-10'),
(2, 'ADIL AMIN', 'Present', 10, 2, 2016, '2016-02-10'),
(1, 'Aamir Amin', 'Present', 11, 2, 2016, '2016-02-11'),
(2, 'ADIL AMIN', 'Present', 11, 2, 2016, '2016-02-11'),
(1, 'Aamir Amin', 'Present', 14, 2, 2016, '2016-02-14'),
(2, 'Adil Amin', 'Present', 14, 2, 2016, '2016-02-14'),
(1, 'Aamir Amin', 'Present', 15, 2, 2016, '2016-02-15'),
(2, 'Adil Amin', 'Absent', 15, 2, 2016, '2016-02-15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_billing`
--

CREATE TABLE IF NOT EXISTS `tbl_billing` (
`ID` int(11) NOT NULL,
  `Items` text NOT NULL,
  `Total` double NOT NULL DEFAULT '0',
  `Status` int(11) NOT NULL DEFAULT '0',
  `Date` date NOT NULL,
  `Profit` double NOT NULL DEFAULT '0',
  `Cost` double NOT NULL DEFAULT '0',
  `Day` int(11) NOT NULL,
  `Month` int(11) NOT NULL,
  `Year` int(11) NOT NULL,
  `TableNo` int(11) NOT NULL,
  `Waiter` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_billing`
--

INSERT INTO `tbl_billing` (`ID`, `Items`, `Total`, `Status`, `Date`, `Profit`, `Cost`, `Day`, `Month`, `Year`, `TableNo`, `Waiter`) VALUES
(1, 'Tea Set X 1 , Espresso Coffee X 1 , ', 50, 1, '2016-02-15', 10, 40, 15, 2, 2016, 0, ''),
(2, 'Tea Set X 1 , ', 30, 1, '2016-02-15', 5, 25, 15, 2, 2016, 0, ''),
(3, 'Tea Set X 1 , ', 30, 0, '2016-02-15', 5, 25, 15, 2, 2016, 0, ''),
(4, 'Tea Set X 1 , ', 30, 0, '2016-02-15', 5, 25, 15, 2, 2016, 0, ''),
(5, 'Tea Set X 1 , ', 30, 1, '2016-02-15', 5, 25, 15, 2, 2016, 0, ''),
(6, 'Tea Set X 1 , ', 30, 1, '2016-02-15', 5, 25, 15, 2, 2016, 0, ''),
(7, 'Tea Set X 1 , Espresso Coffee X 1 , ', 50, 1, '2016-02-15', 10, 40, 15, 2, 2016, 1, 'Adil Amin'),
(8, 'Tea Set X 1 , Espresso Coffee X 1 , ', 50, 1, '2016-02-16', 10, 40, 16, 2, 2016, 1, 'Adil Amin'),
(9, 'Tea Set X 1 , Espresso Coffee X 1 , ', 50, 0, '2016-02-16', 10, 40, 16, 2, 2016, 1, 'Adil Amin'),
(10, 'Tea Set X 1 , Espresso Coffee X 1 , ', 50, 0, '2016-02-16', 10, 40, 16, 2, 2016, 5, 'Adil Amin'),
(11, 'Tea Set X 1 , Veg.Burger X 1 , ', 67.6, 0, '2016-02-16', 17.599999999999994, 50, 16, 2, 2016, 1, 'Adil Amin'),
(12, 'Tea Set X 1 , ', 31.2, 0, '2016-02-16', 6.199999999999999, 25, 16, 2, 2016, 1, 'Adil Amin'),
(13, 'Tea Set X 1 , ', 31.2, 0, '2016-02-16', 6.199999999999999, 25, 16, 2, 2016, 1, 'Adil Amin'),
(14, 'Tea Set X 1 , Espresso Coffee X 1 , Coffee Set X 1 , ', 105, 0, '2016-03-12', 35, 70, 12, 3, 2016, 1, 'Mushtaq'),
(15, 'Tea Set X 1 , Espresso Coffee X 1 , Mutton Kabab X 1 , Coffee Set X 1 , ', 241.5, 0, '2016-03-30', 91.5, 150, 30, 3, 2016, 1, 'Mushtaq'),
(16, 'Tea Set X 1 , Mutton Kanti X 1 , Coffee Set X 1 , Mattar Paneer X 1 , ', 346.5, 0, '2016-03-30', 111.5, 235, 30, 3, 2016, 1, 'Mushtaq');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

CREATE TABLE IF NOT EXISTS `tbl_department` (
`ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Serial` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`ID`, `Name`, `Serial`) VALUES
(3, 'Medical Dep', 1),
(4, 'Library', 2),
(6, 'Edu', 4),
(7, 'Management', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department_bills`
--

CREATE TABLE IF NOT EXISTS `tbl_department_bills` (
`ID` int(11) NOT NULL,
  `deptID` int(11) NOT NULL,
  `deptName` varchar(100) NOT NULL,
  `Items` text NOT NULL,
  `Quantity` text NOT NULL,
  `Total` double NOT NULL DEFAULT '0',
  `Paid` double NOT NULL DEFAULT '0',
  `Balance` double NOT NULL DEFAULT '0',
  `Profit` double NOT NULL DEFAULT '0',
  `Cost` double NOT NULL DEFAULT '0',
  `Day` int(11) NOT NULL,
  `Month` int(11) NOT NULL,
  `Year` int(11) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_department_bills`
--

INSERT INTO `tbl_department_bills` (`ID`, `deptID`, `deptName`, `Items`, `Quantity`, `Total`, `Paid`, `Balance`, `Profit`, `Cost`, `Day`, `Month`, `Year`, `Date`) VALUES
(1, 3, 'Medical Dep', 'Coffee Set,Espresso Coffee,Mutton Kanti,Mattar Paneer,Naan Veg Stuff,', '11,1,1,1,5,', 1020, 0, 1020, 370, 650, 19, 2, 2016, '2016-02-19');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dept_payments`
--

CREATE TABLE IF NOT EXISTS `tbl_dept_payments` (
`ID` int(11) NOT NULL,
  `deptName` varchar(100) NOT NULL,
  `deptID` int(11) NOT NULL,
  `Payment` int(11) NOT NULL,
  `Mode` varchar(50) NOT NULL,
  `Date` varchar(100) NOT NULL,
  `chqNumber` varchar(100) NOT NULL,
  `Month` int(11) NOT NULL,
  `Year` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_dept_payments`
--

INSERT INTO `tbl_dept_payments` (`ID`, `deptName`, `deptID`, `Payment`, `Mode`, `Date`, `chqNumber`, `Month`, `Year`) VALUES
(2, 'Library', 4, 2000, 'Cheque', '02/15/2016', '46464564565646', 2, 2016),
(3, 'Medical Dep', 3, 1000, 'Cash', '02/17/2016', 'NA', 2, 2016),
(5, 'Medical Dep', 3, 1000, 'Cheque', '02/04/2016', '1258', 2, 2016),
(6, 'Medical Dep', 3, 100, 'Cheque', '02/27/2016', '213123', 2, 2016),
(7, 'Medical Dep', 3, 100, 'Cheque', '02/27/2016', '213123', 2, 2016),
(8, 'Medical Dep', 3, 100, 'Cheque', '02/27/2016', '213123', 2, 2016),
(9, 'Medical Dep', 3, 100, 'Cheque', '02/27/2016', '213123', 2, 2016),
(10, 'Medical Dep', 3, 100, 'Cheque', '02/27/2016', '213123', 2, 2016),
(11, 'Medical Dep', 3, 1000, 'Cheque', '02/16/2016', '1654654654654', 2, 2016),
(12, 'Medical Dep', 3, 1000, 'Cheque', '02/16/2016', '54654654654', 2, 2016),
(13, 'Medical Dep', 3, 1000, 'Cheque', '02/16/2016', '5654654464', 2, 2016),
(14, 'Medical Dep', 3, 500, 'Cheque', '02/16/2016', '454654654654', 2, 2016),
(15, 'Medical Dep', 3, 1000, 'Cheque', '02/16/2016', '154654654654', 2, 2016);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expenditure`
--

CREATE TABLE IF NOT EXISTS `tbl_expenditure` (
`ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Amount` int(11) NOT NULL,
  `Paid` int(11) NOT NULL,
  `Balance` int(11) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_expenditure`
--

INSERT INTO `tbl_expenditure` (`ID`, `Name`, `Quantity`, `Amount`, `Paid`, `Balance`, `Date`) VALUES
(1, 'Epson', 1, 1000, 100, 900, '2016-02-21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_items`
--

CREATE TABLE IF NOT EXISTS `tbl_items` (
`ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Cost` int(11) NOT NULL,
  `Price` int(11) NOT NULL,
  `Serial` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_items`
--

INSERT INTO `tbl_items` (`ID`, `Name`, `Cost`, `Price`, `Serial`) VALUES
(1, 'Tea Set', 25, 30, 1),
(2, 'Espresso Coffee', 15, 20, 2),
(3, 'Lemon Tea Set', 20, 30, 3),
(4, 'Patty', 20, 25, 4),
(5, 'Butter Toast', 15, 20, 5),
(6, 'Butter Pakoda', 15, 20, 6),
(7, 'Veg.Sandwich', 15, 20, 7),
(8, 'Cake Butter', 8, 10, 8),
(9, 'Cake Pulm', 8, 12, 9),
(10, 'Veg.Burger', 25, 35, 10),
(11, 'Non-Veg Burger', 35, 45, 11),
(12, 'Coffee Set', 30, 50, 12),
(13, 'Naan Plain', 10, 20, 13),
(14, 'Naan Butter', 15, 30, 14),
(15, 'Naan Veg Stuff', 25, 40, 15),
(16, 'Naan Cheese Stuff', 40, 60, 16),
(17, 'Veg Sping Roll', 25, 40, 17),
(18, 'Chicken Spring Roll', 40, 60, 18),
(19, 'Cheese Pakoda', 40, 60, 19),
(20, 'Veg Pakoda', 20, 35, 20),
(21, 'Mutton Kanti', 100, 130, 21),
(22, 'Chicken Kanti(Boneless)', 110, 150, 22),
(23, 'Mutton Kabab', 80, 130, 23),
(24, 'Chicken Kabab', 80, 130, 24),
(25, 'Fish Kabab', 60, 130, 25),
(26, 'Fish Fry', 120, 190, 26),
(27, 'Chicken Tikka', 120, 190, 27),
(28, 'Chicken Tandoori Full', 250, 380, 28),
(29, 'Chilly Chicken Full', 300, 440, 29),
(30, 'Garlic Chicken', 300, 440, 30),
(31, 'Butter Chicken', 300, 440, 31),
(32, 'Chicken Manchuria', 300, 440, 32),
(33, 'Chicken Biryani', 100, 130, 33),
(34, 'Mutton Biryani', 100, 130, 34),
(35, 'Chicken Fried Rice', 100, 130, 35),
(36, 'Muuton Fried Rice', 100, 130, 36),
(37, 'Veg. Fried Rice', 45, 85, 37),
(38, 'Mushroom Masala', 80, 120, 38),
(39, 'Mattar Mushroom', 80, 120, 39),
(40, 'Tamatar Paneer', 80, 120, 40),
(41, 'Mattar Paneer', 80, 120, 41),
(42, 'Mix Veg', 30, 60, 42);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_percent`
--

CREATE TABLE IF NOT EXISTS `tbl_percent` (
  `Percent` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_percent`
--

INSERT INTO `tbl_percent` (`Percent`) VALUES
(50);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE IF NOT EXISTS `tbl_products` (
`ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Barcode` varchar(100) NOT NULL,
  `Unit` varchar(30) NOT NULL,
  `Type` varchar(30) NOT NULL,
  `Alert` int(11) NOT NULL,
  `Quantity` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`ID`, `Name`, `Barcode`, `Unit`, `Type`, `Alert`, `Quantity`) VALUES
(3, 'Tropicana Mango Juice', '8902080404094', 'No', 'Packaged', 5, 1020),
(4, 'Tropicana Pet', '8902080013869', 'No', 'Packaged', 10, 250),
(5, 'Aquafina', '8902080504060', 'No', 'Packaged', 10, 600);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_property`
--

CREATE TABLE IF NOT EXISTS `tbl_property` (
`ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Value` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_property`
--

INSERT INTO `tbl_property` (`ID`, `Name`, `Quantity`, `Value`) VALUES
(2, 'Table', 15, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salary`
--

CREATE TABLE IF NOT EXISTS `tbl_salary` (
  `staffID` int(11) NOT NULL,
  `staffName` varchar(100) NOT NULL,
  `Salary` int(11) NOT NULL DEFAULT '0',
  `Status` int(11) NOT NULL DEFAULT '0',
  `Month` int(11) NOT NULL,
  `Year` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Balance` int(11) NOT NULL DEFAULT '0',
  `Paid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_salary`
--

INSERT INTO `tbl_salary` (`staffID`, `staffName`, `Salary`, `Status`, `Month`, `Year`, `Date`, `Balance`, `Paid`) VALUES
(1, 'Aamir Amin', 5000, 1, 2, 2016, '2016-02-14', -1000, 6000),
(2, 'Adil Amin', 4000, 1, 2, 2016, '2016-02-14', -2000, 6000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff`
--

CREATE TABLE IF NOT EXISTS `tbl_staff` (
`ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Parentage` varchar(100) NOT NULL,
  `Address` text NOT NULL,
  `Contact` varchar(14) NOT NULL,
  `Designation` varchar(100) NOT NULL,
  `Salary` int(11) NOT NULL,
  `Image` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_staff`
--

INSERT INTO `tbl_staff` (`ID`, `Name`, `Parentage`, `Address`, `Contact`, `Designation`, `Salary`, `Image`) VALUES
(1, 'Aamir Amin', 'Muhammad Amin', 'Nigeen Bagh Srinagar , 190006', '9596476919', 'Manager', 5000, '../images/Staff_Images/Aamir Amin_1.jpg'),
(2, 'Adil Amin', 'Muhammad Amin', 'Batapora', '9596451898', 'Director', 10000, '../images/Staff_Images/Adil Amin_2.jpg'),
(3, 'Mushtaq', 'Gul', 'Bijbehara', '94789478632', 'Waiter', 5000, '../images/Staff_Images/Mushtaq_3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

CREATE TABLE IF NOT EXISTS `tbl_supplier` (
`ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`ID`, `Name`) VALUES
(1, 'CCD'),
(5, 'Ghat');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier_balance`
--

CREATE TABLE IF NOT EXISTS `tbl_supplier_balance` (
  `supplierID` int(11) NOT NULL,
  `supplierName` varchar(100) NOT NULL,
  `Product` varchar(100) NOT NULL,
  `Amount` int(11) NOT NULL DEFAULT '0',
  `Paid` int(11) NOT NULL DEFAULT '0',
  `Balance` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_supplier_balance`
--

INSERT INTO `tbl_supplier_balance` (`supplierID`, `supplierName`, `Product`, `Amount`, `Paid`, `Balance`) VALUES
(1, 'CCD', 'Lays', 1050, 800, -750),
(1, 'CCD', 'lapi', 11000, 5000, 6000),
(1, 'CCD', 'Tropicana Mango Juice', 5100, 500, 4600),
(1, 'CCD', 'Tropicaa Pet', 4000, 3000, 1000),
(1, 'CCD', 'Aquafina', 3000, 3000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
`ID` int(11) NOT NULL,
  `Username` text NOT NULL,
  `Password` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`ID`, `Username`, `Password`) VALUES
(1, 'masteraamie', 'e02e9ef0a48688a50a1e59c3465185c6'),
(2, 'masteraamie', '138b24fc2e5028c15f78b887ac793614'),
(3, 'employee', 'b1d1ab72336885719b522a1920d56e5c');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vat`
--

CREATE TABLE IF NOT EXISTS `tbl_vat` (
  `VAT` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_vat`
--

INSERT INTO `tbl_vat` (`VAT`) VALUES
(5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_billing`
--
ALTER TABLE `tbl_billing`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_department`
--
ALTER TABLE `tbl_department`
 ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `Serial` (`Serial`), ADD UNIQUE KEY `Serial_2` (`Serial`);

--
-- Indexes for table `tbl_department_bills`
--
ALTER TABLE `tbl_department_bills`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_dept_payments`
--
ALTER TABLE `tbl_dept_payments`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_expenditure`
--
ALTER TABLE `tbl_expenditure`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_items`
--
ALTER TABLE `tbl_items`
 ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `Serial` (`Serial`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_property`
--
ALTER TABLE `tbl_property`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
 ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_billing`
--
ALTER TABLE `tbl_billing`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `tbl_department`
--
ALTER TABLE `tbl_department`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tbl_department_bills`
--
ALTER TABLE `tbl_department_bills`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_dept_payments`
--
ALTER TABLE `tbl_dept_payments`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `tbl_expenditure`
--
ALTER TABLE `tbl_expenditure`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_items`
--
ALTER TABLE `tbl_items`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_property`
--
ALTER TABLE `tbl_property`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
