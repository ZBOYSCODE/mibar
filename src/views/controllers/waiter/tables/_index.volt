<div id="waiter_tables_details_render">


    {% for mesa in mesas %}


        <div id="table-item-{{mesa.id}}" class="table-item card" data-mesa="{{mesa.id}}" data-estado-mesa="{{mesa.estado_mesa_id}}">
            <div class="row">

                <div class="col-xs-4 col-sm-4">
                    <div class="table-item-img">
                        {{ image("img/avatars/table.png", "alt":"", "class":"img-responsive") }}
                    </div>  
                </div>

                <div class="col-xs-8 col-sm-8">

                    <div class="table-item-details">
                        <p class="title">MESA {{ mesa.numero }} </p>
                        <p class="description">Total Pedidos: <span id='waiter-totalpedidos-{{mesa.id}}'>{{ pedidosTotales[mesa.id] }}</span></p>
                        <p class="description">Pedidos Pendientes: <span id='waiter-pedidospendientes-{{mesa.id}}'>{{ pedidosPendientes[mesa.id] }}</span></p>
                        <p id="estado" class="description">Estado: <span id='waiter-estado-{{mesa.id}}'>{{ mesa.EstadosMesa.name }}</span></p>
                    </div>  
                </div> 
            </div>
            <div class="row table-item-buttons">
                <div class="col-xs-6 col-sm-6">
                    <a id='btn-liberar-mesa' data-mesaid="{{ mesa.id }}" class='pull-left btn btn-main btn-small btn-release' data-url="waiter/freetable" data-callName='liberar-mesa' >Liberar</a>
                </div>
                <div class="col-xs-6 col-sm-6">
                    <a href="{{ url('waiter/tableDetails') }}/{{ mesa.id }}" class='btn btn-main btn-small pull-right pull-right-top'>Detalle</a> 
                </div>
            </div>
        </div>




    {% endfor %}   
</div>


    
    <div id="table-modal">
        
    </div>

    <div id="table-modal-orders">
        
    </div>    

    