
	<div id="products-modal" class="menu-products-list-modal modal fade" role="dialog">
	    <div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
			    <div class="modal-header card">
			        <button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title"><i class="fa fa-list-alt"></i> Caja - Detalles de Pedido</h4>
			    </div>
			     <div class="row user-details card">
			    	<div class="col-xs-6 col-md-6">
			    		<p>Cliente: {{ cliente.nombre  }} {% if cliente.apellido != null %}{{ cliente.apellido }}{% endif %}</p>
			    	</div>
					 <div class="col-xs-5 col-md-5">
						 <p>Mesa: </p>
					 </div>
					 <div class="col-xs-1 col-md-1">
						 {{ image("img/avatars/default.png", "alt":"", "class":"img-responsive") }}
					 </div>
			    </div>
			    <div class="modal-body">
			      <!-- Products -->
					
					<div class="lista_pedidos">

						{% for producto in productos %}

							<div class="card" id='pedido-{{producto.id}}'>
						      	<div class="product-item-modal">
						      		<p class="title">{{ pedido.nombre }}</p>
						      		<div class="row">

						      			<div class="col-xs-4 col-md-4">
											<img src="{{ pedido.avatar }}" alt="" class="img-responsive">
						      			</div>
						      			<div class="col-xs-8 col-md-8">
											<div class="row">
												<div class="col-xs-6 col-md-6">
													<p><b><i class="fa fa-money"></i> Precio: </b>$<span>{{ producto.precio }}</span></p>
												</div>
												<div class="col-xs-6 col-md-6">
													<p><b><i class="fa fa-money"></i> Cantidad: </b><span>{{ cantidad[producto.id] }}</span></p>
												</div>
												<div lass="col-xs-12 col-md-12">
													<p><b><i class="fa fa-calculator"></i> Toral: </b>$<span>{{ producto.precio * cantidad[producto.id] }}</span></p>
												</div>
												<div lass="col-xs-12 col-md-12">
													<p><b><i class="fa fa-comment-o"></i> Descripción: </b>$<span>{{ producto.descripcion }}</span></p>
												</div>
											</div>
						      			</div>
						      		</div>
						      	</div>
					        </div>

						{% endfor %}

					</div>

					
						


			    </div>
			    <div class="modal-footer card">
			    	<div class="row">
			    		<div class='col-xs-5'>
							<span class="precio-total">$ 0</span>
						</div>
						<div class='col-xs-7'>
							<button id="Send-Products" type="button" class="btn btn-main pull-right">Ir a Pagar</button>
						</div>
			    	</div>
				    	
			      
			    </div>
		    </div>
	    </div>
	</div>

	
