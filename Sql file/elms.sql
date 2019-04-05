-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 05, 2019 at 06:07 PM
-- Server version: 5.7.25-0ubuntu0.16.04.2
-- PHP Version: 7.0.33-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leaveportal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'admin', '97d9de758e20f8e5a74c21ba389fb562', '2019-04-02 12:38:32'),
(2, 'root', '6e5d1637ad859321848d7962ac7de7df', '2019-02-14 14:09:10');

-- --------------------------------------------------------

--
-- Table structure for table `leave_comb`
--

CREATE TABLE `leave_comb` (
  `id` int(11) NOT NULL,
  `main_leave_id` int(11) NOT NULL,
  `comb_leave_id` int(11) NOT NULL,
  `limit_to_comb` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leave_history`
--

CREATE TABLE `leave_history` (
  `id` int(11) NOT NULL,
  `LeaveType` varchar(110) NOT NULL,
  `count` int(11) NOT NULL,
  `cur_year` year(4) NOT NULL,
  `ToDate` varchar(120) NOT NULL,
  `FromDate` varchar(120) NOT NULL,
  `Description` mediumtext NOT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `AdminRemark` mediumtext,
  `AdminRemarkDate` varchar(120) DEFAULT NULL,
  `Status` int(1) NOT NULL,
  `IsRead` int(1) NOT NULL,
  `empid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leave_history`
--

INSERT INTO `leave_history` (`id`, `LeaveType`, `count`, `cur_year`, `ToDate`, `FromDate`, `Description`, `PostingDate`, `AdminRemark`, `AdminRemarkDate`, `Status`, `IsRead`, `empid`) VALUES
(1, 'Casual Leave', 0, 2017, '30/11/2017', '29/10/2017', 'test description test descriptiontest descriptiontest descriptiontest descriptiontest descriptiontest descriptiontest description', '2017-11-19 13:11:21', 'Lorem Ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups.\r\n', '2017-12-02 23:26:27 ', 2, 1, 1),
(2, 'Restricted Holiday(RH)', 0, 2017, '25/12/2017', '25/12/2017', 'Lorem Ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups.', '2017-12-03 08:29:07', 'Lorem Ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups.', '2017-12-03 14:06:12 ', 1, 1, 1),
(3, 'Casual Leave', 0, 2019, '22/02/2019', '25/02/2019', 'Testing', '2019-02-14 14:05:07', 'abcde', '2019-02-15 16:42:30 ', 1, 1, 1),
(4, 'Casual Leave', 0, 2019, '12/03/2019', '23/03/2019', 'testting 213', '2019-02-15 11:15:55', '1not approved', '2019-02-15 16:46:35 ', 2, 1, 1),
(5, 'Earned Leave', 0, 2019, '2019-02-23', '2019-02-26', 'test', '2019-02-22 09:59:42', NULL, NULL, 0, 0, 1),
(6, 'Casual Leave', 0, 2019, '2019-02-23', '2019-02-28', 'blah blah', '2019-02-22 10:05:30', 'okay man', '2019-02-22 15:36:11 ', 1, 1, 1),
(7, 'Casual Leave', 60, 2019, '2009-01-22', '2009-03-22', 'aaj mil jayga qa? plzZZz', '2019-04-02 12:29:26', NULL, NULL, 0, 1, 2),
(8, 'Casual Leave', 60, 2019, '2019-01-22', '2019-10-22', 'see', '2019-04-02 12:29:26', NULL, NULL, 1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `leave_left`
--

CREATE TABLE `leave_left` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `leave_id` int(11) NOT NULL,
  `LeaveType` varchar(200) NOT NULL,
  `leaves_taken` int(11) NOT NULL DEFAULT '0',
  `left_days` int(11) NOT NULL DEFAULT '0',
  `unique_id` varchar(150) NOT NULL,
  `accumulates` int(11) NOT NULL,
  `distributed` int(11) NOT NULL,
  `totl_avl_year` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `leave_left`
--

INSERT INTO `leave_left` (`id`, `emp_id`, `leave_id`, `LeaveType`, `leaves_taken`, `left_days`, `unique_id`, `accumulates`, `distributed`, `totl_avl_year`, `timestamp`) VALUES
(1, 1, 1, 'given', 40, 10, '1_1', 1, 1, 50, '2019-04-05 09:10:23'),
(268, 1, 2, 'System', 25, 15, '1_2', 1, 1, 40, '2019-04-05 09:10:31'),
(269, 2, 2, 'System', 48, 2, '2_2', 0, 1, 50, '2019-04-05 09:10:37');

-- --------------------------------------------------------

--
-- Table structure for table `list_holidays`
--

CREATE TABLE `list_holidays` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbldepartments`
--

CREATE TABLE `tbldepartments` (
  `id` int(11) NOT NULL,
  `DepartmentName` varchar(150) DEFAULT NULL,
  `DepartmentShortName` varchar(100) NOT NULL,
  `DepartmentCode` varchar(50) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbldepartments`
--

INSERT INTO `tbldepartments` (`id`, `DepartmentName`, `DepartmentShortName`, `DepartmentCode`, `CreationDate`) VALUES
(1, 'Human Resource', 'HR', 'HR001', '2017-11-01 07:16:25'),
(2, 'Information Technology', 'IT', 'IT001', '2017-11-01 07:19:37'),
(3, 'Operations', 'OP', 'OP1', '2017-12-02 21:28:56');

-- --------------------------------------------------------

--
-- Table structure for table `tblemployees`
--

CREATE TABLE `tblemployees` (
  `id` int(11) NOT NULL,
  `EmpId` varchar(100) NOT NULL,
  `FirstName` varchar(150) NOT NULL,
  `LastName` varchar(150) NOT NULL,
  `EmailId` varchar(200) NOT NULL,
  `Password` varchar(180) NOT NULL,
  `Gender` varchar(100) NOT NULL,
  `Dob` varchar(100) NOT NULL,
  `Department` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `City` varchar(200) NOT NULL,
  `Country` varchar(150) NOT NULL,
  `Phonenumber` char(11) NOT NULL,
  `Status` int(1) NOT NULL,
  `RegDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblemployees`
--

INSERT INTO `tblemployees` (`id`, `EmpId`, `FirstName`, `LastName`, `EmailId`, `Password`, `Gender`, `Dob`, `Department`, `Address`, `City`, `Country`, `Phonenumber`, `Status`, `RegDate`) VALUES
(1, 'EMP10806121', 'Johnny', 'doe', 'root', '97d9de758e20f8e5a74c21ba389fb562', 'Male', '3 February, 1990', 'Human Resource', 'N NEPO', 'NEPO', 'IRE', '9857555555', 1, '2017-11-10 11:29:59'),
(2, 'DEMP2132', 'James', 'doe', 'james@gmail.com', 'f925916e2754e5e03f75dd58a5733251', 'Male', '3 February, 1990', 'Information Technology', 'N NEPO', 'NEPO', 'IRE', '8587944255', 1, '2017-11-10 13:40:02');

-- --------------------------------------------------------

--
-- Table structure for table `tblleaves`
--

CREATE TABLE `tblleaves` (
  `id` int(11) NOT NULL,
  `LeaveType` varchar(110) NOT NULL,
  `count` int(11) NOT NULL,
  `cur_year` year(4) NOT NULL,
  `ToDate` varchar(120) NOT NULL,
  `FromDate` varchar(120) NOT NULL,
  `Description` mediumtext NOT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `AdminRemark` mediumtext,
  `AdminRemarkDate` varchar(120) DEFAULT NULL,
  `Status` int(1) NOT NULL,
  `IsRead` int(1) NOT NULL,
  `empid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblleaves`
--

INSERT INTO `tblleaves` (`id`, `LeaveType`, `count`, `cur_year`, `ToDate`, `FromDate`, `Description`, `PostingDate`, `AdminRemark`, `AdminRemarkDate`, `Status`, `IsRead`, `empid`) VALUES
(1, 'Casual Leave', 0, 2017, '30/11/2017', '29/10/2017', 'test description test descriptiontest descriptiontest descriptiontest descriptiontest descriptiontest descriptiontest description', '2017-11-19 13:11:21', 'Lorem Ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups.\r\n', '2017-12-02 23:26:27 ', 2, 1, 1),
(2, 'Restricted Holiday(RH)', 0, 2017, '25/12/2017', '25/12/2017', 'Lorem Ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups.', '2017-12-03 08:29:07', 'Lorem Ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups.', '2017-12-03 14:06:12 ', 1, 1, 1),
(3, 'Casual Leave', 0, 2019, '22/02/2019', '25/02/2019', 'Testing', '2019-02-14 14:05:07', 'abcde', '2019-02-15 16:42:30 ', 1, 1, 1),
(4, 'Casual Leave', 0, 2019, '12/03/2019', '23/03/2019', 'testting 213', '2019-02-15 11:15:55', '1not approved', '2019-02-15 16:46:35 ', 2, 1, 1),
(5, 'Earned Leave', 0, 2019, '2019-02-23', '2019-02-26', 'test', '2019-02-22 09:59:42', NULL, NULL, 0, 0, 1),
(6, 'Casual Leave', 0, 2019, '2019-02-23', '2019-02-28', 'blah blah', '2019-02-22 10:05:30', 'okay man', '2019-02-22 15:36:11 ', 1, 1, 1),
(7, 'Casual Leave', 60, 2019, '2009-01-22', '2009-03-22', 'aaj mil jayga qa? plzZZz', '2019-04-02 12:29:26', NULL, NULL, 0, 1, 2),
(8, 'Casual Leave', 60, 2019, '2019-01-22', '2019-10-22', 'see', '2019-04-02 12:29:26', NULL, NULL, 1, 1, 2);

--
-- Triggers `tblleaves`
--
DELIMITER $$
CREATE TRIGGER `ins_year` BEFORE INSERT ON `tblleaves` FOR EACH ROW SET NEW.cur_year = YEAR(NOW())
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tblleavetype`
--

CREATE TABLE `tblleavetype` (
  `id` int(11) NOT NULL,
  `LeaveType` varchar(200) DEFAULT NULL,
  `totl_avl_year` int(11) DEFAULT '0',
  `dIstributed` int(11) NOT NULL DEFAULT '0',
  `accumulates` int(11) NOT NULL DEFAULT '0',
  `include_weekends` int(11) NOT NULL,
  `Restriction` varchar(100) DEFAULT NULL,
  `Description` mediumtext,
  `CreationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblleavetype`
--

INSERT INTO `tblleavetype` (`id`, `LeaveType`, `totl_avl_year`, `dIstributed`, `accumulates`, `include_weekends`, `Restriction`, `Description`, `CreationDate`) VALUES
(1, 'Casual Leave', 8, 0, 0, 0, NULL, 'Casual Leave ', '2017-11-01 12:07:56'),
(3, 'Restricted Holiday(RH)', 0, 0, 0, 0, NULL, 'Restricted Holiday(RH)', '2017-11-06 13:16:38'),
(4, 'Special Leave', 3, 0, 1, 0, 'Have you completed more than 6 years of continuous service?', '', '2017-11-06 13:16:38'),
(5, 'Earned Leave', 30, 1, 1, 0, '', '', '2017-11-06 13:16:38'),
(6, 'casula test', 63, 2, 0, 1, NULL, 'fst', '2019-04-02 13:27:25'),
(7, 'tset 2', 50, 4, 1, 0, NULL, 'quaterly(25)', '2019-04-02 13:34:02'),
(8, 'final', 30, 4, 0, 1, 'riswat?', 'u know well', '2019-04-02 13:35:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_comb`
--
ALTER TABLE `leave_comb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_left`
--
ALTER TABLE `leave_left`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id` (`unique_id`);

--
-- Indexes for table `list_holidays`
--
ALTER TABLE `list_holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbldepartments`
--
ALTER TABLE `tbldepartments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblemployees`
--
ALTER TABLE `tblemployees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblleaves`
--
ALTER TABLE `tblleaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UserEmail` (`empid`);

--
-- Indexes for table `tblleavetype`
--
ALTER TABLE `tblleavetype`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `leave_comb`
--
ALTER TABLE `leave_comb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `leave_left`
--
ALTER TABLE `leave_left`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;
--
-- AUTO_INCREMENT for table `list_holidays`
--
ALTER TABLE `list_holidays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbldepartments`
--
ALTER TABLE `tbldepartments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tblemployees`
--
ALTER TABLE `tblemployees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tblleaves`
--
ALTER TABLE `tblleaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `tblleavetype`
--
ALTER TABLE `tblleavetype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;