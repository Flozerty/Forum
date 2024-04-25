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
  `icone` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_category`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum.category : ~6 rows (environ)
DELETE FROM `category`;
INSERT INTO `category` (`id_category`, `name`, `icone`) VALUES
	(1, 'jeux de société', NULL),
	(2, 'jeux vidéos', NULL),
	(3, 'cuisine', NULL),
	(4, 'voyage', NULL),
	(5, 'musique', NULL),
	(6, 'cinema', NULL);

-- Listage de la structure de table forum. post
DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int NOT NULL AUTO_INCREMENT,
  `dateMessage` datetime DEFAULT NULL,
  `messageContent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `topic_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id_post`) USING BTREE,
  KEY `FK_message_sujet` (`topic_id`) USING BTREE,
  KEY `FK_message_utilisateur` (`user_id`) USING BTREE,
  CONSTRAINT `FK_message_sujet` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`),
  CONSTRAINT `FK_message_utilisateur` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum.post : ~5 rows (environ)
DELETE FROM `post`;
INSERT INTO `post` (`id_post`, `dateMessage`, `messageContent`, `topic_id`, `user_id`) VALUES
	(1, '2024-04-17 12:21:11', 'Bonjour, j\'essaye de faire une omelette à l\'oignon mais j\'arrive pas a casser mes oeufs, quelqu\'un peut m\'aider?', 1, 2),
	(2, '2024-04-17 12:25:21', 'Tu prends tes oeufs et tu les jettes dans la poele, apres ils sont cassés', 1, 3),
	(3, '2024-04-17 12:40:40', 'J\'ai essayé mais ça marche pas très bien ils sont explosés maintenant...', 1, 2),
	(4, '2024-04-17 13:00:00', 'Au secours ma poele est en feu à l\'aide', 1, 2),
	(5, '2024-04-19 11:31:17', 'help', 1, 1);

-- Listage de la structure de table forum. topic
DROP TABLE IF EXISTS `topic`;
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `dateCreation` date DEFAULT NULL,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `closed` tinyint DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id_topic`) USING BTREE,
  KEY `FK_sujet_categorie` (`category_id`) USING BTREE,
  KEY `FK_sujet_utilisateur` (`user_id`) USING BTREE,
  CONSTRAINT `FK_sujet_categorie` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`),
  CONSTRAINT `FK_sujet_utilisateur` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum.topic : ~3 rows (environ)
DELETE FROM `topic`;
INSERT INTO `topic` (`id_topic`, `dateCreation`, `title`, `closed`, `category_id`, `user_id`) VALUES
	(1, '2024-04-17', 'omelette à l\'oignon', NULL, 3, 2),
	(2, '2024-04-18', 'monter la forge sur skyrim', NULL, 2, 2),
	(3, '2024-04-19', 'qui qui joue au jeu de go', NULL, 1, 1);

-- Listage de la structure de table forum. user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dateInscription` date NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_user`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum.user : ~4 rows (environ)
DELETE FROM `user`;
INSERT INTO `user` (`id_user`, `pseudo`, `email`, `password`, `dateInscription`, `role`, `avatar`) VALUES
	(1, 'flozerty', 'floris.louerat@gmail.com', '12345azerty', '2024-04-19', 'admin', NULL),
	(2, 'bob', 'bob.bob@bob.bob', 'bobobobobo', '2024-04-19', NULL, NULL),
	(3, 'test', 'test@gmail.com', 'test123', '2024-04-19', NULL, NULL),
	(6, 'arklane', 'arklane@gmail.com', 'arklemochedu73', '2024-04-19', 'modo', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
