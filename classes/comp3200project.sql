-- phpMyAdmin SQL Dump
-- version 4.2.7
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Apr 13, 2016 at 03:22 PM
-- Server version: 5.5.41-log
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `comp3200project`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
`categoryId` int(8) NOT NULL,
  `categoryName` varchar(255) NOT NULL,
  `categoryDescription` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
`postId` int(8) NOT NULL,
  `postContent` text NOT NULL,
  `postDate` datetime NOT NULL,
  `postTopic` int(8) NOT NULL,
  `postAuthor` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
`topicId` int(8) NOT NULL,
  `topicSubject` varchar(255) NOT NULL,
  `topicDate` datetime NOT NULL,
  `topicCategory` int(8) NOT NULL,
  `topicAuthor` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`userId` int(8) NOT NULL,
  `userName` varchar(30) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `userEmail` varchar(255) NOT NULL,
  `userDate` datetime NOT NULL,
  `userPermLevel` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
 ADD PRIMARY KEY (`categoryId`), ADD UNIQUE KEY `categoryName_unique` (`categoryName`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
 ADD PRIMARY KEY (`postId`), ADD KEY `postTopic` (`postTopic`), ADD KEY `postAuthor` (`postAuthor`);

--
-- Indexes for table `topic`
--
ALTER TABLE `topic`
 ADD PRIMARY KEY (`topicId`), ADD KEY `topicCategory` (`topicCategory`), ADD KEY `topicAuthor` (`topicAuthor`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`userId`), ADD UNIQUE KEY `userName_unique` (`userName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
MODIFY `categoryId` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
MODIFY `postId` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `topic`
--
ALTER TABLE `topic`
MODIFY `topicId` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `userId` int(8) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `post`
--
ALTER TABLE `post`
ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`postTopic`) REFERENCES `topic` (`topicId`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`postAuthor`) REFERENCES `user` (`userId`) ON UPDATE CASCADE;

--
-- Constraints for table `topic`
--
ALTER TABLE `topic`
ADD CONSTRAINT `topic_ibfk_1` FOREIGN KEY (`topicCategory`) REFERENCES `category` (`categoryId`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `topic_ibfk_2` FOREIGN KEY (`topicAuthor`) REFERENCES `user` (`userId`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
