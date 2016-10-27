
	<div id="products-modal" class="menu-products-list-modal modal fade" role="dialog">
	    <div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
			    <div class="modal-header card">
			        <button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title"><i class="fa fa-list-alt"></i> MI CUENTA</h4>
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

			    <div class="modal-body ">
			      <!-- Products -->
					<div class="row card">
						<h4>Llevas un total de <span class="precio-total">$ {{ total_pedido }}</span></h4>
					</div>
					

			    </div>

			    <div class="modal-footer card">

					<div class='col-xs-7'>
						<button id="Send-Products" type="button" class="btn btn-main ">PAGAR</button>
					</div>
				    	
			    </div>
		    </div>
	    </div>
	</div>

	
