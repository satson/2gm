SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `vempfehler`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `vempfehler` (
  `empfID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `empfUrl` VARCHAR(255) NULL,
  `empfCreateDate` DATETIME NULL,
  `empfVorname` VARCHAR(255) NULL,
  `empfNachname` VARCHAR(255) NULL,
  `empfStrasse` VARCHAR(255) NULL,
  `empfPlz` VARCHAR(255) NULL,
  `empfOrt` VARCHAR(255) NULL,
  `empfLand` VARCHAR(255) NULL,
  `empfMail` VARCHAR(255) NULL,
  `empfGeschlecht` VARCHAR(255) NULL,
  `empfFbId` VARCHAR(255) NULL,
  `empfLinkClicks` BIGINT NULL,
  PRIMARY KEY (`empfID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vempfehleranfragen`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `vempfehleranfragen` (
  `emanID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `emanBuchung` TINYINT NULL,
  `emanDate` DATETIME NULL,
  `emanVorname` VARCHAR(255) NULL,
  `emanNachname` VARCHAR(255) NULL,
  `emanMail` VARCHAR(255) NULL,
  `emanMailHtmlText` MEDIUMTEXT NULL,
  `empfID` BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (`emanID`),
  INDEX `fk_vempfehleranfragen_vempfehler_idx` (`empfID` ASC),
  CONSTRAINT `fk_vempfehleranfragen_vempfehler`
    FOREIGN KEY (`empfID`)
    REFERENCES `vempfehler` (`empfID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vempfehlungsmanager`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `vempfehlungsmanager` (
  `emID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `emMail` VARCHAR(255) NULL,
  `emEmpfSiteId` BIGINT NULL,
  `emKontaktSiteId` BIGINT NULL,
  `emIsFbDataActive` TINYINT NULL,
  `emFbAppID` VARCHAR(255) NULL,
  `emFbShareSmallDesc` TEXT NULL,
  `emFbShareDesc` TEXT NULL,
  `emFbShareBild` VARCHAR(255) NULL,
  `emHotelMailText` MEDIUMTEXT NULL,
  `emEmpfehlerBuchMailText` MEDIUMTEXT NULL,
  `emEmpfehlerBuchMailAbsender` TEXT NULL,
  `emEmpfehlerBuchMailBetreff` TEXT NULL,
  `emEmpfehlerRegisterMailText` MEDIUMTEXT NULL,
  `emFirmaName` VARCHAR(255) NULL,
  `emRabattText` MEDIUMTEXT NULL,
  `emGeschenkeRules` MEDIUMTEXT NULL,
  `emTextZwNameFirma` TEXT NULL,
  `emOtherSettingJson` MEDIUMTEXT NULL,
  PRIMARY KEY (`emID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vempfehlergeschenke`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `vempfehlergeschenke` (
  `gesID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `gesBuchAnzahl` INT NULL,
  `gesText` MEDIUMTEXT NULL,
  PRIMARY KEY (`gesID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vempfehlergeschenkelang`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `vempfehlergeschenkelang` (
  `geslaID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `geslaText` MEDIUMTEXT NULL,
  `gesID` INT UNSIGNED NULL,
  `langID` INT UNSIGNED NULL,
  PRIMARY KEY (`geslaID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vempfehlungsmanagerlang`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `vempfehlungsmanagerlang` (
  `emlaID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `emlaFbShareSmallDesc` TEXT NULL,
  `emlaFbShareDesc` TEXT NULL,
  `emlaFbShareBild` VARCHAR(255) NULL,
  `emlaHotelMailText` MEDIUMTEXT NULL,
  `emlaEmpfehlerBuchMailText` MEDIUMTEXT NULL,
  `emlaEmpfehlerBuchMailAbsender` TEXT NULL,
  `emlaEmpfehlerBuchMailBetreff` TEXT NULL,
  `emlaEmpfehlerRegisterMailText` MEDIUMTEXT NULL,
  `emlaFirmaName` VARCHAR(255) NULL,
  `emlaRabattText` VARCHAR(255) NULL,
  `emlaGeschenkeRules` MEDIUMTEXT NULL,
  `emlaTextZwNameFirma` TEXT NULL,
  `emlaOtherSettingJson` MEDIUMTEXT NULL,
  `emID` INT UNSIGNED NULL,
  `langID` INT UNSIGNED NULL,
  PRIMARY KEY (`emlaID`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
