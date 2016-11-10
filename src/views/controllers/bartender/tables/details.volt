<div id="pedido-details-modal" class="menu-products-list-modal modal fade" role="dialog">
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
			    		<p>{{ pedido.nombre }}</p>
			    	</div>
			    	<div class="col-xs-3 col-md-3">
			    		<p></p>
			    	</div>
			    </div>
			    <div class="modal-body">

					<div class="card" id='pedido-'>
				      	<div class="product-item-modal">
				      		<p class="title"></p>
				      		<div class="row">
				      			<div class="col-xs-12 col-md-6">
				      				<p><b><i class="fa fa-money"></i> Precio: </b> ${{ utility._number_format(pedido.precio) }}</p>
				      			</div>
				      			<div class="col-xs-12 col-md-6">
				      				<p><b><i class="fa fa-users"></i> Mesero: </b> {{ mesero.nombre }} {{ mesero.apellido }}</p>
				      			</div>
			      			</div>
			      			<div class="row">


				      			<div class="col-xs-12 col-md-6">
				      				<p><b><i class="fa fa-calendar"></i> Fecha: </b> {{ fecha }}</p>
				      			</div>
				      			<div class="col-xs-12 col-md-6">
				      			
				      				<b><i class="fa fa-clock-o"></i> Hora:</b> {{ hora }}
				      			</div>
			      			</div>

			      			<div class="row">
				      			<div class="col-xs-12 col-md-6">
				      			
				      				<b><i class="fa fa-user"></i> Cliente:</b> {{ pedido.Cuentas.Clientes.nombre }} {{ pedido.Cuentas.Clientes.apellido }}
				      			</div>					      						      			
				      		</div>

				      		<div class="row">

								<div class="col-xs-12 col-md-6">

									<b><i class="fa fa-commenting"></i> Comentario:</b>

								</div>

				      			<div class="col-xs-12 col-md-12">
				      			
				      				 {{ pedido.comentario }}

				      			</div>				      			

				      		</div>
				    
				      	</div>
			        </div>
			      
			    </div>
		    </div>

	    </div>


	</div>


	