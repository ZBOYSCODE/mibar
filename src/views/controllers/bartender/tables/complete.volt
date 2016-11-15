<div id="waiter_tables_details_render">

    {% if orders == false %}

        <div class="table-item card">
            <h3>No hay pedidos asociados </h3>
        </div>

    {% else %}


        {% for ncuenta in orders %}
    

            {% for orden in ncuenta %}
    
            <div class="card">
                <button class='detalle_orden detalle_orden_bartender table_item_bartender_button' id='btn-detalle-{{ orden['mesa_id'] }}_{{ orden['fecha'] }}' data-mesa='{{ orden['mesa_id'] }}' data-fecha='{{ orden['fecha'] }}'>
                    
                    
                    <div class='text-left'>
                        <h3>Mesa {{ orden['mesa_id'] }} - {{ orden['fecha2'] }}Hrs.</h3>
                        
                    </div>

                </button> 
            </div>
                


                <div class='{{ orden['mesa_id'] }}_{{ orden['fecha'] }} card' style='display:none; border: 2px solid #d65cc0'>
                            
                    {% for pedido in orden['orden'] %}
                        
                        <div class="table-item" id='table-pedido-{{pedido.id}}' data-pedido="{{pedido.id}}" data-estado="1">


                            <div class="row">

                                <div class="col-xs-12">

                                    <div class="table-item-details">
                                        <p>
                                            <span class="title">{{ pedido.nombre }}</span>
                                            
                                            <b>( {{ pedido.descripcion }} ) 
                                            {% if pedido.Cuentas.Funcionarios %}
                                                <br>Funcionario: {{ pedido.Cuentas.Funcionarios.nombre }} {{ pedido.Cuentas.Funcionarios.apellido }}
                                            {% endif %}
                                            
                                            {% if pedido.Cuentas.Clientes %}
                                                <br>Cliente : {{ pedido.Cuentas.Clientes.nombre }}
                                            {% endif %}
                                            
                                            <br>Comentario: {{ pedido.comentario }}
                                            
                            
                                        
                                            
                                            </b>
                                        </p>
                                    </div>

                                </div>



                            </div>

                        </div>

                    {% endfor %}

                </div>

                 

            {% endfor %}

                

        {% endfor %}

    {% endif %}
</div>
{#
<div id="waiter_tables_details_render">

    {% if orders == false %}


        <div class="table-item card">
            <h3>No hay pedidos asociados </h3>
        </div>


    {% else %}


        {% for pedido in orders %}
            <div class="table-item card" data-pedido="{{pedido.id}}" data-estado="1">
                <div class="row">
                    <div class="col-xs-4 col-sm-4">
                        <div class="table-item-img">
                            {{ image(pedido.avatar, "alt":"", "class":"img-responsive") }}
                        </div>
                    </div>
                    <div class="col-xs-8 col-sm-8">

                        <div class="table-item-details">
                            <p class="title">{{ pedido.nombre }} </p>
                            <p id="estado" class="description">{{ pedido.descripcion }}</p>
                            <p id="estado" class="description">{{ pedido.comentario }}</p>
                            <div class="row">
                                <button type="button" class="btn btn-small btn-main pull-right table-details-button pedido-details" data-callName="pedido-details" data-pedido="{{ pedido.id }}" data-url="bartender/orderDetails">Detalles</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        {% endfor %}


    {% endif %}
</div>
#}