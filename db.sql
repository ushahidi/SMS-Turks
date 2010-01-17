-- phpMyAdmin SQL Dump
-- version 3.2.2.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 17, 2010 at 02:24 AM
-- Server version: 5.1.37
-- PHP Version: 5.2.10-2ubuntu6.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `ushahidi`
--

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=99 ;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id`, `firstname`, `lastname`, `fullname`, `age`, `gender`, `city`, `department`, `status`, `date_of_birth`, `place_of_birth`, `place_of_residence`, `fathers_name`, `mothers_name`, `country`, `current_location`, `source`, `url_link_back`, `data_entry_initials`, `address`, `lat`, `lon`, `sms`, `current_contact_information`, `created`, `updated`, `ts`, `aid_type`, `notes`, `smsid`) VALUES
(1, 'Manny', 'Tester', 'Manny Tester', 0, '', 'Croix-des-Bouquets', 'Artibonite', 'Survived', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 18.9507, -72.7039, 'Tremblement de terre', '', 1263685320, 1263685320, '2010-01-16 23:42:00', '--2a. Structures at risk', '', 22),
(2, 'Manny', 'Tester', 'Manny Tester', 0, '', 'Croix-des-Bouquets', 'Artibonite', 'Survived', '0000-00-00', '', '', '', '', '', '', '', '', '', '149, Mem location', 18.9507, -72.7039, 'Survived. Building ready to collapse.', '', 1263685380, 1263685380, '2010-01-16 23:43:00', '--2a. Structures at risk', '', 22),
(6, '', '', ' ', 0, '', '', '', 'Other', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0, 0, 'Tramblement de terre', '', 1263689273, 1263689273, '2010-01-17 00:47:53', '--1e. Earthquake and aftershocks', '', 51),
(34, '', '', ' ', 0, '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0, 0, 'Seisme', '', 1263692676, 1263692676, '2010-01-17 01:44:36', '', 'all it says:\r\n\r\nearthquake\r\n', 16),
(16, '', '', ' ', 0, '', '', '', 'Other', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0, 0, 'Tremblement de terre', '', 1263691913, 1263691913, '2010-01-17 01:31:53', '5. Other', 'All this said is :\r\n\r\n\\"Earthquake\\"', 61),
(33, '', '', ' ', 0, '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0, 0, 'Noel', '', 1263692616, 1263692616, '2010-01-17 01:43:36', '', 'this says:\r\n\r\nchristmas', 17),
(32, '', '', ' ', 0, '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0, 0, 'meteo', '', 1263692593, 1263692593, '2010-01-17 01:43:13', '', 'this says:\r\n\r\nweather', 19),
(77, '', '', ' ', 0, '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0, 0, 'MWENTARENMEN.PALE.AVEK.PAPAM..SEJUDE.DEPI.LEOGANE.NIMIEWOPAPAM,NANSE 7542464136', '', 1263694169, 1263694169, '2010-01-17 02:09:29', '', 'Person would like to speak wit their dad. Father is Jude and number is 7542464136\r\n', 25),
(25, '', '', ' ', 0, '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0, 0, 'cyclo ne', '', 1263692137, 1263692137, '2010-01-17 01:35:37', '', 'All this says is:\r\nhurricane', 34),
(26, '', '', ' ', 0, '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0, 0, 'TREMBLEMENT DE TERRE', '', 1263692174, 1263692174, '2010-01-17 01:36:14', '', 'all this says is \\"earthquake\\"', 29),
(27, '', '', ' ', 0, '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0, 0, 'Ceisme', '', 1263692198, 1263692198, '2010-01-17 01:36:38', '', 'all this says is :\r\n\r\nearthquake', 27),
(59, '', '', ' ', 0, '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0, 0, 'Un front froid se retrouve sur Cuba ce matin. Il pourrait traverser Haiti demain. Des averses de pluie isolee sont encore prevues sur notre region ce soi', '', 1263693463, 1263693463, '2010-01-17 01:57:43', '', 'not enough information', 5),
(98, '', '', ' ', 0, '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0, 0, 'Cyclone \\\\\\"Dieu vous visitera\\\\\\"', '', 1263694920, 1263694920, '2010-01-17 02:22:00', '', 'This says:\r\nearthquake, God will visit you', 23);

-- --------------------------------------------------------

--
-- Table structure for table `person_comments`
--

CREATE TABLE IF NOT EXISTS `person_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  `comment` text,
  `created` int(11) DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`),
  KEY `ts` (`ts`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `person_comments`
--


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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=128 ;

--
-- Dumping data for table `person_photos`
--


-- --------------------------------------------------------

--
-- Table structure for table `person_update`
--

CREATE TABLE IF NOT EXISTS `person_update` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `person_update`
--


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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `searcher`
--

INSERT INTO `searcher` (`id`, `email`, `name`, `relationship`, `phone`, `place_of_residence`, `street`, `postal_code`, `location`, `country`, `person_id`, `ts`) VALUES
(1, '', 'xeipher', '', '+50937548631', '', '', '', '', '', 1, '2010-01-16 23:42:00'),
(2, '', 'xeipher', '', '+50937548631', '', '', '', '', '', 2, '2010-01-16 23:43:01');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

--
-- Dumping data for table `sms`
--

INSERT INTO `sms` (`smsid`, `number`, `message`, `status`, `date_rec`, `ts`) VALUES
(1, '+50937690954', 'SEISME', 3, '1263688786', '2010-01-17 01:58:15'),
(2, '+50937975855', 'Bonjour', 3, '1263688643', '2010-01-17 01:53:58'),
(3, '+50936642194', 'SEISME', 3, '1263688491', '2010-01-17 02:22:47'),
(4, '+50938357036', 'Tranbleman de terre', 3, '1263688379', '2010-01-17 01:57:49'),
(5, '+50937930117', 'Un front froid se retrouve sur Cuba ce matin. Il pourrait traverser Haiti demain. Des averses de pluie isolee sont encore prevues sur notre region ce soi', 2, '1263688302', '2010-01-17 01:57:44'),
(6, '+50937758679', 'Secousse sismique', 3, '1263688211', '2010-01-17 02:22:35'),
(7, '+50937953235', 'cyclòn', 3, '1263687668', '2010-01-17 01:16:17'),
(8, '+50936397585', 'SIKLON', 3, '1263687277', '2010-01-17 01:55:41'),
(9, '+50937811672', 'Tranblement de terre', 3, '1263686304', '2010-01-17 02:22:22'),
(10, '+50936434579', 'Tremblement de terre', 3, '1263686101', '2010-01-17 01:45:42'),
(11, '+50938417963', 'Cyclon', 3, '1263685843', '2010-01-17 01:45:33'),
(12, '+50938326769', 'Séisme', 3, '1263685520', '2010-01-17 01:45:23'),
(13, '+50936145675', 'Seisme', 3, '1263682200', '2010-01-17 01:55:34'),
(14, '+50938041675', 'Cylone', 3, '1263682196', '2010-01-17 01:44:55'),
(15, '+50937658144', 'Siklòn', 3, '1263681722', '2010-01-17 01:44:46'),
(16, '+50938023617', 'Seisme', 2, '1263681008', '2010-01-17 01:44:37'),
(17, '+50936376979', 'Noel', 2, '1263680698', '2010-01-17 01:43:37'),
(18, '+50936054175', 'bonswa mwen se john keby gedeon mwen paka ale lagonav paskem gen lajan emwen pagen manje fe yonjan pou mwen map mouri grangou pou madame fab kap koute no', 1, '1263679860', '2010-01-17 02:22:05'),
(19, '+50936591479', 'meteo', 2, '1263679459', '2010-01-17 01:43:14'),
(20, '+50937092585', 'Tranblement de terre', 3, '1263679218', '2010-01-17 01:55:23'),
(21, '+50936992127', 'Info', 3, '1263679108', '2010-01-17 01:39:03'),
(22, '+50938380445', '4636', 3, '1263678652', '2010-01-17 01:38:49'),
(23, '+50936621461', 'Cyclone \\"Dieu vous visitera\\"', 2, '1263678243', '2010-01-17 02:22:01'),
(24, '+50937509687', 'Seisme', 3, '1263675849', '2010-01-17 02:20:10'),
(25, '+50936058361', 'MWENTARENMEN.PALE.AVEK.PAPAM..SEJUDE.DEPI.LEOGANE.NIMIEWOPAPAM,NANSE 7542464136', 2, '1263675743', '2010-01-17 02:09:29'),
(26, '+50938165372', 'ALO MA SE ENIS SE NELAND NOU TOUT LA SE FONVERET NOU YE MESYE KOUZEN M YO TE VIN CHACHE NOU NAN MACHIN', 3, '1263674799', '2010-01-17 02:07:04'),
(27, '+50936444797', 'Ceisme', 2, '1263674552', '2010-01-17 01:36:39'),
(28, '+50938018046', 'et moi mon digicel est nul', 3, '1263673988', '2010-01-17 02:02:06'),
(29, '+50938443822', 'TREMBLEMENT DE TERRE', 2, '1263673017', '2010-01-17 01:36:15'),
(30, '+50936827837', 'tranblement de terre', 3, '1263672797', '2010-01-17 01:48:35'),
(31, '+50937185115', '\\0S\\0é\\0ï\\0m\\0e', 3, '1263672210', '2010-01-17 01:48:21'),
(32, '+50938315259', 'tremblement de terre', 3, '1263672207', '2010-01-17 01:35:17'),
(33, '+50937238928', 'Nico digi', 3, '1263671837', '2010-01-17 01:46:44'),
(34, '+50938607525', 'cyclo ne', 2, '1263671084', '2010-01-17 01:35:38'),
(35, '+50936320251', 'o', 3, '1263670005', '2010-01-17 01:46:27'),
(36, '+50937548631', 'Tremblement de terre', 3, '1263669354', '2010-01-17 01:46:14'),
(37, '+50937439079', 'Nico digi airp', 3, '1263668951', '2010-01-17 01:56:48'),
(38, '+50936543391', 'seisme', 3, '1263668614', '2010-01-17 01:34:44'),
(39, '+50937007366', 'Test 3', 3, '1263666541', '2010-01-17 01:45:57'),
(40, '+50937007366', 'Test 1', 3, '1263666510', '2010-01-17 01:34:27'),
(41, '+50936337377', 'Noel', 3, '1263666037', '2010-01-17 01:24:10'),
(42, '1233', '2', 3, '1263665501', '2010-01-17 01:24:04'),
(43, '+50937195239', 'Séisme', 3, '1263664810', '2010-01-17 01:34:09'),
(44, '+50937447406', 'CYLONE', 3, '1263664120', '2010-01-17 00:51:37'),
(45, '+50937482138', 'Tramblemant de terre.', 3, '1263660745', '2010-01-17 00:51:33'),
(46, '+50937169330', 'siklön', 3, '1263660304', '2010-01-17 00:51:20'),
(47, '+50937482138', 'Tramblément de terre.', 3, '1263660057', '2010-01-17 01:32:27'),
(48, '+50936712977', 'pa radio a se g..', 3, '1263659883', '2010-01-17 02:11:11'),
(49, '+50937045769', 'Cyclonne', 3, '1263659756', '2010-01-17 01:42:39'),
(50, '+50936178334', 'Voye yon numero mw ka jwen radio 1 kounye a.oke', 3, '1263659388', '2010-01-17 02:04:38'),
(51, '+50937783897', 'Tramblement de terre', 2, '1263659290', '2010-01-17 00:47:53'),
(52, '123', 'test 1234', 3, '1263658720', '2010-01-17 00:47:11'),
(53, '123', 'test 123', 3, '', '2010-01-17 00:46:59'),
(54, '+50937147220', 'SEISME', 3, '1263688962', '2010-01-17 02:23:25'),
(55, '+50937644425', 'Help', 3, '1263689395', '2010-01-17 02:17:14'),
(56, '+50937644425', 'Help me', 3, '1263689630', '2010-01-17 01:24:15'),
(57, '+50938341801', 'Testing + patrickeucalitto', 3, '1263690145', '2010-01-17 02:02:31'),
(58, '+50937943968', 'TRANBLEMAN', 3, '1263690036', '2010-01-17 02:02:16'),
(59, '+50938553529', 'Noel', 3, '1263690725', '2010-01-17 02:11:20'),
(63, '+50937435770', 'Syclone', 3, '1263691799', '2010-01-17 02:23:33'),
(65, '+50937711888', 'Cyclonne', 3, '1263692642', '2010-01-17 02:00:40'),
(67, '+50936351676', 'Relem', 3, '1263693803', '2010-01-17 02:23:49'),
(64, '+50937447180', 'Mwen se Etienne Ossé depi dabòn (leogane). Mwen vle di ak Etienne Sauveur si tout fwa li ta vivan poul fè nou konnen paske nou gentan kriye anpil pou li.Mèsi!', 1, '1263692201', '2010-01-17 02:17:24'),
(62, '+50936193099', 'Tranbleman', 3, '1263691842', '2010-01-17 01:38:26'),
(60, '+50936801373', '\\0S\\0I\\0G\\0L\\0Ò\\0N', 3, '1263691355', '2010-01-17 01:24:21'),
(61, '+50937187807', 'Tremblement de terre', 2, '1263691522', '2010-01-17 01:31:54'),
(66, '+50938054099', '(Cyclone)', 3, '1263693117', '2010-01-17 02:11:07'),
(68, '+50936351676', 'Mwen pa kon prenn', 1, '1263694061', '2010-01-17 02:23:56'),
(71, '+50937644425', 'A', 3, '1263694854', '2010-01-17 02:24:14'),
(70, '+50937447180', 'anpil.M espere wap fè mesaj la pase pou nou .ke Bondye beniw. ¤<Neyc>¤', 1, '1263694709', '2010-01-17 02:24:00'),
(69, '+50937447180', 'Mwen se Nesly volcy depi léogan(darbonne)Tanpri radio 1 eden jwen medsen pou zo nan léogan paske gen anpil pye ak ponyèt kase dejwente leogan ap soufri', 1, '1263694664', '2010-01-17 02:18:51'),
(72, '+50938210824', '0\\0x\\0 \\0O\\0h\\0!\\0 \\0C\\0m\\0b\\0i\\0e\\0n\\0 \\0j\\0e\\0 \\0p\\0a\\0n\\0s\\0e\\0,\\0 \\0 \\0p\\0r\\0q\\0u\\0o\\0i\\0 \\0d\\0e\\0 \\0t\\0r\\0è\\0s\\0 \\0t\\0o\\0t\\0 \\0t\\0u\\0 \\0o\\0c\\0u\\0p\\0e\\0 \\0m\\0a\\0p\\0a\\0n\\0s\\0é\\0 \\0!\\0\\0', 3, '1263694965', '2010-01-17 02:24:27');
