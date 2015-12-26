SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `vkontaktformulare`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `vkontaktformulare` (
  `koID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `koAktiv` TINYINT NULL,
  `koName` VARCHAR(255) NULL,
  `koJson` MEDIUMTEXT NULL,
  `koIsImport` TINYINT NULL,
  PRIMARY KEY (`koID`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
