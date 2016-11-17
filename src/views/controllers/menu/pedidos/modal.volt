
	<div id="products-modal" class="menu-products-list-modal modal fade" role="dialog">
	    <div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
			    <div class="modal-header card">
			        <button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title"><i class="fa fa-list-alt"></i> MIS PEDIDOS</h4>
			    </div>
			    <div class="row card">
			        <div class="pull-left nav-user-details-modal">
			            {{ image("img/avatars/waiter.png", "alt":"Avatar", "class":"nav-avatar avatar-sm-card img-responsive") }}
			            <h2 class="nav-subtitle nav-margin-left">{{ session.get('auth-identity')['nombre'] }}</h2>
			        </div>
			        
			        <h2 class="pull-right nav-subtitle"> Mesa: {{ session.get('auth-identity')['mesa'] }}</h2>
			    </div>
			    <div class="modal-body">
			      <!-- Pedidos -->
					
					<div class="lista_pedidos">

						{% for lista in lista_pedidos %}

							<div class="card" class='item-pedido'>
						      	<div class="product-item-modal">
						      	    <h3><i class="fa fa-clock-o"></i> {{ date('H:i', utility._strtotime(lista['fecha'])) }}</h3>
						      		<h3><i class="fa fa-calendar"></i> {{ date('d-m-Y', utility._strtotime(lista['fecha'])) }}</h3>
						      		<h3><i class="fa fa-money"></i> Total $ {{utility._number_format(lista['total'])}}</h3>

						      		<div>
										
										<table class='table'>

											<thead>
												<th>Cnt</th>
												<th>Nombre</th>
												{#<th>Precio c/u</th>#}
												<th>Precio</th>
												<th>Estado</th>
											</thead>

											<tbody>
							
												{% for pedido in lista['pedidos'] %}

													<tr>
														<td>{{ pedido['cantidad'] }} </td>
														<td>{{ pedido['producto_nombre'] }}</td>
														{#<td class='text-right'>$<?php echo number_format($pedido['producto']->precio, '0', ',', '.') ?></td>#}

														<td class='text-right'>$<?php echo number_format( ($pedido['producto']->precio * $pedido['cantidad']), '0', ',', '.') ?></td>
														<td>
															<div class="led-{{pedido['color']}} led pull-right" id='estado-{{pedido['producto'].estado_id}}' ></div>
															<span class='pull-right'>{{pedido['color_nombre'] }}</span>
														</td>
													</tr>

										      	{% endfor %}
									      	</tbody>

									      	<tfooter>
									      		<th></th>
									      		<th></th>
									      		<th class='text-right'>TOTAL</th>
									      		<th class='text-right'>$<?php echo number_format($lista['total'], '0', ',', '.') ?></th>
									      		<th> </th>
									      	</tfooter>

									     </table>
						      		</div>
						      	</div>
					        </div>
						{% endfor %}
					</div>

					
						


			    </div>
			    <div class="modal-footer card">
			    	<div class="row">
			    		<div class='col-xs-12'>
							<span class="precio-total">TOTAL A PAGAR $ {{ total_pedido }}</span>
						</div>
						
						{#
						<div class='col-xs-7'>
							<button id="Send-Products" type="button" class="btn btn-main pull-right">ENVIAR PEDIDO</button>
						</div>
						#}
			    	</div>
				    	
			      
			    </div>
		    </div>
	    </div>
	</div>

	
