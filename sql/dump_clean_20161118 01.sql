# Host: localhost  (Version: 5.5.5-10.1.19-MariaDB)
# Date: 2016-11-18 03:09:34
# Generator: MySQL-Front 5.3  (Build 5.17)

/*!40101 SET NAMES latin1 */;

#
# Structure for table "bares"
#

DROP TABLE IF EXISTS `bares`;
CREATE TABLE `bares` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

#
# Data for table "bares"
#

INSERT INTO `bares` VALUES (1,'miBar');

#
# Structure for table "bodegas"
#

DROP TABLE IF EXISTS `bodegas`;
CREATE TABLE `bodegas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

#
# Data for table "bodegas"
#


#
# Structure for table "categoria_productos"
#

DROP TABLE IF EXISTS `categoria_productos`;
CREATE TABLE `categoria_productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

#
# Data for table "categoria_productos"
#

INSERT INTO `categoria_productos` VALUES (1,'Bebestible'),(2,'Comestible');

#
# Structure for table "descuentos"
#

DROP TABLE IF EXISTS `descuentos`;
CREATE TABLE `descuentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `monto` int(11) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_termino` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

#
# Data for table "descuentos"
#


#
# Structure for table "estados"
#

DROP TABLE IF EXISTS `estados`;
CREATE TABLE `estados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

#
# Data for table "estados"
#

INSERT INTO `estados` VALUES (1,'Pendiente'),(2,'En Proceso'),(3,'Concretado'),(4,'Reservado'),(5,'Entregado'),(6,'Cancelado');

#
# Structure for table "estados_mesa"
#

DROP TABLE IF EXISTS `estados_mesa`;
CREATE TABLE `estados_mesa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "estados_mesa"
#

INSERT INTO `estados_mesa` VALUES (1,'Disponible'),(2,'Ocupada'),(3,'Reservada');

#
# Structure for table "mesas"
#

DROP TABLE IF EXISTS `mesas`;
CREATE TABLE `mesas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  `seccion` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `estado_mesa_id` int(11) NOT NULL DEFAULT '1',
  `bar_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_mesas_bares_idx` (`bar_id`),
  KEY `fk_mesa_estados_mesa` (`estado_mesa_id`),
  CONSTRAINT `fk_mesa_estados_mesa` FOREIGN KEY (`estado_mesa_id`) REFERENCES `estados_mesa` (`id`),
  CONSTRAINT `fk_mesas_bares` FOREIGN KEY (`bar_id`) REFERENCES `bares` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

#
# Data for table "mesas"
#

INSERT INTO `mesas` VALUES (1,1,'1',2,1),(2,2,'1',2,1),(3,3,'1',1,1),(4,4,'1',1,1),(5,5,'1',1,1),(6,6,'1',1,1);

#
# Structure for table "roles"
#

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

#
# Data for table "roles"
#

INSERT INTO `roles` VALUES (1,'admin'),(2,'caja'),(3,'bar'),(4,'cocina'),(5,'mesero'),(6,'cliente');

#
# Structure for table "funcionarios"
#

DROP TABLE IF EXISTS `funcionarios`;
CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `rol_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_funcionarios_rol_idx` (`rol_id`),
  CONSTRAINT `fk_funcionarios_rol` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

#
# Data for table "funcionarios"
#

INSERT INTO `funcionarios` VALUES (1,'Jorge','Cociña','jorge.cocina@mesero.cl','412351',5),(2,'Rodrigo','Soto','rodrigo.soto@barman.cl','6512829',3),(3,'Jorge','Silva','jorge.silva@cocina.cl','2828278',4),(4,'Miguel','Jara','miguel.jara@caja.cl','2982791',2),(5,'Gerardo','Pizarro','gerardo.pizarro@mesero.cl','5822918',5);

#
# Structure for table "pagos"
#

DROP TABLE IF EXISTS `pagos`;
CREATE TABLE `pagos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descuento_id` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `medio_pago` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `funcionario_id` int(11) NOT NULL,
  `subtotal` double NOT NULL,
  `total` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pagos_descuento_idx` (`descuento_id`),
  KEY `fk_pagos_funcionario_idx` (`funcionario_id`),
  CONSTRAINT `fk_pagos_descuento` FOREIGN KEY (`descuento_id`) REFERENCES `descuentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pagos_funcionario` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

#
# Data for table "pagos"
#


#
# Structure for table "subcategoria_productos"
#

DROP TABLE IF EXISTS `subcategoria_productos`;
CREATE TABLE `subcategoria_productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_producto_id` int(11) NOT NULL DEFAULT '0',
  `nombre` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `fk_subcategoria_categoria_producto` (`categoria_producto_id`),
  CONSTRAINT `fk_subcategoria_categoria_producto` FOREIGN KEY (`categoria_producto_id`) REFERENCES `categoria_productos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

#
# Data for table "subcategoria_productos"
#

INSERT INTO `subcategoria_productos` VALUES (1,1,'Ron'),(2,1,'Pisco'),(3,2,'Tabla Fria'),(4,2,'Tabla Caliente'),(5,2,'Sandwich'),(7,1,'Whisky'),(8,1,'Vodka'),(9,1,'Gin'),(10,1,'Tequila'),(11,1,'Cerveza');

#
# Structure for table "productos"
#

DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `precio` int(11) NOT NULL DEFAULT '0',
  `descripcion` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `subcategoria_id` int(11) NOT NULL,
  `codigo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `fk_productos_categoria_idx` (`subcategoria_id`),
  CONSTRAINT `fk_subcategoria_producto` FOREIGN KEY (`subcategoria_id`) REFERENCES `subcategoria_productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

#
# Data for table "productos"
#

INSERT INTO `productos` VALUES (1,'Ron Bacardi Añejo',3800,'Ron +  bebida a elección',1,'1','/img/products/drinks/bacardi.jpg'),(2,'Ron Abuelo',4000,'Ron +  bebida a elección',1,'2','/img/products/drinks/abuelo.jpg'),(3,'Pisco Mistral',3200,'Pisco + bebida a elección',2,'3','/img/products/drinks/mistral.jpg'),(4,'Pisco Alto del Carmen',2800,'Pisco + bebida a elección',2,'4','/img/products/drinks/altodelcarmen.jpg'),(5,'Cerveza Corona',3000,'Versión 700cc',11,'5','/img/products/drinks/corona.jpg'),(6,'Cerveza Heineken',3800,'Botella 1000cc',11,'6','/img/products/drinks/heineken.jpg'),(7,'Gin Tanqueray',3000,'Gin + bebida a elección',9,'7','/img/products/drinks/tanqueray.jpg'),(8,'Gin Beefeater',3400,'Gin + bebida a elección',9,'8','/img/products/drinks/beefeater.jpg'),(9,'Whisky Ballantine\'s',6500,'Whisky + bebida a elección',7,'9','/img/products/drinks/ballantines.jpg'),(10,'Whisky Chivas Regal',7400,'Whisky + bebida a elección',7,'10','/img/products/drinks/chivasregal.jpg'),(11,'Barros Luco',6800,'En mechada o bife de lomo',5,'11','/img/products/foods/barrosluco.jpg'),(12,'Tabla de Quesos',5600,'Variedad de quesos, galletas y aceitunas',3,'12','/img/products/foods/tablaquesos.jpg'),(13,'Vodka Absolut',5000,'Vodka + Jugo a elección',8,'13','/img/products/foods/tablaquesos.jpg'),(14,'Tequila Sombrero Negro',1000,'3 Golpeados',10,'14','/img/products/foods/tablaquesos.jpg'),(15,'Mojito Cubano',3000,'Ron Blanco + Menta + Hielo Frappé + Limón de Pica',1,'15','/img/products/foods/tablaquesos.jpg');

#
# Structure for table "stock"
#

DROP TABLE IF EXISTS `stock`;
CREATE TABLE `stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `bodega_id` int(11) NOT NULL,
  `precio_compra` double NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_stock_producto_idx` (`producto_id`),
  KEY `fk_stock_bodega_idx` (`bodega_id`),
  CONSTRAINT `fk_stock_bodega` FOREIGN KEY (`bodega_id`) REFERENCES `bodegas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_stock_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

#
# Data for table "stock"
#


#
# Structure for table "tipo_clientes"
#

DROP TABLE IF EXISTS `tipo_clientes`;
CREATE TABLE `tipo_clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

#
# Data for table "tipo_clientes"
#

INSERT INTO `tipo_clientes` VALUES (1,'Premium'),(2,'Normal');

#
# Structure for table "clientes"
#

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `telefono` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `fecha_nacimiento` datetime DEFAULT NULL,
  `tipo_cliente_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cliente_tipo_cliente_idx` (`tipo_cliente_id`),
  CONSTRAINT `fk_cliente_tipo_cliente` FOREIGN KEY (`tipo_cliente_id`) REFERENCES `tipo_clientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

#
# Data for table "clientes"
#


#
# Structure for table "reservas"
#

DROP TABLE IF EXISTS `reservas`;
CREATE TABLE `reservas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `mesa_id` int(11) NOT NULL,
  `descripcion` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `monto_garantia` double NOT NULL,
  `estado_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_reserva_cliente_idx` (`cliente_id`),
  KEY `fk_reserva_mesa_idx` (`mesa_id`),
  KEY `fk_reserva_estado_idx` (`estado_id`),
  CONSTRAINT `fk_reserva_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_reserva_estado` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_reserva_mesa` FOREIGN KEY (`mesa_id`) REFERENCES `mesas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

#
# Data for table "reservas"
#


#
# Structure for table "cuentas"
#

DROP TABLE IF EXISTS `cuentas`;
CREATE TABLE `cuentas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) DEFAULT NULL,
  `mesa_id` int(11) DEFAULT NULL,
  `funcionario_id` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_cuentas_cliente_idx` (`cliente_id`),
  KEY `fk_cuentas_mesa_idx` (`mesa_id`),
  KEY `fk_cuentas_funcionario_idx` (`funcionario_id`),
  CONSTRAINT `fk_cuentas_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cuentas_funcionario` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cuentas_mesa` FOREIGN KEY (`mesa_id`) REFERENCES `mesas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

#
# Data for table "cuentas"
#


#
# Structure for table "cuentas_pagos"
#

DROP TABLE IF EXISTS `cuentas_pagos`;
CREATE TABLE `cuentas_pagos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pago_id` int(11) NOT NULL,
  `cuenta_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cuenta_idx` (`cuenta_id`),
  KEY `fk_cp_pago_idx` (`pago_id`),
  CONSTRAINT `fk_cp_cuenta` FOREIGN KEY (`cuenta_id`) REFERENCES `cuentas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cp_pago` FOREIGN KEY (`pago_id`) REFERENCES `pagos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "cuentas_pagos"
#


#
# Structure for table "tipo_promo"
#

DROP TABLE IF EXISTS `tipo_promo`;
CREATE TABLE `tipo_promo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

#
# Data for table "tipo_promo"
#

INSERT INTO `tipo_promo` VALUES (1,'2x1'),(2,'Descuento');

#
# Structure for table "promociones"
#

DROP TABLE IF EXISTS `promociones`;
CREATE TABLE `promociones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `tipo_promo_id` int(11) NOT NULL,
  `precio` int(11) NOT NULL DEFAULT '0',
  `avatar` varchar(255) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `descripcion` varchar(255) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `categoriaproducto_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_promociones_tipopromo_idx` (`tipo_promo_id`),
  KEY `fk_promociones_categoriaproducto_idx` (`categoriaproducto_id`),
  CONSTRAINT `fk_promociones_categoriaproducto` FOREIGN KEY (`categoriaproducto_id`) REFERENCES `categoria_productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_promociones_tipopromo` FOREIGN KEY (`tipo_promo_id`) REFERENCES `tipo_promo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

#
# Data for table "promociones"
#

INSERT INTO `promociones` VALUES (1,'2x1 Ron Bacardi',1,4800,'/img/products/drinks/drink.jpg','2 Ron + 2 Bebida elección',1),(2,'2x1 Pisco Mistral',1,4800,'/img/products/drinks/drink.jpg','2 Pisco + 2 bebida a elección ',1),(3,'Heineken al 50%',2,2100,'/img/products/drinks/drink.jpg','Cerveza en descuento',1),(4,'2x1 Mojito Cubano',1,5000,'/img/products/drinks/drink.jpg','2 Mojitos ',1);

#
# Structure for table "pedidos"
#

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuenta_id` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `promocion_id` int(11) DEFAULT NULL,
  `precio` double NOT NULL,
  `comentario` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `pago_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pedidos_cuenta_idx` (`cuenta_id`),
  KEY `fk_pedidos_producto_idx` (`producto_id`),
  KEY `fk_pedidos_promocion_idx` (`promocion_id`),
  KEY `fk_pedidos_estado_idx` (`estado_id`),
  KEY `fk_pedidos_pagos_idx` (`pago_id`),
  CONSTRAINT `fk_pedidos_cuenta` FOREIGN KEY (`cuenta_id`) REFERENCES `cuentas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedidos_estado` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedidos_pagos` FOREIGN KEY (`pago_id`) REFERENCES `pagos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedidos_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedidos_promocion` FOREIGN KEY (`promocion_id`) REFERENCES `promociones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

#
# Data for table "pedidos"
#


#
# Structure for table "produc_promo_pedidos"
#

DROP TABLE IF EXISTS `produc_promo_pedidos`;
CREATE TABLE `produc_promo_pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `funcionario_id` int(11) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_ppp_pedido_idx` (`pedido_id`),
  KEY `fk_ppp_producto_idx` (`producto_id`),
  KEY `fk_ppp_funcionario_idx` (`funcionario_id`),
  CONSTRAINT `fk_ppp_funcionario` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ppp_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ppp_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

#
# Data for table "produc_promo_pedidos"
#


#
# Structure for table "prod_promo"
#

DROP TABLE IF EXISTS `prod_promo`;
CREATE TABLE `prod_promo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) NOT NULL,
  `promocion_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_prodpromo_producto_idx` (`producto_id`),
  KEY `fk_prodpromo_promocion_idx` (`promocion_id`),
  CONSTRAINT `fk_prodpromo_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_prodpromo_promocion` FOREIGN KEY (`promocion_id`) REFERENCES `promociones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

#
# Data for table "prod_promo"
#

INSERT INTO `prod_promo` VALUES (1,1,1),(2,1,1),(3,3,2),(4,3,2),(5,5,3),(7,15,4),(8,15,4);

#
# Structure for table "turnos"
#

DROP TABLE IF EXISTS `turnos`;
CREATE TABLE `turnos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hora_inicio` time NOT NULL,
  `hora_termino` time NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "turnos"
#

INSERT INTO `turnos` VALUES (1,'11:00:00','17:59:00','Mañana'),(2,'18:00:00','23:59:00','Tarde');

#
# Structure for table "funcionario_mesa"
#

DROP TABLE IF EXISTS `funcionario_mesa`;
CREATE TABLE `funcionario_mesa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `funcionario_id` int(11) NOT NULL,
  `mesa_id` int(11) NOT NULL,
  `turno_id` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `activo` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_funcionario_idx` (`funcionario_id`),
  KEY `fk_mesa_idx` (`mesa_id`),
  KEY `fk_turno_idx` (`turno_id`),
  CONSTRAINT `fk_funcionario` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mesa` FOREIGN KEY (`mesa_id`) REFERENCES `mesas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_turno` FOREIGN KEY (`turno_id`) REFERENCES `turnos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

#
# Data for table "funcionario_mesa"
#

INSERT INTO `funcionario_mesa` VALUES (1,1,1,1,'2016-11-18',1),(2,1,2,1,'2016-11-18',1),(3,1,3,1,'2016-11-18',1),(7,1,4,1,'2016-11-18',1),(8,1,5,1,'2016-11-18',1),(9,1,6,1,'2016-11-18',1);
