
<div id="waiter_tables_details_render">
    {% for mesa in mesas %}
        <div class="table-item card" data-mesa="{{mesa.id}}" data-estado-mesa="{{mesa.estado_mesa_id}}">
            <div class="row">
                <div class="col-xs-4 col-sm-4">
                    <div class="table-item-img">
                        {{ image("img/avatars/table.png", "alt":"", "class":"img-responsive") }}
                    </div>  
                </div>
                <div class="col-xs-8 col-sm-8">

                    <div class="table-item-details">
                        <p class="title">MESA {{mesa.numero}} </p>
                        <p class="description">Total Pedidos: {{ pedidosTotales[mesa.id] }}</p>
                        <p class="description">Pedidos Pendientes: {{ pedidosPendientes[mesa.id] }}</p>
                        <p id="estado" class="description">Estado: {{ mesa.EstadosMesa.name }}</p>
                        <div class="row">
                           <button type="button" class="btn btn-small btn-main pull-right table-details-button" data-callName="table-details-button" data-table="{{ mesa.id }}" data-url="waiter/tableDetails">Detalles</button>
                        </div>
                    </div>  
                    
                </div>
                <button type="button" data-href="{{mesa.numero}}" class="btn btn-small btn-main pull-right table-order-button" data-url="waiter/tableDetails">Crear Pedido</button>
            </div>
        </div>

    {% endfor %}   
</div>


    
    <div id="table-modal">
        
    </div>

    <div id="table-modal-orders">
        
    </div>    

    