
-- -----------------------------------------------------
-- Schema vinodb
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS vinodb ;
CREATE SCHEMA vinodb DEFAULT CHARACTER SET utf8 ;
USE vinodb ;


SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

DROP TABLE IF EXISTS `vino__bouteille__collection`, `vino__usager`, `vino__bouteille`, `vino__type`;

-- -----------------------------------------------------
-- Structure de la table `vino__type`
-- -----------------------------------------------------

CREATE TABLE `vino__type`
(
  `id` INT NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Contenu de la table `vino__type`
-- -----------------------------------------------------

INSERT INTO `vino__type` VALUES(NULL, 'Vin rouge');
INSERT INTO `vino__type` VALUES(NULL, 'Vin blanc');


-- -----------------------------------------------------
-- Structure de la table `vino__bouteille`
-- -----------------------------------------------------

CREATE TABLE `vino__bouteille`
(
  `id` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(200) DEFAULT NULL,
  `url_image` VARCHAR(200) DEFAULT NULL,
  `code_saq` VARCHAR(50) DEFAULT NULL,
  `pays` VARCHAR(50) DEFAULT NULL,
  `description` VARCHAR(200) DEFAULT NULL,
  `prix_saq` DECIMAL(6,2) DEFAULT NULL,
  `url_saq` VARCHAR(200) DEFAULT NULL,
  `format` VARCHAR(20) DEFAULT NULL,
  `id_type` INT DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY(`id_type`) REFERENCES `vino__type`(`id`)
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Structure de la table `vino__usager`
-- -----------------------------------------------------

CREATE TABLE `vino__usager`
(
  `id` INT NOT NULL AUTO_INCREMENT,
  `courriel` VARCHAR(320) NOT NULL UNIQUE,
  `nom` VARCHAR(50) NOT NULL,
  `prenom` VARCHAR(50) NOT NULL,
  `mot_de_passe` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Info de l'admin dans `vino__usager`
-- -----------------------------------------------------

-- courriel : admin_pw2@cmaisonneuve.qc.ca
-- mot de passe : sm1994

INSERT INTO `vino__usager` VALUES(NULL, 'admin_pw2@cmaisonneuve.qc.ca', 'Aran', 'Samus', '$2y$10$F40ZapQ5dZBPq3YEJjJs.eV5zRPlaO9YCnvxijECSx9T.HJrfwucK');


-- -----------------------------------------------------
-- Structure de la table `vino__bouteille__collection`
-- -----------------------------------------------------

CREATE TABLE `vino__bouteille__collection`
(
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_bouteille` INT DEFAULT NULL,
  `date_achat` DATE DEFAULT NULL,
  `garde_jusqua` VARCHAR(200) DEFAULT NULL,
  `notes` VARCHAR(200) DEFAULT NULL,
  `prix` DECIMAL(6,2) DEFAULT NULL,
  `quantite` INT DEFAULT NULL,
  `millesime` INT DEFAULT NULL,
  `id_usager` INT,
  PRIMARY KEY (`id`),
  FOREIGN KEY(`id_bouteille`) REFERENCES `vino__bouteille`(`id`),
  FOREIGN KEY(`id_usager`) REFERENCES `vino__usager`(`id`)
) ENGINE=InnoDB;