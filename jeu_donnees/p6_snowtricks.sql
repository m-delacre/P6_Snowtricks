-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 17 oct. 2023 à 09:20
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `p6_snowtricks`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `figure_id` int NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526CA76ED395` (`user_id`),
  KEY `IDX_9474526C5C011B5` (`figure_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `figure_id`, `content`, `date`) VALUES
(14, 2, 21, '1 commentaire', '2023-10-07'),
(15, 2, 21, '2 com', '2023-10-07'),
(16, 2, 21, 'super figure', '2023-10-07'),
(17, 2, 21, 'cool la figure', '2023-10-07'),
(18, 2, 21, 'je spam les commentaires', '2023-10-07'),
(19, 2, 21, 'testtesteste', '2023-10-07'),
(20, 2, 21, 'OK', '2023-10-07'),
(24, 2, 21, 'soutenance', '2023-10-17');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230911090725', '2023-09-11 09:07:46', 59),
('DoctrineMigrations\\Version20230911092534', '2023-09-11 09:25:41', 31),
('DoctrineMigrations\\Version20230911100247', '2023-09-11 10:02:55', 32),
('DoctrineMigrations\\Version20230911160047', '2023-09-11 16:01:00', 80),
('DoctrineMigrations\\Version20230912131750', '2023-09-12 13:18:06', 88),
('DoctrineMigrations\\Version20230913091736', '2023-09-13 09:18:36', 66),
('DoctrineMigrations\\Version20230917145620', '2023-09-17 14:56:31', 61),
('DoctrineMigrations\\Version20230917162831', '2023-09-17 16:28:40', 92),
('DoctrineMigrations\\Version20230918130816', '2023-09-18 13:08:20', 84),
('DoctrineMigrations\\Version20230918131448', '2023-09-18 13:14:51', 68),
('DoctrineMigrations\\Version20230918132739', '2023-09-18 13:27:45', 72),
('DoctrineMigrations\\Version20230919133247', '2023-09-19 13:33:00', 137),
('DoctrineMigrations\\Version20230924165504', '2023-09-24 16:55:16', 40),
('DoctrineMigrations\\Version20231017091530', '2023-10-17 09:15:44', 62);

-- --------------------------------------------------------

--
-- Structure de la table `figure`
--

DROP TABLE IF EXISTS `figure`;
CREATE TABLE IF NOT EXISTS `figure` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `groupe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creation_date` date NOT NULL,
  `update_date` date DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2F57B37A989D9B62` (`slug`),
  KEY `IDX_2F57B37A9D86650F` (`user_id_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `figure`
--

INSERT INTO `figure` (`id`, `user_id_id`, `name`, `description`, `groupe`, `creation_date`, `update_date`, `slug`) VALUES
(21, 2, 'Mute v3', 'saisie de la carre frontside de la planche entre les deux pieds avec la main avant ;', 'grabs', '2023-10-01', '2023-10-17', 'Mute-v3'),
(22, 2, '360', 'trois six pour un tour complet', 'rotations', '2023-10-01', NULL, '360'),
(23, 2, '720', 'sept deux pour deux tours complets', 'rotations', '2023-10-01', NULL, '720'),
(24, 2, 'front flip', 'Un flip vers l\'avant', 'flips', '2023-10-01', '2023-10-01', 'front-flip'),
(25, 2, 'rotations désaxées', 'rotation initialement horizontale mais lancée avec un mouvement des épaules particulier qui désaxe la rotation', 'rotations désaxées', '2023-10-01', '2023-10-01', 'rotations-desaxees'),
(28, 2, 'soutenance newslug', 'test', 'slides', '2023-10-17', '2023-10-17', 'soutenance-newslug');

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id` int NOT NULL AUTO_INCREMENT,
  `figure_id` int NOT NULL,
  `media_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `groupe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_media` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6A2CA10C5C011B5` (`figure_id`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `media`
--

INSERT INTO `media` (`id`, `figure_id`, `media_path`, `groupe`, `first_media`) VALUES
(89, 21, 'uploads/tricksPhoto/21-65196b0abb368.jpg', 'photo', 0),
(92, 21, 'k6aOWf0LDcQ', 'video', 0),
(93, 21, 'k6aOWf0LDcQ', 'video', 0),
(94, 22, 'k6aOWf0LDcQ', 'video', 0),
(95, 22, 'k6aOWf0LDcQ', 'video', 0),
(96, 22, 'uploads/tricksBanner/65196b78ee5b7.jpg', 'photo', 1),
(98, 22, 'uploads/tricksPhoto/65196f4db78c5.jpg', 'photo', 0),
(99, 23, 'uploads/tricksBanner/65196f8437985.jpg', 'photo', 1),
(100, 23, 'uploads/tricksPhoto/23-65196f8a1553b.jpg', 'photo', 0),
(101, 24, 'uploads/tricksBanner/65196fa052bfd.jpg', 'photo', 1),
(102, 25, 'uploads/tricksBanner/65196fbe1ee5f.jpg', 'photo', 1),
(107, 21, 'uploads/tricksPhoto/21-652e4263e4579.jpg', 'photo', 0),
(109, 21, 'uploads/tricksBanner/652e5064783b6.jpg', 'photo', 1);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reset_password_request`
--

DROP TABLE IF EXISTS `reset_password_request`;
CREATE TABLE IF NOT EXISTS `reset_password_request` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_7CE748AA76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `picture_path`, `email`, `is_verified`) VALUES
(2, 'matt_del', '[]', '$2y$13$bw7PNdLvMWgA34uRXtie5e6dq3TxPMAEf9kQl1Q1pvtgG9siCe0F6', NULL, 'matthieu.delacre@yahoo.fr', 1),
(4, 'SnowRiderz', '[]', '$2y$13$DXpSVgZVMBPxKNCAI0K72.OW89gnAq.qiMosvKwqXGVGyLAPcFZLu', NULL, 'stazdelacre@gmail.com', 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526C5C011B5` FOREIGN KEY (`figure_id`) REFERENCES `figure` (`id`),
  ADD CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `figure`
--
ALTER TABLE `figure`
  ADD CONSTRAINT `FK_2F57B37A9D86650F` FOREIGN KEY (`user_id_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `FK_6A2CA10C5C011B5` FOREIGN KEY (`figure_id`) REFERENCES `figure` (`id`);

--
-- Contraintes pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
