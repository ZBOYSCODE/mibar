CREATE TABLE `turnos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hora_inicio` time NOT NULL,
  `hora_termino` time NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `mibar`.`turnos` (`hora_inicio`, `hora_termino`, `descripcion`) VALUES ('12:00:00', '17:59:00', 'Mañana');

INSERT INTO `mibar`.`turnos` (`hora_inicio`, `hora_termino`, `descripcion`) VALUES ('18:00:00', '00:00:00', 'Tarde');


CREATE TABLE `mibar`.`funcionario_mesa` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `funcionario_id` INT NOT NULL,
  `mesa_id` INT NOT NULL,
  `turno_id` INT NOT NULL,
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_funcionario_idx` (`funcionario_id` ASC),
  INDEX `fk_mesa_idx` (`mesa_id` ASC),
  INDEX `fk_turno_idx` (`turno_id` ASC),
  CONSTRAINT `fk_funcionario`
    FOREIGN KEY (`funcionario_id`)
    REFERENCES `mibar`.`funcionarios` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_mesa`
    FOREIGN KEY (`mesa_id`)
    REFERENCES `mibar`.`mesas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_turno`
    FOREIGN KEY (`turno_id`)
    REFERENCES `mibar`.`turnos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


ALTER TABLE `mibar`.`mesas` 
DROP FOREIGN KEY `fk_mesas_funcionario`;
ALTER TABLE `mibar`.`mesas` 
DROP INDEX `fk_mesas_funcionario_idx` ;


ALTER TABLE `mibar`.`mesas` 
DROP COLUMN `funcionario_id`;


ALTER TABLE `mibar`.`funcionario_mesa` 
CHANGE COLUMN `created_at` `fecha` DATETIME NOT NULL ;


INSERT INTO `mibar`.`funcionario_mesa` (`funcionario_id`, `mesa_id`, `turno_id`, `fecha`) VALUES ('1', '1', '1', '2016-10-17 00:00:01');
INSERT INTO `mibar`.`funcionario_mesa` (`funcionario_id`, `mesa_id`, `turno_id`, `fecha`) VALUES ('1', '2', '1', '00:00:01');
INSERT INTO `mibar`.`funcionario_mesa` (`funcionario_id`, `mesa_id`, `turno_id`, `fecha`) VALUES ('1', '3', '1', '00:00:01');


UPDATE `mibar`.`funcionario_mesa` SET `fecha`='2016-10-17 00:00:01' WHERE `id`='2';
UPDATE `mibar`.`funcionario_mesa` SET `fecha`='2016-10-17 00:00:01' WHERE `id`='3';


INSERT INTO `mibar`.`funcionario_mesa` (`id`, `funcionario_id`, `mesa_id`, `turno_id`, `fecha`) VALUES ('4', '1', '3', '1', '2016-10-18 00:00:01');


INSERT INTO `mibar`.`mesas` (`numero`, `seccion`, `estado`) VALUES ('4', '1', '1');

	
ALTER TABLE `mibar`.`funcionario_mesa` 
CHANGE COLUMN `fecha` `fecha` DATE NOT NULL ;


DELETE FROM `mibar`.`funcionario_mesa` WHERE `id`='7';


INSERT INTO `mibar`.`funcionario_mesa` (`funcionario_id`, `mesa_id`, `turno_id`, `fecha`) VALUES ('1', '2', '1', '2016-10-18');


INSERT INTO `mibar`.`funcionario_mesa` (`funcionario_id`, `mesa_id`, `turno_id`, `fecha`) VALUES ('1', '6', '1', '2016-10-17');
