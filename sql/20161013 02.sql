ALTER TABLE `mibar`.`clientes` 
ADD INDEX `fk_cliente_tipo_cliente_idx` (`tipo_cliente_id` ASC);
ALTER TABLE `mibar`.`clientes` 
ADD CONSTRAINT `fk_cliente_tipo_cliente`
  FOREIGN KEY (`tipo_cliente_id`)
  REFERENCES `mibar`.`tipo_clientes` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


ALTER TABLE `mibar`.`cuentas` 
ADD INDEX `fk_cuentas_cliente_idx` (`cliente_id` ASC),
ADD INDEX `fk_cuentas_mesa_idx` (`mesa_id` ASC),
ADD INDEX `fk_cuentas_funcionario_idx` (`funcionario_id` ASC),
ADD INDEX `fk_cuentas_pago_idx` (`pago_id` ASC),
ADD INDEX `fk_cuentas_bar_idx` (`bar_id` ASC);
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
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_cuentas_funcionario`
  FOREIGN KEY (`funcionario_id`)
  REFERENCES `mibar`.`funcionarios` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_cuentas_pago`
  FOREIGN KEY (`pago_id`)
  REFERENCES `mibar`.`pagos` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_cuentas_bar`
  FOREIGN KEY (`bar_id`)
  REFERENCES `mibar`.`bares` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


ALTER TABLE `mibar`.`funcionarios` 
ADD INDEX `fk_funcionarios_rol_idx` (`rol_id` ASC);
ALTER TABLE `mibar`.`funcionarios` 
ADD CONSTRAINT `fk_funcionarios_rol`
  FOREIGN KEY (`rol_id`)
  REFERENCES `mibar`.`roles` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


ALTER TABLE `mibar`.`mesas` 
ADD INDEX `fk_mesas_funcionario_idx` (`funcionario_id` ASC);
ALTER TABLE `mibar`.`mesas` 
ADD CONSTRAINT `fk_mesas_funcionario`
  FOREIGN KEY (`funcionario_id`)
  REFERENCES `mibar`.`funcionarios` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


ALTER TABLE `mibar`.`pagos` 
ADD INDEX `fk_pagos_descuento_idx` (`descuento_id` ASC),
ADD INDEX `fk_pagos_funcionario_idx` (`funcionario_id` ASC);
ALTER TABLE `mibar`.`pagos` 
ADD CONSTRAINT `fk_pagos_descuento`
  FOREIGN KEY (`descuento_id`)
  REFERENCES `mibar`.`descuentos` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_pagos_funcionario`
  FOREIGN KEY (`funcionario_id`)
  REFERENCES `mibar`.`funcionarios` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


  ALTER TABLE `mibar`.`pedidos` 
ADD INDEX `fk_pedidos_cuenta_idx` (`cuenta_id` ASC),
ADD INDEX `fk_pedidos_producto_idx` (`producto_id` ASC),
ADD INDEX `fk_pedidos_promocion_idx` (`promocion_id` ASC),
ADD INDEX `fk_pedidos_estado_idx` (`estado_id` ASC);
ALTER TABLE `mibar`.`pedidos` 
ADD CONSTRAINT `fk_pedidos_cuenta`
  FOREIGN KEY (`cuenta_id`)
  REFERENCES `mibar`.`cuentas` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_pedidos_producto`
  FOREIGN KEY (`producto_id`)
  REFERENCES `mibar`.`productos` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_pedidos_promocion`
  FOREIGN KEY (`promocion_id`)
  REFERENCES `mibar`.`promociones` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_pedidos_estado`
  FOREIGN KEY (`estado_id`)
  REFERENCES `mibar`.`estados` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;



ALTER TABLE `mibar`.`prod_promo` 
ADD INDEX `fk_prodpromo_producto_idx` (`producto_id` ASC),
ADD INDEX `fk_prodpromo_promocion_idx` (`promocion_id` ASC);
ALTER TABLE `mibar`.`prod_promo` 
ADD CONSTRAINT `fk_prodpromo_producto`
  FOREIGN KEY (`producto_id`)
  REFERENCES `mibar`.`productos` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_prodpromo_promocion`
  FOREIGN KEY (`promocion_id`)
  REFERENCES `mibar`.`promociones` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


  ALTER TABLE `mibar`.`produc_promo_pedidos` 
ADD INDEX `fk_ppp_pedido_idx` (`pedido_id` ASC),
ADD INDEX `fk_ppp_producto_idx` (`producto_id` ASC),
ADD INDEX `fk_ppp_funcionario_idx` (`funcionario_id` ASC);
ALTER TABLE `mibar`.`produc_promo_pedidos` 
ADD CONSTRAINT `fk_ppp_pedido`
  FOREIGN KEY (`pedido_id`)
  REFERENCES `mibar`.`pedidos` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ppp_producto`
  FOREIGN KEY (`producto_id`)
  REFERENCES `mibar`.`productos` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_ppp_funcionario`
  FOREIGN KEY (`funcionario_id`)
  REFERENCES `mibar`.`funcionarios` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;



ALTER TABLE `mibar`.`productos` 
ADD INDEX `fk_productos_categoria_idx` (`categoria_id` ASC);
ALTER TABLE `mibar`.`productos` 
ADD CONSTRAINT `fk_productos_categoria`
  FOREIGN KEY (`categoria_id`)
  REFERENCES `mibar`.`categoria_productos` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;



ALTER TABLE `mibar`.`promociones` 
ADD INDEX `fk_promociones_tipopromo_idx` (`tipo_promo_id` ASC);
ALTER TABLE `mibar`.`promociones` 
ADD CONSTRAINT `fk_promociones_tipopromo`
  FOREIGN KEY (`tipo_promo_id`)
  REFERENCES `mibar`.`tipo_promo` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;



ALTER TABLE `mibar`.`reservas` 
ADD INDEX `fk_reserva_cliente_idx` (`cliente_id` ASC),
ADD INDEX `fk_reserva_mesa_idx` (`mesa_id` ASC),
ADD INDEX `fk_reserva_estado_idx` (`estado_id` ASC);
ALTER TABLE `mibar`.`reservas` 
ADD CONSTRAINT `fk_reserva_cliente`
  FOREIGN KEY (`cliente_id`)
  REFERENCES `mibar`.`clientes` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_reserva_mesa`
  FOREIGN KEY (`mesa_id`)
  REFERENCES `mibar`.`mesas` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_reserva_estado`
  FOREIGN KEY (`estado_id`)
  REFERENCES `mibar`.`estados` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;



ALTER TABLE `mibar`.`stock` 
ADD INDEX `fk_stock_producto_idx` (`producto_id` ASC),
ADD INDEX `fk_stock_bodega_idx` (`bodega_id` ASC);
ALTER TABLE `mibar`.`stock` 
ADD CONSTRAINT `fk_stock_producto`
  FOREIGN KEY (`producto_id`)
  REFERENCES `mibar`.`productos` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_stock_bodega`
  FOREIGN KEY (`bodega_id`)
  REFERENCES `mibar`.`bodegas` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;








































































