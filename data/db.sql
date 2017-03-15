-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `clienti`;
CREATE TABLE `clienti` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `residenza` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `clienti` (`id`, `nome`, `email`, `telefono`, `residenza`) VALUES
(3,	'pluto',	NULL,	'327171711111',	NULL),
(4,	'aladin',	'aladin@libero.com',	'32155551719',	NULL),
(5,	'ezechiele',	NULL,	'32498975556',	NULL),
(8,	'orazio',	NULL,	'327171711165',	NULL),
(14,	'qui',	'qui@gm.org',	'',	'casa di paperino'),
(16,	'quo',	'',	'',	'casa di paperino'),
(17,	'qua',	'',	'34025025005',	'casa di paperino');

DROP TABLE IF EXISTS `ricevute`;
CREATE TABLE `ricevute` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dataemissione` date DEFAULT NULL,
  `clienti_id` int(11) unsigned DEFAULT NULL,
  `descrizione` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `importo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_foreignkey_ricevute_clienti` (`clienti_id`),
  CONSTRAINT `c_fk_ricevute_clienti_id` FOREIGN KEY (`clienti_id`) REFERENCES `clienti` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ricevute` (`id`, `dataemissione`, `clienti_id`, `descrizione`, `importo`, `numero`) VALUES
(1,	'1974-09-19',	8,	'affitto settembre',	'100',	'00001'),
(2,	'2017-03-11',	16,	'pulizia scale marzo',	'120',	'00002'),
(4,	'1970-01-25',	4,	'lucidatura lampada',	'50',	'00003'),
(5,	'2015-01-01',	3,	'pulizia scale annuale',	'150',	'00005'),
(6,	'2015-02-01',	3,	'volo su marte per 2 persone',	'10000',	'00004'),
(7,	'2015-02-01',	3,	'volo su marte per 2 persone',	'10000',	'00004'),
(8,	'2015-02-01',	3,	'volo su marte per 2 persone',	'10000',	'00004'),
(9,	'1970-01-01',	3,	'acquisto legna per il caminetto',	'37',	'00007');

DROP VIEW IF EXISTS `ricliente`;
CREATE TABLE `ricliente` (`rid` int(11) unsigned, `data` date, `descrizione` varchar(191), `clid` int(11) unsigned, `nome` varchar(191), `importo` varchar(191), `numero` varchar(191), `id` int(11) unsigned, `email` varchar(191), `telefono` varchar(191), `residenza` varchar(191));


DROP TABLE IF EXISTS `ricliente`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `ricliente` AS select `r`.`id` AS `rid`,`r`.`dataemissione` AS `data`,`r`.`descrizione` AS `descrizione`,`r`.`clienti_id` AS `clid`,`c`.`nome` AS `nome`,`r`.`importo` AS `importo`,`r`.`numero` AS `numero`,`c`.`id` AS `id`,`c`.`email` AS `email`,`c`.`telefono` AS `telefono`,`c`.`residenza` AS `residenza` from (`ricevute` `r` join `clienti` `c` on((`r`.`clienti_id` = `c`.`id`)));

-- 2017-03-14 20:26:01