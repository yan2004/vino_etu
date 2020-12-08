
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
-- Contenu de la table `vino__bouteille`
-- -----------------------------------------------------

INSERT INTO `vino__bouteille` VALUES(NULL, 'Borsao Seleccion', '//s7d9.scene7.com/is/image/SAQ/10324623_is?$saq-rech-prod-gril$', '10324623', 'Espagne', 'Vin rouge\r\n         \r\n      \r\n      \r\n      Espagne, 750 ml\r\n      \r\n      \r\n      Code SAQ : 10324623', 11, 'https://www.saq.com/page/fr/saqcom/vin-rouge/borsao-seleccion/10324623', ' 750 ml', 1);
INSERT INTO `vino__bouteille` VALUES(NULL, 'Monasterio de Las Vinas Gran Reserva', '//s7d9.scene7.com/is/image/SAQ/10359156_is?$saq-rech-prod-gril$', '10359156', 'Espagne', 'Vin rouge\r\n         \r\n      \r\n      \r\n      Espagne, 750 ml\r\n      \r\n      \r\n      Code SAQ : 10359156', 19, 'https://www.saq.com/page/fr/saqcom/vin-rouge/monasterio-de-las-vinas-gran-reserva/10359156', ' 750 ml', 1);
INSERT INTO `vino__bouteille` VALUES(NULL, 'Castano Hecula', '//s7d9.scene7.com/is/image/SAQ/11676671_is?$saq-rech-prod-gril$', '11676671', 'Espagne', 'Vin rouge\r\n         \r\n      \r\n      \r\n      Espagne, 750 ml\r\n      \r\n      \r\n      Code SAQ : 11676671', 12, 'https://www.saq.com/page/fr/saqcom/vin-rouge/castano-hecula/11676671', ' 750 ml', 1);
INSERT INTO `vino__bouteille` VALUES(NULL, 'Campo Viejo Tempranillo Rioja', '//s7d9.scene7.com/is/image/SAQ/11462446_is?$saq-rech-prod-gril$', '11462446', 'Espagne', 'Vin rouge\r\n         \r\n      \r\n      \r\n      Espagne, 750 ml\r\n      \r\n      \r\n      Code SAQ : 11462446', 14, 'https://www.saq.com/page/fr/saqcom/vin-rouge/campo-viejo-tempranillo-rioja/11462446', ' 750 ml', 1);
INSERT INTO `vino__bouteille` VALUES(NULL, 'Bodegas Atalaya Laya 2017', '//s7d9.scene7.com/is/image/SAQ/12375942_is?$saq-rech-prod-gril$', '12375942', 'Espagne', 'Vin rouge\r\n         \r\n      \r\n      \r\n      Espagne, 750 ml\r\n      \r\n      \r\n      Code SAQ : 12375942', 17, 'https://www.saq.com/page/fr/saqcom/vin-rouge/bodegas-atalaya-laya-2017/12375942', ' 750 ml', 1);
INSERT INTO `vino__bouteille` VALUES(NULL, 'Vin Vault Pinot Grigio', '//s7d9.scene7.com/is/image/SAQ/13467048_is?$saq-rech-prod-gril$', '13467048', 'États-Unis', 'Vin blanc\r\n         \r\n      \r\n      \r\n      États-Unis, 3 L\r\n      \r\n      \r\n      Code SAQ : 13467048', NULL, 'https://www.saq.com/page/fr/saqcom/vin-blanc/vin-vault-pinot-grigio/13467048', ' 3 L', 2);
INSERT INTO `vino__bouteille` VALUES(NULL, 'Huber Riesling Engelsberg 2017', '//s7d9.scene7.com/is/image/SAQ/13675841_is?$saq-rech-prod-gril$', '13675841', 'Autriche', 'Vin blanc\r\n         \r\n      \r\n      \r\n      Autriche, 750 ml\r\n      \r\n      \r\n      Code SAQ : 13675841', 22, 'https://www.saq.com/page/fr/saqcom/vin-blanc/huber-riesling-engelsberg-2017/13675841', ' 750 ml', 2);
INSERT INTO `vino__bouteille` VALUES(NULL, 'Dominio de Tares Estay Castilla y Léon 2015', '//s7d9.scene7.com/is/image/SAQ/13802571_is?$saq-rech-prod-gril$', '13802571', 'Espagne', 'Vin rouge\r\n         \r\n      \r\n      \r\n      Espagne, 750 ml\r\n      \r\n      \r\n      Code SAQ : 13802571', 18, 'https://www.saq.com/page/fr/saqcom/vin-rouge/dominio-de-tares-estay-castilla-y-leon-2015/13802571', ' 750 ml', 1);
INSERT INTO `vino__bouteille` VALUES(NULL, 'Tessellae Old Vines Côtes du Roussillon 2016', '//s7d9.scene7.com/is/image/SAQ/12216562_is?$saq-rech-prod-gril$', '12216562', 'France', 'Vin rouge\r\n         \r\n      \r\n      \r\n      France, 750 ml\r\n      \r\n      \r\n      Code SAQ : 12216562', 21, 'https://www.saq.com/page/fr/saqcom/vin-rouge/tessellae-old-vines-cotes-du-roussillon-2016/12216562', ' 750 ml', 1);
INSERT INTO `vino__bouteille` VALUES(NULL, 'Tenuta Il Falchetto Bricco Paradiso -... 2015', '//s7d9.scene7.com/is/image/SAQ/13637422_is?$saq-rech-prod-gril$', '13637422', 'Italie', 'Vin rouge\r\n         \r\n      \r\n      \r\n      Italie, 750 ml\r\n      \r\n      \r\n      Code SAQ : 13637422', 34, 'https://www.saq.com/page/fr/saqcom/vin-rouge/tenuta-il-falchetto-bricco-paradiso---barbera-dasti-superiore-docg-2015/13637422', ' 750 ml', 1);

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
  `admin` BOOLEAN DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Info de l'admin dans `vino__usager`
-- -----------------------------------------------------

-- courriel : admin_pw2@cmaisonneuve.qc.ca
-- mot de passe : sm1994

INSERT INTO `vino__usager` VALUES(NULL, 'admin_pw2@cmaisonneuve.qc.ca', 'Aran', 'Samus', '$2y$10$F40ZapQ5dZBPq3YEJjJs.eV5zRPlaO9YCnvxijECSx9T.HJrfwucK', true);


-- -----------------------------------------------------
-- Structure de la table `vino__bouteille__collection`
-- -----------------------------------------------------

CREATE TABLE `vino__bouteille__collection`
(
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_bouteille` INT NOT NULL,
  `date_achat` DATE NOT NULL,
  `garde_jusqua` VARCHAR(200) DEFAULT NULL,
  `notes` VARCHAR(200) DEFAULT NULL,
  `prix` DECIMAL(6,2) NOT NULL,
  `quantite` INT NOT NULL,
  `millesime` INT DEFAULT NULL,
  `id_usager` INT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY(`id_bouteille`) REFERENCES `vino__bouteille`(`id`),
  FOREIGN KEY(`id_usager`) REFERENCES `vino__usager`(`id`)
) ENGINE=InnoDB;