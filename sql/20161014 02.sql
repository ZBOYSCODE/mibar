ALTER TABLE `mibar`.`cuentas` 
DROP FOREIGN KEY `fk_cuentas_cliente`,
DROP FOREIGN KEY `fk_cuentas_mesa`;
ALTER TABLE `mibar`.`cuentas` 
CHANGE COLUMN `cliente_id` `cliente_id` INT(11) NULL ,
CHANGE COLUMN `mesa_id` `mesa_id` INT(11) NULL ;
ALTER TABLE `mibar`.`cuentas` 
ADD CONSTRAINT `fk_cuentas_cliente`
  FOREIGN KEY (`cliente_id`)
  REFERENCES `mibar`.`clientes` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_cuentas_mesa`
  FOREIGN KEY (`mesa_id`)
  REFERENCES `mibar`.`mesas` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


ALTER TABLE `mibar`.`cuentas` 
DROP FOREIGN KEY `fk_cuentas_bar`;
ALTER TABLE `mibar`.`cuentas` 
CHANGE COLUMN `bar_id` `bar_id` INT(11) NULL ;
ALTER TABLE `mibar`.`cuentas` 
ADD CONSTRAINT `fk_cuentas_bar`
  FOREIGN KEY (`bar_id`)
  REFERENCES `mibar`.`bares` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
