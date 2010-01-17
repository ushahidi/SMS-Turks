-- phpMyAdmin SQL Dump
-- version 2.9.1.1-Debian-9
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jan 14, 2010 at 03:11 PM
-- Server version: 5.1.30
-- PHP Version: 5.2.0-8+etch15
-- 
-- Database: `haiti`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `familylinks`
-- 

CREATE TABLE `familylinks` (
  `url` varchar(255) NOT NULL,
  `parsed` tinyint(1) unsigned NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `fathers_name` varchar(255) NOT NULL,
  `mothers_name` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `date_of_birth` varchar(255) NOT NULL,
  `place_of_birth` varchar(255) NOT NULL,
  `place_of_residence` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `my_full_name` varchar(255) NOT NULL,
  `my_fathers_name` varchar(255) NOT NULL,
  `my_mothers_name` varchar(255) NOT NULL,
  `my_sex` varchar(255) NOT NULL,
  `my_date_of_birth` varchar(255) NOT NULL,
  `my_place_of_birth` varchar(255) NOT NULL,
  `my_place_of_residence` varchar(255) NOT NULL,
  `my_street` varchar(255) NOT NULL,
  `my_postal_code` varchar(255) NOT NULL,
  `my_location` varchar(255) NOT NULL,
  `my_country` varchar(255) NOT NULL,
  `my_phone` varchar(255) NOT NULL,
  `my_email` varchar(255) NOT NULL,
  `my_via` varchar(255) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `url` (`url`),
  KEY `parsed` (`parsed`,`ts`),
  KEY `full_name` (`full_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `person`
-- 

CREATE TABLE `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(32) DEFAULT NULL,
  `lastname` varchar(32) DEFAULT NULL,
  `fullname` varchar(64) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `city` varchar(64) DEFAULT NULL,
  `department` varchar(16) DEFAULT NULL,
  `status` char(10) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `place_of_birth` varchar(64) NOT NULL,
  `place_of_residence` varchar(255) NOT NULL,
  `country` varchar(64) NOT NULL,
  `current_location` varchar(64) DEFAULT NULL,
  `source` varchar(32) NOT NULL,
  `url_link_back` varchar(255) NOT NULL,
  `data_entry_initials` varchar(10) NOT NULL,
  `address` varchar(64) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lon` float DEFAULT NULL,
  `current_contact_information` varchar(256) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fullname` (`fullname`),
  KEY `ts` (`ts`),
  KEY `source` (`source`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=595 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `person_comments`
-- 

CREATE TABLE `person_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  `comment` text,
  `created` int(11) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`),
  KEY `ts` (`ts`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=215 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `person_photos`
-- 

CREATE TABLE `person_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=87 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `person_update`
-- 

CREATE TABLE `person_update` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) DEFAULT NULL,
  `field` varchar(32) DEFAULT NULL,
  `old_version` text,
  `new_version` text,
  `created` int(11) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`),
  KEY `ts` (`ts`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=501 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `searcher`
-- 

CREATE TABLE `searcher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `relationship` varchar(64) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`),
  KEY `ts` (`ts`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=476 ;
