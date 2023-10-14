-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 11 oct. 2023 à 09:32
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
(21, 2, 26, 'test', '2023-10-07'),
(22, 2, 26, 'test', '2023-10-07'),
(23, 2, 26, 'double test', '2023-10-07');

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
('DoctrineMigrations\\Version20230924165504', '2023-09-24 16:55:16', 40);

--
-- Déchargement des données de la table `figure`
--

INSERT INTO `figure` (`id`, `user_id_id`, `name`, `description`, `groupe`, `creation_date`, `update_date`, `slug`) VALUES
(21, 2, 'Mute', 'saisie de la carre frontside de la planche entre les deux pieds avec la main avant ;', 'grabs', '2023-10-01', NULL, 'Mute'),
(22, 2, '360', 'trois six pour un tour complet', 'rotations', '2023-10-01', NULL, '360'),
(23, 2, '720', 'sept deux pour deux tours complets', 'rotations', '2023-10-01', NULL, '720'),
(24, 2, 'front flip', 'Un flip vers l\'avant', 'flips', '2023-10-01', '2023-10-01', 'front-flip'),
(25, 2, 'rotations désaxées', 'rotation initialement horizontale mais lancée avec un mouvement des épaules particulier qui désaxe la rotation', 'rotations désaxées', '2023-10-01', '2023-10-01', 'rotations-desaxees'),
(26, 2, 'rodeo', 'rotation initialement horizontale mais lancée avec un mouvement des épaules particulier qui désaxe la rotation', 'grabs', '2023-10-01', NULL, 'rodeo');

--
-- Déchargement des données de la table `media`
--

INSERT INTO `media` (`id`, `figure_id`, `media_path`, `groupe`, `first_media`) VALUES
(88, 21, 'uploads/tricksBanner/65196af45cf93.jpg', 'photo', 1),
(89, 21, 'uploads/tricksPhoto/21-65196b0abb368.jpg', 'photo', 0),
(90, 21, 'uploads/tricksPhoto/21-65196b10e59f1.jpg', 'photo', 0),
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
(104, 26, 'uploads/tricksBanner/65196fce32b24.jpg', 'photo', 1),
(106, 26, 'k6aOWf0LDcQ', 'video', 0);

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `picture_path`, `email`, `is_verified`) VALUES
(2, 'matt_del', '[]', '$2y$13$bw7PNdLvMWgA34uRXtie5e6dq3TxPMAEf9kQl1Q1pvtgG9siCe0F6', NULL, 'matthieu.delacre@yahoo.fr', 1),
(4, 'SnowRiderz', '[]', '$2y$13$DXpSVgZVMBPxKNCAI0K72.OW89gnAq.qiMosvKwqXGVGyLAPcFZLu', NULL, 'stazdelacre@gmail.com', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
