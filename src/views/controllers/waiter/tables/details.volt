
   
    <div class="card">
        <h4 class="card-title"><i class="fa fa-list-alt"></i> DETALLES MESA {{ Mesa.numero }}</h4>
    </div>

    <div class="card text-center">
        <a href="#" id='create-user' data-url="{{ url('waiter/createUser') }}" data-callName="create-user-modal" data-table='{{ table_id }}' class="btn btn-main btn-width">
            <i class="fa fa-user-plus"></i>
        </a>
    </div>

    {% if detalles == false %}

    	<div class="card text-center">
    	   <h3>Esta mesa no tiene pedidos asociados.</h3>
    	</div>

    {% else %}
  <!-- Details -->
    {% for detalle in detalles %}
       
    	<div class="table-item card" data-cuenta="{{ detalle['cuenta'].id }}" data-estado-mesa="{{ detalle['cuenta'].estado }}">
    	    <div class="row">
    	        <div class="col-xs-4 col-sm-4">
    	            <div class="table-item-img">
    	                {{ image("img/avatars/default.png", "alt":"", "class":"img-responsive") }}
    	            </div>  
    	        </div>
    	        <div class="col-xs-8 col-sm-8">
    	            <div class="table-item-details">
    	                <button type="button" class="btn btn-main btn-delete btn-sm table-details-button" data-callName="table-details-button" data-url="{{ url('waiter/tableDetails') }}">Eliminar</button>

    	                <p class="description"><b>Cliente: </b>{{ detalle['cuenta'].Clientes.nombre ~ " " ~ detalle['cuenta'].Clientes.apellido }}</p>
    	                <p class="description"><b>N° Pedidos: </b>{{ detalle['cantidad'] }}</p>
    	                <p class="description"><b>Subtotal: </b>$ {{ utility._number_format(detalle['subtotal']) }}</p>
    	            </div>  
    	        </div>
    	    </div>
    	    <div class="table-item-footer">


{#
				<button type="button" class="btn btn-main btn-width detalle-cuenta" data-callName="bill-details-button" data-url="{{ url('waiter/billDetails') }}" data-cuenta="{{ detalle['cuenta'].id }}" >Detalles</button>
                <button type="button" class="btn btn-main btn-width" id='crear-pedido' data-callName="crear-pedido-button" data-url="{{ url('waiter/createOrder') }}" data-cuenta="{{ detalle['cuenta'].id }}" >Crear pedido</button>
 #}

                <a href="{{ url('waiter/createOrder') }}/{{ detalle['cuenta'].id }}" class='btn btn-main btn-width'>Crear pedido</a>

				<button type="button" class="btn btn-main btn-width detalle-cuenta" data-callName="bill-details-button" data-url="{{ url('waiter/billDetails') }}" data-cuenta="{{ detalle['cuenta'].id }}" >Validar</button>
				<button type="button" class="btn btn-main btn-width pedidos-pendientes" data-callName="pedidos-pendientes" data-url="{{ url('waiter/getPendingOrders') }}" data-cuenta="{{ detalle['cuenta'].id }}" >Pendientes</button>

    	    </div>
    	</div>

    {% endfor %}
			   
    
    <div id="table_modal_orders_render"></div>
    <div id="table_modal_pending_orders_render"></div>
	
    {% endif %}