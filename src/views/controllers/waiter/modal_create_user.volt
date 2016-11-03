
	<div id="create-client-modal" class="menu-create-client-modal modal fade" role="dialog">
	    <div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
			    <div class="modal-header card">
			        <button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title"><i class="fa fa-list-alt"></i> CREAR CLIENTE</h4>
			    </div>

			    <div class="modal-body">
			      <!-- Products -->
			      	<label for="nombre-cliente">Nombre cliente</label>
					<input type="text" id='nombre-cliente' class='form-control'>
					<div class="box-errors">
						<p class='error' id='error-nombre-cliente'></p>
					</div>	
			    </div>
			    <div class="modal-footer card">
			    	<div class="row">

						<div class='col-xs-12'>
							<button id="store-cliente" type="button" data-url="{{ url('waiter/storeClient') }}" data-callName="store-cliente-success" data-table='{{ mesa_id }}' data-cuenta='{{ cuenta_id }}' class="btn btn-main pull-right">CREAR</button>
						</div>
			    	</div>
				    	
			      
			    </div>
		    </div>
	    </div>
	</div>

