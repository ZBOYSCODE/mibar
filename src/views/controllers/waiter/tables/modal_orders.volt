<div id="table-products-modal" class="menu-products-list-modal modal fade" role="dialog">
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
			    		<p>Orlando San Martín</p>
			    	</div>
			    	<div class="col-xs-3 col-md-3">
			    		<p>Mesa 1</p>
			    	</div>
			    </div>
			    <div class="modal-body">
			      <!-- Products -->
					<div class="lista_pedidos">
						<div class="card" id='pedido-{{pedido.num_pedido}}'>
					      	<div class="product-item-modal">
					      		<button type="button" data-pedido="{{ pedido.num_pedido }}" class="btn btn-small btn-delete btn-main pull-right delete-pedido">Cancelar</button>
					      		<p class="title">Ron</p>
					      		<div class="row">
					      			<div class="col-xs-6 col-md-6">
					      				<p><b><i class="fa fa-calculator"></i> Precio: </b>$<span>3.500</span></p>
					      			</div>
					      			<div class="col-xs-6 col-md-6">
					      			
					      			<b><i class="fa fa-commenting"></i> Comentario:</b>
					      			<p>Con 2 hielos y una coxina</p>
					      		
					      			</div>
					      		</div>
					    
					      	</div>
				        </div>
					</div>
			    </div>
		    </div>
	    </div>
	</div>

	