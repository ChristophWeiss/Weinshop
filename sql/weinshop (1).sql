-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 10. Feb 2020 um 00:11
-- Server-Version: 10.1.38-MariaDB
-- PHP-Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `weinshop`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bestellung`
--

CREATE TABLE `bestellung` (
  `id` int(11) NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `kunde_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `bestellung`
--

INSERT INTO `bestellung` (`id`, `datum`, `kunde_id`) VALUES
(9, '2012-07-06 22:00:00', 1),
(10, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bestellung_hat_wein`
--

CREATE TABLE `bestellung_hat_wein` (
  `bestellung_id` int(11) NOT NULL,
  `wein_id` int(11) NOT NULL,
  `anzahl` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kunde`
--

CREATE TABLE `kunde` (
  `id` int(11) NOT NULL,
  `vorname` varchar(45) NOT NULL,
  `nachname` varchar(45) NOT NULL,
  `ort` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `kunde`
--

INSERT INTO `kunde` (`id`, `vorname`, `nachname`, `ort`) VALUES
(1, 'Christoph', 'Weiss', 'Bozen');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `wein`
--

CREATE TABLE `wein` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `preis` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `wein`
--

INSERT INTO `wein` (`id`, `name`, `preis`) VALUES
(1, 'Lagrein - Kellerei St. Micheal', 7),
(2, 'Vernatsch', 7.5),
(3, 'Pinot', 8);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `bestellung`
--
ALTER TABLE `bestellung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bestellung_kunde1` (`kunde_id`);

--
-- Indizes für die Tabelle `bestellung_hat_wein`
--
ALTER TABLE `bestellung_hat_wein`
  ADD PRIMARY KEY (`bestellung_id`,`wein_id`),
  ADD KEY `fk_bestellung_hat_wein_wein1` (`wein_id`);

--
-- Indizes für die Tabelle `kunde`
--
ALTER TABLE `kunde`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `wein`
--
ALTER TABLE `wein`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `bestellung`
--
ALTER TABLE `bestellung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `kunde`
--
ALTER TABLE `kunde`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `wein`
--
ALTER TABLE `wein`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `bestellung`
--
ALTER TABLE `bestellung`
  ADD CONSTRAINT `fk_bestellung_kunde1` FOREIGN KEY (`kunde_id`) REFERENCES `kunde` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `bestellung_hat_wein`
--
ALTER TABLE `bestellung_hat_wein`
  ADD CONSTRAINT `fk_bestellung_hat_wein_bestellung` FOREIGN KEY (`bestellung_id`) REFERENCES `bestellung` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bestellung_hat_wein_wein1` FOREIGN KEY (`wein_id`) REFERENCES `wein` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
