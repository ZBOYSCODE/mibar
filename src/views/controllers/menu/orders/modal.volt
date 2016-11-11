
	<div id="products-modal" class="menu-products-list-modal modal fade" role="dialog">
	    <div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
			    <div class="modal-header card">
			        <button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title"><i class="fa fa-list-alt"></i> MI CARRO</h4>
			    </div>
			     <div class="row user-details card">
			    	<div class="col-xs-2 col-md-2">
			    		{{ image("img/avatars/default.png", "alt":"", "class":"img-responsive") }}
			    	</div>
			    	<div class="col-xs-7 col-md-7">
			    		<p>{{ session.get('auth-identity')['nombre'] }}</p>
			    	</div>
			    	<div class="col-xs-3 col-md-3">
			    		<p>Mesa {{ session.get('auth-identity')['mesa'] }}</p>
			    	</div>
			    </div>
			    <div class="modal-body">
			      <!-- Products -->
					
					<div class="lista_pedidos">

						{% for pedido in pedidos %}

							<div class="card" id='pedido-{{pedido.num_pedido}}'>
						      	<div class="product-item-modal">
						      		<button type="button" data-pedido="{{ pedido.num_pedido }}" class="btn btn-small btn-main btn-delete pull-right delete-pedido">Eliminar</button>
						      		<p class="title">{{ pedido.nombre }}</p>
						      		<div class="row">
						      			<div class="col-xs-6 col-md-6">
						      				<p><b><i class="fa fa-bar-chart"></i> Cantidad: </b>{{ pedido.cantidad }}</p>
						      			</div>
						      			<div class="col-xs-6 col-md-6">
						      				<p><b><i class="fa fa-calculator"></i> Total Pedido: </b>$<span>{{ utility._number_format(pedido.precio) }}</span></p>
						      			</div>
						      		</div>
						      		<div class="comment">
						      			<b><i class="fa fa-commenting"></i> Comentario:</b>
						      			<p>{{ pedido.comentario }}</p>
						      		</div>
						      	</div>
					        </div>

						{% endfor %}

					</div>

					
						


			    </div>
			    <div class="modal-footer card">
			    	<div class="row">
			    		<div class='col-xs-8'>
							<span class="precio-total pull-left"><b>Total Pedido: </b>$ {{ utility._number_format(total_pedido) }}</span>
						</div>
						<div class='col-xs-4'>
							<button id="Send-Products" type="button" class="btn btn-main pull-right">ENVIAR PEDIDO</button>
						</div>
			    	</div>
				    	
			      
			    </div>
		    </div>
	    </div>
	</div>

	
