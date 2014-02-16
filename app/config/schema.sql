# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Hôte: 127.0.0.1 (MySQL 5.6.15)
# Base de données: uframework
# Temps de génération: 2014-02-07 02:41:51 +0000
# ************************************************************

DROP TABLE IF EXISTS `Tweet`;

CREATE TABLE `Tweet` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'Identifiant de l''utilisateur',
  `content` varchar(140) NOT NULL DEFAULT 'Message par defaut...' COMMENT 'Contenu',
  `date` datetime NOT NULL COMMENT 'Date de creation',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO `Tweet` (`id`, `user_id`, `content`, `date`)
VALUES
	(1,1,'Premier tweet en base','2014-02-07 02:24:24'),
	(2,1,'Second tweet du maestro !','2014-02-07 02:28:12'),
	(3,2,'Je suis un poney et je tweet, ca te dérange ?','2014-02-07 02:28:46');

DROP TABLE IF EXISTS `User`;

CREATE TABLE `User` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(140) NOT NULL COMMENT 'Pseudo de l''utilisateur',
  `password` varchar(40) NOT NULL COMMENT 'Mot de passe',
  `name` varchar(40) NOT NULL COMMENT 'Nom de l''utilisateur',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO `User` (`id`, `pseudo`, `password`, `name`)
VALUES (1,'Tralgar','admin','Léo');