<div id="bill-details" class="menu-products-list-modal modal fade" role="dialog">
	    <div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
			    <div class="modal-header card">
			        <button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title"><i class="fa fa-list-alt"></i>PEDIDOS CLIENTE</h4>
			    </div>
			     <div class="row user-details card">
			    	<div class="col-xs-2 col-md-2">
			    		{{ image("img/avatars/default.png", "alt":"", "class":"img-responsive") }}
			    	</div>
			    	<div class="col-xs-7 col-md-7">
			    		<p>{{cuenta.Clientes.nombre}} {{cuenta.Clientes.apellido}}</p>
			    	</div>
			    	<div class="col-xs-3 col-md-3">
			    		<p>Mesa {{ cuenta.Mesas.numero }}</p>
			    	</div>
			    </div>
			    <div class="modal-body">
			      <!-- Products -->
					<div class="lista_pedidos">

						{% for pedido in pedidosCuenta %}

							{% if pedido.producto_id is defined %}
								{% set title = pedido.Productos.nombre %}
							{% else %}
								{% set title = pedido.Promociones.nombre %}
							{% endif %}
				
							<div class="card" id='pedido-{{pedido.id}}'>
						      	<div class="product-item-modal">
						      		<button type="button" data-pedido="{{ pedido.id }}" class="btn btn-small btn-delete btn-main pull-right delete-pedido">Cancelar</button>
						      		<p class="title">{{ title }}</p>
						      		<div class="row">
						      			<div class="col-xs-6 col-md-6">
						      				<p><b><i class="fa fa-calculator"></i> Precio: </b>$<span>{{ pedido.precio }}</span></p>
						      			</div>
						      			<div class="col-xs-6 col-md-6">
						      			
						      			<b><i class="fa fa-commenting"></i> Comentario:</b>
						      			<p>{{ pedido.comentario }}</p>
						      		
						      			</div>
						      		</div>
						    
						      	</div>
					        </div>

				        {% endfor %}
					</div>
			    </div>
		    </div>
	    </div>
	</div>

	