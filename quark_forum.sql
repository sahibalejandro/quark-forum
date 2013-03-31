-- Adminer 3.6.3 MySQL dump

SET NAMES utf8;

CREATE DATABASE `quark_forum` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `quark_forum`;

CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categories_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_id` (`categories_id`),
  CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `favorite_posts` (
  `posts_id` bigint(20) unsigned NOT NULL,
  `users_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`posts_id`,`users_id`),
  KEY `users_id` (`users_id`),
  CONSTRAINT `favorite_posts_ibfk_1` FOREIGN KEY (`posts_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `favorite_posts_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `posts_id` bigint(20) unsigned DEFAULT NULL COMMENT 'parent post ID, for comments.',
  `categories_id` int(10) unsigned DEFAULT NULL,
  `users_id` int(10) unsigned NOT NULL COMMENT 'author id',
  `title` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modification_date` datetime DEFAULT NULL COMMENT 'last modification date',
  `sticky` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Post is sticky in their category',
  `good_points` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Good points counter',
  `bad_points` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Bad points counter',
  PRIMARY KEY (`id`),
  KEY `users_id` (`users_id`),
  KEY `posts_id` (`posts_id`),
  KEY `categories_id` (`categories_id`),
  CONSTRAINT `posts_ibfk_5` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `posts_ibfk_6` FOREIGN KEY (`posts_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `posts_ibfk_7` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='posts and comments';


CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT 'User screen name',
  `email` varchar(100) NOT NULL COMMENT 'User email address',
  `auth_method` char(1) CHARACTER SET ascii NOT NULL COMMENT 'Authe method. T=twitter, G=Google, F=Facebook',
  `join_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Join date and time',
  `type` char(1) NOT NULL DEFAULT 'U' COMMENT 'U=User, M=Moderator, A=Admin',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Registered users';


CREATE TABLE `watched_posts` (
  `posts_id` bigint(20) unsigned NOT NULL,
  `users_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`posts_id`,`users_id`),
  KEY `users_id` (`users_id`),
  CONSTRAINT `watched_posts_ibfk_1` FOREIGN KEY (`posts_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `watched_posts_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2013-03-31 00:41:40
