SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `vfilterkategorien`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vfilterkategorien` (
  `filkatID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `filkatName` VARCHAR(255) NOT NULL,
  `filkatParent` BIGINT UNSIGNED NOT NULL,
  `filkatAktiv` TINYINT NULL,
  `filtkatPosition` INT NULL,
  `filtkatLangJson` MEDIUMTEXT NULL,
  PRIMARY KEY (`filkatID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vfiltersystem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vfiltersystem` (
  `filsysID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `filsysName` VARCHAR(255) NULL,
  `filsysConfig` MEDIUMTEXT NULL,
  PRIMARY KEY (`filsysID`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
