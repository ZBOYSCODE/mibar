/* NULLS */

ALTER TABLE `mibar`.`pedidos`
CHANGE COLUMN `producto_id` `producto_id` int(11) NULL DEFAULT NULL;

ALTER TABLE `mibar`.`pedidos`
CHANGE COLUMN `promocion_id` `promocion_id` int(11) NULL DEFAULT NULL;

ALTER TABLE `mibar`.`cuentas`
  CHANGE COLUMN `funcionario_id` `funcionario_id` int(11) NULL DEFAULT NULL;

ALTER TABLE `mibar`.`cuentas`
  CHANGE COLUMN `pago_id` `pago_id` int(11) NULL DEFAULT NULL;  

ALTER TABLE `mibar`.`cuentas`
  CHANGE COLUMN `estado` `estado` tinyint(1) NULL DEFAULT 0;

ALTER TABLE `mibar`.`productos`
  CHANGE COLUMN `precio` `precio` int(11) NOT NULL DEFAULT 0;  


/* DATOS FUNCIONARIO */

INSERT INTO `mibar`.`funcionarios` SET `id`=1,`nombre`='Jorge',`apellido`='Cociña',`email`='jorge.cocina@mesero.cl',`telefono`='412351',`rol_id`=5;
INSERT INTO `mibar`.`funcionarios` SET `id`=2,`nombre`='Rodrigo',`apellido`='Soto',`email`='rodrigo.soto@barman.cl',`telefono`='6512829',`rol_id`=3;
INSERT INTO `mibar`.`funcionarios` SET `id`=3,`nombre`='Jorge',`apellido`='Silva',`email`='jorge.silva@cocina.cl',`telefono`='2828278',`rol_id`=4;
INSERT INTO `mibar`.`funcionarios` SET `id`=4,`nombre`='Miguel',`apellido`='Jara',`email`='miguel.jara@caja.cl',`telefono`='2982791',`rol_id`=2;


/* MESAS */

INSERT INTO `mibar`.`mesas` SET `numero`=1,`seccion`='1',`funcionario_id`=1,`estado`=1;
INSERT INTO `mibar`.`mesas` SET `numero`=2,`seccion`='1',`funcionario_id`=1,`estado`=1;
INSERT INTO `mibar`.`mesas` SET `numero`=3,`seccion`='1',`funcionario_id`=1,`estado`=1;

/* BAR */

INSERT INTO `mibar`.`bares` SET `id`=1,`nombre`='ZentaBar';


/*TABLA SUBCATEGORIA*/

CREATE TABLE `mibar`.`subcategoria_productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_producto_id` int(11) NOT NULL DEFAULT 0,
  `nombre` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/* FK SUBCATEGORIA CATEGORIA */

ALTER TABLE `mibar`.`subcategoria_productos`
  ADD CONSTRAINT `fk_subcategoria_categoria_producto` FOREIGN KEY (`categoria_producto_id`) REFERENCES `mibar`.`categoria_productos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;


/* DROP FK CATEGORIA PRODUCTO*/

ALTER TABLE `mibar`.`productos`
  DROP FOREIGN KEY `fk_productos_categoria`;

/* ADD FK PRODUCTO SUBCATEGORIA */

ALTER TABLE `mibar`.`productos`
  CHANGE COLUMN `categoria_id` `subcategoria_id` int(11) NOT NULL;

ALTER TABLE `mibar`.`productos`
  ADD CONSTRAINT `fk_subcategoria_producto` FOREIGN KEY (`subcategoria_id`) REFERENCES `mibar`.`subcategoria_productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;




