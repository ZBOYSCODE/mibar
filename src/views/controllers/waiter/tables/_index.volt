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
                        <p class="title">MESA {{ mesa.numero }} </p>
                        <p class="description">Total Pedidos: {{ pedidosTotales[mesa.id] }}</p>
                        <p class="description">Pedidos Pendientes: {{ pedidosPendientes[mesa.id] }}</p>
                        <p id="estado" class="description">Estado: {{ mesa.EstadosMesa.name }}</p>
                        
                        {% if pedidosTotales[mesa.id] != 0 %}
                        <div class="row">
    {#
                            <a href="{{ url('waiter/tableDetails') }}/{{ mesa.id }}" class='btn btn-main btn-small dpull-right pull-right-top'>Detalle</a>
                            
                            
                                <button type="button" class="btnAjax btn btn-small btn-main pull-right table-details-button" data-cuenta="{{ mesa.cuenta_id }}" data-callName="table-details-button" data-table="{{ mesa.id }}" data-numero="{{ mesa.numero }}" data-url="waiter/tableDetails">Detalles</button>
                            
                        </div>
                             #}

                               <button type="button" class="btnAjax btn btn-small btn-main pull-right table-details-button" data-cuenta="{{ mesa.cuenta_id }}" data-callName="table-details-button" data-table="{{ mesa.id }}" data-numero="{{ mesa.numero }}" data-url="waiter/tableDetails">Detalles</button>
                            </div>
                        {% else %}
                        <div class="row">
                               <button type="button" class="btnAjax btn btn-small btn-main pull-right table-details-button hidden" data-cuenta="{{ mesa.cuenta_id }}" data-callName="table-details-button" data-table="{{ mesa.id }}" data-numero="{{ mesa.numero }}" data-url="waiter/tableDetails" >Detalles</button>
                            </div>

                        {% endif %}

                    </div>  
                    
                </div>

                {#
                    <button type="button" data-href="{{mesa.numero}}" data-mesaid="{{ mesa.id }}" data-cuenta="{{ mesa.cuenta_id }}" class="btn btn-small btn-main pull-right table-order-button" data-url="waiter/tableDetails">Crear Pedido</button>
                #}
            </div>
        </div>




    {% endfor %}   
</div>


    
    <div id="table-modal">
        
    </div>

    <div id="table-modal-orders">
        
    </div>    

    