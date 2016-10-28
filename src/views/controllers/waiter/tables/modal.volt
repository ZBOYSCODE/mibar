
	<div id="table-details" class="menu-products-list-modal modal fade" role="dialog">
	    <div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
			    <div class="modal-header card">
			        <button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title"><i class="fa fa-list-alt"></i>DETALLES MESA1</h4>
			    </div>
			    <div class="modal-body">
			      <!-- Details -->
			        {% for detalle in detalles %}
				    	<div class="table-item card" data-categoria="">
				    	    <div class="row">
				    	        <div class="col-xs-4 col-sm-4">
				    	            <div class="table-item-img">
				    	                {{ image("img/avatars/default.png", "alt":"", "class":"img-responsive") }}
				    	            </div>  
				    	        </div>
				    	        <div class="col-xs-8 col-sm-8">
				    	            <div class="table-item-details">
				    	                <button type="button" class="btn btn-main btn-delete btn-sm table-details-button" data-callName="table-details-button" data-url="waiter/tableDetails">Eliminar</button>
				    	                <p class="description"><b>Cliente: </b>{{ detalle['cuenta'].Clientes.nombre ~ " " ~ detalle['cuenta'].Clientes.apellido }}</p>
				    	                <p class="description"><b>N° Pedidos: </b>{{ detalle['cantidad'] }}</p>
				    	                <p class="description"><b>Subtotal: </b>${{ utility._number_format(detalle['subtotal']) }}</p>
				    	            </div>  
				    	        </div>
				    	    </div>
				    	    <div class="table-item-footer">
								<button type="button" class="btn btn-main btn-width detalle-cuenta" data-callName="bill-details-button" data-url="{{ url('waiter/billDetails') }}" data-cuenta="1" >Detalles</button>
				    	    </div>
				    	</div>
                    {% endfor %}
			    </div>
		    </div>
	    </div>
	</div>

	
