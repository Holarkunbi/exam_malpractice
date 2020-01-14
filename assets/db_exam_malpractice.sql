-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2019 at 12:54 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 5.6.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_exam_malpractice`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

CREATE TABLE `tbl_department` (
  `dept_ID` int(11) NOT NULL,
  `dept_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`dept_ID`, `dept_name`) VALUES
(1, 'Computer Science'),
(2, 'Mathematics'),
(3, 'Statistics'),
(4, 'Physics'),
(5, 'Chemistry'),
(6, 'Geography'),
(7, 'Geology');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lecturer`
--

CREATE TABLE `tbl_lecturer` (
  `lect_ID` int(11) NOT NULL,
  `lect_name` varchar(50) NOT NULL,
  `lect_dept` int(11) NOT NULL,
  `lect_phone` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_lecturer`
--

INSERT INTO `tbl_lecturer` (`lect_ID`, `lect_name`, `lect_dept`, `lect_phone`) VALUES
(1, 'Aliyu Salisu', 1, '0803124789');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login`
--

CREATE TABLE `tbl_login` (
  `u_ID` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(15) NOT NULL,
  `hierachy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_login`
--

INSERT INTO `tbl_login` (`u_ID`, `username`, `password`, `hierachy`) VALUES
(1, 'admin', '12345', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_malpractice`
--

CREATE TABLE `tbl_malpractice` (
  `mal_ID` int(11) NOT NULL,
  `studID` varchar(11) NOT NULL,
  `deptID` int(11) NOT NULL,
  `courseID` text NOT NULL,
  `lectID` int(11) NOT NULL,
  `offence` text NOT NULL,
  `wit_name` varchar(50) NOT NULL,
  `wit_phone` varchar(12) NOT NULL,
  `evidence_name` text NOT NULL,
  `venue` text NOT NULL,
  `mal_date` varchar(20) NOT NULL,
  `mal_session` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_malpractice`
--

INSERT INTO `tbl_malpractice` (`mal_ID`, `studID`, `deptID`, `courseID`, `lectID`, `offence`, `wit_name`, `wit_phone`, `evidence_name`, `venue`, `mal_date`, `mal_session`) VALUES
(1, 'U18ST1001', 3, 'COURSE AND NAME', 1, 'OFFENCE', 'WITNESS NAME', 'PHONE', 'evidence', 'venue', 'DATE', 1),
(2, 'U17CS2011', 1, 'cosc203 discrete', 1, 'using phone to copy in class', 'Musa Kallamu', '07063152287', 'evidence', 'venue', '10/11/1991', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_session`
--

CREATE TABLE `tbl_session` (
  `session_ID` int(11) NOT NULL,
  `session_name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_session`
--

INSERT INTO `tbl_session` (`session_ID`, `session_name`) VALUES
(1, '2015/2016'),
(2, '2016/2017'),
(3, '2017/2018'),
(4, '2018/2019'),
(5, '2019/2020');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

CREATE TABLE `tbl_student` (
  `reg_no` varchar(15) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `stud_dept` int(11) NOT NULL,
  `phone_no` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_student`
--

INSERT INTO `tbl_student` (`reg_no`, `lname`, `fname`, `stud_dept`, `phone_no`) VALUES
('U16CS1001', 'Musa', 'Jameel', 1, '08031234567'),
('U17CS2011', 'OGUCHE', 'GRACE', 1, '07031234567'),
('U17MT1010', 'USMAN', 'SHEHU', 2, '0123583697'),
('U15MT2050', 'SALAM', 'RAHAMAT', 2, '08131234567'),
('U18ST1001', 'FAITH', 'JEGA', 3, '1790559426'),
('U16ST1002', 'SAFIYA', 'SHEHU', 3, '3012895147');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_upload`
--

CREATE TABLE `tbl_upload` (
  `upload_ID` int(11) NOT NULL,
  `upload_link` text NOT NULL,
  `mal_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_department`
--
ALTER TABLE `tbl_department`
  ADD PRIMARY KEY (`dept_ID`);

--
-- Indexes for table `tbl_lecturer`
--
ALTER TABLE `tbl_lecturer`
  ADD PRIMARY KEY (`lect_ID`);

--
-- Indexes for table `tbl_login`
--
ALTER TABLE `tbl_login`
  ADD PRIMARY KEY (`u_ID`);

--
-- Indexes for table `tbl_malpractice`
--
ALTER TABLE `tbl_malpractice`
  ADD PRIMARY KEY (`mal_ID`);

--
-- Indexes for table `tbl_session`
--
ALTER TABLE `tbl_session`
  ADD PRIMARY KEY (`session_ID`);

--
-- Indexes for table `tbl_upload`
--
ALTER TABLE `tbl_upload`
  ADD PRIMARY KEY (`upload_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_department`
--
ALTER TABLE `tbl_department`
  MODIFY `dept_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_lecturer`
--
ALTER TABLE `tbl_lecturer`
  MODIFY `lect_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_login`
--
ALTER TABLE `tbl_login`
  MODIFY `u_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_malpractice`
--
ALTER TABLE `tbl_malpractice`
  MODIFY `mal_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_session`
--
ALTER TABLE `tbl_session`
  MODIFY `session_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_upload`
--
ALTER TABLE `tbl_upload`
  MODIFY `upload_ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
