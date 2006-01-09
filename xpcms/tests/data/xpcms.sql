-- phpMyAdmin SQL Dump
-- version 2.6.4-pl4
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Erstellungszeit: 09. Januar 2006 um 07:13
-- Server Version: 4.1.16
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
  `name` varchar(64) NOT NULL default '',
  `description` text,
  `state` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `collection_fid` (`collection_fid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `xpcms_asset`
-- 

INSERT INTO `xpcms_asset` (`id`, `collection_fid`, `language`, `name`, `description`, `state`) VALUES (0, 12, 'de_DE', 'Prado-Website', 'Ein Link zur Webseite von Prado', 1);
INSERT INTO `xpcms_asset` (`id`, `collection_fid`, `language`, `name`, `description`, `state`) VALUES (1, 12, 'de_DE', 'Creole-Website', 'Ein Link zur Webseite von Creole', 1);
INSERT INTO `xpcms_asset` (`id`, `collection_fid`, `language`, `name`, `description`, `state`) VALUES (2, 12, 'de_DE', 'Link Sonst wohin', 'Ein Link ins Nirvana', 1);
INSERT INTO `xpcms_asset` (`id`, `collection_fid`, `language`, `name`, `description`, `state`) VALUES (3, 12, 'de_DE', 'Erster Text Block', 'Bla Bla Bla', 1);
INSERT INTO `xpcms_asset` (`id`, `collection_fid`, `language`, `name`, `description`, `state`) VALUES (4, 12, 'de_DE', 'Ein Bild', 'Bla Bla', 1);
INSERT INTO `xpcms_asset` (`id`, `collection_fid`, `language`, `name`, `description`, `state`) VALUES (5, 12, 'de_DE', 'Noch ein Text', 'Bla Bla Bla ', 1);

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

INSERT INTO `xpcms_asset_image` (`asset_fid`, `url`, `title`) VALUES (4, 'http://www.xplib.de/blog/img/collection-model.png', 'Datenmodell der Navigationsstruktur');

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
  `clicks` int(11) NOT NULL default '0',
  PRIMARY KEY  (`asset_fid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `xpcms_asset_link`
-- 

INSERT INTO `xpcms_asset_link` (`asset_fid`, `url`, `title`, `description`, `clicks`) VALUES (0, 'http://www.xisc.com', 'Prado-Homepage', 'Auf dieser Seite finden Sie alle relevanten Informationen rund um Prado.', 0);
INSERT INTO `xpcms_asset_link` (`asset_fid`, `url`, `title`, `description`, `clicks`) VALUES (1, 'http://creole.phpdb.org', 'Creole-Homepage', 'Auf dieser Seite finden Sie alle relevanten Informationen rund um Prado.', 0);
INSERT INTO `xpcms_asset_link` (`asset_fid`, `url`, `title`, `description`, `clicks`) VALUES (2, 'http://nowhere.example.de', 'Ein Link ins Nichts', 'Auf dieser Seite werden Sie wohl nicht finden, wenn Sie überhaupt die Seite finden ;-)', 0);

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

INSERT INTO `xpcms_asset_sequence` (`id`) VALUES (5);

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

INSERT INTO `xpcms_asset_text` (`asset_fid`, `title`, `content`) VALUES (3, 'Agilität von A-Z', 'Durch einen Thread im Sitepoint Forum bin ich heute auf Homepage von Scoot Ambler gestoßen. Die Masse an angebotenen Dokumenten zum Thema Agile Softwareentwicklung ist schier erdrückend. So reicht die Spannweite des Materials von der Dokumentation, über Vorgehensmodelle, Modellierung und Testing, bis hin zum Objekt-Relationel-Mapping.\r\n\r\nMeiner Meinung nach ein wahrer Informationsschatz im Netz, den ich jedem mit Interesse an der Agilen Softwareentwicklung nur empfehlen kann.');
INSERT INTO `xpcms_asset_text` (`asset_fid`, `title`, `content`) VALUES (5, 'Ein optimales Datenbank-Design', 'Zur Zeit sitze ich in meiner Freizeit an der Entwicklung eines kleinen CMS auf Basis von Prado und Creole. Dabei stellt sich mir die Frage, wie sieht ein optimales Datenmodell aus, um möglichst wenig Abfragen an die Datenbank(Zur Zeit MySQL) zu schicken.\r\nFür die Navigationsstruktur habe ich einen abgewandelten Nested-Set Ansatz gewählt, den ich jeweils zu einer Navigationsgruppe zusammenfasse.');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `xpcms_structure_group`
-- 

DROP TABLE IF EXISTS `xpcms_structure_group`;
CREATE TABLE `xpcms_structure_group` (
  `id` int(11) NOT NULL default '0',
  `group_fid` int(11) NOT NULL default '0',
  `position` float default NULL,
  `alias` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `group_fid` (`group_fid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `xpcms_structure_group`
-- 

INSERT INTO `xpcms_structure_group` (`id`, `group_fid`, `position`, `alias`) VALUES (1, 6, NULL, NULL);
INSERT INTO `xpcms_structure_group` (`id`, `group_fid`, `position`, `alias`) VALUES (2, 6, NULL, 'web_site');
INSERT INTO `xpcms_structure_group` (`id`, `group_fid`, `position`, `alias`) VALUES (3, 7, 2, NULL);
INSERT INTO `xpcms_structure_group` (`id`, `group_fid`, `position`, `alias`) VALUES (4, 7, 1, NULL);
INSERT INTO `xpcms_structure_group` (`id`, `group_fid`, `position`, `alias`) VALUES (5, 0, NULL, 'backend');
INSERT INTO `xpcms_structure_group` (`id`, `group_fid`, `position`, `alias`) VALUES (6, 5, NULL, 'complete_web_site_structure');
INSERT INTO `xpcms_structure_group` (`id`, `group_fid`, `position`, `alias`) VALUES (7, 0, NULL, 'web_page_asset_groups');
INSERT INTO `xpcms_structure_group` (`id`, `group_fid`, `position`, `alias`) VALUES (8, 7, NULL, 'download_assets');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `xpcms_structure_group_detail`
-- 

DROP TABLE IF EXISTS `xpcms_structure_group_detail`;
CREATE TABLE `xpcms_structure_group_detail` (
  `group_fid` int(11) NOT NULL default '0',
  `language` varchar(5) NOT NULL default 'en_US',
  `name` varchar(64) NOT NULL default '',
  `description` text NOT NULL,
  KEY `group_fid` (`group_fid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `xpcms_structure_group_detail`
-- 

INSERT INTO `xpcms_structure_group_detail` (`group_fid`, `language`, `name`, `description`) VALUES (1, 'de_DE', 'Menü oben', 'Dies ist das Menü oben.');
INSERT INTO `xpcms_structure_group_detail` (`group_fid`, `language`, `name`, `description`) VALUES (2, 'de_DE', 'Menü links', 'Die baumartige Navigation links');
INSERT INTO `xpcms_structure_group_detail` (`group_fid`, `language`, `name`, `description`) VALUES (3, 'de_DE', 'Inhalt Links', 'Weiterführende Links zum Inhalt der Webseite.');
INSERT INTO `xpcms_structure_group_detail` (`group_fid`, `language`, `name`, `description`) VALUES (4, 'de_DE', 'Inhaltsbereich', 'In dieser Gruppe werden alle Bestandteile die zum Inhalt einer Seite gehören zusammengefasst.');
INSERT INTO `xpcms_structure_group_detail` (`group_fid`, `language`, `name`, `description`) VALUES (5, 'de_DE', 'Admin Menü', 'Diese Gruppe definiert die sichtbaren Menüeinträge im Adminbereich');
INSERT INTO `xpcms_structure_group_detail` (`group_fid`, `language`, `name`, `description`) VALUES (6, 'de_DE', 'Vollständige Struktur der Webseite', 'In dieser Gruppe sind alle verfügbaren Kollektionsstrukturen der Webseite zusammen gefasst..');

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
  KEY `group_fid` (`group_fid`),
  KEY `collection_fid` (`collection_fid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `xpcms_structure_group_nested_set`
-- 

INSERT INTO `xpcms_structure_group_nested_set` (`group_fid`, `collection_fid`, `lft`, `rgt`) VALUES (1, 1, 2, 3);
INSERT INTO `xpcms_structure_group_nested_set` (`group_fid`, `collection_fid`, `lft`, `rgt`) VALUES (1, 2, 4, 5);
INSERT INTO `xpcms_structure_group_nested_set` (`group_fid`, `collection_fid`, `lft`, `rgt`) VALUES (1, 3, 6, 9);
INSERT INTO `xpcms_structure_group_nested_set` (`group_fid`, `collection_fid`, `lft`, `rgt`) VALUES (1, 4, 10, 11);
INSERT INTO `xpcms_structure_group_nested_set` (`group_fid`, `collection_fid`, `lft`, `rgt`) VALUES (1, -1, 1, 14);
INSERT INTO `xpcms_structure_group_nested_set` (`group_fid`, `collection_fid`, `lft`, `rgt`) VALUES (1, 6, 7, 8);
INSERT INTO `xpcms_structure_group_nested_set` (`group_fid`, `collection_fid`, `lft`, `rgt`) VALUES (2, 5, 2, 3);
INSERT INTO `xpcms_structure_group_nested_set` (`group_fid`, `collection_fid`, `lft`, `rgt`) VALUES (2, 7, 4, 5);
INSERT INTO `xpcms_structure_group_nested_set` (`group_fid`, `collection_fid`, `lft`, `rgt`) VALUES (2, 8, 6, 7);
INSERT INTO `xpcms_structure_group_nested_set` (`group_fid`, `collection_fid`, `lft`, `rgt`) VALUES (2, 9, 8, 21);
INSERT INTO `xpcms_structure_group_nested_set` (`group_fid`, `collection_fid`, `lft`, `rgt`) VALUES (2, 10, 9, 16);
INSERT INTO `xpcms_structure_group_nested_set` (`group_fid`, `collection_fid`, `lft`, `rgt`) VALUES (2, 11, 17, 18);
INSERT INTO `xpcms_structure_group_nested_set` (`group_fid`, `collection_fid`, `lft`, `rgt`) VALUES (2, 12, 19, 20);
INSERT INTO `xpcms_structure_group_nested_set` (`group_fid`, `collection_fid`, `lft`, `rgt`) VALUES (2, -1, 1, 24);
INSERT INTO `xpcms_structure_group_nested_set` (`group_fid`, `collection_fid`, `lft`, `rgt`) VALUES (2, 14, 10, 11);
INSERT INTO `xpcms_structure_group_nested_set` (`group_fid`, `collection_fid`, `lft`, `rgt`) VALUES (2, 13, 22, 23);
INSERT INTO `xpcms_structure_group_nested_set` (`group_fid`, `collection_fid`, `lft`, `rgt`) VALUES (2, 15, 12, 15);
INSERT INTO `xpcms_structure_group_nested_set` (`group_fid`, `collection_fid`, `lft`, `rgt`) VALUES (2, 16, 13, 14);
INSERT INTO `xpcms_structure_group_nested_set` (`group_fid`, `collection_fid`, `lft`, `rgt`) VALUES (5, -1, 1, 6);
INSERT INTO `xpcms_structure_group_nested_set` (`group_fid`, `collection_fid`, `lft`, `rgt`) VALUES (5, 17, 2, 3);
INSERT INTO `xpcms_structure_group_nested_set` (`group_fid`, `collection_fid`, `lft`, `rgt`) VALUES (5, 18, 4, 5);
INSERT INTO `xpcms_structure_group_nested_set` (`group_fid`, `collection_fid`, `lft`, `rgt`) VALUES (2, 13, 22, 23);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `xpcms_web_collection`
-- 

DROP TABLE IF EXISTS `xpcms_web_collection`;
CREATE TABLE `xpcms_web_collection` (
  `id` int(11) NOT NULL auto_increment,
  `status` tinyint(1) NOT NULL default '0',
  `alias` varchar(128) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `alias` (`alias`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- 
-- Daten für Tabelle `xpcms_web_collection`
-- 

INSERT INTO `xpcms_web_collection` (`id`, `status`, `alias`) VALUES (1, 1, 'home');
INSERT INTO `xpcms_web_collection` (`id`, `status`, `alias`) VALUES (2, 1, 'about_us');
INSERT INTO `xpcms_web_collection` (`id`, `status`, `alias`) VALUES (3, 1, 'company');
INSERT INTO `xpcms_web_collection` (`id`, `status`, `alias`) VALUES (4, 1, 'inactive');
INSERT INTO `xpcms_web_collection` (`id`, `status`, `alias`) VALUES (5, 1, 'home');
INSERT INTO `xpcms_web_collection` (`id`, `status`, `alias`) VALUES (6, 1, 'jobs');
INSERT INTO `xpcms_web_collection` (`id`, `status`, `alias`) VALUES (7, 1, 'blog');
INSERT INTO `xpcms_web_collection` (`id`, `status`, `alias`) VALUES (8, 1, 'article');
INSERT INTO `xpcms_web_collection` (`id`, `status`, `alias`) VALUES (9, 1, 'project');
INSERT INTO `xpcms_web_collection` (`id`, `status`, `alias`) VALUES (10, 1, 'nexd');
INSERT INTO `xpcms_web_collection` (`id`, `status`, `alias`) VALUES (11, 1, 'carbon');
INSERT INTO `xpcms_web_collection` (`id`, `status`, `alias`) VALUES (12, 1, 'xpcms');
INSERT INTO `xpcms_web_collection` (`id`, `status`, `alias`) VALUES (13, 1, 'imprint');
INSERT INTO `xpcms_web_collection` (`id`, `status`, `alias`) VALUES (14, 1, 'apidoc');
INSERT INTO `xpcms_web_collection` (`id`, `status`, `alias`) VALUES (15, 1, 'umldoc');
INSERT INTO `xpcms_web_collection` (`id`, `status`, `alias`) VALUES (16, 1, 'diagrams');
INSERT INTO `xpcms_web_collection` (`id`, `status`, `alias`) VALUES (17, 1, 'admin_structure');
INSERT INTO `xpcms_web_collection` (`id`, `status`, `alias`) VALUES (18, 1, 'admin_asset');

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `xpcms_web_collection_page_class`
-- 

DROP TABLE IF EXISTS `xpcms_web_collection_page_class`;
CREATE TABLE `xpcms_web_collection_page_class` (
  `collection_fid` int(11) NOT NULL default '0',
  `page_class` varchar(128) NOT NULL default '',
  PRIMARY KEY  (`collection_fid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `xpcms_web_collection_page_class`
-- 

INSERT INTO `xpcms_web_collection_page_class` (`collection_fid`, `page_class`) VALUES (7, 'Blog:Blog');
INSERT INTO `xpcms_web_collection_page_class` (`collection_fid`, `page_class`) VALUES (17, 'WebContent:Structure');
INSERT INTO `xpcms_web_collection_page_class` (`collection_fid`, `page_class`) VALUES (18, 'WebContent:Asset');

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

INSERT INTO `xpcms_web_collection_sequence` (`id`) VALUES (2767);

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
  PRIMARY KEY  (`id`),
  KEY `collection_fid` (`collection_fid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3383 ;

-- 
-- Daten für Tabelle `xpcms_web_page`
-- 

INSERT INTO `xpcms_web_page` (`id`, `collection_fid`, `name`, `description`, `language`, `status`) VALUES (1, 1, 'Home', 'Die Starseite', 'de_DE', 1);
INSERT INTO `xpcms_web_page` (`id`, `collection_fid`, `name`, `description`, `language`, `status`) VALUES (2, 2, 'Über Uns', 'Über uns', 'de_DE', 1);
INSERT INTO `xpcms_web_page` (`id`, `collection_fid`, `name`, `description`, `language`, `status`) VALUES (3, 3, 'Unternehmen', 'Unternehmen', 'de_DE', 1);
INSERT INTO `xpcms_web_page` (`id`, `collection_fid`, `name`, `description`, `language`, `status`) VALUES (4, 4, 'Nicht aktiv', 'Nicht aktiv', 'de_DE', 1);
INSERT INTO `xpcms_web_page` (`id`, `collection_fid`, `name`, `description`, `language`, `status`) VALUES (5, 5, 'Home', 'Startseite', 'de_DE', 1);
INSERT INTO `xpcms_web_page` (`id`, `collection_fid`, `name`, `description`, `language`, `status`) VALUES (6, 6, 'Jobs', 'Jobs', 'de_DE', 1);
INSERT INTO `xpcms_web_page` (`id`, `collection_fid`, `name`, `description`, `language`, `status`) VALUES (7, 7, 'Blog', 'Mein kleines online Tagebuch', 'de_DE', 1);
INSERT INTO `xpcms_web_page` (`id`, `collection_fid`, `name`, `description`, `language`, `status`) VALUES (8, 8, 'Artikel', 'Von mir geschriebene Artikel, Tutorials und weiterer geistiger Schwachsinn.', 'de_DE', 1);
INSERT INTO `xpcms_web_page` (`id`, `collection_fid`, `name`, `description`, `language`, `status`) VALUES (9, 9, 'Projekte', 'Von mir entwickelte bzw. angedachte Projekte', 'de_DE', 1);
INSERT INTO `xpcms_web_page` (`id`, `collection_fid`, `name`, `description`, `language`, `status`) VALUES (10, 10, 'NEXD', 'Bis jetzt das Projekt schlecht hin.', 'de_DE', 1);
INSERT INTO `xpcms_web_page` (`id`, `collection_fid`, `name`, `description`, `language`, `status`) VALUES (11, 11, 'Carbon', 'Eine native XML-Datenbank in PHP.', 'de_DE', 1);
INSERT INTO `xpcms_web_page` (`id`, `collection_fid`, `name`, `description`, `language`, `status`) VALUES (12, 12, 'XpCms', 'Mein erstes PHP5-CMS', 'de_DE', 1);
INSERT INTO `xpcms_web_page` (`id`, `collection_fid`, `name`, `description`, `language`, `status`) VALUES (13, 13, 'Impressum', 'Impressum', 'de_DE', 1);
INSERT INTO `xpcms_web_page` (`id`, `collection_fid`, `name`, `description`, `language`, `status`) VALUES (14, 14, 'apidoc', 'apidoc', 'de_DE', 1);
INSERT INTO `xpcms_web_page` (`id`, `collection_fid`, `name`, `description`, `language`, `status`) VALUES (15, 15, 'Umldoc', 'Die UML Dokumentation zum CMS', 'de_DE', 1);
INSERT INTO `xpcms_web_page` (`id`, `collection_fid`, `name`, `description`, `language`, `status`) VALUES (16, 16, 'Diagramme', 'Die einzelnen Diagramme nach ihren Typen', 'de_DE', 1);
INSERT INTO `xpcms_web_page` (`id`, `collection_fid`, `name`, `description`, `language`, `status`) VALUES (17, 17, 'Struktur', 'In dieser Kollektion wird die sichtbare Struktur einer Webseite verwaltet', 'de_DE', 1);
INSERT INTO `xpcms_web_page` (`id`, `collection_fid`, `name`, `description`, `language`, `status`) VALUES (18, 18, 'Inhalte', 'In dieser Kollektion werden die Inhalte einer Webseite verwaltet.', 'de_DE', 1);
INSERT INTO `xpcms_web_page` (`id`, `collection_fid`, `name`, `description`, `language`, `status`) VALUES (19, 9, 'Projects', 'On this page you could find all my projects.', 'en_GB', 1);
INSERT INTO `xpcms_web_page` (`id`, `collection_fid`, `name`, `description`, `language`, `status`) VALUES (3382, 2301, 'Foo', 'BAR', 'de_DE', 1);

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

INSERT INTO `xpcms_web_page_sequence` (`id`) VALUES (4082);

-- --------------------------------------------------------

-- 
-- Tabellenstruktur für Tabelle `xpcms_web_page_to_asset`
-- 

DROP TABLE IF EXISTS `xpcms_web_page_to_asset`;
CREATE TABLE `xpcms_web_page_to_asset` (
  `web_page_fid` int(11) NOT NULL default '0',
  `asset_fid` int(11) NOT NULL default '0',
  `group_fid` int(11) NOT NULL default '0',
  `position` float NOT NULL default '0',
  KEY `web_page_fid` (`web_page_fid`),
  KEY `asset_fid` (`asset_fid`),
  KEY `group_fid` (`group_fid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Daten für Tabelle `xpcms_web_page_to_asset`
-- 

INSERT INTO `xpcms_web_page_to_asset` (`web_page_fid`, `asset_fid`, `group_fid`, `position`) VALUES (12, 0, 3, 0);
INSERT INTO `xpcms_web_page_to_asset` (`web_page_fid`, `asset_fid`, `group_fid`, `position`) VALUES (12, 1, 3, 0);
INSERT INTO `xpcms_web_page_to_asset` (`web_page_fid`, `asset_fid`, `group_fid`, `position`) VALUES (12, 2, 3, 0);
INSERT INTO `xpcms_web_page_to_asset` (`web_page_fid`, `asset_fid`, `group_fid`, `position`) VALUES (12, 3, 4, 0);
INSERT INTO `xpcms_web_page_to_asset` (`web_page_fid`, `asset_fid`, `group_fid`, `position`) VALUES (12, 4, 4, 0);
INSERT INTO `xpcms_web_page_to_asset` (`web_page_fid`, `asset_fid`, `group_fid`, `position`) VALUES (12, 5, 4, 0);

-- 
-- Constraints der exportierten Tabellen
-- 

-- 
-- Constraints der Tabelle `xpcms_asset_comment`
-- 
ALTER TABLE `xpcms_asset_comment`
  ADD CONSTRAINT `xpcms_asset_comment_ibfk_1` FOREIGN KEY (`asset_fid`) REFERENCES `xpcms_asset` (`id`) ON DELETE CASCADE;

-- 
-- Constraints der Tabelle `xpcms_asset_download`
-- 
ALTER TABLE `xpcms_asset_download`
  ADD CONSTRAINT `xpcms_asset_download_ibfk_1` FOREIGN KEY (`asset_fid`) REFERENCES `xpcms_asset` (`id`) ON DELETE CASCADE;

-- 
-- Constraints der Tabelle `xpcms_asset_image`
-- 
ALTER TABLE `xpcms_asset_image`
  ADD CONSTRAINT `xpcms_asset_image_ibfk_1` FOREIGN KEY (`asset_fid`) REFERENCES `xpcms_asset` (`id`) ON DELETE CASCADE;

-- 
-- Constraints der Tabelle `xpcms_asset_link`
-- 
ALTER TABLE `xpcms_asset_link`
  ADD CONSTRAINT `xpcms_asset_link_ibfk_1` FOREIGN KEY (`asset_fid`) REFERENCES `xpcms_asset` (`id`) ON DELETE CASCADE;

-- 
-- Constraints der Tabelle `xpcms_asset_text`
-- 
ALTER TABLE `xpcms_asset_text`
  ADD CONSTRAINT `xpcms_asset_text_ibfk_1` FOREIGN KEY (`asset_fid`) REFERENCES `xpcms_asset` (`id`) ON DELETE CASCADE;

-- 
-- Constraints der Tabelle `xpcms_structure_group_detail`
-- 
ALTER TABLE `xpcms_structure_group_detail`
  ADD CONSTRAINT `xpcms_structure_group_detail_ibfk_1` FOREIGN KEY (`group_fid`) REFERENCES `xpcms_structure_group` (`id`) ON DELETE CASCADE;

-- 
-- Constraints der Tabelle `xpcms_structure_group_nested_set`
-- 
ALTER TABLE `xpcms_structure_group_nested_set`
  ADD CONSTRAINT `xpcms_structure_group_nested_set_ibfk_1` FOREIGN KEY (`group_fid`) REFERENCES `xpcms_structure_group` (`id`) ON DELETE CASCADE;

-- 
-- Constraints der Tabelle `xpcms_web_collection_page_class`
-- 
ALTER TABLE `xpcms_web_collection_page_class`
  ADD CONSTRAINT `xpcms_web_collection_page_class_ibfk_1` FOREIGN KEY (`collection_fid`) REFERENCES `xpcms_web_collection` (`id`) ON DELETE CASCADE;

-- 
-- Constraints der Tabelle `xpcms_web_page_to_asset`
-- 
ALTER TABLE `xpcms_web_page_to_asset`
  ADD CONSTRAINT `xpcms_web_page_to_asset_ibfk_3` FOREIGN KEY (`asset_fid`) REFERENCES `xpcms_asset` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `xpcms_web_page_to_asset_ibfk_4` FOREIGN KEY (`group_fid`) REFERENCES `xpcms_structure_group` (`id`) ON DELETE CASCADE;
