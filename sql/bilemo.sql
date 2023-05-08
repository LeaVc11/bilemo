-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 08 mai 2023 à 20:58
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bilemo`
--

-- --------------------------------------------------------

--
-- Structure de la table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `customer`
--

INSERT INTO `customer` (`id`, `user_id`, `name`, `email`) VALUES
(1, 1, 'Alice Brun', 'franck.delorme@sfr.fr'),
(2, 1, 'Xavier Pruvost', 'mdesousa@club-internet.fr'),
(3, 1, 'Noël Jacquot', 'zacharie05@lombard.com'),
(4, 1, 'Adrienne Fernandez', 'emile.bertrand@gmail.com'),
(5, 1, 'Bertrand Petitjean', 'germain.antoine@besnard.fr'),
(6, 1, 'Christophe-Philippe Charpentier', 'colin.brigitte@philippe.org'),
(7, 1, 'Édouard Vidal', 'caroline.texier@free.fr'),
(8, 1, 'Agathe Millet-Bernard', 'lorraine31@raynaud.fr'),
(9, 1, 'Noël de la Francois', 'christophe.masse@noos.fr'),
(10, 1, 'Mathilde Dupont', 'lenoir.matthieu@live.com'),
(11, 1, 'Nicolas-Philippe Bodin', 'alves.tristan@club-internet.fr'),
(12, 1, 'Pierre Baron', 'eleonore.berthelot@live.com'),
(13, 1, 'Anne Aubert-Carpentier', 'jeannine.meunier@lucas.com'),
(14, 1, 'Benjamin Alves', 'sweber@tele2.fr'),
(15, 1, 'Agathe Dijoux', 'odette16@bertrand.com'),
(16, 1, 'Maryse Muller', 'arnaud.alfred@sfr.fr'),
(17, 1, 'Lorraine Hardy', 'chevallier.joseph@hotmail.fr'),
(18, 1, 'Hugues de la Thomas', 'tdeoliveira@laposte.net'),
(19, 1, 'Michelle Sauvage-Lemonnier', 'julien33@lucas.com'),
(20, 1, 'Stéphane Martel', 'paubry@sfr.fr'),
(21, 2, 'Madeleine Fischer', 'elisabeth82@charles.com'),
(22, 2, 'Stéphanie du Weiss', 'renard.augustin@delmas.com'),
(23, 2, 'Rémy Klein-Buisson', 'icordier@tele2.fr'),
(24, 2, 'Margot Carpentier', 'michaud.alfred@live.com'),
(25, 2, 'Lucas Pelletier', 'michelle.morin@bouvier.com'),
(26, 2, 'Daniel Martineau', 'marthe.fouquet@noos.fr'),
(27, 2, 'Michelle Dupre', 'rey.madeleine@rey.com'),
(28, 2, 'Roland Normand', 'thibaut.hardy@antoine.com'),
(29, 2, 'Eugène Lelievre', 'daniel.gauthier@tele2.fr'),
(30, 2, 'Manon Dupont', 'guillaume91@letellier.fr'),
(31, 2, 'Éléonore Brunel', 'xpruvost@voisin.fr'),
(32, 2, 'Gilbert Jourdan', 'odette56@gregoire.com'),
(33, 2, 'Richard Marie', 'franck75@laurent.com'),
(34, 2, 'Marine Pelletier', 'jjacquot@perez.com'),
(35, 2, 'Olivie Leduc', 'pottier.gregoire@maillot.com'),
(36, 2, 'Lucie Lacroix-Jacquet', 'arnaude.levy@jacquet.fr'),
(37, 2, 'Hortense Blondel', 'fouquet.matthieu@fontaine.fr'),
(38, 2, 'Matthieu Etienne', 'nmaillot@hamel.fr'),
(39, 2, 'Martine Barthelemy', 'renee33@noel.fr'),
(40, 2, 'Auguste Vallet', 'aubert.joseph@club-internet.fr'),
(41, 3, 'Richard-Roger Duval', 'adrien94@yahoo.fr'),
(42, 3, 'Nicolas Julien', 'bcharrier@live.com'),
(43, 3, 'Clémence Becker', 'tristan02@torres.org'),
(44, 3, 'Éléonore Le Lemaitre', 'noemi.dijoux@yahoo.fr'),
(45, 3, 'Chantal Traore', 'druiz@free.fr'),
(46, 3, 'Isaac Carre-Le Goff', 'philippe.buisson@gonzalez.org'),
(47, 3, 'Vincent Thierry', 'lorraine.raymond@laposte.net'),
(48, 3, 'Marguerite Lebreton', 'celine.jourdan@delattre.net'),
(49, 3, 'Thomas Menard', 'vidal.jacqueline@noos.fr'),
(50, 3, 'Franck Maillot', 'bailly.oceane@live.com'),
(51, 3, 'Odette Gautier', 'etienne.guillaume@camus.org'),
(52, 3, 'Yves Techer', 'jeannine.clerc@martinez.net'),
(53, 3, 'Julien Lambert', 'stephane02@michel.fr'),
(54, 3, 'Édouard Blanchet', 'alex.moreau@lenoir.com'),
(55, 3, 'Thibault Nicolas', 'luc.remy@menard.fr'),
(56, 3, 'Christine Lefevre-Munoz', 'laure.hamon@allain.org'),
(57, 3, 'Bernadette Baron', 'louis06@sfr.fr'),
(58, 3, 'Juliette-Louise Rodriguez', 'auguste84@laposte.net'),
(59, 3, 'Pierre Paul', 'wdacosta@bonneau.com'),
(60, 3, 'Éléonore Blanchard', 'thomas46@laposte.net'),
(61, 4, 'Élisabeth Hebert', 'berthelot.denis@laposte.net'),
(62, 4, 'Bernard Benard', 'oleroy@wanadoo.fr'),
(63, 4, 'Roland Richard', 'rlemoine@martineau.fr'),
(64, 4, 'Amélie Hernandez', 'antoine.thibault@valentin.net'),
(65, 4, 'Noémi Martineau', 'louis99@barre.org'),
(66, 4, 'Michel Pineau', 'francois.mahe@germain.fr'),
(67, 4, 'Michelle de Bonnet', 'daniel.cohen@deoliveira.fr'),
(68, 4, 'Jean Lelievre', 'fernandez.matthieu@marechal.com'),
(69, 4, 'Louis Huet', 'allard.theodore@gmail.com'),
(70, 4, 'Étienne Le Da Costa', 'bigot.diane@chauvin.fr'),
(71, 4, 'Alain Guibert-Levy', 'delorme.clemence@petitjean.fr'),
(72, 4, 'Alfred Clement', 'laetitia80@etienne.net'),
(73, 4, 'Bernard Perrot', 'uweiss@masson.fr'),
(74, 4, 'Dominique Gros', 'valerie19@laposte.net'),
(75, 4, 'Thomas-Charles Pierre', 'marthe06@dbmail.com'),
(76, 4, 'Benjamin-Roland Gaudin', 'olivier.faure@pinto.fr'),
(77, 4, 'Augustin Coste', 'vduhamel@pinto.org'),
(78, 4, 'Virginie Henry', 'bertrand79@live.com'),
(79, 4, 'Franck Riviere', 'jacques33@dbmail.com'),
(80, 4, 'Adrienne Pierre', 'zbodin@wanadoo.fr'),
(81, 5, 'Georges Barbe-Paul', 'juliette78@sfr.fr'),
(82, 5, 'Thérèse Normand', 'ppicard@toussaint.com'),
(83, 5, 'Adélaïde Le Germain', 'eugene.laurent@free.fr'),
(84, 5, 'Laurent-Rémy Traore', 'trenaud@gmail.com'),
(85, 5, 'Mathilde Munoz', 'acousin@gmail.com'),
(86, 5, 'Mathilde Foucher', 'vmercier@club-internet.fr'),
(87, 5, 'Isabelle-Marine Gauthier', 'guillot.michelle@club-internet.fr'),
(88, 5, 'Guy Guillon-Henry', 'bbaudry@lefebvre.fr'),
(89, 5, 'Adèle Reynaud', 'ulemaitre@fischer.org'),
(90, 5, 'Alphonse Joly', 'gilles96@vallee.fr'),
(91, 5, 'Yves de la Barbier', 'aurore.michaud@laposte.net'),
(92, 5, 'Guillaume Guillon', 'hamel.noel@yahoo.fr'),
(93, 5, 'Suzanne de Gosselin', 'loiseau.martin@fischer.com'),
(94, 5, 'Emmanuel Pinto', 'gabriel.dijoux@live.com'),
(95, 5, 'Zacharie Charpentier', 'margaud58@remy.com'),
(96, 5, 'Sabine Morin', 'carlier.louis@dbmail.com'),
(97, 5, 'Cécile de Vallet', 'roger.fernandez@carlier.com'),
(98, 5, 'Gilles Turpin-Robert', 'ulaurent@hotmail.fr'),
(99, 5, 'Hugues Pierre-Thibault', 'perez.olivie@orange.fr'),
(100, 5, 'Martin-Martin Da Costa', 'langlois.aurore@sfr.fr'),
(101, 6, 'Susanne-Manon Bruneau', 'frederique27@delmas.com'),
(102, 6, 'Martin de la Fontaine', 'auguste99@letellier.fr'),
(103, 6, 'Louis Gregoire', 'jean42@couturier.com'),
(104, 6, 'Alice Didier-Michaud', 'philippe12@yahoo.fr'),
(105, 6, 'Frédérique Noel', 'jacques96@laposte.net'),
(106, 6, 'Roger David', 'philippe.gabriel@sfr.fr'),
(107, 6, 'Michelle Pereira', 'jacques.marques@dbmail.com'),
(108, 6, 'Valérie Ollivier', 'bdesousa@tele2.fr'),
(109, 6, 'Anaïs Fontaine', 'michel.meyer@ledoux.com'),
(110, 6, 'Margot Philippe', 'mleduc@hotmail.fr'),
(111, 6, 'Jacques Allain', 'paul.genevieve@ferreira.com'),
(112, 6, 'Thomas Georges', 'danielle56@mace.fr'),
(113, 6, 'Charlotte Hubert', 'catherine12@pottier.fr'),
(114, 6, 'Denis Le Hernandez', 'stephanie28@colin.com'),
(115, 6, 'Margaux Guerin', 'alix.dumont@charrier.com'),
(116, 6, 'Mathilde Adam', 'diane.dias@live.com'),
(117, 6, 'Margaret Jacob', 'alex34@tele2.fr'),
(118, 6, 'Honoré Antoine', 'rperrin@tele2.fr'),
(119, 6, 'Jeannine Humbert', 'seguin.eugene@rousset.fr'),
(120, 6, 'Honoré Boucher-Chevallier', 'francois95@lopes.org'),
(121, 7, 'Noël-René Roy', 'amelie.monnier@roy.com'),
(122, 7, 'Pierre Sanchez', 'thibault.bousquet@laposte.net'),
(123, 7, 'Antoine Devaux', 'xgautier@moreau.fr'),
(124, 7, 'Susanne du Gay', 'thierry.perret@dbmail.com'),
(125, 7, 'Astrid Morin', 'rcamus@techer.net'),
(126, 7, 'Alphonse Gaudin-Reynaud', 'benoit27@club-internet.fr'),
(127, 7, 'Frédérique Bertrand', 'amelie.morel@renaud.fr'),
(128, 7, 'Mathilde de la Briand', 'ebenard@gmail.com'),
(129, 7, 'Alexandria Leclerc', 'vvoisin@guichard.com'),
(130, 7, 'Thierry Chevalier-Deschamps', 'emile.bodin@wanadoo.fr'),
(131, 7, 'Alain Charpentier-Bertrand', 'suzanne00@delmas.net'),
(132, 7, 'Lucie Hubert', 'michel45@hubert.fr'),
(133, 7, 'Alex-Dominique Rodriguez', 'rbuisson@maillard.com'),
(134, 7, 'Adrienne-Valérie Lelievre', 'mercier.raymond@free.fr'),
(135, 7, 'Patrick Jacquet', 'bigot.celine@hamon.net'),
(136, 7, 'Dominique Herve', 'millet.juliette@barbier.org'),
(137, 7, 'Charlotte du Pons', 'jlagarde@weiss.org'),
(138, 7, 'Gabrielle de Guillon', 'lacroix.margot@live.com'),
(139, 7, 'Benoît Pasquier', 'berger.astrid@traore.fr'),
(140, 7, 'Henri Delorme', 'georges.alain@noos.fr'),
(141, 8, 'Denis Gregoire-Gros', 'wandre@laposte.net'),
(142, 8, 'Roger Gonzalez', 'isaac.normand@orange.fr'),
(143, 8, 'Jules Nguyen', 'raynaud.guy@samson.com'),
(144, 8, 'Léon de la Valentin', 'elisabeth96@wanadoo.fr'),
(145, 8, 'Roger Ramos', 'maubert@dbmail.com'),
(146, 8, 'Lucas Jacquot-Carpentier', 'capucine.bouvier@faure.fr'),
(147, 8, 'Margaret Aubert', 'blombard@noos.fr'),
(148, 8, 'Lucas Alves-Morel', 'zdavid@hotmail.fr'),
(149, 8, 'Emmanuel de la Leblanc', 'robert62@verdier.fr'),
(150, 8, 'Lucie Laurent', 'joseph58@gerard.org'),
(151, 8, 'Charlotte Leduc-Turpin', 'voisin.alexandre@gay.fr'),
(152, 8, 'Emmanuelle de la Ramos', 'odelaunay@noos.fr'),
(153, 8, 'Maggie Riviere-Diallo', 'bouvet.vincent@free.fr'),
(154, 8, 'Gilbert-Laurent Barbe', 'riou.penelope@yahoo.fr'),
(155, 8, 'Céline Bertin', 'vaillant.olivier@free.fr'),
(156, 8, 'Thierry Bonneau', 'josephine.evrard@gerard.com'),
(157, 8, 'Anne-Maggie Sanchez', 'henriette.charles@millet.fr'),
(158, 8, 'Gabrielle Moreno', 'hortense.dumont@evrard.com'),
(159, 8, 'Arthur Le Roux', 'lemaire.gilles@bouvier.com'),
(160, 8, 'Agathe Antoine', 'henri.bouvet@lecomte.net'),
(161, 9, 'Frédéric-Alphonse Moulin', 'guillou.chantal@wanadoo.fr'),
(162, 9, 'Guillaume Lemoine', 'renault.auguste@tele2.fr'),
(163, 9, 'Sébastien Dupuy-Payet', 'benard.isaac@club-internet.fr'),
(164, 9, 'Denis Hoarau-Turpin', 'louise.marques@orange.fr'),
(165, 9, 'Jérôme Laporte', 'omunoz@garnier.com'),
(166, 9, 'Édith Le Valentin', 'guichard.bertrand@club-internet.fr'),
(167, 9, 'Alphonse de la De Sousa', 'odette.roche@colas.com'),
(168, 9, 'Claude Perret-Delaunay', 'zmarques@sfr.fr'),
(169, 9, 'Alain Lacroix-Arnaud', 'bertrand.marques@vasseur.com'),
(170, 9, 'Antoine Lejeune', 'hbarbe@yahoo.fr'),
(171, 9, 'Étienne-Arthur Charpentier', 'dijoux.marc@payet.fr'),
(172, 9, 'Nathalie Picard-Gilles', 'egauthier@gmail.com'),
(173, 9, 'Céline-Hélène Rocher', 'georges.gregoire@maillard.com'),
(174, 9, 'Christelle Maillot', 'bouvier.vincent@leduc.fr'),
(175, 9, 'Corinne Pires', 'wdupont@renault.net'),
(176, 9, 'Grégoire Dupuis', 'jacqueline08@lambert.org'),
(177, 9, 'Alexandre Bailly', 'fontaine.charles@meunier.fr'),
(178, 9, 'Léon du Techer', 'maurice72@orange.fr'),
(179, 9, 'Simone-Stéphanie Ferreira', 'dossantos.lucie@orange.fr'),
(180, 9, 'Étienne Roger', 'leon46@philippe.org'),
(181, 10, 'Gilbert de Meunier', 'guichard.elodie@voisin.fr'),
(182, 10, 'William Gaudin-Dupre', 'alphonse84@sfr.fr'),
(183, 10, 'André Leblanc', 'mpichon@martin.com'),
(184, 10, 'Odette Diallo', 'dumas.elisabeth@barbe.com'),
(185, 10, 'Eugène-Yves Lacombe', 'mteixeira@live.com'),
(186, 10, 'Josette Collin', 'renee75@gmail.com'),
(187, 10, 'Françoise Duhamel', 'ferreira.henri@free.fr'),
(188, 10, 'Olivier Becker-Neveu', 'laetitia72@gmail.com'),
(189, 10, 'Brigitte-Jacqueline Jacob', 'pages.suzanne@langlois.com'),
(190, 10, 'Noël Le Dufour', 'charles.manon@orange.fr'),
(191, 10, 'Hélène Le Meunier', 'gilbert.payet@hotmail.fr'),
(192, 10, 'Mathilde de Richard', 'luce.lejeune@courtois.fr'),
(193, 10, 'Adrienne-Laurence Delannoy', 'denis88@berger.org'),
(194, 10, 'Benoît Marion', 'hcarre@gautier.com'),
(195, 10, 'Sylvie Pages', 'leger.marianne@hotmail.fr'),
(196, 10, 'Anastasie Marin-Bernard', 'antoine.margaret@live.com'),
(197, 10, 'Alexandria Delmas-Martel', 'oceane93@laporte.com'),
(198, 10, 'Daniel Gomez', 'laurent.bousquet@free.fr'),
(199, 10, 'Martin Masson', 'bertrand65@pottier.com'),
(200, 10, 'Julien Bonneau', 'brigitte.lamy@begue.net'),
(201, 11, 'Brigitte Leduc', 'iriou@live.com'),
(202, 11, 'Michelle-Marie Briand', 'bpeltier@fleury.com'),
(203, 11, 'Luc-Laurent Carpentier', 'roland19@club-internet.fr'),
(204, 11, 'Franck-Grégoire Vincent', 'charlotte70@delahaye.com'),
(205, 11, 'Marthe Thibault-Leclerc', 'benoit68@francois.org'),
(206, 11, 'Maggie Durand', 'laure.salmon@chauvet.fr'),
(207, 11, 'Daniel de Charrier', 'boyer.nicole@marion.com'),
(208, 11, 'Michèle Leclercq', 'paul61@wanadoo.fr'),
(209, 11, 'Valentine Voisin', 'luce.blanchard@leclercq.com'),
(210, 11, 'Christine Dupuis', 'lucas.jacquot@fournier.fr'),
(211, 11, 'Jules Delahaye-Meyer', 'oceane.pelletier@munoz.fr'),
(212, 11, 'Alice Boulay', 'isaac92@prevost.net'),
(213, 11, 'François Ferrand', 'lmunoz@dupuis.com'),
(214, 11, 'Colette De Sousa-Allard', 'prevost.eugene@lucas.com'),
(215, 11, 'Pierre Dupre', 'victor.lecoq@noos.fr'),
(216, 11, 'Lucie Loiseau', 'oguillou@noos.fr'),
(217, 11, 'Anne Chevalier', 'rey.olivier@orange.fr'),
(218, 11, 'Louise Moreau-Lefebvre', 'framos@yahoo.fr'),
(219, 11, 'Geneviève Delaunay', 'fischer.thibaut@dbmail.com'),
(220, 11, 'Marthe Gaudin', 'marguerite.mace@hotmail.fr'),
(221, 12, 'Maggie Chauvin', 'maurice40@hotmail.fr'),
(222, 12, 'Hélène Roy', 'alain.joubert@guillou.com'),
(223, 12, 'Diane Leroux', 'robert62@sfr.fr'),
(224, 12, 'Robert du Bigot', 'hugues65@leblanc.fr'),
(225, 12, 'Adélaïde Hernandez', 'nrobin@godard.com'),
(226, 12, 'Alphonse Couturier', 'sleveque@laposte.net'),
(227, 12, 'Richard Henry', 'henri58@orange.fr'),
(228, 12, 'David Navarro-Chevallier', 'levy.edith@noos.fr'),
(229, 12, 'Monique Langlois', 'bertrand.patricia@sfr.fr'),
(230, 12, 'Alex Marin', 'noel.garnier@gmail.com'),
(231, 12, 'Marc Guillon', 'jdelannoy@dbmail.com'),
(232, 12, 'Marcel de la Laine', 'andre52@lombard.fr'),
(233, 12, 'Dorothée Fischer', 'ycollet@bailly.org'),
(234, 12, 'Alfred de la Blanchet', 'kchretien@free.fr'),
(235, 12, 'Catherine-Monique Ollivier', 'william.monnier@tele2.fr'),
(236, 12, 'Louis Riviere', 'colin.marcel@hotmail.fr'),
(237, 12, 'Margot Maillard', 'adrien20@bailly.com'),
(238, 12, 'Alfred de Roche', 'lroussel@yahoo.fr'),
(239, 12, 'Arthur-Zacharie Delahaye', 'richard.oceane@chauveau.com'),
(240, 12, 'Julien Perrin', 'marguerite.lebreton@pasquier.net'),
(241, 13, 'Josette Fabre', 'cordier.andree@orange.fr'),
(242, 13, 'Marguerite Boutin', 'alix.guichard@club-internet.fr'),
(243, 13, 'Claude Masson', 'eric24@legoff.com'),
(244, 13, 'Suzanne Gautier', 'alfred.rocher@weiss.org'),
(245, 13, 'Geneviève Rousset', 'isabelle.garnier@cordier.com'),
(246, 13, 'Guy Pineau', 'yjacquot@pichon.fr'),
(247, 13, 'Guillaume Baudry', 'marechal.josephine@tele2.fr'),
(248, 13, 'Adèle de la Roux', 'lucie08@moulin.fr'),
(249, 13, 'Alain Maillet', 'lmartineau@guerin.fr'),
(250, 13, 'Adèle Brunet-Masse', 'lucas11@samson.com'),
(251, 13, 'Colette Baudry', 'nicolas67@klein.com'),
(252, 13, 'Nathalie-Laure Arnaud', 'ucosta@wanadoo.fr'),
(253, 13, 'Véronique Maurice', 'tprevost@live.com'),
(254, 13, 'Isabelle-Monique Legendre', 'yguilbert@simon.org'),
(255, 13, 'Léon Schmitt', 'celine.delannoy@laposte.net'),
(256, 13, 'Isaac Thierry', 'bouvier.eugene@briand.net'),
(257, 13, 'Guillaume Aubert-Rousseau', 'philippe.constance@martineau.com'),
(258, 13, 'Laure Pascal-Pruvost', 'frederic20@perret.fr'),
(259, 13, 'Grégoire Coulon', 'lucas20@dbmail.com'),
(260, 13, 'Roland Vincent', 'noel.michele@hotmail.fr'),
(261, 14, 'Hélène de la Normand', 'joly.eric@valette.fr'),
(262, 14, 'Lucy Ledoux', 'isabelle89@hotmail.fr'),
(263, 14, 'Victoire Bonnin', 'helene.duval@wanadoo.fr'),
(264, 14, 'Roland Chartier', 'augustin77@marty.com'),
(265, 14, 'Emmanuelle Vasseur', 'benoit.vaillant@free.fr'),
(266, 14, 'Antoine Marion', 'gerard.martinez@dbmail.com'),
(267, 14, 'Auguste Berger', 'thomas57@laposte.net'),
(268, 14, 'Lucy Rodrigues', 'matthieu79@laposte.net'),
(269, 14, 'Michelle Le Dijoux', 'adrienne.gregoire@sfr.fr'),
(270, 14, 'Astrid de Martins', 'tristan28@hotmail.fr'),
(271, 14, 'Emmanuelle Cordier', 'daniel.dominique@michel.com'),
(272, 14, 'Emmanuel Faivre', 'gaudin.thierry@colas.fr'),
(273, 14, 'Denis Imbert', 'marcel.pages@lagarde.org'),
(274, 14, 'Joseph Guyot', 'hernandez.georges@vaillant.com'),
(275, 14, 'Richard de Chauveau', 'nath.guerin@pages.net'),
(276, 14, 'Thibault Normand', 'lorraine53@wanadoo.fr'),
(277, 14, 'Arthur du Leger', 'marthe.barre@hernandez.fr'),
(278, 14, 'Timothée Laurent', 'denis.mendes@marin.fr'),
(279, 14, 'Honoré Guillet', 'michel.besnard@gmail.com'),
(280, 14, 'Patricia-Laurence Roger', 'mahe.stephane@club-internet.fr'),
(281, 15, 'Danielle Martineau', 'imbert.gregoire@rolland.fr'),
(282, 15, 'Léon Chauvet', 'bvaillant@wanadoo.fr'),
(283, 15, 'Denise Brunel', 'vallet.sebastien@tele2.fr'),
(284, 15, 'Théophile Marques', 'andre.legros@dasilva.fr'),
(285, 15, 'Maggie Legrand', 'jean.giraud@hotmail.fr'),
(286, 15, 'Nath Robin', 'martin.leroux@carpentier.com'),
(287, 15, 'Christiane Martins-Teixeira', 'theophile.deschamps@chauveau.org'),
(288, 15, 'Marguerite de Chretien', 'fischer.monique@chauveau.fr'),
(289, 15, 'Mathilde Francois', 'gpinto@devaux.net'),
(290, 15, 'Thibaut Hebert', 'elodie.jourdan@club-internet.fr'),
(291, 15, 'Léon de Gilbert', 'edouard30@coste.fr'),
(292, 15, 'Noël du Camus', 'olivie51@sfr.fr'),
(293, 15, 'Charlotte Delannoy', 'patricia25@club-internet.fr'),
(294, 15, 'Maryse Bouvier', 'eleonore82@live.com'),
(295, 15, 'André Bonnin-Barre', 'ksamson@wanadoo.fr'),
(296, 15, 'Jacques Dumont', 'bmarie@rodriguez.com'),
(297, 15, 'Sophie Ruiz', 'robert79@rodriguez.com'),
(298, 15, 'Camille Lejeune', 'omartel@renaud.fr'),
(299, 15, 'Maurice Morel', 'joubert.joseph@rodriguez.fr'),
(300, 15, 'Marc Arnaud', 'philippe.madeleine@noos.fr'),
(301, 16, 'Françoise Chauvin-Ribeiro', 'scouturier@laposte.net'),
(302, 16, 'Xavier Charles', 'matthieu.dupuis@leclercq.fr'),
(303, 16, 'Sylvie Leduc', 'eric33@live.com'),
(304, 16, 'Adrienne Buisson', 'fchevallier@leleu.fr'),
(305, 16, 'Alexandrie Charpentier', 'wcolas@herve.net'),
(306, 16, 'Théodore-Arthur Fernandez', 'maillard.emmanuel@sfr.fr'),
(307, 16, 'Nathalie-Françoise Muller', 'monique.alexandre@yahoo.fr'),
(308, 16, 'Suzanne de la Mathieu', 'elucas@guillou.fr'),
(309, 16, 'Sylvie du Gillet', 'agnes87@dbmail.com'),
(310, 16, 'Jules-Claude Mace', 'michel.maryse@dbmail.com'),
(311, 16, 'Jacqueline du Lemaire', 'tdeschamps@turpin.com'),
(312, 16, 'André Brunet', 'qgomez@wanadoo.fr'),
(313, 16, 'Gabriel du Berger', 'emile89@hotmail.fr'),
(314, 16, 'Amélie Charrier', 'glegoff@gmail.com'),
(315, 16, 'Alexandrie Marechal', 'diane.garnier@bruneau.com'),
(316, 16, 'Zacharie Brunet', 'zoe.neveu@besnard.com'),
(317, 16, 'Anaïs Fleury', 'renee72@guyon.org'),
(318, 16, 'Alain Gautier', 'dupuis.elodie@bouchet.fr'),
(319, 16, 'Claude Le Goff', 'vsalmon@wanadoo.fr'),
(320, 16, 'Gilbert Maury', 'michel.guichard@tele2.fr'),
(321, 17, 'Léon Le Verdier', 'fpeltier@carpentier.org'),
(322, 17, 'Renée Dumont', 'availlant@club-internet.fr'),
(323, 17, 'Julie Francois', 'ngomes@yahoo.fr'),
(324, 17, 'Émilie Le Leroy', 'bertrand.coulon@huet.com'),
(325, 17, 'Claudine de Aubry', 'ichevallier@yahoo.fr'),
(326, 17, 'Noémi-Jeanne Vidal', 'hugues93@roche.com'),
(327, 17, 'Daniel Diallo', 'perret.marthe@yahoo.fr'),
(328, 17, 'Marc Descamps', 'pages.luce@leroux.net'),
(329, 17, 'Gilles Chauvin-Lejeune', 'gjacquet@free.fr'),
(330, 17, 'Zacharie Leconte', 'mlejeune@thibault.org'),
(331, 17, 'Daniel de la Fouquet', 'dlucas@sfr.fr'),
(332, 17, 'Valérie Blot-Barthelemy', 'thibaut79@yahoo.fr'),
(333, 17, 'Alex Gosselin', 'colin.marine@fournier.org'),
(334, 17, 'Élodie Le Perrot', 'collin.jeannine@brunet.net'),
(335, 17, 'Alfred Le Fabre', 'emmanuel38@pierre.net'),
(336, 17, 'Chantal du Guyot', 'michel.dacosta@live.com'),
(337, 17, 'François Fouquet', 'roux.thibaut@mahe.fr'),
(338, 17, 'René Turpin', 'bernier.martine@diaz.com'),
(339, 17, 'Susanne Rousset', 'langlois.thibaut@wanadoo.fr'),
(340, 17, 'Marie Lamy-Perret', 'leroux.brigitte@laposte.net'),
(341, 18, 'Chantal Parent', 'phamel@tessier.com'),
(342, 18, 'Martine Coulon', 'qevrard@deoliveira.fr'),
(343, 18, 'Anouk Lopez', 'stephane.faure@marchand.org'),
(344, 18, 'Agnès Albert', 'potier.andree@gautier.fr'),
(345, 18, 'Alex Martinez-Diaz', 'gerard.lopez@dupuis.com'),
(346, 18, 'Robert Francois', 'edith40@leclerc.com'),
(347, 18, 'Bernard Renault-Rolland', 'guillaume48@vidal.com'),
(348, 18, 'Noémi Millet', 'alexandria16@laroche.net'),
(349, 18, 'Charles Guillon', 'sguyot@sfr.fr'),
(350, 18, 'Rémy Costa', 'frederique45@gmail.com'),
(351, 18, 'Roland Martin', 'celina.ferrand@samson.com'),
(352, 18, 'Maggie-Patricia Hernandez', 'gtecher@coulon.fr'),
(353, 18, 'Zacharie-Victor Pereira', 'proche@charrier.org'),
(354, 18, 'Thérèse du Verdier', 'svallet@hotmail.fr'),
(355, 18, 'Pierre Fouquet-Charrier', 'jean.alves@dijoux.com'),
(356, 18, 'Geneviève Guibert-Moulin', 'paul.albert@dbmail.com'),
(357, 18, 'Diane de Devaux', 'delorme.alexandria@perret.com'),
(358, 18, 'Sophie Carpentier', 'michel.luc@bonnin.com'),
(359, 18, 'Alex Leblanc', 'luce38@denis.com'),
(360, 18, 'Audrey Imbert-Turpin', 'nhernandez@tele2.fr'),
(361, 19, 'Aurélie-Agnès Berger', 'martins.laurent@techer.com'),
(362, 19, 'William Gerard', 'francois80@blanc.org'),
(363, 19, 'Joséphine Blanc', 'ljulien@dbmail.com'),
(364, 19, 'Suzanne du Sanchez', 'baron.jeannine@hotmail.fr'),
(365, 19, 'Victor Bertin', 'maurice89@lecoq.com'),
(366, 19, 'Isaac Baron', 'andree.pinto@live.com'),
(367, 19, 'Margot-Julie Masson', 'wverdier@orange.fr'),
(368, 19, 'Richard-Claude Gregoire', 'pasquier.claude@yahoo.fr'),
(369, 19, 'Martine du Texier', 'amelie98@dbmail.com'),
(370, 19, 'Inès de la Briand', 'meyer.lucas@wagner.com'),
(371, 19, 'Eugène Rodrigues', 'hugues22@desousa.org'),
(372, 19, 'Dominique Didier', 'dupont.gabriel@vidal.fr'),
(373, 19, 'Adrienne-Marthe Fernandes', 'daniel.bertrand@yahoo.fr'),
(374, 19, 'Margot du Jacob', 'guilbert.benoit@tele2.fr'),
(375, 19, 'Henri Alexandre', 'carre.gabriel@hernandez.org'),
(376, 19, 'Alexandre Bertrand', 'jerome.marechal@yahoo.fr'),
(377, 19, 'Édith-Andrée Renault', 'vincent68@gmail.com'),
(378, 19, 'Amélie Roy', 'jeannine.pinto@lemonnier.fr'),
(379, 19, 'Richard Meunier', 'virginie19@lebon.net'),
(380, 19, 'Noël Valentin', 'courtois.audrey@gros.net'),
(381, 20, 'Jules Leleu', 'ugilles@dbmail.com'),
(382, 20, 'Guy Goncalves', 'cvalette@gros.com'),
(383, 20, 'Virginie Buisson', 'jpetitjean@louis.fr'),
(384, 20, 'Jeanne Le Lefevre', 'imarty@dupuis.fr'),
(385, 20, 'Suzanne Daniel-Boyer', 'margaret.tessier@paris.net'),
(386, 20, 'Susanne-Alexandria Guillot', 'zbernard@lemaitre.com'),
(387, 20, 'Constance du Ollivier', 'maillot.noel@thibault.fr'),
(388, 20, 'Julien Raynaud', 'charpentier.claire@orange.fr'),
(389, 20, 'Adrien de Tanguy', 'oceane.nicolas@sfr.fr'),
(390, 20, 'Pierre Torres', 'vduhamel@dbmail.com'),
(391, 20, 'Anouk de Lebon', 'valentine71@morin.fr'),
(392, 20, 'Amélie de Albert', 'jcarre@free.fr'),
(393, 20, 'Émile Guerin', 'frederique.foucher@gomes.com'),
(394, 20, 'Rémy Lelievre', 'jleconte@yahoo.fr'),
(395, 20, 'Hugues de la Rocher', 'lecoq.jean@dbmail.com'),
(396, 20, 'Nicole Martinez', 'andre.audrey@colin.fr'),
(397, 20, 'Émilie Dupont', 'margaux.schneider@charpentier.org'),
(398, 20, 'Yves Richard', 'louise.valentin@live.com'),
(399, 20, 'Françoise Delattre', 'isabelle.loiseau@hotmail.fr'),
(400, 20, 'Timothée Muller', 'navarro.gregoire@cordier.com');

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `description` longtext NOT NULL,
  `price` double NOT NULL,
  `brand` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `name`, `created_at`, `updated_at`, `description`, `price`, `brand`) VALUES
(1, 'Nom : 0', '2023-05-07 18:57:44', '2023-05-08 18:57:44', 'Description :  0', 0, 'Marque :  0'),
(2, 'Nom : 1', '2023-05-07 18:57:44', '2023-05-08 18:57:44', 'Description :  1', 100, 'Marque :  1'),
(3, 'Nom : 2', '2023-05-07 18:57:44', '2023-05-08 18:57:44', 'Description :  2', 200, 'Marque :  2'),
(4, 'Nom : 3', '2023-05-07 18:57:44', '2023-05-08 18:57:44', 'Description :  3', 300, 'Marque :  3'),
(5, 'Nom : 4', '2023-05-07 18:57:44', '2023-05-08 18:57:44', 'Description :  4', 400, 'Marque :  4'),
(6, 'Nom : 5', '2023-05-07 18:57:44', '2023-05-08 18:57:44', 'Description :  5', 500, 'Marque :  5'),
(7, 'Nom : 6', '2023-05-07 18:57:44', '2023-05-08 18:57:44', 'Description :  6', 600, 'Marque :  6'),
(8, 'Nom : 7', '2023-05-07 18:57:44', '2023-05-08 18:57:44', 'Description :  7', 700, 'Marque :  7'),
(9, 'Nom : 8', '2023-05-07 18:57:44', '2023-05-08 18:57:44', 'Description :  8', 800, 'Marque :  8'),
(10, 'Nom : 9', '2023-05-07 18:57:44', '2023-05-08 18:57:44', 'Description :  9', 900, 'Marque :  9'),
(11, 'Nom : 10', '2023-05-07 18:57:44', '2023-05-08 18:57:44', 'Description :  10', 1000, 'Marque :  10'),
(12, 'Nom : 11', '2023-05-07 18:57:44', '2023-05-08 18:57:44', 'Description :  11', 1100, 'Marque :  11'),
(13, 'Nom : 12', '2023-05-07 18:57:44', '2023-05-08 18:57:44', 'Description :  12', 1200, 'Marque :  12'),
(14, 'Nom : 13', '2023-05-07 18:57:44', '2023-05-08 18:57:44', 'Description :  13', 1300, 'Marque :  13'),
(15, 'Nom : 14', '2023-05-07 18:57:44', '2023-05-08 18:57:44', 'Description :  14', 1400, 'Marque :  14'),
(16, 'Nom : 15', '2023-05-07 18:57:44', '2023-05-08 18:57:44', 'Description :  15', 1500, 'Marque :  15'),
(17, 'Nom : 16', '2023-05-07 18:57:44', '2023-05-08 18:57:44', 'Description :  16', 1600, 'Marque :  16'),
(18, 'Nom : 17', '2023-05-07 18:57:44', '2023-05-08 18:57:44', 'Description :  17', 1700, 'Marque :  17'),
(19, 'Nom : 18', '2023-05-07 18:57:44', '2023-05-08 18:57:44', 'Description :  18', 1800, 'Marque :  18'),
(20, 'Nom : 19', '2023-05-07 18:57:44', '2023-05-08 18:57:44', 'Description :  19', 1900, 'Marque :  19');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `company_name`) VALUES
(1, 'Admin-0@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$d/jHzzOrmCOmoU.bXkRUCuar.gQkqY37cbl/NfoAbWAoQdT7xutdy', 'Cousin'),
(2, 'Admin-1@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$h5ltQ1WPTCS.ntOclZuJV.eFSBfsB9X1BSLdanmejnwY.y4t7Vc2O', 'Arnaud'),
(3, 'Admin-2@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$w.sUf5Md.a8LDHgHZSRSF.ZE0Uf9WmE1jhgiJhHLsOuqrqnNct/P.', 'Pineau et Fils'),
(4, 'Admin-3@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$2ucMa0EMAHGw88JaMq2kwuk5HJHctUZTWWulXHHo0UTi4LNrVW17u', 'Lagarde'),
(5, 'Admin-4@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$B2JhvfHDbVyUizYImTSXnem28xzvX3IWxZrWSeStjtrDG33nQAcj.', 'Guillou'),
(6, 'Admin-5@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$/leoE2EcfGdQuDxGST0Vvuw1UkDLpGqRf4vqZ75k/cmfpcGUk4QGK', 'Pineau SA'),
(7, 'Admin-6@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$xGQRP.pZOsDW9wKoJsG7iuXJDNVgHFgbpqx5XlOInjJytVOJK8OX2', 'Moreno'),
(8, 'Admin-7@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$Wv8gE2KaatqwCsqR7WsFQ.slhEwcWNf6c6Ske6Ip/My7SsIDlZ2XK', 'Lefort Rolland SA'),
(9, 'Admin-8@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$VNn5EBowkL2U4Rb61BrjuO4KtVPzvn/CAh.EbJ.O10LjN/cR7MMK2', 'Vasseur'),
(10, 'Admin-9@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$vt//LUsnYmVTgdJ.pfd2wOl1fbnRihtRirmelVXEQ14Q3zb2tVIoK', 'Courtois SA'),
(11, 'marcel.verdier@club-internet.fr', '[\"ROLE_USER\"]', '$2y$13$7e2xXz7YvXHu6BDPQ7mNx.xlXIyYJXCLxwxfBSQJJCdSqnDv1EsX2', 'Germain Chauveau et Fils'),
(12, 'alphonse.renault@wanadoo.fr', '[\"ROLE_USER\"]', '$2y$13$QEVu1IUn4whKSSvQs.EwEuwOtV5Aar8NI2VmaIf3wAZxEB0kudzIy', 'Carre Bonnin S.A.S.'),
(13, 'lesage.marianne@jacques.fr', '[\"ROLE_USER\"]', '$2y$13$uzX9K6fvGlEXcI49uJK0zuKmYBMEZe4HflQPkugsX8dCByiUDOmXu', 'Meunier et Fils'),
(14, 'alves.brigitte@lejeune.fr', '[\"ROLE_USER\"]', '$2y$13$ARU/w0B6u/UoldhYv/eVFefL59c4HWcS2.gfUwQYQoxJ5arIsNjfi', 'Normand et Fils'),
(15, 'qdumas@laposte.net', '[\"ROLE_USER\"]', '$2y$13$gjT6Hvug6KXt8atj2Wnbz.NA5E6Un673DZ2Bca/oGCLOYK0xswWnO', 'Carlier'),
(16, 'penelope.rey@yahoo.fr', '[\"ROLE_USER\"]', '$2y$13$TEWAXa25CBL6tuCbD55Yte7BLr5SytYChDvHsqbohDfgdIFNoT/1S', 'Bernard'),
(17, 'renee.diallo@sfr.fr', '[\"ROLE_USER\"]', '$2y$13$6gHXRtZmz/.Jh2E8a.sUN.F0FAfA4BE2TtuWx6shEca7aFeGn58ES', 'Albert'),
(18, 'fcourtois@sfr.fr', '[\"ROLE_USER\"]', '$2y$13$ONkn6LDaHUAtUIOu/lp9Sefl0Y9.zHE.DTxF7kQB7GnS7K6kzmkkS', 'Bousquet Roger et Fils'),
(19, 'marine.alexandre@sfr.fr', '[\"ROLE_USER\"]', '$2y$13$YOnpZakYAkDQcOcVO6z1tu2Hnmp7ky2J431JIPC7JDwPSQ26MP4ua', 'Grenier SA'),
(20, 'mhuet@lemonnier.fr', '[\"ROLE_USER\"]', '$2y$13$.PpcoXJ3ACr4r3iAsfsvGuv0pKrTpJ/xVWL.GyD7Pv3AQnujeWlba', 'Lemaire Guilbert S.A.S.');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_81398E09A76ED395` (`user_id`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT pour la table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=401;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `FK_81398E09A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
