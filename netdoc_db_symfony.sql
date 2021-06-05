-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 05 juin 2021 à 13:39
-- Version du serveur :  10.4.18-MariaDB
-- Version de PHP : 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `netdoc_db_symfony`
--

-- --------------------------------------------------------

--
-- Structure de la table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `appointment_patient_id` int(11) DEFAULT NULL,
  `appointment_doctor_id` int(11) DEFAULT NULL,
  `appointment_date` datetime NOT NULL,
  `appointment_duration` int(11) NOT NULL,
  `appointment_take_datetime` datetime DEFAULT NULL,
  `appointment_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `appointment`
--

INSERT INTO `appointment` (`id`, `appointment_patient_id`, `appointment_doctor_id`, `appointment_date`, `appointment_duration`, `appointment_take_datetime`, `appointment_status`) VALUES
(53, NULL, 6, '2021-11-05 14:25:00', 60, NULL, 1),
(54, NULL, 6, '2021-11-08 16:15:00', 60, NULL, 1),
(55, 7, 6, '2021-10-09 09:20:00', 60, NULL, 3),
(56, NULL, 6, '2021-10-15 17:00:00', 30, NULL, 1),
(57, NULL, 9, '2021-07-10 06:30:00', 120, NULL, 1),
(58, NULL, 9, '2021-07-15 06:30:00', 120, NULL, 1),
(59, NULL, 8, '2021-06-05 15:40:53', 45, NULL, 1),
(60, NULL, 8, '2021-06-20 07:00:00', 45, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `doctor`
--

CREATE TABLE `doctor` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `doctor_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doctor_lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doctor_complete_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doctor_birth` date NOT NULL,
  `doctor_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doctor_place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doctor_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `doctor`
--

INSERT INTO `doctor` (`id`, `user_id`, `doctor_name`, `doctor_lastname`, `doctor_complete_name`, `doctor_birth`, `doctor_phone`, `doctor_place`, `doctor_city`) VALUES
(6, 12, 'Dimitri', 'Dupond', 'Dimitri Dupond', '1981-06-05', '0600000000', '1 Rue du Lion', 'Rennes'),
(7, 13, 'Jeanne', 'Petit', 'Jeanne Petit', '1982-02-24', '0600000001', '15 Rue du Renard', 'Nantes'),
(8, 14, 'Louis', 'Da Silva', 'Louis Da Silva', '1986-11-13', '0600000002', '1 Lotissement du Sapin', 'Vannes'),
(9, 15, 'Camille', 'Quest', 'Camille Quest', '1990-12-09', '0600000003', '17 Lotissement du Lac', 'Vannes'),
(10, 16, 'Camille', 'Zen', 'Camille Zen', '1974-12-09', '0600000004', ' 2 Rue du Clair', 'Vannes');

-- --------------------------------------------------------

--
-- Structure de la table `doctor_domain`
--

CREATE TABLE `doctor_domain` (
  `doctor_id` int(11) NOT NULL,
  `domain_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `doctor_domain`
--

INSERT INTO `doctor_domain` (`doctor_id`, `domain_id`) VALUES
(6, 1),
(7, 2),
(8, 18),
(9, 18),
(9, 22),
(10, 19);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210429135414', '2021-04-29 15:54:20', 56),
('DoctrineMigrations\\Version20210429135753', '2021-04-29 15:58:18', 49),
('DoctrineMigrations\\Version20210429141304', '2021-04-29 16:13:11', 120),
('DoctrineMigrations\\Version20210430082002', '2021-04-30 10:20:10', 1652),
('DoctrineMigrations\\Version20210430083408', '2021-04-30 10:35:34', 46),
('DoctrineMigrations\\Version20210430084027', '2021-04-30 10:40:40', 221),
('DoctrineMigrations\\Version20210430084741', '2021-04-30 10:47:47', 94),
('DoctrineMigrations\\Version20210430085147', '2021-04-30 10:51:53', 48),
('DoctrineMigrations\\Version20210430090122', '2021-04-30 11:01:27', 49),
('DoctrineMigrations\\Version20210430095603', '2021-04-30 11:56:12', 90),
('DoctrineMigrations\\Version20210430110929', '2021-04-30 13:09:33', 86),
('DoctrineMigrations\\Version20210430130956', '2021-04-30 15:10:05', 105),
('DoctrineMigrations\\Version20210522161537', '2021-05-22 18:15:49', 324),
('DoctrineMigrations\\Version20210529102451', '2021-05-29 12:24:58', 729);

-- --------------------------------------------------------

--
-- Structure de la table `domain`
--

CREATE TABLE `domain` (
  `id` int(11) NOT NULL,
  `domain_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `domain`
--

INSERT INTO `domain` (`id`, `domain_name`) VALUES
(1, 'Dermatologue'),
(2, 'Kinésithérapeute'),
(17, 'Dentiste'),
(18, 'Médecin généraliste'),
(19, 'Algologue'),
(20, 'Ophtalmologue'),
(21, 'Podologue'),
(22, 'Médecin du sport');

-- --------------------------------------------------------

--
-- Structure de la table `jwt_refresh`
--

CREATE TABLE `jwt_refresh` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `jwtrefresh_value` varchar(650) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jwtrefresh_date_issued` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `jwt_refresh`
--

INSERT INTO `jwt_refresh` (`id`, `user_id`, `jwtrefresh_value`, `jwtrefresh_date_issued`) VALUES
(83, 17, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJyZWZyZXNoIiwiYXVkIjoicGF0aWVudCIsImlhdCI6MTYyMjg5OTg5OSwibmJmIjoxNjIyODk5ODk5LCJleHAiOjE2MzYwMzk4OTksImRhdGEiOnsiY29tcGxldGVfbmFtZSI6Ik1pY2hlbCBEdWJvaXMiLCJlbWFpbCI6Im1pY2hlbC5mYWtlQGZha2UuY29tIiwiaWQiOjE3LCJyb2xlcyI6WyJST0xFX1BBVElFTlQiLCJST0xFX1VTRVIiXX19.mrYVdW0npZb-7LFK3C43v7cTYdwHGQi9ESa2X3rDHPo', '2021-06-05 13:31:39');

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

CREATE TABLE `patient` (
  `id` int(11) NOT NULL,
  `patient_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_complete_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_birth` date NOT NULL,
  `patient_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `patient`
--

INSERT INTO `patient` (`id`, `patient_name`, `patient_lastname`, `patient_complete_name`, `patient_birth`, `patient_phone`, `user_id`) VALUES
(7, 'Michel', 'Dubois', 'Michel Dubois', '1974-12-15', '0600000005', 17),
(8, 'Claire', 'Toile', 'Claire Toile', '1998-08-26', '0600000006', 18);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_register` datetime NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `date_register`, `type`) VALUES
(12, 'dimitri.fake@fake.com', '[\"ROLE_DOCTOR\"]', '$2y$10$3sl03AyEOiO7MiNI1ArwMetqVcf0Xt3qVyBFfAiEtdgnFa.Uc9OsW', '2021-06-05 13:16:28', 'doctor'),
(13, 'jeanne.fake@fake.com', '[\"ROLE_DOCTOR\"]', '$2y$10$Ucj6ZlP8ovH.n2sHGsFHMOT5scmlqa5kW4D/3fVy6cDrkQBdSoqH6', '2021-06-05 13:17:54', 'doctor'),
(14, 'louis.fake@fake.com', '[\"ROLE_DOCTOR\"]', '$2y$10$Lhyr/mQtQ1/wC1QzAu51pu1EAnJvpoA0k9gDYo.iuEWnMq26.KHNK', '2021-06-05 13:19:08', 'doctor'),
(15, 'camille.fake@fake.com', '[\"ROLE_DOCTOR\"]', '$2y$10$E.0zTXUDcO2TDs5nbF9KZupVwJkKBCCUQcbLepeCOecqxGBeIbUay', '2021-06-05 13:20:32', 'doctor'),
(16, 'camille2.fake@fake.com', '[\"ROLE_DOCTOR\"]', '$2y$10$LsQW7N4X7KF9VzuZOXL0OuDhlEwXndnUU9zYYdi2p7OeQbgRLWkJq', '2021-06-05 13:22:04', 'doctor'),
(17, 'michel.fake@fake.com', '[\"ROLE_PATIENT\"]', '$2y$10$aBCb/xgAb3/dGINiywYvSebzmU5WBMeUY38ctix2pK6EQNTzeJiYG', '2021-06-05 13:22:58', 'patient'),
(18, 'claire.fake@fake.com', '[\"ROLE_PATIENT\"]', '$2y$10$RmsrISkyas.Nuo0l7bHMlu/1iO9uqpXhS19S43xF8kPkhEonfSpey', '2021-06-05 13:25:01', 'patient');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FE38F84412C0A0B3` (`appointment_patient_id`),
  ADD KEY `IDX_FE38F844127E951E` (`appointment_doctor_id`);

--
-- Index pour la table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1FC0F36AA76ED395` (`user_id`);

--
-- Index pour la table `doctor_domain`
--
ALTER TABLE `doctor_domain`
  ADD PRIMARY KEY (`doctor_id`,`domain_id`),
  ADD KEY `IDX_3352E8687F4FB17` (`doctor_id`),
  ADD KEY `IDX_3352E86115F0EE5` (`domain_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `domain`
--
ALTER TABLE `domain`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `jwt_refresh`
--
ALTER TABLE `jwt_refresh`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_11CDED87A76ED395` (`user_id`);

--
-- Index pour la table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1ADAD7EBA76ED395` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT pour la table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `domain`
--
ALTER TABLE `domain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `jwt_refresh`
--
ALTER TABLE `jwt_refresh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT pour la table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `FK_FE38F844127E951E` FOREIGN KEY (`appointment_doctor_id`) REFERENCES `doctor` (`id`),
  ADD CONSTRAINT `FK_FE38F84412C0A0B3` FOREIGN KEY (`appointment_patient_id`) REFERENCES `patient` (`id`);

--
-- Contraintes pour la table `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `FK_1FC0F36AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `doctor_domain`
--
ALTER TABLE `doctor_domain`
  ADD CONSTRAINT `FK_3352E86115F0EE5` FOREIGN KEY (`domain_id`) REFERENCES `domain` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_3352E8687F4FB17` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `jwt_refresh`
--
ALTER TABLE `jwt_refresh`
  ADD CONSTRAINT `FK_11CDED87A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `FK_1ADAD7EBA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
