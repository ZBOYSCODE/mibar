<div id="tables-content">

    {% if cuentas == false %}

        <div class="table-item card">
            <h3>No hay Cuentas </h3>
        </div>

    {% else %}

        {%  for cuenta in cuentas %}

            <div class="table-item card">
                <div class="row">
                    <div class="col-xs-4 col-sm-4">
                        <div class="table-item-img">
                            {{ image("img/avatars/table.png", "alt":"", "class":"img-responsive") }}
                        </div>
                    </div>
                    <div class="col-xs-8 col-sm-8">
                        <div class="table-item-details">

                            <p class="title">Cliente: {{ clientes[cuenta.id].nombre }}

                                {% if clientes[cuenta.id].apellido != null %}
                                    {{ clientes[cuenta.id].apellido }}
                                {% endif %}

                            </p>

                            <p class="description">Total Pedidos: {{ cantidadPedidos[cuenta.id] }}</p>
                            <p class="description">Subtotal: ${{ subtotales[cuenta.id] }}</p>

                            <div class="row">

                                <span class="btn btn-small btn-main pull-right table-details-button"
                                      data-callName="detallePedido"
                                      data-url="{{ url("cashbox/detallepedidos") }}"
                                      data-cuenta="{{ cuenta.id }}">
                                    Detalles
                                </span>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        {% endfor %}
    {% endif %}
</div>

<div id="modal_cuenta_render"></div>