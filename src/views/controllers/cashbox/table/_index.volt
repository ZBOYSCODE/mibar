<div id="tables-content">

    {% if cuentasGroup == false %}

        <div class="table-item card">
            <h3>No hay Cuentas </h3>
        </div>

    {% else %}

        {%  for cuenta in cuentasGroup %}

            <div class="table-item card" data-client='{{ cuenta['cliente'].id }}'>
                <div class="row">
                    <div class="col-xs-4 col-sm-4">
                        <div class="table-item-img">
                            {{ image("img/avatars/cuenta.png", "alt":"", "class":"img-responsive") }}
                        </div>
                    </div>
                    <div class="col-xs-8 col-sm-8">
                        <div class="table-item-details">

                            <p class="title">Cliente:</p>
                            <p class="title">{{ cuenta['cliente'].nombre }}

                                {% if cuenta['cliente'].apellido != null %}
                                    {{ cuenta['cliente'].apellido }}
                                {% endif %}

                            </p>

                            <p class="description">Total Pedidos: {{ cuenta['cantidadPedidos'] }}</p>
                            <p class="description">Subtotal: $ {{ cuenta['subtotal'] }}</p>
                             {% if cuenta['subtotal'] > 0 %}
                            <div class="row">

                                <span class="btn btn-small btn-main pull-right table-details-button btn-main-margin-bottom-sm btn-font-size-sm btn-main-margin-top-sm"
                                      data-callName="pagarCuenta"
                                      data-url="{{ url("cashbox/pagarCuenta") }}"
                                      data-cuenta="{{ cuenta['cuenta'].id }}">
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