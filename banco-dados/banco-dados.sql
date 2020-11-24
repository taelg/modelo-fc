# É recomendado que a a estrutura e os dados de exemplos estajam nessa pasta

DROP SCHEMA IF EXISTS `teste_fc` ;

CREATE SCHEMA `teste_fc` DEFAULT CHARACTER SET utf8 ;
USE `teste_fc` ;


DROP TABLE IF EXISTS `teste_fc`.`medico` ;
CREATE TABLE `teste_fc`.`medico` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(45) NOT NULL,
  `nome` VARCHAR(45) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
  `data_criacao` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_alteracao` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


DROP TABLE IF EXISTS `teste_fc`.`horario` ;
CREATE TABLE `teste_fc`.`horario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_medico` INT NOT NULL,
  `data_horario` DATETIME NOT NULL,
  `horario_agendado` TINYINT NOT NULL DEFAULT 0,
  `data_criacao` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_alteracao` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_horario_medico_idx` (`id_medico` ASC),
  CONSTRAINT `fk_horario_medico`
    FOREIGN KEY (`id_medico`)
    REFERENCES `teste_fc`.`medico` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;
