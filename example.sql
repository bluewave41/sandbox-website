-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2019 at 10:29 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `example`
--

-- --------------------------------------------------------

--
-- Table structure for table `apikeys`
--

CREATE TABLE `apikeys` (
  `id` int(11) NOT NULL,
  `apikey` char(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apikeys`
--

INSERT INTO `apikeys` (`id`, `apikey`) VALUES
(0, '4faecf3be27bc01d4c4e0a0736eac39e764c168e'),
(3, '84130acaaa342b5dd82760eb6dffc77a0c671d72'),
(2, '5adbe81d7b1a9a282e8d1fa2314202d3ea51e8ee'),
(2, '76189048fcf35b9139c6ba890e2850db6bca1c26'),
(2, '423ea6fe404535d1cdd02949d8e7ea10c62cd844'),
(2, '51c6747978dea6aa2a2965852378d9677810c275'),
(2, '14abb604fbe8982063165de4c69ef4a314b7ee9c');

-- --------------------------------------------------------

--
-- Table structure for table `attacks`
--

CREATE TABLE `attacks` (
  `name` varchar(25) NOT NULL,
  `id` smallint(6) NOT NULL,
  `damage` smallint(6) NOT NULL COMMENT '0 indicates stat change',
  `accuracy` tinyint(4) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT 'Links to either move type or stat to alter if stat move',
  `basic` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attacks`
--

INSERT INTO `attacks` (`name`, `id`, `damage`, `accuracy`, `type`, `basic`) VALUES
('Tackle', 1, 50, 100, 1, 1),
('Leer', 2, 0, 100, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bag`
--

CREATE TABLE `bag` (
  `id` int(11) NOT NULL,
  `itemID` smallint(6) NOT NULL,
  `count` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bag`
--

INSERT INTO `bag` (`id`, `itemID`, `count`) VALUES
(2, 1, 10),
(2, 5, 1),
(37, 0, 1),
(57, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `itemlist`
--

CREATE TABLE `itemlist` (
  `itemID` smallint(6) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `itemlist`
--

INSERT INTO `itemlist` (`itemID`, `name`) VALUES
(0, 'Potion'),
(1, 'Super Potion'),
(2, 'Hyper Potion'),
(3, 'Max Potion'),
(4, 'Poke Ball'),
(5, 'Great Ball'),
(6, 'Ultra Ball');

-- --------------------------------------------------------

--
-- Table structure for table `pokemon`
--

CREATE TABLE `pokemon` (
  `A_I` int(11) NOT NULL,
  `ownerID` int(6) NOT NULL,
  `partyPosition` tinyint(4) NOT NULL,
  `pokemonNo` smallint(6) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `hp` smallint(6) NOT NULL,
  `attack1` smallint(6) NOT NULL,
  `attack2` smallint(6) NOT NULL,
  `attack3` smallint(6) NOT NULL,
  `attack4` smallint(6) NOT NULL,
  `hpIV` tinyint(4) NOT NULL,
  `attackIV` tinyint(4) NOT NULL,
  `defenseIV` tinyint(4) NOT NULL,
  `spAttackIV` tinyint(4) NOT NULL,
  `spDefenseIV` tinyint(4) NOT NULL,
  `speedIV` tinyint(4) NOT NULL,
  `attackStat` smallint(6) NOT NULL,
  `defenseStat` smallint(6) NOT NULL,
  `spAttackStat` smallint(6) NOT NULL,
  `spDefenseStat` smallint(6) NOT NULL,
  `speedStat` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pokemon`
--

INSERT INTO `pokemon` (`A_I`, `ownerID`, `partyPosition`, `pokemonNo`, `level`, `hp`, `attack1`, `attack2`, `attack3`, `attack4`, `hpIV`, `attackIV`, `defenseIV`, `spAttackIV`, `spDefenseIV`, `speedIV`, `attackStat`, `defenseStat`, `spAttackStat`, `spDefenseStat`, `speedStat`) VALUES
(35, 55, 1, 7, 5, 19, 1, 0, 0, 0, 8, 5, 17, 18, 12, 11, 10, 11, 10, 11, 9),
(36, 56, 1, 7, 5, 896, 1, 0, 0, 0, 12, 22, 28, 10, 25, 25, 10, 12, 10, 12, 9),
(37, 57, 1, 7, 5, 11, 1, 0, 0, 0, 2, 17, 31, 1, 25, 28, 9, 11, 10, 11, 9);

-- --------------------------------------------------------

--
-- Table structure for table `pokemonlookup`
--

CREATE TABLE `pokemonlookup` (
  `pokemonNo` smallint(6) NOT NULL,
  `name` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pokemonlookup`
--

INSERT INTO `pokemonlookup` (`pokemonNo`, `name`) VALUES
(1, 'Bulbasaur'),
(2, 'Ivysaur'),
(3, 'Venusaur'),
(4, 'Charmander'),
(5, 'Charmeleon'),
(6, 'Charizard'),
(7, 'Squirtle'),
(8, 'Wartortle'),
(9, 'Blastoise'),
(151, 'Mew'),
(16, 'Pidgey');

-- --------------------------------------------------------

--
-- Table structure for table `shopitems`
--

CREATE TABLE `shopitems` (
  `itemID` smallint(6) NOT NULL,
  `cost` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shopitems`
--

INSERT INTO `shopitems` (`itemID`, `cost`) VALUES
(0, 300),
(1, 700),
(2, 1200),
(3, 2500),
(4, 200),
(5, 600);

-- --------------------------------------------------------

--
-- Table structure for table `stats`
--

CREATE TABLE `stats` (
  `id` tinyint(4) NOT NULL,
  `stat` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stats`
--

INSERT INTO `stats` (`id`, `stat`) VALUES
(1, 'HP'),
(2, 'ATK'),
(3, 'DEF'),
(4, 'SP.A'),
(5, 'SP.D'),
(6, 'SPD');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` tinyint(4) NOT NULL,
  `type` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `type`) VALUES
(1, 'Normal'),
(2, 'Fire'),
(3, 'Fighting'),
(4, 'Water'),
(5, 'Flying'),
(6, 'Grass'),
(7, 'Poison'),
(8, 'Electric'),
(9, 'Ground'),
(10, 'Psychic'),
(11, 'Rock'),
(12, 'Ice'),
(13, 'Bug'),
(14, 'Bug'),
(15, 'Dragon'),
(16, 'Ghost'),
(17, 'Dark'),
(18, 'Steel'),
(19, 'Fairy');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(20) NOT NULL,
  `password` char(64) NOT NULL,
  `email` varchar(30) NOT NULL,
  `id` int(11) NOT NULL,
  `money` int(11) NOT NULL DEFAULT '5000',
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `email`, `id`, `money`, `admin`) VALUES
('bob', 'ca978112ca1bbdcafac231b39a23dc4da786eff8147c4e72b9807785afee48bb', 'a', 57, 4800, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attacks`
--
ALTER TABLE `attacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bag`
--
ALTER TABLE `bag`
  ADD UNIQUE KEY `uq_bag` (`id`,`itemID`);

--
-- Indexes for table `itemlist`
--
ALTER TABLE `itemlist`
  ADD PRIMARY KEY (`itemID`);

--
-- Indexes for table `pokemon`
--
ALTER TABLE `pokemon`
  ADD PRIMARY KEY (`A_I`);

--
-- Indexes for table `stats`
--
ALTER TABLE `stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `itemlist`
--
ALTER TABLE `itemlist`
  MODIFY `itemID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pokemon`
--
ALTER TABLE `pokemon`
  MODIFY `A_I` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `stats`
--
ALTER TABLE `stats`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
