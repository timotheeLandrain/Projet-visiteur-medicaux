-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 09 Novembre 2015 à 15:24
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `gsb_frais`
--

-- --------------------------------------------------------

--
-- Structure de la table `cabinet`
--

CREATE TABLE IF NOT EXISTS `cabinet` (
  `idCabinet` int(11) NOT NULL,
  `rue` char(40) NOT NULL,
  `ville` char(15) NOT NULL,
  `codePostal` int(8) NOT NULL,
  PRIMARY KEY (`idCabinet`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `cabinet`
--

INSERT INTO `cabinet` (`idCabinet`, `rue`, `ville`, `codePostal`) VALUES
(1, 'de Gaulle', 'nantes', 44000),
(2, 'Edith Piaf', 'St Nazaire', 44600);

-- --------------------------------------------------------

--
-- Structure de la table `delegue`
--

CREATE TABLE IF NOT EXISTS `delegue` (
  `idDel` int(11) NOT NULL,
  `idRH` int(11) NOT NULL,
  PRIMARY KEY (`idDel`),
  KEY `idRH` (`idRH`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `delegue`
--

INSERT INTO `delegue` (`idDel`, `idRH`) VALUES
(1, 28),
(12, 28),
(37, 28),
(41, 28),
(50, 28),
(51, 28),
(52, 28),
(53, 28);

-- --------------------------------------------------------

--
-- Structure de la table `entretenir`
--

CREATE TABLE IF NOT EXISTS `entretenir` (
  `id` int(11) NOT NULL,
  `idVisiteur` int(11) NOT NULL,
  `idDel` int(11) NOT NULL,
  `commentaires` char(40) NOT NULL,
  `notes` char(11) NOT NULL,
  `Date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idVisiteur` (`idVisiteur`,`idDel`),
  KEY `INDEX` (`idDel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `entretenir`
--

INSERT INTO `entretenir` (`id`, `idVisiteur`, `idDel`, `commentaires`, `notes`, `Date`) VALUES
(1, 3, 12, 'Entretien salariale', '', '2015-11-02'),
(2, 29, 37, 'Faute professionel', '', '2015-11-19'),
(3, 6, 12, 'bla', 'pouet', '2016-01-15');

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

CREATE TABLE IF NOT EXISTS `etat` (
  `id` char(2) NOT NULL,
  `libelle` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `etat`
--

INSERT INTO `etat` (`id`, `libelle`) VALUES
('CL', 'Saisie clôturée'),
('CR', 'Fiche créée, saisie en cours'),
('RB', 'Remboursée'),
('VA', 'Validée et mise en paiement');

-- --------------------------------------------------------

--
-- Structure de la table `fichefrais`
--

CREATE TABLE IF NOT EXISTS `fichefrais` (
  `idVisiteur` int(4) NOT NULL,
  `mois` char(6) NOT NULL,
  `nbJustificatifs` int(11) DEFAULT NULL,
  `montantValide` decimal(10,2) DEFAULT NULL,
  `dateModif` date DEFAULT NULL,
  `idEtat` char(2) DEFAULT 'CR',
  PRIMARY KEY (`idVisiteur`,`mois`),
  KEY `idEtat` (`idEtat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `fichefrais`
--

INSERT INTO `fichefrais` (`idVisiteur`, `mois`, `nbJustificatifs`, `montantValide`, `dateModif`, `idEtat`) VALUES
(0, '201509', 0, NULL, '2015-09-30', 'CR'),
(2, '201510', 0, NULL, '2015-11-09', 'CL'),
(2, '201511', 0, NULL, '2015-11-09', 'CR'),
(17, '201505', 0, NULL, '2015-05-05', 'CR'),
(17, '201509', 0, NULL, '2015-09-09', 'CR'),
(28, '201511', 0, NULL, '2015-11-09', 'CR');

-- --------------------------------------------------------

--
-- Structure de la table `fraisforfait`
--

CREATE TABLE IF NOT EXISTS `fraisforfait` (
  `id` char(3) NOT NULL,
  `libelle` char(20) DEFAULT NULL,
  `montant` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `fraisforfait`
--

INSERT INTO `fraisforfait` (`id`, `libelle`, `montant`) VALUES
('ETP', 'Forfait Etape', '110.00'),
('KM', 'Frais Kilométrique', '0.62'),
('NUI', 'Nuitée Hôtel', '80.00'),
('REP', 'Repas Restaurant', '25.00');

-- --------------------------------------------------------

--
-- Structure de la table `lignefraisforfait`
--

CREATE TABLE IF NOT EXISTS `lignefraisforfait` (
  `idVisiteur` int(4) NOT NULL,
  `mois` char(6) NOT NULL,
  `idFraisForfait` char(3) NOT NULL,
  `quantite` int(11) DEFAULT NULL,
  PRIMARY KEY (`idVisiteur`,`mois`,`idFraisForfait`),
  KEY `idFraisForfait` (`idFraisForfait`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `lignefraisforfait`
--

INSERT INTO `lignefraisforfait` (`idVisiteur`, `mois`, `idFraisForfait`, `quantite`) VALUES
(0, '201509', 'ETP', 0),
(0, '201509', 'KM', 0),
(0, '201509', 'NUI', 0),
(0, '201509', 'REP', 0),
(2, '201510', 'ETP', 0),
(2, '201510', 'KM', 0),
(2, '201510', 'NUI', 0),
(2, '201510', 'REP', 0),
(2, '201511', 'ETP', 0),
(2, '201511', 'KM', 0),
(2, '201511', 'NUI', 0),
(2, '201511', 'REP', 0),
(17, '201505', 'ETP', 0),
(17, '201505', 'KM', 0),
(17, '201505', 'NUI', 0),
(17, '201505', 'REP', 0),
(17, '201509', 'ETP', 0),
(17, '201509', 'KM', 0),
(17, '201509', 'NUI', 0),
(17, '201509', 'REP', 0),
(28, '201511', 'ETP', 0),
(28, '201511', 'KM', 0),
(28, '201511', 'NUI', 0),
(28, '201511', 'REP', 0);

-- --------------------------------------------------------

--
-- Structure de la table `lignefraishorsforfait`
--

CREATE TABLE IF NOT EXISTS `lignefraishorsforfait` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idVisiteur` int(4) NOT NULL,
  `mois` char(6) NOT NULL,
  `libelle` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idVisiteur` (`idVisiteur`,`mois`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `lignefraishorsforfait`
--

INSERT INTO `lignefraishorsforfait` (`id`, `idVisiteur`, `mois`, `libelle`, `date`, `montant`) VALUES
(1, 0, '201509', 'la fiche pas frais', '2015-08-02', '355.00'),
(2, 28, '201511', 'la fiche pas frais', '2015-08-02', '355.00');

-- --------------------------------------------------------

--
-- Structure de la table `medecin`
--

CREATE TABLE IF NOT EXISTS `medecin` (
  `idMed` int(11) NOT NULL,
  `nom` char(20) NOT NULL,
  `prenom` char(20) NOT NULL,
  `telephone` char(20) NOT NULL,
  `idVisiteur` int(11) NOT NULL,
  `idCabinet` int(11) NOT NULL,
  PRIMARY KEY (`idMed`),
  KEY `idVisiteur` (`idVisiteur`,`idCabinet`),
  KEY `INDEX` (`idCabinet`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `personnel`
--

CREATE TABLE IF NOT EXISTS `personnel` (
  `id` int(4) NOT NULL,
  `nom` char(30) DEFAULT NULL,
  `prenom` char(30) DEFAULT NULL,
  `login` char(20) DEFAULT NULL,
  `mdp` char(20) DEFAULT NULL,
  `adresse` char(30) DEFAULT NULL,
  `cp` char(5) DEFAULT NULL,
  `ville` char(30) DEFAULT NULL,
  `dateEmbauche` date DEFAULT NULL,
  `idZone` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idZone` (`idZone`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `personnel`
--

INSERT INTO `personnel` (`id`, `nom`, `prenom`, `login`, `mdp`, `adresse`, `cp`, `ville`, `dateEmbauche`, `idZone`) VALUES
(1, 'Villechalane', 'Louis', 'lvillachane', 'jux7g', '8 rue des Charmes', '46000', 'Cahors', '2005-12-21', 22),
(2, 'Andre', 'David', 'dandre', 'oppg5', '1 rue Petit', '46200', 'Lalbenque', '1998-11-23', NULL),
(3, 'Bedos', 'Christian', 'cbedos', 'gmhxd', '1 rue Peranud', '46250', 'Montcuq', '1995-01-12', NULL),
(5, 'Bentot', 'Pascal', 'pbentot', 'doyw1', '11 allée des Cerises', '46512', 'Bessines', '1992-07-09', NULL),
(6, 'Bioret', 'Luc', 'lbioret', 'hrjfs', '1 Avenue gambetta', '46000', 'Cahors', '1998-05-11', NULL),
(7, 'Bunisset', 'Francis', 'fbunisset', '4vbnd', '10 rue des Perles', '93100', 'Montreuil', '1987-10-21', NULL),
(8, 'Bunisset', 'Denise', 'dbunisset', 's1y1r', '23 rue Manin', '75019', 'paris', '2010-12-05', NULL),
(9, 'Cacheux', 'Bernard', 'bcacheux', 'uf7r3', '114 rue Blanche', '75017', 'Paris', '2009-11-12', NULL),
(10, 'Cadic', 'Eric', 'ecadic', '6u8dc', '123 avenue de la République', '75011', 'Paris', '2008-09-23', NULL),
(11, 'Charoze', 'Catherine', 'ccharoze', 'u817o', '100 rue Petit', '75019', 'Paris', '2005-11-12', NULL),
(12, 'Clepkens', 'Christophe', 'cclepkens', 'bw1us', '12 allée des Anges', '93230', 'Romainville', '2003-08-11', 1),
(13, 'Cottin', 'Vincenne', 'vcottin', '2hoh9', '36 rue Des Roches', '93100', 'Monteuil', '2001-11-18', NULL),
(14, 'Daburon', 'François', 'fdaburon', '7oqpv', '13 rue de Chanzy', '94000', 'Créteil', '2002-02-11', NULL),
(15, 'De', 'Philippe', 'pde', 'gk9kx', '13 rue Barthes', '94000', 'Créteil', '2010-12-14', NULL),
(16, 'Debelle', 'Michel', 'mdebelle', 'od5rt', '181 avenue Barbusse', '93210', 'Rosny', '2006-11-23', NULL),
(17, 'Debelle', 'Jeanne', 'jdebelle', 'nvwqq', '134 allée des Joncs', '44000', 'Nantes', '2000-05-11', NULL),
(18, 'Debroise', 'Michel', 'mdebroise', 'sghkb', '2 Bld Jourdain', '44000', 'Nantes', '2001-04-17', NULL),
(19, 'Desmarquest', 'Nathalie', 'ndesmarquest', 'f1fob', '14 Place d Arc', '45000', 'Orléans', '2005-11-12', NULL),
(20, 'Desnost', 'Pierre', 'pdesnost', '4k2o5', '16 avenue des Cèdres', '23200', 'Guéret', '2001-02-05', NULL),
(21, 'Dudouit', 'Frédéric', 'fdudouit', '44im8', '18 rue de l église', '23120', 'GrandBourg', '2000-08-01', NULL),
(22, 'Duncombe', 'Claude', 'cduncombe', 'qf77j', '19 rue de la tour', '23100', 'La souteraine', '1987-10-10', NULL),
(23, 'Enault-Pascreau', 'Céline', 'cenault', 'y2qdu', '25 place de la gare', '23200', 'Gueret', '1995-09-01', NULL),
(24, 'Eynde', 'Valérie', 'veynde', 'i7sn3', '3 Grand Place', '13015', 'Marseille', '1999-11-01', NULL),
(25, 'Finck', 'Jacques', 'jfinck', 'mpb3t', '10 avenue du Prado', '13002', 'Marseille', '2001-11-10', NULL),
(26, 'Frémont', 'Fernande', 'ffremont', 'xs5tq', '4 route de la mer', '13012', 'Allauh', '1998-10-01', NULL),
(27, 'Gest', 'Alain', 'agest', 'dywvt', '30 avenue de la mer', '13025', 'Berre', '1985-11-01', NULL),
(28, 'Chazal', 'Claire', 'cchazal', 'mdp', '48 boulevard milet', '44300', 'Nantes', '2015-09-09', NULL),
(29, 'eraud', 'clément', 'ceraud', 'plop', 'azeaiezaie', '44700', 'clementvil', '2000-08-20', NULL),
(34, 'landrain', 'timothee', 'tlandrain', 'plop', 'blabla', '44300', 'nantes', '2000-08-20', NULL),
(35, 'veslin', 'benjamin', 'bveslin', 'plop', 'rue du benjamin', '44500', 'benjaminville', '2000-08-20', NULL),
(36, 'veslin', 'benjamin', 'bveslin', 'plop', 'rue du benjamin', '44500', 'benjaminville', '2000-08-20', NULL),
(37, 'landrain', 'timothee', 'tlandrain', 'plop', 'blabla', '44300', 'nantes', '2000-08-20', NULL),
(38, 'picard', 'clément', 'cpicard', 'RODO', 'azeaiezaie', '44700', 'clementvil', '2015-09-21', NULL),
(39, 'picard', 'clément', 'cpicard', 'RODO', 'azeaiezaie', '44700', 'clementvil', '2015-09-21', NULL),
(40, 'veslin', 'benjamin', 'bveslin', 'plop', 'rue du benjamin', '44500', 'benjaminville', '2000-08-20', 1),
(41, 'angeli', 'martin', 'mangeli', 'plop', 'ploplo', '44703', 'martincity', '2000-08-20', 1),
(42, 'boutin', 'christine', 'cboutin', 'blabla', '44 boulevard des poilus', '55000', 'nantes', '2000-08-20', 16),
(43, 'dupond', 'jean', 'jdupond', 'eraud', '44 boulevard des poilus', '88900', 'st nazaore', '2000-08-20', 9),
(44, 'dupond', 'jean', 'jdupond', 'eraud', '44 boulevard des poilus', '88900', 'st nazaore', '2000-08-20', 9),
(45, 'dupond', 'jean', 'jdupond', 'eraud', '44 boulevard des poilus', '88900', 'st nazaore', '2000-08-20', 9),
(46, 'veslin', 'benjamin', 'bveslin', 'blabla', 'rue du benjamin', '44500', 'benjaminville', '1993-08-20', 18),
(47, 'dupond', 'jean', 'jdupond', 'eraud', '44 boulevard des poilus', '88900', 'st nazaore', '2000-08-20', 9),
(48, 'picard', 'clément', 'cpicard', 'plop', 'azeaiezaie', '44700', 'clementvil', '2000-08-20', 1),
(49, 'landrain', 'timothee', 'tlandrain', 'eraud', 'blabla', '44300', 'nantes', '1993-08-20', 7),
(50, 'landrain', 'timothee', 'tlandrain', 'eraud', 'blabla', '44300', 'nantes', '1993-08-20', 7),
(51, 'landrain', 'timothee', 'tlandrain', 'eraud', 'blabla', '44300', 'nantes', '1993-08-20', 7),
(52, 'dupond', 'jean', 'jdupond', 'benjamin', '44 boulevard des poilus', '88900', 'st nazaore', '2000-08-20', 21),
(53, 'Letallec', 'George', 'GLetallec', 'blabla', '25 rue des pissenlits', '44700', 'st etienne', '2015-09-21', 18);

-- --------------------------------------------------------

--
-- Structure de la table `rh`
--

CREATE TABLE IF NOT EXISTS `rh` (
  `id` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `rh`
--

INSERT INTO `rh` (`id`) VALUES
(28);

-- --------------------------------------------------------

--
-- Structure de la table `visiteur`
--

CREATE TABLE IF NOT EXISTS `visiteur` (
  `idPers` int(11) NOT NULL,
  `idDel` int(11) DEFAULT NULL,
  PRIMARY KEY (`idPers`),
  KEY `idDel` (`idDel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `visiteur`
--

INSERT INTO `visiteur` (`idPers`, `idDel`) VALUES
(38, NULL),
(39, NULL),
(40, NULL),
(1, 1),
(2, 1),
(3, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(29, 1),
(34, 1),
(35, 1),
(36, 12),
(37, 12),
(41, 12),
(52, 52),
(53, 53);

-- --------------------------------------------------------

--
-- Structure de la table `zone`
--

CREATE TABLE IF NOT EXISTS `zone` (
  `id` int(11) NOT NULL,
  `region` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `zone`
--

INSERT INTO `zone` (`id`, `region`) VALUES
(1, 'Alsace'),
(2, 'Aquitaine'),
(3, 'Basse-Normandie'),
(4, 'Bourgogne'),
(5, 'Centre'),
(6, 'Champagne-Ardenne'),
(7, 'Corse'),
(8, 'Franche-Compté'),
(9, 'Haute-Normandie'),
(10, 'Ile-de-France'),
(11, 'Languedoc-Roussillon'),
(12, 'Limousin'),
(13, 'Lorraine'),
(14, 'Midi-Pyrénées'),
(15, 'Nord-Pas-de-Calais'),
(16, 'Pays de la Loire'),
(17, 'Picardie'),
(18, 'Poitou-Charentes'),
(19, 'Provence-Alpes-Côte d''Azur'),
(20, 'Rhone-Alpes'),
(21, 'Auvergne'),
(22, 'Bretagne');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `delegue`
--
ALTER TABLE `delegue`
  ADD CONSTRAINT `fk_personnel_delegue` FOREIGN KEY (`idDel`) REFERENCES `personnel` (`id`),
  ADD CONSTRAINT `fk_rh_delegue` FOREIGN KEY (`idRH`) REFERENCES `rh` (`id`);

--
-- Contraintes pour la table `entretenir`
--
ALTER TABLE `entretenir`
  ADD CONSTRAINT `fk_delegue_entretenir` FOREIGN KEY (`idDel`) REFERENCES `delegue` (`idDel`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_visiteur_entretenir` FOREIGN KEY (`idVisiteur`) REFERENCES `visiteur` (`idPers`) ON DELETE CASCADE;

--
-- Contraintes pour la table `fichefrais`
--
ALTER TABLE `fichefrais`
  ADD CONSTRAINT `fichefrais_ibfk_1` FOREIGN KEY (`idEtat`) REFERENCES `etat` (`id`);

--
-- Contraintes pour la table `lignefraisforfait`
--
ALTER TABLE `lignefraisforfait`
  ADD CONSTRAINT `lignefraisforfait_ibfk_1` FOREIGN KEY (`idVisiteur`, `mois`) REFERENCES `fichefrais` (`idVisiteur`, `mois`),
  ADD CONSTRAINT `lignefraisforfait_ibfk_2` FOREIGN KEY (`idFraisForfait`) REFERENCES `fraisforfait` (`id`);

--
-- Contraintes pour la table `lignefraishorsforfait`
--
ALTER TABLE `lignefraishorsforfait`
  ADD CONSTRAINT `lignefraishorsforfait_ibfk_1` FOREIGN KEY (`idVisiteur`, `mois`) REFERENCES `fichefrais` (`idVisiteur`, `mois`);

--
-- Contraintes pour la table `medecin`
--
ALTER TABLE `medecin`
  ADD CONSTRAINT `fk_cabinet_medecin` FOREIGN KEY (`idCabinet`) REFERENCES `cabinet` (`idCabinet`),
  ADD CONSTRAINT `fk_visiteur_cabinet` FOREIGN KEY (`idVisiteur`) REFERENCES `visiteur` (`idPers`);

--
-- Contraintes pour la table `personnel`
--
ALTER TABLE `personnel`
  ADD CONSTRAINT `fk_personnel_zone` FOREIGN KEY (`idZone`) REFERENCES `zone` (`id`);

--
-- Contraintes pour la table `visiteur`
--
ALTER TABLE `visiteur`
  ADD CONSTRAINT `fk_pers_del` FOREIGN KEY (`idDel`) REFERENCES `delegue` (`idDel`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pers_vist` FOREIGN KEY (`idPers`) REFERENCES `personnel` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
