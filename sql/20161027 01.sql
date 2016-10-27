CREATE TABLE `mibar`.`estados_mesa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;	

INSERT INTO `mibar`.`estados_mesa` SET `name`='Disponible';
INSERT INTO `mibar`.`estados_mesa` SET `name`='Ocupada';
INSERT INTO `mibar`.`estados_mesa` SET `name`='Reservada';
