-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 20 jan. 2023 à 05:28
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sae_s3_internkeep`
--

-- --------------------------------------------------------

--
-- Structure de la table `bos`
--

DROP TABLE IF EXISTS `bos`;
CREATE TABLE IF NOT EXISTS `bos` (
  `bos_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `document_id` int(11) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `bos_flag` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`bos_id`),
  UNIQUE KEY `bos_id` (`bos_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `commentaire_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `visibilite_flag` int(11) DEFAULT NULL,
  `enseignant_id` int(11) DEFAULT NULL,
  `document_id` int(11) DEFAULT NULL,
  `vue_flag` tinyint(1) DEFAULT NULL,
  `commentaire` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`commentaire_id`),
  UNIQUE KEY `commentaire_id` (`commentaire_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`commentaire_id`, `visibilite_flag`, `enseignant_id`, `document_id`, `vue_flag`, `commentaire`) VALUES
(1, NULL, NULL, NULL, NULL, 'je veux pas faire ca'),
(2, NULL, NULL, NULL, NULL, 'lol'),
(3, NULL, NULL, NULL, NULL, 'mdr'),
(4, NULL, NULL, NULL, NULL, 'hey');

-- --------------------------------------------------------

--
-- Structure de la table `document`
--

DROP TABLE IF EXISTS `document`;
CREATE TABLE IF NOT EXISTS `document` (
  `document_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(20) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `date_heure` timestamp NULL DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `version` int(11) DEFAULT NULL,
  PRIMARY KEY (`document_id`),
  UNIQUE KEY `document_id` (`document_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `document`
--

INSERT INTO `document` (`document_id`, `type`, `student_id`, `date_heure`, `url`, `version`) VALUES
(1, 'sae.zip', 213, NULL, 'files/sae.zip', NULL),
(2, 'CV_English.pdf', 213, NULL, 'files/CV_English.pdf', NULL),
(3, 'SAE_ATHOS.docx', 213, NULL, 'files/SAE_ATHOS.docx', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

DROP TABLE IF EXISTS `entreprise`;
CREATE TABLE IF NOT EXISTS `entreprise` (
  `entreprise_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `adresse` varchar(100) DEFAULT NULL,
  `telephone` int(11) DEFAULT NULL,
  `lieu` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`entreprise_id`),
  UNIQUE KEY `entreprise_id` (`entreprise_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

DROP TABLE IF EXISTS `etudiant`;
CREATE TABLE IF NOT EXISTS `etudiant` (
  `student_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) DEFAULT NULL,
  `prenom` varchar(30) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `stage_detention` tinyint(1) DEFAULT NULL,
  `visibility_flag` tinyint(1) DEFAULT NULL,
  `entreprise_id` int(11) DEFAULT NULL,
  `groupe` varchar(30) DEFAULT NULL,
  `personnel_id` int(11) DEFAULT NULL,
  `formation_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `student_id` (`student_id`)
) ENGINE=MyISAM AUTO_INCREMENT=216 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`student_id`, `nom`, `prenom`, `mail`, `stage_detention`, `visibility_flag`, `entreprise_id`, `groupe`, `personnel_id`, `formation_id`) VALUES
(213, 'LADDADA', 'Anis', 'anisladdada@gmail.com', NULL, NULL, NULL, 'Athos', NULL, NULL),
(214, 'LAZAR', 'Moahamed', 'Mohamedlazar@gmail.com', NULL, NULL, NULL, 'Athos', NULL, NULL),
(215, 'ELABASY ', 'Amgad', 'amgadelabasy@gmail.com', NULL, NULL, NULL, 'Athos', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

DROP TABLE IF EXISTS `formation`;
CREATE TABLE IF NOT EXISTS `formation` (
  `formation_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `departement` varchar(50) DEFAULT NULL,
  `composante` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`formation_id`),
  UNIQUE KEY `formation_id` (`formation_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `username` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `role` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `login`
--

INSERT INTO `login` (`username`, `password`, `user_id`, `role`) VALUES
('anisladdada@gmail.com', 'Bac20.21', 213, 'Etudiant'),
('Prof', 'Prof', 111, 'professeur'),
('Mohamedlazar@gmail.com', 'momo', 214, 'Etudiant'),
('amgadelabassy@gmail.com', 'momo', 215, 'Etudiant');

-- --------------------------------------------------------

--
-- Structure de la table `personnel`
--

DROP TABLE IF EXISTS `personnel`;
CREATE TABLE IF NOT EXISTS `personnel` (
  `personnel_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) DEFAULT NULL,
  `prenom` varchar(30) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `visibility_flag` tinyint(1) DEFAULT NULL,
  `role` varchar(30) DEFAULT NULL,
  `formation_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`personnel_id`),
  UNIQUE KEY `personnel_id` (`personnel_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `stage`
--

DROP TABLE IF EXISTS `stage`;
CREATE TABLE IF NOT EXISTS `stage` (
  `stage_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `mission` varchar(200) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `annee` int(11) DEFAULT NULL,
  `personnel_id` int(11) DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `tuteur_id` int(11) DEFAULT NULL,
  `gratification` tinyint(1) DEFAULT NULL,
  `teletravail` int(11) DEFAULT NULL,
  PRIMARY KEY (`stage_id`),
  UNIQUE KEY `stage_id` (`stage_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tuteur`
--

DROP TABLE IF EXISTS `tuteur`;
CREATE TABLE IF NOT EXISTS `tuteur` (
  `tuteur_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) DEFAULT NULL,
  `entreprise_id` int(11) DEFAULT NULL,
  `prenom` varchar(30) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`tuteur_id`),
  UNIQUE KEY `tuteur_id` (`tuteur_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
