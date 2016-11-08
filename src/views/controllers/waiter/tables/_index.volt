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

                        <a href="{{ url('waiter/tableDetails') }}/{{ mesa.id }}" class='btn btn-main btn-small dpull-right pull-right-top'>Detalle</a>

                        <a id='btn-liberar-mesa' data-mesaid="{{ mesa.id }}" class='pull-right btn btn-main btn-small' data-url="waiter/freetable">Liberar</a>
                    </div>  
                    
                </div>

                
                
            </div>
        </div>




    {% endfor %}   
</div>


    
    <div id="table-modal">
        
    </div>

    <div id="table-modal-orders">
        
    </div>    

    