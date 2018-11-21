-- Adminer 4.6.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `drug`;
CREATE TABLE `drug` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `count` int(10) unsigned NOT NULL,
  `producer` int(11) NOT NULL,
  `price` int(10) unsigned NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `producer` (`producer`),
  CONSTRAINT `drug_ibfk_1` FOREIGN KEY (`producer`) REFERENCES `producer` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=ascii;


DROP TABLE IF EXISTS `drug_insurer`;
CREATE TABLE `drug_insurer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` int(10) unsigned NOT NULL,
  `drug_id` int(10) unsigned NOT NULL,
  `insurer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `drug_id` (`drug_id`),
  KEY `insurer_id` (`insurer_id`),
  CONSTRAINT `drug_insurer_ibfk_1` FOREIGN KEY (`drug_id`) REFERENCES `drug` (`id`) ON DELETE CASCADE,
  CONSTRAINT `drug_insurer_ibfk_2` FOREIGN KEY (`insurer_id`) REFERENCES `insurer` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=ascii;


DROP TABLE IF EXISTS `insurer`;
CREATE TABLE `insurer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=ascii;


DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(20) NOT NULL,
  `city` varchar(20) DEFAULT NULL,
  `zip` varchar(6) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=ascii;


DROP TABLE IF EXISTS `order_drug`;
CREATE TABLE `order_drug` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `count` int(10) unsigned NOT NULL DEFAULT '1',
  `drug_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `drug_id` (`drug_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_drug_ibfk_1` FOREIGN KEY (`drug_id`) REFERENCES `drug` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_drug_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=ascii;


DROP TABLE IF EXISTS `producer`;
CREATE TABLE `producer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=ascii;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role` varchar(11) DEFAULT 'user',
  `city` varchar(20) NOT NULL,
  `address` varchar(50) NOT NULL,
  `zip` varchar(6) NOT NULL,
  `country` varchar(50) NOT NULL,
  `insurer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `insurer_id` (`insurer_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`insurer_id`) REFERENCES `insurer` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=ascii;


-- 2018-11-21 19:13:46
