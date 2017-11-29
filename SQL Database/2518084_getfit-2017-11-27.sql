-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: fdb13.awardspace.net
-- Gegenereerd op: 27 nov 2017 om 15:11
-- Serverversie: 5.7.20-log
-- PHP-versie: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `2518084_getfit`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tblDoelstellingen`
--

CREATE TABLE `tblDoelstellingen` (
  `doelstelling_id` int(11) NOT NULL,
  `gebruiker_id` int(11) NOT NULL,
  `tijdsduur` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `aantal` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `tblDoelstellingen`
--

INSERT INTO `tblDoelstellingen` (`doelstelling_id`, `gebruiker_id`, `tijdsduur`, `start`, `aantal`) VALUES
(1, 2, 31, '2017-11-15 00:00:00', 5);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tblGebruiker`
--

CREATE TABLE `tblGebruiker` (
  `GEB_ID` int(11) NOT NULL,
  `GEB_Voornaam` varchar(255) NOT NULL,
  `GEB_Familienaam` varchar(255) NOT NULL,
  `GEB_Email` varchar(255) NOT NULL,
  `GEB_Wachtwoord` varchar(255) NOT NULL,
  `GEB_KAL_ID` int(11) NOT NULL,
  `GEB_schema_naam_watisdit` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `tblGebruiker`
--

INSERT INTO `tblGebruiker` (`GEB_ID`, `GEB_Voornaam`, `GEB_Familienaam`, `GEB_Email`, `GEB_Wachtwoord`, `GEB_KAL_ID`, `GEB_schema_naam_watisdit`) VALUES
(1, 'Ruben', 'Godeau', 'ruben.godeau@student.odisee.be', 'simpelwachtwoord', 1, ''),
(2, 'Gert', 'Van der Brempt', 'gert-van-der-brempt@hotmail.com', 'mi3', 2, '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tblKalender`
--

CREATE TABLE `tblKalender` (
  `KAL_ID` int(11) NOT NULL,
  `KAL_ROU_ID` int(11) NOT NULL,
  `KAL_Datum` date NOT NULL,
  `KAL_Kalender_ID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `tblKalender`
--

INSERT INTO `tblKalender` (`KAL_ID`, `KAL_ROU_ID`, `KAL_Datum`, `KAL_Kalender_ID`) VALUES
(1, 1, '2017-11-27', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tblOefening`
--

CREATE TABLE `tblOefening` (
  `OEF_ID` int(11) NOT NULL,
  `OEF_Categorie` varchar(255) NOT NULL,
  `OEF_Spier` varchar(255) NOT NULL,
  `OEF_Titel` varchar(255) NOT NULL,
  `OEF_Beschrijving` varchar(255) NOT NULL,
  `OEF_Url` varchar(255) NOT NULL,
  `OEF_AantalCal` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `tblOefening`
--

INSERT INTO `tblOefening` (`OEF_ID`, `OEF_Categorie`, `OEF_Spier`, `OEF_Titel`, `OEF_Beschrijving`, `OEF_Url`, `OEF_AantalCal`) VALUES
(1, 'Volumetraining', 'Biceps', 'Gewichtheffen', 'Een gewicht heffen', 'lol', 12);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tblRoutine`
--

CREATE TABLE `tblRoutine` (
  `ROU_ID` int(11) NOT NULL,
  `ROU_Naam` varchar(255) NOT NULL,
  `ROU_GEB_ID_watisdit` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `tblRoutine`
--

INSERT INTO `tblRoutine` (`ROU_ID`, `ROU_Naam`, `ROU_GEB_ID_watisdit`) VALUES
(1, 'routine 1', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tblRoutine-fout`
--

CREATE TABLE `tblRoutine-fout` (
  `routine_ID` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `gebruiker_id` int(11) NOT NULL,
  `tabel_naam` varchar(255) NOT NULL,
  `favoriet` int(1) DEFAULT '0',
  `beoordeling` int(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `tblRoutine-fout`
--

INSERT INTO `tblRoutine-fout` (`routine_ID`, `naam`, `gebruiker_id`, `tabel_naam`, `favoriet`, `beoordeling`) VALUES
(2, 'mijn spier training', 1, 'Routine2', 0, 0),
(3, 'XtremeBodyWorkout2000', 2, 'Routine1', 1, 88);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tblRoutineItem`
--

CREATE TABLE `tblRoutineItem` (
  `RIT_ID` int(11) NOT NULL,
  `RIT_ROU_ID` int(11) NOT NULL,
  `RIT_OEF_ID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `tblRoutineItem`
--

INSERT INTO `tblRoutineItem` (`RIT_ID`, `RIT_ROU_ID`, `RIT_OEF_ID`) VALUES
(1, 1, 1);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `tblDoelstellingen`
--
ALTER TABLE `tblDoelstellingen`
  ADD PRIMARY KEY (`doelstelling_id`);

--
-- Indexen voor tabel `tblGebruiker`
--
ALTER TABLE `tblGebruiker`
  ADD PRIMARY KEY (`GEB_ID`);

--
-- Indexen voor tabel `tblKalender`
--
ALTER TABLE `tblKalender`
  ADD PRIMARY KEY (`KAL_ID`);

--
-- Indexen voor tabel `tblOefening`
--
ALTER TABLE `tblOefening`
  ADD PRIMARY KEY (`OEF_ID`);

--
-- Indexen voor tabel `tblRoutine`
--
ALTER TABLE `tblRoutine`
  ADD PRIMARY KEY (`ROU_ID`);

--
-- Indexen voor tabel `tblRoutine-fout`
--
ALTER TABLE `tblRoutine-fout`
  ADD PRIMARY KEY (`routine_ID`);

--
-- Indexen voor tabel `tblRoutineItem`
--
ALTER TABLE `tblRoutineItem`
  ADD PRIMARY KEY (`RIT_ID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `tblDoelstellingen`
--
ALTER TABLE `tblDoelstellingen`
  MODIFY `doelstelling_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT voor een tabel `tblGebruiker`
--
ALTER TABLE `tblGebruiker`
  MODIFY `GEB_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT voor een tabel `tblKalender`
--
ALTER TABLE `tblKalender`
  MODIFY `KAL_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT voor een tabel `tblOefening`
--
ALTER TABLE `tblOefening`
  MODIFY `OEF_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT voor een tabel `tblRoutine`
--
ALTER TABLE `tblRoutine`
  MODIFY `ROU_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT voor een tabel `tblRoutine-fout`
--
ALTER TABLE `tblRoutine-fout`
  MODIFY `routine_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT voor een tabel `tblRoutineItem`
--
ALTER TABLE `tblRoutineItem`
  MODIFY `RIT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
