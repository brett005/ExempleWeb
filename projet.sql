-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 05 jan. 2018 à 21:33
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`, `description`) VALUES
(1, 'Alimentaire', 'Tous types d\'aliments'),
(2, 'Service', 'Tous types de services'),
(3, 'Matériel', 'Tous types de matériel'),
(4, 'Custom', 'Vas voir ce que c\'est'),
(5, 'Autre', 'Ce qui va nullepart');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `lien_commande`
--

DROP TABLE IF EXISTS `lien_commande`;
CREATE TABLE IF NOT EXISTS `lien_commande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_commande` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `id_livraison` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-lcommande_produit` (`id_produit`),
  KEY `fk-lcommande_commande` (`id_commande`),
  KEY `fk-lcommande_livraison` (`id_livraison`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `lien_livraison_produit`
--

DROP TABLE IF EXISTS `lien_livraison_produit`;
CREATE TABLE IF NOT EXISTS `lien_livraison_produit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produit` int(20) NOT NULL,
  `id_livraison` int(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk-livraison_produit` (`id_produit`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `lien_livraison_produit`
--

INSERT INTO `lien_livraison_produit` (`id`, `id_produit`, `id_livraison`) VALUES
(1, 1, 1),
(2, 1, 3),
(3, 2, 1),
(4, 3, 1),
(5, 4, 2),
(6, 5, 1),
(9, 9, 3),
(10, 10, 2);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `prix` float NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  `description_livraison` varchar(255) NOT NULL,
  `unite` varchar(255) DEFAULT NULL,
  `unite2` varchar(255) DEFAULT NULL,
  `estim` float NOT NULL DEFAULT '1',
  `image` text,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `fk-produi_categorie` (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `nom`, `description`, `prix`, `id_user`, `id_categorie`, `description_livraison`, `unite`, `unite2`, `estim`, `image`) VALUES
(1, 'Chaise', 'Belle chaise en bois et osier faite par mes soins', 40, 2, 3, 'Livraison par transporteur privé', 'unité', 'unité', 1, NULL),
(2, 'Orange', 'Belles oranges de mon jardin', 2.1, 3, 1, 'Je livre les orange à vélo, délais de livraison : 1 semaine', 'kg', 'kg', 1, './public/img/2.jpg'),
(3, 'Cerise', 'Bonnes cerises juteuses de mon jardin', 4.3, 3, 1, 'Pas de livraison dans le sud de la France', 'kg', 'kg', 1, './public/img/3.jpg'),
(4, 'Navet', 'Légumes bios', 2.5, 3, 2, 'Déplacez-vous', 'kg', 'kg', 1, NULL),
(5, 'Poulet', 'Poulets bien dodus', 5, 3, 1, ' Livraison par la poste', 'unité', 'kg', 1.5, NULL),
(9, 'Coton tiges', 'Je vend des cotons tiges de très bonne qualité', 0.02, 1, 3, 'Décision au cas par cas', 'm', 'unité', 100.01, './public/img/9.jpg'),
(10, 'Chausettes', 'Je vend des chaussettes de sport', 2, 1, 3, 'Déplacez vous', 'unité', 'unité', 1, './public/img/10.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `professionnel`
--

DROP TABLE IF EXISTS `professionnel`;
CREATE TABLE IF NOT EXISTS `professionnel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` text NOT NULL,
  `adresse` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `professionnel`
--

INSERT INTO `professionnel` (`id`, `nom`, `email`, `pass`, `adresse`) VALUES
(1, 'M.Maréchal', 'marechal.projetdeweb@mail.com', 'xxxxxxx', '25 rue du Maréchal, Metz'),
(2, 'M.Robert', 'robert.projetdeweb@mail.com', 'xxxxxxx', '54 rue de Paris, Lyon'),
(3, 'Simon', 'simon.projetdeweb@mail.com', 'xxxxxxx', '36 rue de Pologne, Nancy'),
(4, 'Louis', 'louis@gmail.com', 'blabla', '666 rue st Louis, Quimper');

-- --------------------------------------------------------

--
-- Structure de la table `type_livraison`
--

DROP TABLE IF EXISTS `type_livraison`;
CREATE TABLE IF NOT EXISTS `type_livraison` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libellé` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `type_livraison`
--

INSERT INTO `type_livraison` (`id`, `libellé`) VALUES
(1, 'Livraison à domicile'),
(2, 'A venir chercher'),
(3, 'Contacte le client');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `fk-produi_categorie` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk-produi_user` FOREIGN KEY (`id_user`) REFERENCES `professionnel` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
