-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2018 at 08:09 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inmar`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `CHECK_USER_EXIST` (IN `uname` VARCHAR(30), IN `pword` VARCHAR(200))  NO SQL
SELECT l.user_id FROM login l WHERE l.username = uname and l.password = pword LIMIT 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GET_USER` (IN `user_id` VARCHAR(30))  NO SQL
SELECT	s.name, s.surname,
        s.UID, s.gender, s.email_id, s.mobile,
        CONCAT_WS(',', ad.line_1, ad.city, AD.state, 			ad.country) as address, ad.zipcode
FROM user s, address_table ad
WHERE s.user_id = user_id 
AND s.address_id = ad.address_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GET_USER_CONTACT` (IN `user_id` VARCHAR(30))  READS SQL DATA
    COMMENT 'GET THE CONTACTS OF THE USER WHOSE USER ID IS user_id'
SELECT	c.contact_id, c.name, c.gender, c.email, c.mobile, c.status, 
        CONCAT_WS(',', ad.line_1, ad.city, AD.state, ad.country) as address, ad.zipcode
FROM contacts c, user s, address_table ad
WHERE s.user_id = user_id
AND s.user_id = c.contact_of 
AND c.address_id = ad.address_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GET_USER_GROUPS` (IN `user_id` VARCHAR(10))  NO SQL
SELECT cg.group_id, cg.gname FROM contact_group cg
WHERE cg.admin = user_id$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `address_table`
--

CREATE TABLE `address_table` (
  `address_id` int(6) NOT NULL,
  `line_1` varchar(50) NOT NULL,
  `city` varchar(30) NOT NULL,
  `state` varchar(30) NOT NULL,
  `country` varchar(20) NOT NULL,
  `zipcode` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `address_table`
--

INSERT INTO `address_table` (`address_id`, `line_1`, `city`, `state`, `country`, `zipcode`) VALUES
(1, 'Dr. 956', 'Vijayawada', 'Andhra Pradesh', 'India', '520015'),
(2, 'Dr. 342', 'Vijayawada', 'Andhra Pradesh', 'India', '520001'),
(3, 'Dr. 6', 'Vizag', 'Andhra Pradesh', 'India', '520215'),
(4, 'Dr. 342', 'Tirupathi', 'Andhra Pradesh', 'India', '520301'),
(7, 'Dr323', 'Vizag', 'Andhra Pradesh', 'India', '895623'),
(9, 'Dr323', 'Vijayawada', 'Andhra Pradesh', 'India', '897845'),
(19, '23423', 'dlkfj', 'ldfkj', 'ldfkn', '123432'),
(20, 'sf', 'df', 'dfb', 'gre', '987858');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contact_id` int(6) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(40) NOT NULL,
  `contact_of` varchar(10) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `address_id` int(11) NOT NULL,
  `gender` enum('Male','Female','Other','') NOT NULL,
  `status` enum('active','passive','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`contact_id`, `name`, `email`, `contact_of`, `mobile`, `address_id`, `gender`, `status`) VALUES
(1, 'arjun', 'arjun@inmar.com', 'U100', '9658653214', 7, 'Male', 'active'),
(2, 'krishna', 'krishna@inmar.com', 'U100', '9228653214', 1, 'Male', 'passive'),
(6, 'chiranjeevi', 'chiru@inmar.com', 'U104', '9865326598', 20, 'Male', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `contact_group`
--

CREATE TABLE `contact_group` (
  `group_id` int(6) NOT NULL,
  `gname` varchar(50) NOT NULL,
  `admin` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_group`
--

INSERT INTO `contact_group` (`group_id`, `gname`, `admin`) VALUES
(1, 'mango group', 'U100'),
(2, 'banana group', 'U101'),
(9, 'daredevils', 'U104');

-- --------------------------------------------------------

--
-- Table structure for table `group_contact_map`
--

CREATE TABLE `group_contact_map` (
  `group_id` int(6) NOT NULL,
  `contact_id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_contact_map`
--

INSERT INTO `group_contact_map` (`group_id`, `contact_id`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(30) NOT NULL,
  `password` varchar(200) NOT NULL,
  `user_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`, `user_id`) VALUES
('arjun@inmar.com', 'arjun', 'U104'),
('bvpky@inmar.com', '123', 'U101'),
('joshi@inmar.com', '123', 'U103'),
('rbablu94@inmar.com', '123', 'U100');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` varchar(10) NOT NULL,
  `email_id` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `gender` enum('Male','Female','Other','') NOT NULL,
  `mobile` varchar(30) NOT NULL,
  `UID` varchar(12) NOT NULL,
  `address_id` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email_id`, `name`, `surname`, `gender`, `mobile`, `UID`, `address_id`) VALUES
('U100', 'rbablu94@inmar.com', 'Ram Prasad', 'Gudiwada', 'Male', '7659080610', '520145698563', 1),
('U101', 'bvpky@inmar.com', 'Prudhvi Kumar', 'Boyina', 'Male', '9666287937', '986532147521', 2),
('U102', 'baburoa94@inmar.com', 'Babu Rao', 'Gudiwada', 'Male', '9659050610', '920148698563', 3),
('U103', 'joshi@inmar.com', 'Joshi Kumar', 'Chalamala', 'Male', '9688287937', '986577147521', 4),
('U104', 'arjun@inmar.com', 'arjun', 'reddy', 'Female', '2344332211', '232323434343', 19);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address_table`
--
ALTER TABLE `address_table`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contact_id`),
  ADD UNIQUE KEY `EMAIL` (`email`),
  ADD UNIQUE KEY `MOBILE` (`mobile`),
  ADD UNIQUE KEY `ADDRESS` (`address_id`),
  ADD KEY `contact_belongs_to` (`contact_of`);

--
-- Indexes for table `contact_group`
--
ALTER TABLE `contact_group`
  ADD PRIMARY KEY (`group_id`),
  ADD KEY `group_belongs_to` (`admin`);

--
-- Indexes for table `group_contact_map`
--
ALTER TABLE `group_contact_map`
  ADD PRIMARY KEY (`group_id`,`contact_id`),
  ADD KEY `contact_is` (`contact_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`username`),
  ADD KEY `login_of_user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `MOBILE_INDEX` (`mobile`),
  ADD UNIQUE KEY `UID_INDEX` (`UID`),
  ADD UNIQUE KEY `ADDRESS_INDEX` (`address_id`),
  ADD UNIQUE KEY `EMAIL_INDEX` (`email_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address_table`
--
ALTER TABLE `address_table`
  MODIFY `address_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `contact_group`
--
ALTER TABLE `contact_group`
  MODIFY `group_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `group_contact_map`
--
ALTER TABLE `group_contact_map`
  MODIFY `contact_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contact_address_is` FOREIGN KEY (`address_id`) REFERENCES `address_table` (`address_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contact_belongs_to` FOREIGN KEY (`contact_of`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contact_group`
--
ALTER TABLE `contact_group`
  ADD CONSTRAINT `group_belongs_to` FOREIGN KEY (`admin`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `group_contact_map`
--
ALTER TABLE `group_contact_map`
  ADD CONSTRAINT `contact_is` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`contact_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group_is` FOREIGN KEY (`group_id`) REFERENCES `contact_group` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_of_user` FOREIGN KEY (`username`) REFERENCES `user` (`email_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `login_of_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `address_is` FOREIGN KEY (`address_id`) REFERENCES `address_table` (`address_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
