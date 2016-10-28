<div id="waiter_tables_details_render">

    {% if orders == false %}


        <div class="table-item card" data-pedido="{{pedido.id}}" data-estado="1">
            <h3>No hay pedidos asociados </h3>
        </div>


    {% else %}


        {% for pedido in orders %}
            <div class="table-item card" data-pedido="{{pedido.id}}" data-estado="1">
                <div class="row">
                    <div class="col-xs-4 col-sm-4">
                        <div class="table-item-img">
                            {{ image("img/avatars/table.png", "alt":"", "class":"img-responsive") }}
                        </div>
                    </div>
                    <div class="col-xs-8 col-sm-8">

                        <div class="table-item-details">
                            <p class="title">Pedido {{pedido.id}} </p>
                            <p id="estado" class="description">Estado: 1</p>
                            <div class="row">
                                <button type="button" class="btn btn-small btn-main pull-right table-details-button" data-callName="table-details-button" data-table="{{ pedido.id }}" data-url="bartender/tabledetails">Detalles</button>
                            </div>
                        </div>

                    </div>
                    <button type="button" data-pedido=" {{ pedido.id }}" class="btn btn-small btn-main pull-right table-order-button" data-url="waiter/tableDetails">Entregar Pedidos</button>
                </div>
            </div>

        {% endfor %}


    {% endif %}
</div>