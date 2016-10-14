/* para crear usuarios temporales, es necesario dejar en blanco la mayoría de los campos */


ALTER TABLE `mibar`.`clientes` 
CHANGE COLUMN `apellido` `apellido` VARCHAR(50) CHARACTER SET 'utf8' NULL ,
CHANGE COLUMN `email` `email` VARCHAR(50) CHARACTER SET 'utf8' NULL ,
CHANGE COLUMN `telefono` `telefono` VARCHAR(50) CHARACTER SET 'utf8' NULL ,
CHANGE COLUMN `fecha_nacimiento` `fecha_nacimiento` DATETIME NULL ;



INSERT INTO `mibar`.`roles` (`id`, `nombre`) VALUES ('1', 'admin');
INSERT INTO `mibar`.`roles` (`id`, `nombre`) VALUES ('2', 'caja');
INSERT INTO `mibar`.`roles` (`id`, `nombre`) VALUES ('3', 'bar');
INSERT INTO `mibar`.`roles` (`id`, `nombre`) VALUES ('4', 'cocina');
INSERT INTO `mibar`.`roles` (`id`, `nombre`) VALUES ('5', 'mesero');
INSERT INTO `mibar`.`roles` (`id`, `nombre`) VALUES ('6', 'cliente');


ALTER TABLE `mibar`.`cuentas` 
DROP COLUMN `pedido_id`;
