-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Pát 07. pro 2012, 21:44
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
  PRIMARY KEY (`genre_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Movie genre' AUTO_INCREMENT=34 ;

--
-- Vypisuji data pro tabulku `mov_genre`
--

INSERT INTO `mov_genre` (`genre_id`, `name`) VALUES
(5, 'Akční'),
(6, 'Animovaný'),
(7, 'Dobrodružný'),
(8, 'Dokumentární'),
(2, 'Drama'),
(9, 'Erotický'),
(10, 'Experimentální'),
(3, 'Fantasy'),
(12, 'Horor'),
(13, 'Hudební'),
(14, 'Katastrofický'),
(1, 'Komedie'),
(15, 'Krimi'),
(16, 'Loutkový'),
(17, 'Muzikál'),
(18, 'Mysteriózní'),
(19, 'Podobenství'),
(20, 'Poetický'),
(21, 'Pohádka'),
(22, 'Povídkový'),
(23, 'Psychologický'),
(24, 'Publicistický'),
(25, 'Rodinný'),
(26, 'Romantický'),
(4, 'Sci-fi'),
(28, 'Sportovní'),
(29, 'Telenovela'),
(30, 'Thriller'),
(31, 'Válečný'),
(32, 'Western'),
(33, 'Životopisný');

-- --------------------------------------------------------

--
-- Struktura tabulky `mov_title`
--

CREATE TABLE IF NOT EXISTS `mov_title` (
  `title_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_czech_ci NOT NULL,
  `director` varchar(128) COLLATE utf8_czech_ci NOT NULL,
  `year` year(4) NOT NULL,
  `new` tinyint(4) NOT NULL DEFAULT '1',
  `picture` varchar(64) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`title_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci COMMENT='Movie title' AUTO_INCREMENT=37 ;

--
-- Vypisuji data pro tabulku `mov_title`
--

INSERT INTO `mov_title` (`title_id`, `name`, `director`, `year`, `new`, `picture`) VALUES
(5, 'Vykoupení z věznice Shawshank', 'Frank Darabont', 1994, 0, 'http://img.csfd.cz/posters/0/2294_dvd.jpg'),
(6, 'Forrest Gump', 'Robert Zemeckis', 1994, 0, 'http://img.csfd.cz/posters/1/10135_dvd.jpg'),
(7, 'Přelet nad kukaččím hnízdem', 'Miloš Forman', 1975, 0, 'http://img.csfd.cz/posters/0/2982_dvd.jpg'),
(8, 'Zelená míle', 'Frank Darabont', 1999, 0, 'http://img.csfd.cz/posters/0/2292_1.jpg'),
(9, 'Schindlerův seznam', 'Steven Spielberg', 1993, 0, 'http://img.csfd.cz/posters/0/8653_dvd.jpg'),
(10, 'Sedm', 'David Fincher', 1995, 0, 'http://img.csfd.cz/posters/0/2671_dvd.jpg'),
(11, 'Kmotr', 'Francis Ford Coppola', 1972, 0, 'http://img.csfd.cz/posters/0/1644_dvd_1.jpg'),
(12, 'Dvanáct rozhněvaných mužů', 'Sidney Lumet, Edward Binns', 1957, 0, 'http://img.csfd.cz/posters/0/6178.jpg'),
(13, 'Nedotknutelní', 'Olivier Nakache, Eric Toledano', 2011, 1, 'http://img.csfd.cz/posters/30/306731_1.jpg'),
(14, 'Kmotr II', 'Kmotr II', 1974, 0, 'http://img.csfd.cz/posters/0/1645_dvd_1.jpg'),
(15, 'Tenkrát na Západě', 'Sergio Leone', 1968, 0, 'http://img.csfd.cz/posters/0/5911_dvd.jpg'),
(16, 'Pelíšky', 'Jan Hřebejk', 1999, 0, 'http://img.csfd.cz/posters/0/4570.jpg'),
(17, 'Pulp Fiction: Historky z podsvětí', 'Quentin Tarantino', 1994, 0, 'http://img.csfd.cz/posters/0/8852_dvd.jpg'),
(18, 'Terminátor 2: Den zúčtování', 'James Cameron', 1991, 0, 'http://img.csfd.cz/posters/0/1248_dvd.jpg'),
(19, 'Mlčení jehňátek', 'Jonathan Demme', 1991, 0, 'http://img.csfd.cz/posters/0/2356_dvd_1.jpg'),
(20, 'Hodný, zlý a ošklivý', 'Sergio Leone', 1966, 0, 'http://img.csfd.cz/posters/0/5910_dvd.jpg'),
(21, 'Gran Torino', 'Clint Eastwood', 2008, 0, 'http://img.csfd.cz/posters/24/240479_dvd_1.jpg'),
(22, 'Rain Man', 'Barry Levinson', 1988, 0, 'http://img.csfd.cz/posters/0/5954_dvd_1.jpg'),
(23, 'Earth', 'Alastair Fothergill, Mark Linfield', 2007, 0, 'http://img.csfd.cz/posters/22/228566.jpg'),
(24, 'Pán prstenů: Společenstvo Prstenu', 'Peter Jackson', 2001, 0, 'http://img.csfd.cz/posters/0/4711_dvd.jpg'),
(25, 'Avengers', 'Joss Whedon', 2012, 1, 'http://img.csfd.cz/posters/24/241997_dvd.jpg'),
(26, 'Temný rytíř povstal', 'Christopher Nolan', 2012, 1, 'http://img.csfd.cz/posters/25/252669_dvd.jpg'),
(27, 'Matrix', 'Lana Wachowski, Andy Wachowski', 1999, 0, 'http://img.csfd.cz/posters/0/9499_dvd.jpg'),
(28, 'obyvatelé ztracené archy', 'Steven Spielberg', 1981, 0, 'http://img.csfd.cz/posters/0/8650_dvd.jpg'),
(29, 'Sedm statečných', 'John Sturges', 1960, 0, 'http://img.csfd.cz/posters/1/18780_dvd.jpg'),
(30, 'Podraz', 'George Roy Hill', 1973, 0, 'http://img.csfd.cz/posters/1/15046_dvd_1.jpg'),
(31, 'Butch Cassidy a Sundance Kid', 'George Roy Hill', 1969, 0, 'http://img.csfd.cz/posters/1/15031_dvd.jpg'),
(32, 'Temný rytíř', 'Christopher Nolan', 2008, 1, 'http://img.csfd.cz/posters/22/223734_dvd.jpg'),
(33, 'Leon', 'Luc Besson', 1994, 0, 'http://img.csfd.cz/posters/0/773_dvd.jpg'),
(34, 'Pán prstenů: Návrat krále', 'Peter Jackson', 2003, 0, 'http://img.csfd.cz/posters/0/4712_dvd.jpg'),
(35, 'Vetřelci', 'James Cameron', 1986, 0, 'http://img.csfd.cz/posters/0/1245_dvd.jpg'),
(36, 'Indiana Jones a Poslední křížová výprava', 'Steven Spielberg', 1989, 0, 'http://img.csfd.cz/posters/0/8641_dvd.jpg');

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

--
-- Vypisuji data pro tabulku `mov_title_genre`
--

INSERT INTO `mov_title_genre` (`title_id`, `genre_id`) VALUES
(5, 2),
(5, 15),
(6, 1),
(6, 2),
(6, 26),
(7, 2),
(8, 2),
(8, 15),
(8, 18),
(9, 2),
(9, 31),
(9, 33),
(10, 15),
(10, 18),
(10, 30),
(11, 2),
(11, 15),
(12, 2),
(12, 15),
(13, 1),
(13, 2),
(13, 33),
(14, 2),
(14, 15),
(14, 30),
(15, 32),
(16, 1),
(16, 2),
(17, 15),
(17, 30),
(18, 4),
(18, 5),
(18, 30),
(19, 12),
(19, 15),
(19, 30),
(20, 7),
(20, 32),
(21, 2),
(21, 23),
(22, 2),
(23, 8),
(24, 3),
(24, 5),
(24, 7),
(25, 5),
(26, 5),
(26, 15),
(27, 4),
(27, 5),
(27, 30),
(28, 5),
(28, 7),
(29, 2),
(29, 7),
(29, 32),
(30, 1),
(30, 2),
(30, 15),
(31, 7),
(31, 15),
(31, 32),
(32, 2),
(32, 5),
(32, 15),
(32, 30),
(33, 2),
(33, 15),
(33, 30),
(34, 3),
(34, 5),
(34, 7),
(35, 4),
(35, 5),
(35, 12),
(35, 30),
(36, 5),
(36, 7);

-- --------------------------------------------------------

--
-- Struktura tabulky `tbl_bill`
--

CREATE TABLE IF NOT EXISTS `tbl_bill` (
  `bill_id` int(11) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `title_id` int(11) DEFAULT NULL,
  `type` enum('Blu-ray','DVD','VHS','') COLLATE utf8_czech_ci NOT NULL DEFAULT 'DVD',
  `price` int(11) NOT NULL DEFAULT '0',
  `days` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`bill_id`),
  KEY `title_id` (`title_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=32 ;

--
-- Vypisuji data pro tabulku `tbl_bill`
--

INSERT INTO `tbl_bill` (`bill_id`, `time`, `title_id`, `type`, `price`, `days`) VALUES
(1, '2012-12-04 15:26:08', 5, 'DVD', 40, 1),
(2, '2012-12-04 16:31:18', 5, 'DVD', 30, 1),
(3, '2012-12-04 16:31:33', 5, 'DVD', 30, 1),
(4, '2012-12-05 17:41:50', 6, 'DVD', 30, 1),
(5, '2012-12-05 17:44:55', 6, 'DVD', 30, 1),
(6, '2012-12-05 17:47:29', 6, 'DVD', 30, 1),
(7, '2012-12-05 18:13:01', 13, 'Blu-ray', 40, 1),
(8, '2012-12-05 18:13:39', 6, 'DVD', 120, 4),
(9, '2012-12-05 18:22:40', 6, 'DVD', 30, 1),
(10, '2012-12-05 18:28:50', 15, 'DVD', 30, 1),
(11, '2012-12-05 18:59:55', 10, 'DVD', 30, 1),
(12, '2012-12-05 19:00:00', 23, 'DVD', 30, 1),
(13, '2012-12-05 19:00:09', 12, 'DVD', 30, 1),
(14, '2012-12-05 19:00:20', 21, 'Blu-ray', 120, 3),
(15, '2012-12-05 19:00:21', 17, 'Blu-ray', 45, 1),
(16, '2012-12-05 19:47:31', 5, 'DVD', 30, 1),
(17, '2012-12-05 20:04:15', 20, 'DVD', 0, 1),
(18, '2012-12-05 20:05:58', 12, 'DVD', 30, 1),
(19, '2012-12-05 20:08:23', 10, 'DVD', 30, 1),
(20, '2012-12-05 20:08:35', 16, 'DVD', 0, 1),
(21, '2012-12-05 20:09:52', 11, 'DVD', 30, 1),
(22, '2012-12-05 20:15:00', 26, 'DVD', 0, 1),
(23, '2012-12-05 20:16:21', 8, 'DVD', 30, 1),
(24, '2012-12-06 07:37:43', 5, 'Blu-ray', 40, 1),
(25, '2012-12-06 07:47:07', 21, 'DVD', 30, 1),
(26, '2012-12-06 08:14:03', 6, 'DVD', 30, 1),
(27, '2012-12-07 16:00:00', 6, 'DVD', 30, 1),
(28, '2012-12-07 20:14:58', 16, 'DVD', 30, 1),
(29, '2012-12-07 20:27:00', 7, 'DVD', 30, 1),
(30, '2012-12-07 20:27:24', 9, 'DVD', 60, 2),
(31, '2012-12-07 20:29:21', 6, 'DVD', 210, 7);

-- --------------------------------------------------------

--
-- Struktura tabulky `tbl_borrowing`
--

CREATE TABLE IF NOT EXISTS `tbl_borrowing` (
  `borrowing_id` int(11) NOT NULL AUTO_INCREMENT,
  `borrowed` date DEFAULT NULL,
  `returned` date DEFAULT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=33 ;

--
-- Vypisuji data pro tabulku `tbl_borrowing`
--

INSERT INTO `tbl_borrowing` (`borrowing_id`, `borrowed`, `returned`, `penalty`, `customer_id`, `employee_id_lend`, `employee_id_take`, `bill_id`) VALUES
(1, '2012-12-04', '2012-12-04', 0, 17, 5, 15, 3),
(3, '2012-12-04', '2012-12-05', 0, 37, 5, 5, 15),
(4, '2012-12-02', '2012-12-05', 0, 24, 5, 5, 14),
(5, '2012-12-03', '2012-12-04', 0, 24, 15, 15, 2),
(6, '2012-12-04', '2012-12-05', 0, 25, 15, 5, 13),
(7, '2012-12-04', '2012-12-05', 0, 42, 15, 5, 12),
(8, '2012-12-05', '2012-12-05', 0, 25, 5, 5, 6),
(9, '2012-12-03', '2012-12-05', 0, 42, 5, 5, 4),
(10, '2012-12-04', '2012-12-05', 0, 59, 5, 5, 5),
(11, '2012-12-05', '2012-12-05', 0, 17, 5, 5, 7),
(12, '2012-12-01', '2012-12-05', 0, 17, 5, 5, 8),
(13, '2012-12-05', '2012-12-05', 0, 17, 5, 5, 9),
(14, '2012-12-05', '2012-12-05', 0, 17, 5, 5, 11),
(15, '2012-12-05', '2012-12-05', 0, 59, 5, 5, 10),
(16, '2012-12-05', '2012-12-05', 0, 19, 5, 5, 23),
(17, '2012-12-05', '2012-12-06', 0, 37, 5, 62, 24),
(18, '2012-12-05', NULL, 0, 24, 5, NULL, NULL),
(19, '2012-12-05', NULL, 0, 59, 5, NULL, NULL),
(20, '2012-12-05', '2012-12-06', 0, 60, 62, 62, 25),
(21, '2012-12-05', NULL, 0, 31, 62, NULL, NULL),
(22, '2012-12-06', NULL, 0, 52, 62, NULL, NULL),
(23, '2012-12-05', NULL, 0, 24, 62, NULL, NULL),
(24, '2012-12-06', NULL, 0, 58, 62, NULL, NULL),
(25, '2012-12-05', '2012-12-06', 0, 61, 62, 62, 26),
(26, '2012-12-06', NULL, 0, 42, 5, NULL, NULL),
(27, '2012-12-07', '2012-12-07', 0, 52, 5, 5, 27),
(28, '2012-12-06', '2012-12-07', 0, 52, 5, 5, 28),
(29, '2012-12-07', '2012-12-07', 0, 17, 5, 5, 29),
(30, '2012-12-05', '2012-12-07', 0, 52, 5, 5, 30),
(31, '2012-12-07', NULL, 0, 52, 5, NULL, NULL),
(32, '2012-11-30', '2012-12-07', 0, 52, 5, 5, 31);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=55 ;

--
-- Vypisuji data pro tabulku `tbl_medium`
--

INSERT INTO `tbl_medium` (`medium_id`, `type`, `price`, `title_id`, `borrowing_id`) VALUES
(2, 'Blu-ray', 40, 5, 21),
(3, 'DVD', 30, 5, 18),
(4, 'DVD', 30, 5, 19),
(5, 'DVD', 30, 6, NULL),
(6, 'DVD', 30, 6, NULL),
(7, 'Blu-ray', 40, 7, NULL),
(8, 'DVD', 30, 7, NULL),
(9, 'DVD', 30, 8, 23),
(10, 'DVD', 30, 8, 22),
(11, 'DVD', 30, 9, NULL),
(12, 'DVD', 30, 10, NULL),
(13, 'VHS', 30, 10, NULL),
(14, 'DVD', 30, 11, NULL),
(15, 'DVD', 30, 11, NULL),
(16, 'DVD', 30, 12, 24),
(17, 'Blu-ray', 40, 13, 26),
(18, 'Blu-ray', 40, 13, NULL),
(19, 'Blu-ray', 40, 13, NULL),
(20, 'DVD', 35, 13, NULL),
(21, 'DVD', 35, 13, NULL),
(22, 'DVD', 30, 14, NULL),
(23, 'DVD', 30, 14, NULL),
(24, 'DVD', 30, 15, NULL),
(25, 'VHS', 30, 16, NULL),
(26, 'DVD', 30, 16, NULL),
(27, 'DVD', 30, 16, NULL),
(28, 'DVD', 30, 17, NULL),
(29, 'DVD', 30, 17, NULL),
(30, 'VHS', 30, 18, NULL),
(31, 'DVD', 30, 18, NULL),
(32, 'DVD', 30, 19, NULL),
(33, 'DVD', 30, 20, NULL),
(34, 'Blu-ray', 40, 21, NULL),
(35, 'DVD', 30, 21, NULL),
(36, 'DVD', 30, 22, NULL),
(37, 'DVD', 30, 23, NULL),
(38, 'Blu-ray', 40, 23, NULL),
(39, 'Blu-ray', 40, 23, NULL),
(40, 'DVD', 30, 24, NULL),
(41, 'Blu-ray', 45, 25, NULL),
(42, 'Blu-ray', 45, 25, 31),
(43, 'DVD', 40, 25, NULL),
(44, 'Blu-ray', 45, 26, NULL),
(45, 'Blu-ray', 45, 26, NULL),
(46, 'DVD', 40, 26, NULL),
(47, 'DVD', 30, 27, NULL),
(48, 'DVD', 30, 29, NULL),
(49, 'VHS', 20, 30, NULL),
(50, 'VHS', 20, 31, NULL),
(51, 'DVD', 30, 32, NULL),
(52, 'Blu-ray', 40, 32, NULL),
(53, 'DVD', 30, 33, NULL),
(54, 'DVD', 30, 34, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=63 ;

--
-- Vypisuji data pro tabulku `usr`
--

INSERT INTO `usr` (`usr_id`, `username`, `password`) VALUES
(5, 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(14, 'honza', 'd9479746ea51a4177f8bc092c5db7b8d'),
(15, 'anna', 'a70f9e38ff015afaa9ab0aacabee2e13'),
(16, 'eva', 'ce87da99f84e29be87ef8be6b84ea4e3'),
(17, 'pepa', '281ffbf5eb2a3916b9c1eb8f28637836'),
(19, 'lucie', '318fbaf5acbf2b69a202de4c6df4cd2c'),
(24, 'ivana', '4eb274593fde2b15697a325349d89aa4'),
(25, 'mira', '9ed0bf9229b8d75193ee8540a57a90a6'),
(31, 'petr', 'bf1d161a0c5a6489a42d7cff49f5a78a'),
(37, 'pavel', 'ef1652b79c940145b600de7a2fe0288e'),
(42, 'katka', '154618619348deed677d40398a0d1e4c'),
(47, 'franta', '7e2a12b82afd182cd5aeebfa4e7f4f51'),
(52, 'jakub', 'eccdacd4709395e97e6b19756c7b45c1'),
(58, 'adela', 'bbad14bc2a2ddb9244a72058cddf15cb'),
(59, 'karel', '2cd324f30dc548396570da4e637c53ee'),
(60, 'lukas', '1d028378e12ca6bdafa3b8b21bc5a9ea'),
(61, 'lida', 'd41d8cd98f00b204e9800998ecf8427e'),
(62, 'tom', '34b7da764b21d298ef307d04d8152dc5');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=37 ;

--
-- Vypisuji data pro tabulku `usr_address`
--

INSERT INTO `usr_address` (`address_id`, `street`, `street_number`, `town`, `zip`) VALUES
(10, 'Orná', 1024, 'Dolní Lhotka', 45001),
(14, 'Dlouhá', 444, 'Štemberk', 61010),
(15, NULL, NULL, NULL, NULL),
(16, 'Přičná', 111, 'Praha', 20010),
(17, NULL, NULL, 'Brno', NULL),
(18, NULL, NULL, NULL, NULL),
(19, NULL, NULL, NULL, NULL),
(20, NULL, NULL, NULL, NULL),
(21, NULL, NULL, 'Pardubice', NULL),
(22, NULL, NULL, 'Olomouc', NULL),
(23, 'Přímá', 1220, 'Olomouc', 49000),
(24, 'Přímá', 1220, 'Olomouc', 49000),
(25, 'Přímá', 1220, 'Olomouc', 49000),
(26, 'Přímá', 1220, 'Olomouc', 49000),
(27, 'Přímá', 1220, 'Olomouc', 49000),
(28, 'Přímá', 1220, 'Olomouc', 49000),
(29, NULL, NULL, NULL, NULL),
(30, NULL, NULL, NULL, NULL),
(31, NULL, NULL, NULL, NULL),
(32, NULL, NULL, NULL, NULL),
(33, 'Krlíkova', 10, 'Karlovi Vary', 20102),
(34, 'Luční', 12, 'Ostrava', 88811),
(35, 'Hlavní', 41, 'Přerov', 74116),
(36, 'Pevná', 411, 'Praha', 21041);

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

--
-- Vypisuji data pro tabulku `usr_customer`
--

INSERT INTO `usr_customer` (`customer_id`, `email`, `name`, `surname`, `address_id`) VALUES
(17, 'josef@seznam.cz', 'Josef', 'Nový', NULL),
(19, 'lucka@seznam.cz', 'Lucie', 'Zelená', NULL),
(24, 'iva@seznam.cz', 'Iva', 'Modrá', NULL),
(25, 'mira@gmail.com', 'Miroslav', 'Dlouhý', 22),
(31, 'petr@centrum.cz', 'Petr', 'Malý', 21),
(37, 'pavlik@pavlicek.cz', 'Pavlik', 'Pavlíček', 16),
(42, 'katerina@seznam.cz', 'Kateřina', 'Rychlá', 17),
(52, 'jakub@centrum.cz', 'Jakub', 'Procházka', 31),
(58, 'adela@seznam.cz', 'Adéla', 'Adamová', 32),
(59, 'karel@volny.cz', 'Karel', 'Karlíček', 33),
(60, 'lukas@volny.cz', 'Lukáš', 'Lukavský', 34),
(61, 'lida2@gmail.cz', 'Lída', 'Lukášová', 35);

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
-- Vypisuji data pro tabulku `usr_employee`
--

INSERT INTO `usr_employee` (`employee_id`, `email`, `name`, `surname`, `telephone_number`, `superuser`, `address_id`) VALUES
(5, 'admin@admin.cz', 'Adam', 'Novák', 777222685, 1, 10),
(14, 'honza@seznam.cz', 'Jan', 'Bedna', 741456789, 0, 14),
(15, 'anna@centrum.cz', 'Anna', 'Černá', 777000111, 0, 15),
(16, 'eva@gmail.com', 'eva', 'Bílá', 605444111, 0, NULL),
(47, 'vomacka@centrum.cz', 'František', 'Vomáčka', 605700110, 0, NULL),
(62, 'tomas@centrum.cz', 'Tomáš', 'Teplý', 777800100, 0, 36);

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
-- Omezení pro tabulku `tbl_bill`
--
ALTER TABLE `tbl_bill`
  ADD CONSTRAINT `tbl_bill_ibfk_1` FOREIGN KEY (`title_id`) REFERENCES `mov_title` (`title_id`);

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
  ADD CONSTRAINT `usr_customer_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `usr_address` (`address_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usr_customer_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `usr` (`usr_id`);

--
-- Omezení pro tabulku `usr_employee`
--
ALTER TABLE `usr_employee`
  ADD CONSTRAINT `usr_employee_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `usr_address` (`address_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usr_employee_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `usr` (`usr_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
