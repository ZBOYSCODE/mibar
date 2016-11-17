
	<div id="products-modal" class="menu-products-list-modal modal fade" role="dialog">
	    <div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
			    <div class="modal-header card">
			        <button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title"><i class="fa fa-list-alt"></i> MI CUENTA</h4>
			    </div>

			    <div class="row card">
			        <div class="pull-left nav-user-details-modal">
			            {{ image("img/avatars/waiter.png", "alt":"Avatar", "class":"nav-avatar avatar-sm-card img-responsive") }}
			            <h2 class="nav-subtitle">{{ session.get('auth-identity')['nombre'] }}</h2>
			        </div>
			        
			        <h2 class="pull-right nav-subtitle"> Mesa: {{ session.get('auth-identity')['mesa'] }}</h2>
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

	
