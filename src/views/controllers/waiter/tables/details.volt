<div id="waiter_tables_details_render">
   
    <div class="card">
	    <div class="row">
	    	<div class="col-xs-10 col-sm-10">
	    		 <h4 class="card-title"><i class="fa fa-list-alt"></i> DETALLES MESA {{ numeroMesa }}</h4>
	    	</div>
	    	<div class="col-xs-2 col-sm-2">
	    		<h4 class="pull-right"><a href="#" id='create-user' data-url="{{ url('waiter/createUser') }}" data-callName="create-user-modal" data-table='{{ table_id }}' class="btn btn-main btn-round create-user-button">
	            <i class="fa fa-user-plus"></i>
	        </a></h4>
	    	</div>
	    </div>  
    </div>

    {% if detalles == false %}

    	<div class="card text-center">
    	   <h3>Esta mesa no tiene pedidos asociados.</h3>
    	</div>

    {% else %}
  <!-- Details -->
    {% for detalle in detalles %}
       
    	<div class="table-item card" id='cuenta-{{ detalle['cuenta'].id }}' data-cuenta="{{ detalle['cuenta'].id }}" data-estado-mesa="{{ detalle['cuenta'].estado }}">
    	    <div class="row">
    	        <div class="col-xs-4 col-sm-4">
    	            <div class="table-item-img table-item-details-img">
    	                {{ image("img/avatars/default.png", "alt":"", "class":"img-responsive") }}
    	            </div>  
    	        </div>
    	        <div class="col-xs-8 col-sm-8">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <button type="button" id='delete-cuenta' class="btn btn-main btn-delete btn-sm delete-cuenta-button pull-right" data-cuenta="{{ detalle['cuenta'].id }}" data-callName="delete-cuenta-button" data-url="{{ url('waiter/deleteCuenta') }}">
                                <i class="fa fa-trash"></i>
                                <span class='hidden-xs'>Eliminar</span>
                            </button>
                        </div>
                    </div> 
    	            <div class="table-item-details">
    	                <p class="description"><b>Cliente: </b>{{ detalle['cuenta'].Clientes.nombre ~ " " ~ detalle['cuenta'].Clientes.apellido }}</p>
    	                <p class="description"><b>N° Pedidos: </b>{{ detalle['cantidad'] }}</p>
    	                <p class="description"><b>Subtotal: </b>$ {{ utility._number_format(detalle['subtotal']) }}</p>
    	            </div> 
    	        </div>
    	    </div>
    	    <div class="table-item-footer">
                <div class="row table-item-buttons">
                    <div class="col-xs-4 col-sm-4 col-md-2 col-md-offset-6">
                        <a href="{{ url('waiter/createOrder') }}/{{ detalle['cuenta'].id }}" class='btn btn-main'>
                            <i class="fa fa-plus"></i>
                            <span class='hidden-xs'>Crear orden</span>
                        </a>

                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-2">
                        <button type="button" class="btn btn-main detalle-cuenta" data-callName="bill-details-button" data-url="{{ url('waiter/billDetails') }}" data-cuenta="{{ detalle['cuenta'].id }}" >
                            <i class="fa fa-check-square-o"></i>
                            <span class='hidden-xs'>Pendientes</span>
                        </button>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-2">
                        <button type="button" class="btn btn-main pedidos-pendientes" data-callName="pedidos-pendientes" data-url="{{ url('waiter/getPendingOrders') }}" data-cuenta="{{ detalle['cuenta'].id }}" >
                            <i class="fa fa-clock-o"></i>
                            <span class='hidden-xs'>Por entregar</span>    
                        </button>
                    </div>
                </div>
    	    </div>
    	</div>

    {% endfor %}
			   
    
    <div id="table_modal_orders_render"></div>
    <div id="table_modal_pending_orders_render"></div>
	
    {% endif %}

</div>