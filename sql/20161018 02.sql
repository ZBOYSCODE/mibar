UPDATE `mibar`.`cuentas` SET `estado`='1' WHERE `id`='1';


ALTER TABLE `mibar`.`cuentas` 
DROP FOREIGN KEY `fk_cuentas_pago`;
ALTER TABLE `mibar`.`cuentas` 
DROP COLUMN `pago_id`,
DROP INDEX `fk_cuentas_pago_idx` ;


CREATE TABLE `mibar`.`cuentas_pagos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `pago_id` INT NOT NULL,
  `cuenta_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_cuenta_idx` (`cuenta_id` ASC),
  INDEX `fk_cp_pago_idx` (`pago_id` ASC),
  CONSTRAINT `fk_cp_cuenta`
    FOREIGN KEY (`cuenta_id`)
    REFERENCES `mibar`.`cuentas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cp_pago`
    FOREIGN KEY (`pago_id`)
    REFERENCES `mibar`.`pagos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


ALTER TABLE `mibar`.`pedidos` 
ADD COLUMN `pagado` INT NULL AFTER `updated_at`;


ALTER TABLE `mibar`.`pagos` 
DROP FOREIGN KEY `fk_pagos_descuento`;
ALTER TABLE `mibar`.`pagos` 
CHANGE COLUMN `descuento_id` `descuento_id` INT(11) NULL ;
ALTER TABLE `mibar`.`pagos` 
ADD CONSTRAINT `fk_pagos_descuento`
  FOREIGN KEY (`descuento_id`)
  REFERENCES `mibar`.`descuentos` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

INSERT INTO `mibar`.`cuentas_pagos` (`pago_id`, `cuenta_id`) VALUES ('1', '1');

INSERT INTO `mibar`.`cuentas_pagos` (`pago_id`, `cuenta_id`) VALUES ('1', '1');

ALTER TABLE `mibar`.`pedidos` 
CHANGE COLUMN `pagado` `pago_id` INT(11) NULL ,
ADD INDEX `fk_pedidos_pagos_idx` (`pago_id` ASC);
ALTER TABLE `mibar`.`pedidos` 
ADD CONSTRAINT `fk_pedidos_pagos`
  FOREIGN KEY (`pago_id`)
  REFERENCES `mibar`.`pagos` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;



ALTER TABLE `mibar`.`mesas` 
ADD COLUMN `bar_id` INT NULL AFTER `estado`,
ADD INDEX `fk_mesas_bares_idx` (`bar_id` ASC);
ALTER TABLE `mibar`.`mesas` 
ADD CONSTRAINT `fk_mesas_bares`
  FOREIGN KEY (`bar_id`)
  REFERENCES `mibar`.`bares` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;



ALTER TABLE `mibar`.`cuentas` 
DROP FOREIGN KEY `fk_cuentas_bar`;
ALTER TABLE `mibar`.`cuentas` 
DROP COLUMN `bar_id`,
DROP INDEX `fk_cuentas_bar_idx` ;



UPDATE `mibar`.`mesas` SET `bar_id`='1' WHERE `id`='1';
UPDATE `mibar`.`mesas` SET `bar_id`='1' WHERE `id`='2';
UPDATE `mibar`.`mesas` SET `bar_id`='1' WHERE `id`='3';
UPDATE `mibar`.`mesas` SET `bar_id`='1' WHERE `id`='6';


	
INSERT INTO `mibar`.`estados` (`id`, `nombre`) VALUES ('5', 'Entregado');

UPDATE `mibar`.`pedidos` SET `estado_id`='1' WHERE `id`='24';


UPDATE `mibar`.`produc_promo_pedidos` SET `estado`='1' WHERE `id`='1';
UPDATE `mibar`.`produc_promo_pedidos` SET `estado`='1' WHERE `id`='2';


