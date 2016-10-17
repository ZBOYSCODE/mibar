ALTER TABLE `mibar`.`produc_promo_pedidos`
  CHANGE COLUMN `funcionario_id` `funcionario_id` int(11) NULL DEFAULT NULL;

ALTER TABLE `mibar`.`produc_promo_pedidos`
CHANGE COLUMN `estado` `estado` tinyint(1) NOT NULL DEFAULT 0;

ALTER TABLE `mibar`.`promociones`
  CHANGE COLUMN `nombre` `nombre` varchar(255) NOT NULL DEFAULT '';