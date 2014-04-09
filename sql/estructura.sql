SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `hackaton` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `hackaton` ;

-- -----------------------------------------------------
-- Table `hackaton`.`proyecto`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hackaton`.`proyecto` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(128) NOT NULL ,
  `descripcion` TEXT NOT NULL ,
  `url` VARCHAR(256) NOT NULL ,
  `usuario_id` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_proyecto_usuario1` (`usuario_id` ASC) ,
  CONSTRAINT `fk_proyecto_usuario1`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `hackaton`.`usuario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `hackaton`.`usuario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hackaton`.`usuario` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `twitter_id` INT UNSIGNED NOT NULL ,
  `twitter_screen_name` VARCHAR(128) NOT NULL ,
  `proyecto_id` INT UNSIGNED NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `twitter_id_UNIQUE` (`twitter_id` ASC) ,
  INDEX `fk_usuario_proyecto` (`proyecto_id` ASC) ,
  CONSTRAINT `fk_usuario_proyecto`
    FOREIGN KEY (`proyecto_id` )
    REFERENCES `hackaton`.`proyecto` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
