-- phpMyAdmin SQL Dump
-- version 2.11.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 05, 2008 at 08:08 PM
-- Server version: 5.0.60
-- PHP Version: 5.2.6-pl5-gentoo

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `codex`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `author_id` int(11) NOT NULL auto_increment,
  `author_name` varchar(50) NOT NULL default '',
  `author_email` varchar(50) default NULL,
  `author_website` varchar(100) default NULL,
  PRIMARY KEY  (`author_id`),
  KEY `author_name` (`author_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE IF NOT EXISTS `chapters` (
  `id` int(11) NOT NULL auto_increment,
  `fic` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `title` varchar(255) default NULL,
  `file` varchar(100) default NULL,
  `data` longtext,
  PRIMARY KEY  (`id`),
  KEY `fic_id` (`fic`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `chapters`:
--   `fic`
--       `fics` -> `fic_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

CREATE TABLE IF NOT EXISTS `characters` (
  `character_id` int(11) NOT NULL auto_increment,
  `character_name` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`character_id`),
  KEY `character_name` (`character_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `characters_series`
--

CREATE TABLE IF NOT EXISTS `characters_series` (
  `character_id` int(11) NOT NULL default '0',
  `series_id` int(11) NOT NULL default '0',
  KEY `character_id` (`character_id`),
  KEY `series_id` (`series_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `characters_series`:
--   `character_id`
--       `characters` -> `character_id`
--   `series_id`
--       `series` -> `series_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `fics`
--

CREATE TABLE IF NOT EXISTS `fics` (
  `fic_id` int(11) NOT NULL auto_increment,
  `fic_title` varchar(50) NOT NULL default '',
  `fic_comments` text,
  PRIMARY KEY  (`fic_id`),
  KEY `fic_title` (`fic_title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 PACK_KEYS=0;

-- --------------------------------------------------------

--
-- Table structure for table `fic_author`
--

CREATE TABLE IF NOT EXISTS `fic_author` (
  `fic_id` int(11) NOT NULL default '0',
  `author_id` int(11) NOT NULL default '0',
  KEY `fic_id` (`fic_id`),
  KEY `author_id` (`author_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `fic_author`:
--   `author_id`
--       `authors` -> `author_id`
--   `fic_id`
--       `fics` -> `fic_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `fic_genre`
--

CREATE TABLE IF NOT EXISTS `fic_genre` (
  `fic_id` int(11) NOT NULL default '0',
  `genre_id` int(11) NOT NULL default '0',
  KEY `fic_id` (`fic_id`),
  KEY `genre_id` (`genre_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `fic_genre`:
--   `fic_id`
--       `fics` -> `fic_id`
--   `genre_id`
--       `genres` -> `genre_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `fic_matchup`
--

CREATE TABLE IF NOT EXISTS `fic_matchup` (
  `fic_id` int(11) NOT NULL default '0',
  `matchup_id` int(11) NOT NULL default '0',
  KEY `fic_id` (`fic_id`),
  KEY `matchup_id` (`matchup_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `fic_matchup`:
--   `fic_id`
--       `fics` -> `fic_id`
--   `matchup_id`
--       `matchups` -> `matchup_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `fic_series`
--

CREATE TABLE IF NOT EXISTS `fic_series` (
  `fic_id` int(11) NOT NULL default '0',
  `series_id` int(11) NOT NULL default '0',
  KEY `fic_id` (`fic_id`),
  KEY `series_id` (`series_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `fic_series`:
--   `fic_id`
--       `fics` -> `fic_id`
--   `series_id`
--       `series` -> `series_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE IF NOT EXISTS `genres` (
  `genre_id` int(11) NOT NULL auto_increment,
  `genre_name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`genre_id`),
  KEY `genre_name` (`genre_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `matchups`
--

CREATE TABLE IF NOT EXISTS `matchups` (
  `matchup_id` int(11) NOT NULL auto_increment,
  `match_1` int(11) NOT NULL default '0',
  `match_2` int(11) NOT NULL default '0',
  PRIMARY KEY  (`matchup_id`),
  KEY `match_1` (`match_1`),
  KEY `match_2` (`match_2`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `matchups`:
--   `match_1`
--       `characters` -> `character_id`
--   `match_2`
--       `characters` -> `character_id`
--

-- --------------------------------------------------------

--
-- Table structure for table `series`
--

CREATE TABLE IF NOT EXISTS `series` (
  `series_id` int(11) NOT NULL auto_increment,
  `series_title` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`series_id`),
  KEY `series_title` (`series_title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
