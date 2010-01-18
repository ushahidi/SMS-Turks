-- phpMyAdmin SQL Dump
-- version 3.2.2.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 18, 2010 at 01:44 AM
-- Server version: 5.1.37
-- PHP Version: 5.2.10-2ubuntu6.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `ushahidi`
--

-- --------------------------------------------------------

--
-- Table structure for table `ajax_chat_bans`
--

CREATE TABLE IF NOT EXISTS `ajax_chat_bans` (
  `userID` int(11) NOT NULL,
  `userName` varchar(64) COLLATE utf8_bin NOT NULL,
  `dateTime` datetime NOT NULL,
  `ip` varbinary(16) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `ajax_chat_invitations`
--

CREATE TABLE IF NOT EXISTS `ajax_chat_invitations` (
  `userID` int(11) NOT NULL,
  `channel` int(11) NOT NULL,
  `dateTime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `ajax_chat_messages`
--

CREATE TABLE IF NOT EXISTS `ajax_chat_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `userName` varchar(64) COLLATE utf8_bin NOT NULL,
  `userRole` int(1) NOT NULL,
  `channel` int(11) NOT NULL,
  `dateTime` datetime NOT NULL,
  `ip` varbinary(16) NOT NULL,
  `text` text COLLATE utf8_bin,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Table structure for table `ajax_chat_online`
--

CREATE TABLE IF NOT EXISTS `ajax_chat_online` (
  `userID` int(11) NOT NULL,
  `userName` varchar(64) COLLATE utf8_bin NOT NULL,
  `userRole` int(1) NOT NULL,
  `channel` int(11) NOT NULL,
  `dateTime` datetime NOT NULL,
  `ip` varbinary(16) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(32) CHARACTER SET latin1 DEFAULT NULL,
  `lastname` varchar(32) CHARACTER SET latin1 DEFAULT NULL,
  `fullname` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `city` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  `department` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
  `status` char(10) CHARACTER SET latin1 DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `place_of_birth` varchar(64) CHARACTER SET latin1 NOT NULL,
  `place_of_residence` varchar(255) CHARACTER SET latin1 NOT NULL,
  `fathers_name` varchar(64) CHARACTER SET latin1 NOT NULL,
  `mothers_name` varchar(64) CHARACTER SET latin1 NOT NULL,
  `country` varchar(64) CHARACTER SET latin1 NOT NULL,
  `current_location` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  `source` varchar(32) CHARACTER SET latin1 NOT NULL,
  `url_link_back` varchar(255) CHARACTER SET latin1 NOT NULL,
  `data_entry_initials` varchar(10) CHARACTER SET latin1 NOT NULL,
  `address` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  `lat` float DEFAULT '0',
  `lon` float DEFAULT '0',
  `sms` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  `current_contact_information` varchar(256) CHARACTER SET latin1 DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `aid_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  `smsid` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fullname` (`fullname`),
  KEY `ts` (`ts`),
  KEY `source` (`source`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=583 ;

-- --------------------------------------------------------

--
-- Table structure for table `person_comments`
--

CREATE TABLE IF NOT EXISTS `person_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  `comment` mediumtext,
  `created` int(11) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`),
  KEY `ts` (`ts`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `person_photos`
--

CREATE TABLE IF NOT EXISTS `person_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=128 ;

-- --------------------------------------------------------

--
-- Table structure for table `person_update`
--

CREATE TABLE IF NOT EXISTS `person_update` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) DEFAULT NULL,
  `field` varchar(32) DEFAULT NULL,
  `old_version` mediumtext,
  `new_version` mediumtext,
  `created` int(11) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`),
  KEY `ts` (`ts`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `searcher`
--

CREATE TABLE IF NOT EXISTS `searcher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `relationship` varchar(64) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `place_of_residence` varchar(255) NOT NULL,
  `street` varchar(64) NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `location` varchar(64) NOT NULL,
  `country` varchar(64) NOT NULL,
  `person_id` int(11) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`),
  KEY `ts` (`ts`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

-- --------------------------------------------------------

--
-- Table structure for table `sms`
--

CREATE TABLE IF NOT EXISTS `sms` (
  `smsid` bigint(20) NOT NULL AUTO_INCREMENT,
  `number` varchar(20) NOT NULL,
  `message` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-Not Seen 1-In Process 2-Complete',
  `date_rec` varchar(30) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`smsid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1824 ;
