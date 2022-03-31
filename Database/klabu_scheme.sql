-- phpMyAdmin SQL Dump
-- version 4.2.13.3
-- http://www.phpmyadmin.net
--
-- Host: db1580.mydbserver.com
-- Erstellungszeit: 31. Mrz 2022 um 18:32
-- Server Version: 8.0.25-15
-- PHP-Version: 5.3.29
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8 */
;
--
-- Datenbank: `klabu`
--
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `belegung`
--
CREATE TABLE IF NOT EXISTS `belegung` (
  `id` int NOT NULL,
  `schueler_id` int NOT NULL,
  `gruppe_id` int NOT NULL,
  `beginn` date NOT NULL DEFAULT '2020-08-01',
  `ende` date NOT NULL DEFAULT '2021-07-31',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE = InnoDB AUTO_INCREMENT = 19844 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `corona_typ`
--
CREATE TABLE IF NOT EXISTS `corona_typ` (
  `id` int NOT NULL,
  `erledigung_id` int NOT NULL,
  `corona_typen_id` int NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `geloescht` tinyint NOT NULL DEFAULT '0'
) ENGINE = InnoDB AUTO_INCREMENT = 1636 DEFAULT CHARSET = utf8mb3;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `corona_typen`
--
CREATE TABLE IF NOT EXISTS `corona_typen` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `geloescht` tinyint NOT NULL DEFAULT '0',
  `created_by` varchar(255) DEFAULT NULL,
  `updated_gy` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `kuerzel` varchar(32) DEFAULT NULL,
  `icon` varchar(64) DEFAULT NULL
) ENGINE = InnoDB AUTO_INCREMENT = 6 DEFAULT CHARSET = utf8mb3;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `corona_vonbis`
--
CREATE TABLE IF NOT EXISTS `corona_vonbis` (
  `id` int NOT NULL,
  `von` timestamp NULL DEFAULT NULL,
  `bis` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE = InnoDB AUTO_INCREMENT = 125 DEFAULT CHARSET = utf8mb3;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `eigenschaft`
--
CREATE TABLE IF NOT EXISTS `eigenschaft` (
  `id` int NOT NULL,
  `sortierung` int NOT NULL,
  `lehrer_id` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `privat` tinyint(1) NOT NULL DEFAULT '1',
  `onclick` int NOT NULL DEFAULT '0',
  `regel` tinyint NOT NULL DEFAULT '0',
  `startseite` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `geloescht` tinyint NOT NULL DEFAULT '0',
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE = InnoDB AUTO_INCREMENT = 6 DEFAULT CHARSET = utf8mb3;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `erledigung`
--
CREATE TABLE IF NOT EXISTS `erledigung` (
  `id` int NOT NULL,
  `eigenschaft_id` int NOT NULL,
  `schueler_id` int DEFAULT NULL,
  `lehrer_id` int DEFAULT NULL,
  `von` timestamp NULL DEFAULT NULL,
  `bis` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `geloescht` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE = InnoDB AUTO_INCREMENT = 27410 DEFAULT CHARSET = utf8mb3;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `fach`
--
CREATE TABLE IF NOT EXISTS `fach` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `kurz` varchar(10) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE = InnoDB AUTO_INCREMENT = 32 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `gruppe`
--
CREATE TABLE IF NOT EXISTS `gruppe` (
  `id` int NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `lehrer_id` int DEFAULT NULL,
  `fach_id` int DEFAULT NULL,
  `klasse` int DEFAULT '0',
  `sortierung` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `danis_id` int DEFAULT NULL,
  `apollon_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `geloescht` tinyint NOT NULL DEFAULT '0'
) ENGINE = InnoDB AUTO_INCREMENT = 655 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `lehrer`
--
CREATE TABLE IF NOT EXISTS `lehrer` (
  `id` int NOT NULL,
  `nachname` varchar(100) NOT NULL DEFAULT '',
  `vorname` varchar(100) NOT NULL DEFAULT '',
  `kuerzel` varchar(10) NOT NULL,
  `iserv` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE = InnoDB AUTO_INCREMENT = 144 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `log`
--
CREATE TABLE IF NOT EXISTS `log` (
  `id` int NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_iserv` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gruppe_id` int DEFAULT NULL,
  `message` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE = InnoDB AUTO_INCREMENT = 36224 DEFAULT CHARSET = utf8mb3;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `mitteilung`
--
CREATE TABLE IF NOT EXISTS `mitteilung` (
  `id` int NOT NULL,
  `erledigung_id` int DEFAULT NULL,
  `lehrer_id` int DEFAULT NULL,
  `schueler_id` int DEFAULT NULL,
  `mitteilung` varchar(255) NOT NULL,
  `eltern` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `geloescht` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE = InnoDB AUTO_INCREMENT = 5998 DEFAULT CHARSET = utf8mb3;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `praesenz`
--
CREATE TABLE IF NOT EXISTS `praesenz` (
  `id` int NOT NULL,
  `unterricht_id` int NOT NULL,
  `belegung_id` int NOT NULL,
  `fehlt` int NOT NULL DEFAULT '0',
  `entschuldigt` int NOT NULL DEFAULT '0',
  `verspaetet` varchar(50) NOT NULL DEFAULT '',
  `bemerkung` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE = InnoDB AUTO_INCREMENT = 423740 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
-- --------------------------------------------------------
--
-- Stellvertreter-Struktur des Views `praesenz_gruppe`
--
CREATE TABLE IF NOT EXISTS `praesenz_gruppe` (
  `id` binary(0),
  `unterricht_id` binary(0),
  `belegung_id` int,
  `fehlt` binary(0),
  `entschuldigt` binary(0),
  `verspaetet` binary(0),
  `bemerkung` binary(0),
  `schueler_id` int,
  `gruppe_id` int,
  `beginn` date,
  `ende` date,
  `nachname` varchar(100),
  `vorname` varchar(100),
  `teilgruppe` varchar(10),
  `s_gruppe_id` int
);
-- --------------------------------------------------------
--
-- Stellvertreter-Struktur des Views `praesenz_ist`
--
CREATE TABLE IF NOT EXISTS `praesenz_ist` (
  `id` int,
  `unterricht_id` int,
  `belegung_id` int,
  `fehlt` int,
  `entschuldigt` int,
  `verspaetet` varchar(50),
  `bemerkung` text,
  `schueler_id` int,
  `gruppe_id` int,
  `beginn` date,
  `ende` date,
  `nachname` varchar(100),
  `vorname` varchar(100),
  `teilgruppe` varchar(10),
  `s_gruppe_id` int
);
-- --------------------------------------------------------
--
-- Stellvertreter-Struktur des Views `praesenz_soll`
--
CREATE TABLE IF NOT EXISTS `praesenz_soll` (
  `id` int,
  `unterricht_id` int,
  `belegung_id` int,
  `fehlt` int,
  `entschuldigt` int,
  `verspaetet` varchar(50),
  `bemerkung` text,
  `schueler_id` int,
  `gruppe_id` int,
  `beginn` date,
  `ende` date,
  `nachname` varchar(100),
  `vorname` varchar(100),
  `teilgruppe` varchar(10),
  `s_gruppe_id` int
);
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `raum`
--
CREATE TABLE IF NOT EXISTS `raum` (
  `id` int NOT NULL,
  `name` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE = InnoDB AUTO_INCREMENT = 145 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `rfid`
--
CREATE TABLE IF NOT EXISTS `rfid` (
  `id` int NOT NULL,
  `rfid` varchar(20) NOT NULL,
  `schueler_id` int DEFAULT NULL,
  `lehrer_id` int DEFAULT NULL
) ENGINE = InnoDB AUTO_INCREMENT = 2202 DEFAULT CHARSET = utf8mb3;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `rfid_danis`
--
CREATE TABLE IF NOT EXISTS `rfid_danis` (
  `id` int NOT NULL,
  `mensacode` varchar(32) DEFAULT NULL,
  `danis_schueler_id` int DEFAULT NULL,
  `schueler_id` int DEFAULT NULL,
  `rfid` varchar(32) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb3 ROW_FORMAT = COMPACT;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `rfid_lul`
--
CREATE TABLE IF NOT EXISTS `rfid_lul` (
  `id` int NOT NULL,
  `vorname` varchar(64) NOT NULL,
  `nachname` varchar(64) NOT NULL,
  `rfid_hex40` varchar(10) DEFAULT NULL,
  `rfid_hex32` varchar(8) DEFAULT NULL,
  `rfid_dez32` varchar(10) DEFAULT NULL
) ENGINE = InnoDB AUTO_INCREMENT = 123 DEFAULT CHARSET = utf8mb3;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `rfid_mensa`
--
CREATE TABLE IF NOT EXISTS `rfid_mensa` (
  `id` int NOT NULL,
  `rfid_hex40` varchar(10) DEFAULT NULL,
  `mensacode` varchar(32) DEFAULT NULL,
  `rfid_hex32` varchar(8) DEFAULT NULL,
  `rfid_dez32` varchar(10) DEFAULT NULL
) ENGINE = InnoDB AUTO_INCREMENT = 1757 DEFAULT CHARSET = utf8mb3;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `schueler`
--
CREATE TABLE IF NOT EXISTS `schueler` (
  `id` int NOT NULL,
  `nachname` varchar(100) NOT NULL DEFAULT '',
  `vorname` varchar(100) NOT NULL DEFAULT '',
  `iserv` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `gruppe_id` int DEFAULT NULL,
  `teilgruppe` varchar(10) DEFAULT '',
  `danis_id` int DEFAULT NULL,
  `apollon_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `geloescht` tinyint NOT NULL DEFAULT '0'
) ENGINE = InnoDB AUTO_INCREMENT = 10043 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `sitzplan`
--
CREATE TABLE IF NOT EXISTS `sitzplan` (
  `id` int NOT NULL,
  `gruppe_id` int DEFAULT NULL,
  `teilgruppe` varchar(10) DEFAULT NULL,
  `lehrer_id` int NOT NULL,
  `beginn` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `raum_id` int DEFAULT NULL,
  `size_x` int NOT NULL,
  `size_y` int NOT NULL,
  `sort` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'A',
  `name` varchar(100) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE = InnoDB AUTO_INCREMENT = 1594 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `sitzplatz`
--
CREATE TABLE IF NOT EXISTS `sitzplatz` (
  `id` int NOT NULL,
  `sitzplan_id` int DEFAULT NULL,
  `x` int NOT NULL DEFAULT '0',
  `y` int NOT NULL DEFAULT '0',
  `rot` int NOT NULL DEFAULT '0',
  `schueler_id` int DEFAULT NULL,
  `text` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE = InnoDB AUTO_INCREMENT = 51029 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `unterricht`
--
CREATE TABLE IF NOT EXISTS `unterricht` (
  `id` int NOT NULL,
  `gruppe_id` int NOT NULL,
  `lehrer_id` int NOT NULL,
  `datum` date NOT NULL,
  `ustunde_id` int NOT NULL,
  `fach_id` int NOT NULL,
  `vertretung` tinyint(1) NOT NULL DEFAULT '0',
  `inhalte` text NOT NULL,
  `aufgaben` text NOT NULL,
  `aufgaben_zeit` int NOT NULL DEFAULT '30',
  `bemerkungen` text NOT NULL,
  `sitzplan_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `geloescht` tinyint(1) DEFAULT '0'
) ENGINE = InnoDB AUTO_INCREMENT = 20301 DEFAULT CHARSET = utf8mb3;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `update`
--
CREATE TABLE IF NOT EXISTS `update` (
  `id` int NOT NULL,
  `access_last` timestamp NULL DEFAULT NULL,
  `access_count` int NOT NULL DEFAULT '0',
  `access_limit` int NOT NULL DEFAULT '0',
  `upload_start` timestamp NULL DEFAULT NULL,
  `upload_end` timestamp NULL DEFAULT NULL,
  `upload_allowed` tinyint NOT NULL DEFAULT '0'
) ENGINE = InnoDB AUTO_INCREMENT = 2 DEFAULT CHARSET = utf8mb3;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `update_belegung`
--
CREATE TABLE IF NOT EXISTS `update_belegung` (
  `id` int NOT NULL,
  `danis_schueler_id` int DEFAULT NULL,
  `apollon_schueler_id` int DEFAULT NULL,
  `danis_gruppe_id` int DEFAULT NULL,
  `apollon_gruppe_id` int DEFAULT NULL,
  `von_hj` tinyint NOT NULL DEFAULT '1',
  `bis_hj` tinyint NOT NULL DEFAULT '2',
  `von` date DEFAULT NULL,
  `bis` date DEFAULT NULL,
  `belegung_id` int DEFAULT NULL
) ENGINE = InnoDB AUTO_INCREMENT = 7618 DEFAULT CHARSET = utf8mb3;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `update_gruppe`
--
CREATE TABLE IF NOT EXISTS `update_gruppe` (
  `id` int NOT NULL,
  `danis_gruppe_id` int DEFAULT NULL,
  `apollon_gruppe_id` int DEFAULT NULL,
  `name` varchar(40) NOT NULL,
  `lehrer_kuerzel` varchar(10) DEFAULT NULL,
  `gruppe_id` int DEFAULT NULL
) ENGINE = InnoDB AUTO_INCREMENT = 425 DEFAULT CHARSET = utf8mb3;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `update_lehrer`
--
CREATE TABLE IF NOT EXISTS `update_lehrer` (
  `id` int NOT NULL,
  `vorname` varchar(255) DEFAULT NULL,
  `nachname` varchar(255) DEFAULT NULL,
  `kuerzel` varchar(10) DEFAULT NULL,
  `lehrer_id` int DEFAULT NULL
) ENGINE = InnoDB AUTO_INCREMENT = 134 DEFAULT CHARSET = utf8mb3;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `update_schueler`
--
CREATE TABLE IF NOT EXISTS `update_schueler` (
  `id` int NOT NULL,
  `danis_schueler_id` int DEFAULT NULL,
  `apollon_schueler_id` int DEFAULT NULL,
  `vorname` varchar(100) NOT NULL,
  `nachname` varchar(100) NOT NULL,
  `iserv` varchar(200) DEFAULT NULL,
  `danis_gruppe_id` int DEFAULT NULL,
  `apollon_gruppe_id` int DEFAULT NULL,
  `schueler_id` int DEFAULT NULL
) ENGINE = InnoDB AUTO_INCREMENT = 1663 DEFAULT CHARSET = utf8mb3;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `ustunde`
--
CREATE TABLE IF NOT EXISTS `ustunde` (
  `id` int NOT NULL,
  `name` varchar(30) NOT NULL DEFAULT '',
  `beginn` time NOT NULL,
  `ende` time NOT NULL,
  `anzeige` int NOT NULL DEFAULT '0',
  `block` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
-- --------------------------------------------------------
--
-- Tabellenstruktur für Tabelle `zustimmung`
--
CREATE TABLE IF NOT EXISTS `zustimmung` (
  `id` int NOT NULL,
  `erledigung_id` int NOT NULL,
  `lehrer_id` int DEFAULT NULL,
  `gruppe_id` int DEFAULT NULL,
  `info` varchar(32) DEFAULT NULL,
  `zustimmung` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) DEFAULT NULL,
  `geloescht` tinyint NOT NULL DEFAULT '0'
) ENGINE = InnoDB AUTO_INCREMENT = 13821 DEFAULT CHARSET = utf8mb3;
-- --------------------------------------------------------
--
-- Struktur des Views `praesenz_gruppe`
--
DROP TABLE IF EXISTS `praesenz_gruppe`;
CREATE ALGORITHM = UNDEFINED DEFINER = `klabu` @`localhost` SQL SECURITY DEFINER VIEW `praesenz_gruppe` AS
select NULL AS `id`,
  NULL AS `unterricht_id`,
  `b`.`id` AS `belegung_id`,
  NULL AS `fehlt`,
  NULL AS `entschuldigt`,
  NULL AS `verspaetet`,
  NULL AS `bemerkung`,
  `b`.`schueler_id` AS `schueler_id`,
  `b`.`gruppe_id` AS `gruppe_id`,
  `b`.`beginn` AS `beginn`,
  `b`.`ende` AS `ende`,
  `s`.`nachname` AS `nachname`,
  `s`.`vorname` AS `vorname`,
  `s`.`teilgruppe` AS `teilgruppe`,
  `s`.`gruppe_id` AS `s_gruppe_id`
from (
    (
      `gruppe` `g`
      left join `belegung` `b` on((`b`.`gruppe_id` = `g`.`id`))
    )
    left join `schueler` `s` on((`s`.`id` = `b`.`schueler_id`))
  );
-- --------------------------------------------------------
--
-- Struktur des Views `praesenz_ist`
--
DROP TABLE IF EXISTS `praesenz_ist`;
CREATE ALGORITHM = UNDEFINED DEFINER = `klabu` @`localhost` SQL SECURITY DEFINER VIEW `praesenz_ist` AS
select `p`.`id` AS `id`,
  `p`.`unterricht_id` AS `unterricht_id`,
  `p`.`belegung_id` AS `belegung_id`,
  `p`.`fehlt` AS `fehlt`,
  `p`.`entschuldigt` AS `entschuldigt`,
  `p`.`verspaetet` AS `verspaetet`,
  `p`.`bemerkung` AS `bemerkung`,
  `b`.`schueler_id` AS `schueler_id`,
  `b`.`gruppe_id` AS `gruppe_id`,
  `b`.`beginn` AS `beginn`,
  `b`.`ende` AS `ende`,
  `s`.`nachname` AS `nachname`,
  `s`.`vorname` AS `vorname`,
  `s`.`teilgruppe` AS `teilgruppe`,
  `s`.`gruppe_id` AS `s_gruppe_id`
from (
    (
      `praesenz` `p`
      left join `belegung` `b` on((`b`.`id` = `p`.`belegung_id`))
    )
    left join `schueler` `s` on((`s`.`id` = `b`.`schueler_id`))
  );
-- --------------------------------------------------------
--
-- Struktur des Views `praesenz_soll`
--
DROP TABLE IF EXISTS `praesenz_soll`;
CREATE ALGORITHM = UNDEFINED DEFINER = `klabu` @`localhost` SQL SECURITY DEFINER VIEW `praesenz_soll` AS
select `p`.`id` AS `id`,
  `u`.`id` AS `unterricht_id`,
  `b`.`id` AS `belegung_id`,
  `p`.`fehlt` AS `fehlt`,
  `p`.`entschuldigt` AS `entschuldigt`,
  `p`.`verspaetet` AS `verspaetet`,
  `p`.`bemerkung` AS `bemerkung`,
  `b`.`schueler_id` AS `schueler_id`,
  `b`.`gruppe_id` AS `gruppe_id`,
  `b`.`beginn` AS `beginn`,
  `b`.`ende` AS `ende`,
  `s`.`nachname` AS `nachname`,
  `s`.`vorname` AS `vorname`,
  `s`.`teilgruppe` AS `teilgruppe`,
  `s`.`gruppe_id` AS `s_gruppe_id`
from (
    (
      (
        (
          `unterricht` `u`
          left join `gruppe` `g` on((`u`.`gruppe_id` = `g`.`id`))
        )
        left join `belegung` `b` on((`b`.`gruppe_id` = `g`.`id`))
      )
      left join `praesenz` `p` on(
        (
          (`b`.`id` = `p`.`belegung_id`)
          and (`u`.`id` = `p`.`unterricht_id`)
        )
      )
    )
    left join `schueler` `s` on((`s`.`id` = `b`.`schueler_id`))
  );
--
-- Indizes der exportierten Tabellen
--
--
-- Indizes für die Tabelle `belegung`
--
ALTER TABLE `belegung`
ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `belegung_uq` (`schueler_id`, `gruppe_id`, `beginn`),
  ADD KEY `belegung_gruppe_fk` (`gruppe_id`);
--
-- Indizes für die Tabelle `corona_typ`
--
ALTER TABLE `corona_typ`
ADD PRIMARY KEY (`id`),
  ADD KEY `fk_corona_typ_erledigung` (`erledigung_id`),
  ADD KEY `fk_corona_typ_corona_typen` (`corona_typen_id`);
--
-- Indizes für die Tabelle `corona_typen`
--
ALTER TABLE `corona_typen`
ADD PRIMARY KEY (`id`);
--
-- Indizes für die Tabelle `corona_vonbis`
--
ALTER TABLE `corona_vonbis`
ADD PRIMARY KEY (`id`);
--
-- Indizes für die Tabelle `eigenschaft`
--
ALTER TABLE `eigenschaft`
ADD PRIMARY KEY (`id`),
  ADD KEY `fk_eigenschaft_lehrer` (`lehrer_id`);
--
-- Indizes für die Tabelle `erledigung`
--
ALTER TABLE `erledigung`
ADD PRIMARY KEY (`id`),
  ADD KEY `fk_erledigung_schueler` (`schueler_id`),
  ADD KEY `fk_erledigung_eigenschaft` (`eigenschaft_id`),
  ADD KEY `fk_erledigung_lehrer` (`lehrer_id`);
--
-- Indizes für die Tabelle `fach`
--
ALTER TABLE `fach`
ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fach_name_uq` (`name`),
  ADD UNIQUE KEY `fach_kurz_uq` (`kurz`);
--
-- Indizes für die Tabelle `gruppe`
--
ALTER TABLE `gruppe`
ADD PRIMARY KEY (`id`),
  ADD KEY `gruppe_lehrer_fk` (`lehrer_id`),
  ADD KEY `fk_gruppe_fach` (`fach_id`);
--
-- Indizes für die Tabelle `lehrer`
--
ALTER TABLE `lehrer`
ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lehrer_kuerzel_uq` (`kuerzel`);
--
-- Indizes für die Tabelle `log`
--
ALTER TABLE `log`
ADD PRIMARY KEY (`id`);
--
-- Indizes für die Tabelle `mitteilung`
--
ALTER TABLE `mitteilung`
ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mitteilung_erledigung` (`erledigung_id`),
  ADD KEY `fk_mitteilung_lehrer` (`lehrer_id`),
  ADD KEY `fk_mitteilung_schueler` (`schueler_id`);
--
-- Indizes für die Tabelle `praesenz`
--
ALTER TABLE `praesenz`
ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `praesenz_uq` (`unterricht_id`, `belegung_id`),
  ADD KEY `praesenz_belegung_fk` (`belegung_id`);
--
-- Indizes für die Tabelle `raum`
--
ALTER TABLE `raum`
ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `raum_name_uq` (`name`);
--
-- Indizes für die Tabelle `rfid`
--
ALTER TABLE `rfid`
ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rfid_schueler` (`schueler_id`),
  ADD KEY `fk_rfid_lehrer` (`lehrer_id`);
--
-- Indizes für die Tabelle `rfid_danis`
--
ALTER TABLE `rfid_danis`
ADD PRIMARY KEY (`id`);
--
-- Indizes für die Tabelle `rfid_lul`
--
ALTER TABLE `rfid_lul`
ADD PRIMARY KEY (`id`);
--
-- Indizes für die Tabelle `rfid_mensa`
--
ALTER TABLE `rfid_mensa`
ADD PRIMARY KEY (`id`);
--
-- Indizes für die Tabelle `schueler`
--
ALTER TABLE `schueler`
ADD PRIMARY KEY (`id`),
  ADD KEY `schueler_gruppe_fk` (`gruppe_id`);
--
-- Indizes für die Tabelle `sitzplan`
--
ALTER TABLE `sitzplan`
ADD PRIMARY KEY (`id`),
  ADD KEY `sitzplan_gruppe_fk` (`gruppe_id`),
  ADD KEY `sitzplan_raum_fk` (`raum_id`),
  ADD KEY `fk_sitzplan_lehrer` (`lehrer_id`);
--
-- Indizes für die Tabelle `sitzplatz`
--
ALTER TABLE `sitzplatz`
ADD PRIMARY KEY (`id`),
  ADD KEY `sitzplatz_schueler_fk` (`schueler_id`),
  ADD KEY `sitzplatz_sitzplan_fk` (`sitzplan_id`);
--
-- Indizes für die Tabelle `unterricht`
--
ALTER TABLE `unterricht`
ADD PRIMARY KEY (`id`),
  ADD KEY `unterricht_fach_fk` (`fach_id`),
  ADD KEY `unterricht_gruppe_fk` (`gruppe_id`),
  ADD KEY `unterricht_lehrer_fk` (`lehrer_id`),
  ADD KEY `unterricht_ustunde_fk` (`ustunde_id`),
  ADD KEY `unterricht_sitzplan_fk` (`sitzplan_id`);
--
-- Indizes für die Tabelle `update`
--
ALTER TABLE `update`
ADD PRIMARY KEY (`id`);
--
-- Indizes für die Tabelle `update_belegung`
--
ALTER TABLE `update_belegung`
ADD PRIMARY KEY (`id`);
--
-- Indizes für die Tabelle `update_gruppe`
--
ALTER TABLE `update_gruppe`
ADD PRIMARY KEY (`id`);
--
-- Indizes für die Tabelle `update_lehrer`
--
ALTER TABLE `update_lehrer`
ADD PRIMARY KEY (`id`);
--
-- Indizes für die Tabelle `update_schueler`
--
ALTER TABLE `update_schueler`
ADD PRIMARY KEY (`id`);
--
-- Indizes für die Tabelle `ustunde`
--
ALTER TABLE `ustunde`
ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ustunde_name_uq` (`name`);
--
-- Indizes für die Tabelle `zustimmung`
--
ALTER TABLE `zustimmung`
ADD PRIMARY KEY (`id`),
  ADD KEY `fk_zustimmung_erledigung` (`erledigung_id`),
  ADD KEY `fk_zustimmung_lehrer` (`lehrer_id`),
  ADD KEY `fk_zustimmung_gruppe` (`gruppe_id`);
--
-- AUTO_INCREMENT für exportierte Tabellen
--
--
-- AUTO_INCREMENT für Tabelle `belegung`
--
ALTER TABLE `belegung`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 19844;
--
-- AUTO_INCREMENT für Tabelle `corona_typ`
--
ALTER TABLE `corona_typ`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 1639;
--
-- AUTO_INCREMENT für Tabelle `corona_typen`
--
ALTER TABLE `corona_typen`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 6;
--
-- AUTO_INCREMENT für Tabelle `corona_vonbis`
--
ALTER TABLE `corona_vonbis`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 125;
--
-- AUTO_INCREMENT für Tabelle `eigenschaft`
--
ALTER TABLE `eigenschaft`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 6;
--
-- AUTO_INCREMENT für Tabelle `erledigung`
--
ALTER TABLE `erledigung`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 27451;
--
-- AUTO_INCREMENT für Tabelle `fach`
--
ALTER TABLE `fach`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 32;
--
-- AUTO_INCREMENT für Tabelle `gruppe`
--
ALTER TABLE `gruppe`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 655;
--
-- AUTO_INCREMENT für Tabelle `lehrer`
--
ALTER TABLE `lehrer`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 144;
--
-- AUTO_INCREMENT für Tabelle `log`
--
ALTER TABLE `log`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 36478;
--
-- AUTO_INCREMENT für Tabelle `mitteilung`
--
ALTER TABLE `mitteilung`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 6011;
--
-- AUTO_INCREMENT für Tabelle `praesenz`
--
ALTER TABLE `praesenz`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 426859;
--
-- AUTO_INCREMENT für Tabelle `raum`
--
ALTER TABLE `raum`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 145;
--
-- AUTO_INCREMENT für Tabelle `rfid`
--
ALTER TABLE `rfid`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2203;
--
-- AUTO_INCREMENT für Tabelle `rfid_danis`
--
ALTER TABLE `rfid_danis`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 1211;
--
-- AUTO_INCREMENT für Tabelle `rfid_lul`
--
ALTER TABLE `rfid_lul`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 124;
--
-- AUTO_INCREMENT für Tabelle `rfid_mensa`
--
ALTER TABLE `rfid_mensa`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 1758;
--
-- AUTO_INCREMENT für Tabelle `schueler`
--
ALTER TABLE `schueler`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 10043;
--
-- AUTO_INCREMENT für Tabelle `sitzplan`
--
ALTER TABLE `sitzplan`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 1597;
--
-- AUTO_INCREMENT für Tabelle `sitzplatz`
--
ALTER TABLE `sitzplatz`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 51156;
--
-- AUTO_INCREMENT für Tabelle `unterricht`
--
ALTER TABLE `unterricht`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 20485;
--
-- AUTO_INCREMENT für Tabelle `update`
--
ALTER TABLE `update`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;
--
-- AUTO_INCREMENT für Tabelle `update_belegung`
--
ALTER TABLE `update_belegung`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 7618;
--
-- AUTO_INCREMENT für Tabelle `update_gruppe`
--
ALTER TABLE `update_gruppe`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 425;
--
-- AUTO_INCREMENT für Tabelle `update_lehrer`
--
ALTER TABLE `update_lehrer`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 134;
--
-- AUTO_INCREMENT für Tabelle `update_schueler`
--
ALTER TABLE `update_schueler`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 1663;
--
-- AUTO_INCREMENT für Tabelle `zustimmung`
--
ALTER TABLE `zustimmung`
MODIFY `id` int NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 13921;
--
-- Constraints der exportierten Tabellen
--
--
-- Constraints der Tabelle `belegung`
--
ALTER TABLE `belegung`
ADD CONSTRAINT `belegung_gruppe_fk` FOREIGN KEY (`gruppe_id`) REFERENCES `gruppe` (`id`),
  ADD CONSTRAINT `belegung_schueler_fk` FOREIGN KEY (`schueler_id`) REFERENCES `schueler` (`id`);
--
-- Constraints der Tabelle `corona_typ`
--
ALTER TABLE `corona_typ`
ADD CONSTRAINT `fk_corona_typ_corona_typen` FOREIGN KEY (`corona_typen_id`) REFERENCES `corona_typen` (`id`),
  ADD CONSTRAINT `fk_corona_typ_erledigung` FOREIGN KEY (`erledigung_id`) REFERENCES `erledigung` (`id`);
--
-- Constraints der Tabelle `eigenschaft`
--
ALTER TABLE `eigenschaft`
ADD CONSTRAINT `fk_eigenschaft_lehrer` FOREIGN KEY (`lehrer_id`) REFERENCES `lehrer` (`id`);
--
-- Constraints der Tabelle `erledigung`
--
ALTER TABLE `erledigung`
ADD CONSTRAINT `fk_erledigung_eigenschaft` FOREIGN KEY (`eigenschaft_id`) REFERENCES `eigenschaft` (`id`),
  ADD CONSTRAINT `fk_erledigung_lehrer` FOREIGN KEY (`lehrer_id`) REFERENCES `lehrer` (`id`),
  ADD CONSTRAINT `fk_erledigung_schueler` FOREIGN KEY (`schueler_id`) REFERENCES `schueler` (`id`);
--
-- Constraints der Tabelle `gruppe`
--
ALTER TABLE `gruppe`
ADD CONSTRAINT `fk_gruppe_fach` FOREIGN KEY (`fach_id`) REFERENCES `fach` (`id`),
  ADD CONSTRAINT `gruppe_lehrer_fk` FOREIGN KEY (`lehrer_id`) REFERENCES `lehrer` (`id`);
--
-- Constraints der Tabelle `mitteilung`
--
ALTER TABLE `mitteilung`
ADD CONSTRAINT `fk_mitteilung_erledigung` FOREIGN KEY (`erledigung_id`) REFERENCES `erledigung` (`id`),
  ADD CONSTRAINT `fk_mitteilung_lehrer` FOREIGN KEY (`lehrer_id`) REFERENCES `lehrer` (`id`),
  ADD CONSTRAINT `fk_mitteilung_schueler` FOREIGN KEY (`schueler_id`) REFERENCES `schueler` (`id`);
--
-- Constraints der Tabelle `praesenz`
--
ALTER TABLE `praesenz`
ADD CONSTRAINT `praesenz_belegung_fk` FOREIGN KEY (`belegung_id`) REFERENCES `belegung` (`id`),
  ADD CONSTRAINT `praesenz_unterricht_fk` FOREIGN KEY (`unterricht_id`) REFERENCES `unterricht` (`id`);
--
-- Constraints der Tabelle `rfid`
--
ALTER TABLE `rfid`
ADD CONSTRAINT `fk_rfid_lehrer` FOREIGN KEY (`lehrer_id`) REFERENCES `lehrer` (`id`),
  ADD CONSTRAINT `fk_rfid_schueler` FOREIGN KEY (`schueler_id`) REFERENCES `schueler` (`id`);
--
-- Constraints der Tabelle `schueler`
--
ALTER TABLE `schueler`
ADD CONSTRAINT `schueler_gruppe_fk` FOREIGN KEY (`gruppe_id`) REFERENCES `gruppe` (`id`);
--
-- Constraints der Tabelle `sitzplan`
--
ALTER TABLE `sitzplan`
ADD CONSTRAINT `fk_sitzplan_lehrer` FOREIGN KEY (`lehrer_id`) REFERENCES `lehrer` (`id`),
  ADD CONSTRAINT `sitzplan_gruppe_fk` FOREIGN KEY (`gruppe_id`) REFERENCES `gruppe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sitzplan_raum_fk` FOREIGN KEY (`raum_id`) REFERENCES `raum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- Constraints der Tabelle `sitzplatz`
--
ALTER TABLE `sitzplatz`
ADD CONSTRAINT `sitzplatz_schueler_fk` FOREIGN KEY (`schueler_id`) REFERENCES `schueler` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sitzplatz_sitzplan_fk` FOREIGN KEY (`sitzplan_id`) REFERENCES `sitzplan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- Constraints der Tabelle `unterricht`
--
ALTER TABLE `unterricht`
ADD CONSTRAINT `unterricht_fach_fk` FOREIGN KEY (`fach_id`) REFERENCES `fach` (`id`),
  ADD CONSTRAINT `unterricht_gruppe_fk` FOREIGN KEY (`gruppe_id`) REFERENCES `gruppe` (`id`),
  ADD CONSTRAINT `unterricht_lehrer_fk` FOREIGN KEY (`lehrer_id`) REFERENCES `lehrer` (`id`),
  ADD CONSTRAINT `unterricht_sitzplan_fk` FOREIGN KEY (`sitzplan_id`) REFERENCES `sitzplan` (`id`),
  ADD CONSTRAINT `unterricht_ustunde_fk` FOREIGN KEY (`ustunde_id`) REFERENCES `ustunde` (`id`);
--
-- Constraints der Tabelle `zustimmung`
--
ALTER TABLE `zustimmung`
ADD CONSTRAINT `fk_zustimmung_erledigung` FOREIGN KEY (`erledigung_id`) REFERENCES `erledigung` (`id`),
  ADD CONSTRAINT `fk_zustimmung_gruppe` FOREIGN KEY (`gruppe_id`) REFERENCES `gruppe` (`id`),
  ADD CONSTRAINT `fk_zustimmung_lehrer` FOREIGN KEY (`lehrer_id`) REFERENCES `lehrer` (`id`);
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;