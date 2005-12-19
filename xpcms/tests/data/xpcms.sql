-- phpMyAdmin SQL Dump
-- version 2.6.4-pl4
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Erstellungszeit: 19. Dezember 2005 um 07:20
-- Server Version: 4.1.15
-- PHP-Version: 5.1.1
-- 
-- Datenbank: `xpcms`
-- 

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `xpcms_asset`
-- 

DROP TABLE IF EXISTS `xpcms_asset`;
CREATE TABLE `xpcms_asset` (
  `id` int(11) NOT NULL default '0',
  `collection_fid` int(11) NOT NULL default '0',
  `language` varchar(5) NOT NULL default 'en_US',
  `position` float NOT NULL default '0',
  `name` varchar(64) NOT NULL default '',
  `description` text,
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `collection_fid` (`collection_fid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `xpcms_asset`
-- 

INSERT INTO `xpcms_asset` VALUES (0, 0, 'de_DE', 0, 'Prado-Website', 'Ein Link zur Webseite von Prado', 1);
INSERT INTO `xpcms_asset` VALUES (1, 0, 'de_DE', 1, 'Creole-Website', 'Ein Link zur Webseite von Creole', 1);
INSERT INTO `xpcms_asset` VALUES (2, 0, 'de_DE', 2, 'Link Sonst wohin', 'Ein Link ins Nirvana', 1);
INSERT INTO `xpcms_asset` VALUES (3, 0, 'de_DE', 0, 'Erster Text Block', 'Bla Bla Bla', 1);
INSERT INTO `xpcms_asset` VALUES (4, 0, 'de_DE', 1, 'Ein Bild', 'Bla Bla', 1);
INSERT INTO `xpcms_asset` VALUES (5, 0, 'de_DE', 2, 'Noch ein Text', 'Bla Bla Bla ', 1);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `xpcms_asset_comment`
-- 

DROP TABLE IF EXISTS `xpcms_asset_comment`;
CREATE TABLE `xpcms_asset_comment` (
  `asset_fid` int(11) NOT NULL default '0',
  `author` varchar(128) NOT NULL default '',
  `email` text NOT NULL,
  `title` varchar(64) NOT NULL default '',
  `content` text NOT NULL,
  PRIMARY KEY  (`asset_fid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `xpcms_asset_comment`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `xpcms_asset_download`
-- 

DROP TABLE IF EXISTS `xpcms_asset_download`;
CREATE TABLE `xpcms_asset_download` (
  `asset_fid` int(11) NOT NULL default '0',
  `url` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  PRIMARY KEY  (`asset_fid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `xpcms_asset_download`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `xpcms_asset_image`
-- 

DROP TABLE IF EXISTS `xpcms_asset_image`;
CREATE TABLE `xpcms_asset_image` (
  `asset_fid` int(11) NOT NULL default '0',
  `url` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`asset_fid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `xpcms_asset_image`
-- 

INSERT INTO `xpcms_asset_image` VALUES (4, 'http://www.xplib.de/blog/img/collection-model.png', 'Datenmodell der Navigationsstruktur');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `xpcms_asset_link`
-- 

DROP TABLE IF EXISTS `xpcms_asset_link`;
CREATE TABLE `xpcms_asset_link` (
  `asset_fid` int(11) NOT NULL default '0',
  `url` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  PRIMARY KEY  (`asset_fid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `xpcms_asset_link`
-- 

INSERT INTO `xpcms_asset_link` VALUES (0, 'http://www.xisc.com', 'Prado-Homepage', 'Auf dieser Seite finden Sie alle relevanten Informationen rund um Prado.');
INSERT INTO `xpcms_asset_link` VALUES (1, 'http://creole.phpdb.org', 'Creole-Homepage', 'Auf dieser Seite finden Sie alle relevanten Informationen rund um Prado.');
INSERT INTO `xpcms_asset_link` VALUES (2, 'http://nowhere.example.de', 'Ein Link ins Nichts', 'Auf dieser Seite werden Sie wohl nicht finden, wenn Sie überhaupt die Seite finden ;-)');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `xpcms_asset_sequence`
-- 

DROP TABLE IF EXISTS `xpcms_asset_sequence`;
CREATE TABLE `xpcms_asset_sequence` (
  `id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `xpcms_asset_sequence`
-- 

INSERT INTO `xpcms_asset_sequence` VALUES (5);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `xpcms_asset_text`
-- 

DROP TABLE IF EXISTS `xpcms_asset_text`;
CREATE TABLE `xpcms_asset_text` (
  `asset_fid` int(11) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  PRIMARY KEY  (`asset_fid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `xpcms_asset_text`
-- 

INSERT INTO `xpcms_asset_text` VALUES (3, 'Agilität von A-Z', 'Durch einen Thread im Sitepoint Forum bin ich heute auf Homepage von Scoot Ambler gestoßen. Die Masse an angebotenen Dokumenten zum Thema Agile Softwareentwicklung ist schier erdrückend. So reicht die Spannweite des Materials von der Dokumentation, über Vorgehensmodelle, Modellierung und Testing, bis hin zum Objekt-Relationel-Mapping.\r\n\r\nMeiner Meinung nach ein wahrer Informationsschatz im Netz, den ich jedem mit Interesse an der Agilen Softwareentwicklung nur empfehlen kann.');
INSERT INTO `xpcms_asset_text` VALUES (5, 'Ein optimales Datenbank-Design', 'Zur Zeit sitze ich in meiner Freizeit an der Entwicklung eines kleinen CMS auf Basis von Prado und Creole. Dabei stellt sich mir die Frage, wie sieht ein optimales Datenmodell aus, um möglichst wenig Abfragen an die Datenbank(Zur Zeit MySQL) zu schicken.\r\nFür die Navigationsstruktur habe ich einen abgewandelten Nested-Set Ansatz gewählt, den ich jeweils zu einer Navigationsgruppe zusammenfasse.');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `xpcms_structure_group`
-- 

DROP TABLE IF EXISTS `xpcms_structure_group`;
CREATE TABLE `xpcms_structure_group` (
  `id` int(11) NOT NULL default '0',
  `alias` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `xpcms_structure_group`
-- 

INSERT INTO `xpcms_structure_group` VALUES (0, NULL);
INSERT INTO `xpcms_structure_group` VALUES (1, NULL);
INSERT INTO `xpcms_structure_group` VALUES (2, 'web_site');
INSERT INTO `xpcms_structure_group` VALUES (3, NULL);
INSERT INTO `xpcms_structure_group` VALUES (4, NULL);
INSERT INTO `xpcms_structure_group` VALUES (5, 'backend');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `xpcms_structure_group_detail`
-- 

DROP TABLE IF EXISTS `xpcms_structure_group_detail`;
CREATE TABLE `xpcms_structure_group_detail` (
  `group_fid` int(11) NOT NULL default '0',
  `language` varchar(5) NOT NULL default '',
  `name` varchar(64) NOT NULL default '',
  `text` text NOT NULL,
  KEY `group_fid` (`group_fid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `xpcms_structure_group_detail`
-- 

INSERT INTO `xpcms_structure_group_detail` VALUES (1, 'de_DE', 'Menü oben', 'Dies ist das Menü oben.');
INSERT INTO `xpcms_structure_group_detail` VALUES (2, 'de_DE', 'Menü links', 'Die baumartige Navigation links');
INSERT INTO `xpcms_structure_group_detail` VALUES (3, 'de_DE', 'Inhalt Links', 'Weiterführende Links zum Inhalt der Webseite.');
INSERT INTO `xpcms_structure_group_detail` VALUES (4, 'de_DE', 'Inhaltsbereich', 'In dieser Gruppe werden alle Bestandteile die zum Inhalt einer Seite gehören zusammengefasst.');
INSERT INTO `xpcms_structure_group_detail` VALUES (5, 'de_DE', 'Admin Menü', 'Diese Gruppe definiert die sichtbaren Menüeinträge im Adminbereich');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `xpcms_structure_group_nested_set`
-- 

DROP TABLE IF EXISTS `xpcms_structure_group_nested_set`;
CREATE TABLE `xpcms_structure_group_nested_set` (
  `group_fid` int(11) NOT NULL default '0',
  `collection_fid` int(11) NOT NULL default '0',
  `lft` int(11) NOT NULL default '0',
  `rgt` int(11) NOT NULL default '0',
  KEY `group_id` (`group_fid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `xpcms_structure_group_nested_set`
-- 

INSERT INTO `xpcms_structure_group_nested_set` VALUES (1, 1, 2, 3);
INSERT INTO `xpcms_structure_group_nested_set` VALUES (1, 2, 4, 5);
INSERT INTO `xpcms_structure_group_nested_set` VALUES (1, 3, 6, 9);
INSERT INTO `xpcms_structure_group_nested_set` VALUES (1, 4, 10, 11);
INSERT INTO `xpcms_structure_group_nested_set` VALUES (1, -1, 1, 12);
INSERT INTO `xpcms_structure_group_nested_set` VALUES (1, 6, 7, 8);
INSERT INTO `xpcms_structure_group_nested_set` VALUES (2, 5, 2, 3);
INSERT INTO `xpcms_structure_group_nested_set` VALUES (2, 7, 4, 5);
INSERT INTO `xpcms_structure_group_nested_set` VALUES (2, 8, 6, 7);
INSERT INTO `xpcms_structure_group_nested_set` VALUES (2, 9, 8, 21);
INSERT INTO `xpcms_structure_group_nested_set` VALUES (2, 10, 9, 16);
INSERT INTO `xpcms_structure_group_nested_set` VALUES (2, 11, 17, 18);
INSERT INTO `xpcms_structure_group_nested_set` VALUES (2, 12, 19, 20);
INSERT INTO `xpcms_structure_group_nested_set` VALUES (2, -1, 1, 24);
INSERT INTO `xpcms_structure_group_nested_set` VALUES (2, 14, 10, 11);
INSERT INTO `xpcms_structure_group_nested_set` VALUES (2, 13, 22, 23);
INSERT INTO `xpcms_structure_group_nested_set` VALUES (2, 15, 12, 15);
INSERT INTO `xpcms_structure_group_nested_set` VALUES (2, 16, 13, 14);
INSERT INTO `xpcms_structure_group_nested_set` VALUES (5, -1, 1, 6);
INSERT INTO `xpcms_structure_group_nested_set` VALUES (5, 17, 2, 3);
INSERT INTO `xpcms_structure_group_nested_set` VALUES (5, 18, 4, 5);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `xpcms_web_collection`
-- 

DROP TABLE IF EXISTS `xpcms_web_collection`;
CREATE TABLE `xpcms_web_collection` (
  `id` int(11) NOT NULL auto_increment,
  `status` tinyint(1) NOT NULL default '0',
  `alias` varchar(128) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=602 ;

-- 
-- Daten für Tabelle `xpcms_web_collection`
-- 

INSERT INTO `xpcms_web_collection` VALUES (1, 1, '');
INSERT INTO `xpcms_web_collection` VALUES (2, 1, '');
INSERT INTO `xpcms_web_collection` VALUES (3, 1, '');
INSERT INTO `xpcms_web_collection` VALUES (4, 1, '');
INSERT INTO `xpcms_web_collection` VALUES (5, 1, '');
INSERT INTO `xpcms_web_collection` VALUES (6, 1, '');
INSERT INTO `xpcms_web_collection` VALUES (7, 1, '');
INSERT INTO `xpcms_web_collection` VALUES (8, 1, '');
INSERT INTO `xpcms_web_collection` VALUES (9, 1, '');
INSERT INTO `xpcms_web_collection` VALUES (10, 1, '');
INSERT INTO `xpcms_web_collection` VALUES (11, 1, '');
INSERT INTO `xpcms_web_collection` VALUES (12, 1, '');
INSERT INTO `xpcms_web_collection` VALUES (13, 1, '');
INSERT INTO `xpcms_web_collection` VALUES (14, 1, '');
INSERT INTO `xpcms_web_collection` VALUES (15, 1, '');
INSERT INTO `xpcms_web_collection` VALUES (16, 1, '');
INSERT INTO `xpcms_web_collection` VALUES (17, 1, 'WebContent:Structure');
INSERT INTO `xpcms_web_collection` VALUES (18, 1, 'WebContent:Asset');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `xpcms_web_collection_sequence`
-- 

DROP TABLE IF EXISTS `xpcms_web_collection_sequence`;
CREATE TABLE `xpcms_web_collection_sequence` (
  `id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `xpcms_web_collection_sequence`
-- 

INSERT INTO `xpcms_web_collection_sequence` VALUES (601);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `xpcms_web_collection_to_group`
-- 

DROP TABLE IF EXISTS `xpcms_web_collection_to_group`;
CREATE TABLE `xpcms_web_collection_to_group` (
  `collection_fid` int(11) NOT NULL default '0',
  `group_fid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`collection_fid`),
  KEY `group_fid` (`group_fid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `xpcms_web_collection_to_group`
-- 


-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `xpcms_web_page`
-- 

DROP TABLE IF EXISTS `xpcms_web_page`;
CREATE TABLE `xpcms_web_page` (
  `id` int(11) NOT NULL auto_increment,
  `collection_fid` int(11) NOT NULL default '0',
  `name` varchar(64) default NULL,
  `description` text NOT NULL,
  `language` varchar(5) NOT NULL default 'en_US',
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=841 ;

-- 
-- Daten für Tabelle `xpcms_web_page`
-- 

INSERT INTO `xpcms_web_page` VALUES (1, 1, 'Home', 'Die Starseite', 'de_DE', 1);
INSERT INTO `xpcms_web_page` VALUES (2, 2, 'Über Uns', 'Über uns', 'de_DE', 1);
INSERT INTO `xpcms_web_page` VALUES (3, 3, 'Unternehmen', 'Über unser Unternehmen', 'de_DE', 1);
INSERT INTO `xpcms_web_page` VALUES (4, 4, 'Nicht aktiv', 'Nicht aktiv', 'de_DE', 1);
INSERT INTO `xpcms_web_page` VALUES (5, 5, 'Home', 'Startseite', 'de_DE', 1);
INSERT INTO `xpcms_web_page` VALUES (6, 6, 'Jobs', 'Jobs', 'de_DE', 1);
INSERT INTO `xpcms_web_page` VALUES (7, 7, 'Blog', 'Mein kleines online Tagebuch', 'de_DE', 1);
INSERT INTO `xpcms_web_page` VALUES (8, 8, 'Artikel', 'Von mir geschriebene Artikel, Tutorials und weiterer geistiger Schwachsinn.', 'de_DE', 1);
INSERT INTO `xpcms_web_page` VALUES (9, 9, 'Projekte', 'Von mir entwickelte bzw. angedachte Projekte', 'de_DE', 1);
INSERT INTO `xpcms_web_page` VALUES (10, 10, 'NEXD', 'Bis jetzt das Projekt schlecht hin.', 'de_DE', 1);
INSERT INTO `xpcms_web_page` VALUES (11, 11, 'Carbon', 'Eine native XML-Datenbank in PHP.', 'de_DE', 1);
INSERT INTO `xpcms_web_page` VALUES (12, 12, 'XpCms', 'Mein erstes PHP5-CMS', 'de_DE', 1);
INSERT INTO `xpcms_web_page` VALUES (13, 13, 'Impressum', 'Impressum', 'de_DE', 1);
INSERT INTO `xpcms_web_page` VALUES (14, 14, 'apidoc', 'apidoc', 'de_DE', 1);
INSERT INTO `xpcms_web_page` VALUES (15, 15, 'Umldoc', 'Die UML Dokumentation zum CMS', 'de_DE', 1);
INSERT INTO `xpcms_web_page` VALUES (16, 16, 'Diagramme', 'Die einzelnen Diagramme nach ihren Typen', 'de_DE', 1);
INSERT INTO `xpcms_web_page` VALUES (17, 17, 'Struktur', 'In dieser Kollektion wird die sichtbare Struktur einer Webseite verwaltet', 'de_DE', 1);
INSERT INTO `xpcms_web_page` VALUES (18, 18, 'Inhalte', 'In dieser Kollektion werden die Inhalte einer Webseite verwaltet.', 'de_DE', 1);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `xpcms_web_page_sequence`
-- 

DROP TABLE IF EXISTS `xpcms_web_page_sequence`;
CREATE TABLE `xpcms_web_page_sequence` (
  `id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `xpcms_web_page_sequence`
-- 

INSERT INTO `xpcms_web_page_sequence` VALUES (840);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `xpcms_web_page_to_asset`
-- 

DROP TABLE IF EXISTS `xpcms_web_page_to_asset`;
CREATE TABLE `xpcms_web_page_to_asset` (
  `web_page_fid` int(11) NOT NULL default '0',
  `asset_fid` int(11) NOT NULL default '0',
  `group_fid` int(11) NOT NULL default '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `xpcms_web_page_to_asset`
-- 

INSERT INTO `xpcms_web_page_to_asset` VALUES (12, 0, 3);
INSERT INTO `xpcms_web_page_to_asset` VALUES (12, 1, 3);
INSERT INTO `xpcms_web_page_to_asset` VALUES (12, 2, 3);
INSERT INTO `xpcms_web_page_to_asset` VALUES (12, 3, 4);
INSERT INTO `xpcms_web_page_to_asset` VALUES (12, 4, 4);
INSERT INTO `xpcms_web_page_to_asset` VALUES (12, 5, 4);
