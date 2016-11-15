<div id="tables-content">

    {% if cuentas == false %}

        <div class="table-item card">
            <h3>No hay Cuentas </h3>
        </div>

    {% else %}

        {%  for cuenta in cuentas %}

            <div class="table-item card" data-client='{{ clientes[cuenta.id].id }}'>
                <div class="row">
                    <div class="col-xs-4 col-sm-4">
                        <div class="table-item-img">
                            {{ image("img/avatars/cuenta.png", "alt":"", "class":"img-responsive") }}
                        </div>
                    </div>
                    <div class="col-xs-8 col-sm-8">
                        <div class="table-item-details">

                            <p class="title">Cliente:</p>
                            <p class="title">{{ clientes[cuenta.id].nombre }}

                                {% if clientes[cuenta.id].apellido != null %}
                                    {{ clientes[cuenta.id].apellido }}
                                {% endif %}

                            </p>

                            <p class="description">Total Pedidos: {{ cantidadPedidos[cuenta.id] }}</p>
                            <p class="description">Subtotal: ${{ subtotales[cuenta.id] }}</p>
                             {% if subtotales[cuenta.id] > 0 %}
                            <div class="row">

                                <span class="btn btn-small btn-main pull-right table-details-button btn-main-margin-bottom-sm btn-font-size-sm btn-main-margin-top-sm"
                                      data-callName="pagarCuenta"
                                      data-url="{{ url("cashbox/pagarCuenta") }}"
                                      data-cuenta="{{ cuenta.id }}">
                                    Detalles
                                </span>

                            </div>
                            {% endif %}
                        </div>
                    </div>
                </div>
            </div>

        {% endfor %}
    {% endif %}
</div>

<div id="modal_cuenta_render"></div>

<div id="modal_pagar_render"></div>