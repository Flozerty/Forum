-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour forum
DROP DATABASE IF EXISTS `forum`;
CREATE DATABASE IF NOT EXISTS `forum` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `forum`;

-- Listage de la structure de table forum. category
DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '',
  `icone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_category`) USING BTREE,
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum.category : ~7 rows (environ)
DELETE FROM `category`;
INSERT INTO `category` (`id_category`, `name`, `icone`) VALUES
	(1, 'jeux de société', '<i class="fa-solid fa-dice"></i>'),
	(2, 'jeux vidéos', '<i class="fa-solid fa-gamepad"></i>'),
	(3, 'cuisine', '<i class="fa-solid fa-bowl-rice"></i>'),
	(4, 'voyage', '<i class="fa-solid fa-location-dot"></i>'),
	(5, 'musique', '<i class="fa-solid fa-music"></i>'),
	(6, 'cinema', '<i class="fa-solid fa-clapperboard"></i>'),
	(7, 'sport', '<i class="fa-solid fa-table-tennis-paddle-ball"></i>');

-- Listage de la structure de table forum. post
DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int NOT NULL AUTO_INCREMENT,
  `postDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `messageContent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `topic_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id_post`) USING BTREE,
  KEY `FK_message_sujet` (`topic_id`) USING BTREE,
  KEY `FK_message_utilisateur` (`user_id`) USING BTREE,
  CONSTRAINT `FK_message_sujet` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`),
  CONSTRAINT `FK_message_utilisateur` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum.post : ~11 rows (environ)
DELETE FROM `post`;
INSERT INTO `post` (`id_post`, `postDate`, `messageContent`, `deleted`, `topic_id`, `user_id`) VALUES
	(2, '2024-04-17 12:25:21', 'Tu prends tes oeufs et tu les jettes dans la poele, apres ils sont cassés', 0, 1, 3),
	(3, '2024-04-17 12:40:40', 'J\'ai essayé mais ça marche pas très bien ils sont explosés maintenant...', 0, 1, 2),
	(4, '2024-04-17 13:00:00', 'Au secours ma poele est en feu à l\'aide', 0, 1, 2),
	(5, '2024-04-19 11:31:17', 'help', 0, 1, 2),
	(6, '2024-05-02 10:33:34', 'messsage 1', 0, 4, 2),
	(7, '2024-05-02 10:34:12', 'messgae 2', 0, 4, 1),
	(8, '2024-05-02 10:34:32', 'message 3', 1, 4, 4),
	(9, '2024-05-02 10:35:01', 'messaage 4', 0, 4, 2),
	(10, '2024-05-02 10:35:06', 'messge 5', 1, 4, 1),
	(11, '2024-05-02 10:35:47', 'messgea 6', 0, 4, 3),
	(12, '2024-05-04 16:44:31', 'tsetstt', 0, 2, 2);

-- Listage de la structure de table forum. topic
DROP TABLE IF EXISTS `topic`;
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `intro` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `category_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id_topic`) USING BTREE,
  UNIQUE KEY `title` (`title`),
  KEY `FK_sujet_categorie` (`category_id`) USING BTREE,
  KEY `FK_sujet_utilisateur` (`user_id`) USING BTREE,
  CONSTRAINT `FK_sujet_categorie` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`),
  CONSTRAINT `FK_sujet_utilisateur` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum.topic : ~5 rows (environ)
DELETE FROM `topic`;
INSERT INTO `topic` (`id_topic`, `title`, `creationDate`, `intro`, `closed`, `category_id`, `user_id`) VALUES
	(1, 'omelette à l\'oignon', '2024-04-19 00:00:00', 'Bonjour, j\'essaye de faire une omelette à l\'oignon mais j\'arrive pas a casser mes oeufs, quelqu\'un peut m\'aider?', 0, 3, 2),
	(2, 'monter la forge sur skyrim', '2024-04-18 00:00:00', 'vous faites comment?', 0, 2, 2),
	(3, 'qui qui joue au jeu de go', '2024-04-19 00:00:00', 'Je recherche des joueurs sur Strasbourg', 0, 1, 1),
	(4, 'test', '2024-05-02 10:32:30', 'test fermé', 1, 3, 1),
	(9, 'rg', '2024-05-02 12:24:12', 'rg', 0, 2, 1),
	(10, 'qqf', '2024-05-03 21:17:22', 'zef', 0, 3, 1);

-- Listage de la structure de table forum. user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `inscriptionDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(50) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_user`) USING BTREE,
  UNIQUE KEY `pseudo` (`pseudo`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum.user : ~4 rows (environ)
DELETE FROM `user`;
INSERT INTO `user` (`id_user`, `pseudo`, `email`, `password`, `inscriptionDate`, `role`, `avatar`) VALUES
	(1, 'flozerty', 'floris.louerat@gmail.com', '$2y$10$gkrZ74CiTXM9LA3dvSmmQefCBhMiJMqZjfyrGWWHNQyfh6REjVUny', '2024-04-19 00:00:00', 'admin', NULL),
	(2, 'bob', 'bob.bob@bob.bob', '$2y$10$SHoMyZatD5e9qJysX0ieCOw3/A58rFXSE22qT/AhSuhl/O11EyYRG', '2024-04-19 00:00:00', NULL, NULL),
	(3, 'test', 'test@gmail.com', '$2y$10$va6ieL2z2MhmJfL1jipnvOTo6nL/YkVAt.BygbC7/MMvy6rfaP/uK', '2024-04-19 00:00:00', NULL, NULL),
	(4, 'arklane', 'arklane.gmail.com', '$2y$10$z4WzV2FZDCOQYqPpf4N54eT4RpTLhFmdnRju9wDf2p0VWwqADVXt6', '2024-04-19 00:00:00', 'modo', NULL),
	(15, 'azrf', 'zefr.defr@fed.fr', '$2y$10$/J2WkDDPrY0jfm1J1OMdhOkWupn.87bgPft5lpkAShuEkBGuJwTb2', '2024-05-04 17:42:48', NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
