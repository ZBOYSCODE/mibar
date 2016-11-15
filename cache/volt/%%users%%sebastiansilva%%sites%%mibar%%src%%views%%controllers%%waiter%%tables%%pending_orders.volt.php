<div id="pending_orders" class="menu-products-list-modal modal fade" role="dialog">
	    <div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
			    <div class="modal-header card">
			        <button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title"><i class="fa fa-list-alt"></i>PEDIDOS PENDIENTES</h4>
			    </div>
			    <div class="row card">
			        <div class="pull-left nav-user-details-modal">
			            <?= $this->tag->image(['img/avatars/default.png', 'alt' => 'Avatar', 'class' => 'nav-avatar avatar-sm-card img-responsive']) ?>
			            <h2 class="nav-subtitle"><?= $cuenta->Clientes->nombre . ' ' . $cuenta->Clientes->apellido ?></h2>
			        </div>
			        
			        <h2 class="pull-right nav-subtitle"> Mesa: <?= $cuenta->Mesas->numero ?></h2>
			    </div>
			    <div class="modal-body">

			    <?php if ($pedidosCuenta == false) { ?>


		            <div class="card text-center margin-bottom-last-card">
		               <h4>No hay Pedidos Pendientes.</h4>
		            </div>
		            </div>
				    </div>

					<div class="menu-footer">
						<div class="row menu-footer-buttons card">
							<button  class="btn btn-main" class="close modal-close" data-dismiss="modal">CERRAR</button>
						</div>
					</div>	


			    <?php } else { ?>

			    	<form id="form-validar">
						<div class="lista_pedidos modal-bottom">

							<?php foreach ($pedidosCuenta as $pedido) { ?>

								<?php if (isset($pedido->producto_id)) { ?>
									<?php $title = $pedido->Productos->nombre; ?>
								<?php } else { ?>
									<?php $title = $pedido->Promociones->nombre; ?>
								<?php } ?>
					
								<div class="card" id='pedido-<?= $pedido->id ?>'>
							      	<div class="product-item-modal">
										<div class="wine-switch">
						                   <input id="<?= $pedido->id ?>" class="checkPedido" name="approve_order[]" type="checkbox" value="<?= $pedido->id ?>"/>
						                   <label for="<?= $pedido->id ?>" class="label-success"></label>
						               </div>
							      		<p class="title"><?= $title ?></p>
							      		<div class="row">
							      			<div class="col-xs-6 col-md-6">
							      				<p><b><i class="fa fa-calculator"></i> Precio: </b>$<span><?= $pedido->precio ?></span></p>
							      			</div>
							      			<div class="col-xs-6 col-md-6">
							      			
							      			<b><i class="fa fa-commenting"></i> Comentario:</b>
							      			<p><?= $pedido->comentario ?></p>
							      		
							      			</div>
							      		</div>
							    
							      	</div>
						        </div>

					        <?php } ?>
						</div>
					</form>
			    </div>
		    </div>

			<div class="menu-footer">
				<div class="row menu-footer-buttons card">
					<button id="btn-entregar-pedidos" class="btn btn-main btnAjax" data-url="<?= $this->url->get('waiter/deliverOrders') ?>" data-callname="btn-entregar-pedidos" data-table="<?= $cuenta->mesa_id ?>">ENTREGAR PEDIDOS</button>
				</div>
			</div>	
		    <?php } ?>
	    </div>


	</div>


	