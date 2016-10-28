CREATE TABLE `mibar`.`estados_mesa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;	

INSERT INTO `mibar`.`estados_mesa` SET `name`='Disponible';
INSERT INTO `mibar`.`estados_mesa` SET `name`='Ocupada';
INSERT INTO `mibar`.`estados_mesa` SET `name`='Reservada';

ALTER TABLE `mibar`.`mesas`
  CHANGE COLUMN `estado` `estado_mesa_id` int(11) NOT NULL DEFAULT 1;

ALTER TABLE `mibar`.`mesas`
  ADD CONSTRAINT `fk_mesa_estados_mesa` FOREIGN KEY (`estado_mesa_id`) REFERENCES `mibar`.`estados_mesa` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;