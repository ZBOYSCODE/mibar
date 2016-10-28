{% for mesa in mesas %}
    <div class="table-item card" data-categoria="">
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
                    <div class="row">
                       <button type="button" class="btn btn-small btn-main pull-right table-details-button" data-callName="table-details-button" data-table="{{ mesa.id }}" data-url="waiter/tableDetails">Detalles</button>
                    </div>
                </div>  
                
            </div>
        </div>
    </div>
{% endfor %}
    
    <div id="table-modal">
        
    </div
    