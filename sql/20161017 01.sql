ALTER TABLE `mibar`.`produc_promo_pedidos`
  CHANGE COLUMN `funcionario_id` `funcionario_id` int(11) NULL DEFAULT NULL;

ALTER TABLE `mibar`.`produc_promo_pedidos`
CHANGE COLUMN `estado` `estado` tinyint(1) NOT NULL DEFAULT 0;

ALTER TABLE `mibar`.`promociones`
  CHANGE COLUMN `nombre` `nombre` varchar(255) NOT NULL DEFAULT '';

ALTER TABLE `mibar`.`productos`
  ADD COLUMN `avatar` varchar(255) NOT NULL DEFAULT '';


INSERT INTO `mibar`.`subcategoria_productos` SET `id`=5,`categoria_producto_id`=2,`nombre`='Hamburguesas';  
INSERT INTO `mibar`.`productos` SET `id`=5,`nombre`='Mini Mac',`precio`=4500,`descripcion`='Hamburguesa Pequeña',`subcategoria_id`=1,`codigo`='3',`avatar`='/img/products/food/food.jpg';

UPDATE `mibar`.`productos` SET `avatar`='/img/products/drinks/drink.jpg' WHERE `id`=1;
UPDATE `mibar`.`productos` SET `avatar`='/img/products/drinks/drink.jpg' WHERE `id`=2;





