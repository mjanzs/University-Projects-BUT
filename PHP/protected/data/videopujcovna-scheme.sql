-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Stř 17. říj 2012, 21:50
-- Verze MySQL: 5.5.25a
-- Verze PHP: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `videopujcovna`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `mov_genre`
--

CREATE TABLE IF NOT EXISTS `mov_genre` (
  `genre_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`genre_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Movie genre' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `mov_title`
--

CREATE TABLE IF NOT EXISTS `mov_title` (
  `title_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_czech_ci NOT NULL,
  `director` varchar(128) COLLATE utf8_czech_ci NOT NULL,
  `count` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `new` tinyint(4) NOT NULL DEFAULT '1',
  `picture` varchar(64) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`title_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Movie title' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `mov_title_genre`
--

CREATE TABLE IF NOT EXISTS `mov_title_genre` (
  `title_id` int(11) NOT NULL DEFAULT '0',
  `genre_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`title_id`,`genre_id`),
  KEY `title_id` (`title_id`),
  KEY `genre_id` (`genre_id`),
  KEY `title_id_2` (`title_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `tbl_bill`
--

CREATE TABLE IF NOT EXISTS `tbl_bill` (
  `bill_id` int(11) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `tbl_borrowing`
--

CREATE TABLE IF NOT EXISTS `tbl_borrowing` (
  `borrowing_id` int(11) NOT NULL AUTO_INCREMENT,
  `borrowed` time NOT NULL,
  `returned` time NOT NULL,
  `penalty` int(11) NOT NULL DEFAULT '0',
  `customer_id` int(11) NOT NULL,
  `employee_id_lend` int(11) NOT NULL,
  `employee_id_take` int(11) DEFAULT NULL,
  `bill_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`borrowing_id`),
  KEY `customer_id` (`customer_id`),
  KEY `employee_id_take` (`employee_id_take`),
  KEY `employee_id_lend` (`employee_id_lend`),
  KEY `bill_id` (`bill_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `tbl_medium`
--

CREATE TABLE IF NOT EXISTS `tbl_medium` (
  `medium_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('Blu-ray','DVD','VHS') COLLATE utf8_czech_ci NOT NULL DEFAULT 'DVD',
  `price` int(11) NOT NULL DEFAULT '40',
  `title_id` int(11) NOT NULL,
  `borrowing_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`medium_id`),
  KEY `title_id` (`title_id`),
  KEY `borrowing_id` (`borrowing_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Struktura tabulky `usr`
--

CREATE TABLE IF NOT EXISTS `usr` (
  `usr_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`usr_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `usr_address`
--

CREATE TABLE IF NOT EXISTS `usr_address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `street` varchar(64) COLLATE utf8_czech_ci DEFAULT NULL,
  `street_number` int(11) DEFAULT NULL,
  `town` varchar(64) COLLATE utf8_czech_ci DEFAULT NULL,
  `zip` int(11) DEFAULT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `usr_customer`
--

CREATE TABLE IF NOT EXISTS `usr_customer` (
  `customer_id` int(11) NOT NULL,
  `email` varchar(128) COLLATE utf8_czech_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_czech_ci NOT NULL,
  `surname` varchar(64) COLLATE utf8_czech_ci NOT NULL,
  `address_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `email` (`email`),
  KEY `address_id` (`address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `usr_employee`
--

CREATE TABLE IF NOT EXISTS `usr_employee` (
  `employee_id` int(11) NOT NULL,
  `email` varchar(128) COLLATE utf8_czech_ci NOT NULL,
  `name` varchar(64) COLLATE utf8_czech_ci NOT NULL,
  `surname` varchar(64) COLLATE utf8_czech_ci NOT NULL,
  `telephone_number` int(11) NOT NULL,
  `superuser` tinyint(4) NOT NULL DEFAULT '0',
  `address_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`employee_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `telephone_number` (`telephone_number`),
  UNIQUE KEY `telephone_number_2` (`telephone_number`),
  KEY `address_id` (`address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `mov_title_genre`
--
ALTER TABLE `mov_title_genre`
  ADD CONSTRAINT `mov_title_genre_ibfk_1` FOREIGN KEY (`title_id`) REFERENCES `mov_title` (`title_id`),
  ADD CONSTRAINT `mov_title_genre_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `mov_genre` (`genre_id`);

--
-- Omezení pro tabulku `tbl_borrowing`
--
ALTER TABLE `tbl_borrowing`
  ADD CONSTRAINT `tbl_borrowing_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `usr_customer` (`customer_id`),
  ADD CONSTRAINT `tbl_borrowing_ibfk_3` FOREIGN KEY (`employee_id_take`) REFERENCES `usr_employee` (`employee_id`),
  ADD CONSTRAINT `tbl_borrowing_ibfk_4` FOREIGN KEY (`employee_id_lend`) REFERENCES `usr_employee` (`employee_id`),
  ADD CONSTRAINT `tbl_borrowing_ibfk_5` FOREIGN KEY (`bill_id`) REFERENCES `tbl_bill` (`bill_id`);

--
-- Omezení pro tabulku `tbl_medium`
--
ALTER TABLE `tbl_medium`
  ADD CONSTRAINT `tbl_medium_ibfk_1` FOREIGN KEY (`title_id`) REFERENCES `mov_title` (`title_id`),
  ADD CONSTRAINT `tbl_medium_ibfk_2` FOREIGN KEY (`borrowing_id`) REFERENCES `tbl_borrowing` (`borrowing_id`);

--
-- Omezení pro tabulku `usr_customer`
--
ALTER TABLE `usr_customer`
  ADD CONSTRAINT `usr_customer_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `usr` (`usr_id`),
  ADD CONSTRAINT `usr_customer_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `usr_address` (`address_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `usr_employee`
--
ALTER TABLE `usr_employee`
  ADD CONSTRAINT `usr_employee_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `usr` (`usr_id`),
  ADD CONSTRAINT `usr_employee_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `usr_address` (`address_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
