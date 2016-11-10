<div id="waiter_tables_details_render">

    {% if orders == false %}

        <div class="table-item card">
            <h3>No hay pedidos asociados </h3>
        </div>

    {% else %}


        {% for ncuenta in orders %}
    

            {% for orden in ncuenta %}
    

                <button class='table-item card detalle_orden' id='btn-detalle-{{ orden['mesa_id'] }}_{{ orden['fecha'] }}' data-mesa='{{ orden['mesa_id'] }}' data-fecha='{{ orden['fecha'] }}'>
                    
                    
                    <div class='text-left'>
                        <h3>Mesa {{ orden['mesa_id'] }} - {{ orden['fecha2'] }}Hrs.</h3>
                        
                    </div>

                </button>


                <div class='{{ orden['mesa_id'] }}_{{ orden['fecha'] }}' style='display:none'>
                            
                    {% for pedido in orden['orden'] %}
                        
                        <div class="table-item" id='table-pedido-{{pedido.id}}' data-pedido="{{pedido.id}}" data-estado="1">


                            <div class="row">

                                <div class="col-xs-10">

                                    <div class="table-item-details">
                                        <p>
                                            <span class="title">{{ pedido.nombre }}</span>
                                            <br>
                                            <b>( {{ pedido.descripcion }} ) 
                                            {% if pedido.Cuentas.Funcionarios %}
                                                <br>Funcionario: {{ pedido.Cuentas.Funcionarios.nombre }} {{ pedido.Cuentas.Funcionarios.apellido }}
                                            {% endif %}
                                            
                                            {% if pedido.Cuentas.Clientes %}
                                                <br>Cliente : {{ pedido.Cuentas.Clientes.nombre }}
                                            {% endif %}
                                            <br>
                                            Comentario: {{ pedido.comentario }}
                                            <br>
                            
                                        
                                            
                                            </b>
                                        </p>
                                    </div>

                                </div>

                                <div class="col-xs-2">
                                        <button type="button" 
                                                id='btn-delete-{{ pedido.id }}'
                                                data-pedido = "{{ pedido.id }}"
                                                data-fecha  = "{{ orden['fecha'] }}"
                                                data-mesa   = "{{ orden['mesa_id'] }}"

                                                class="btn btn-small btn-main table-order-button btn-concretar" 
                                                data-callName="delete-pedido" 
                                                data-url="{{ url('bartender/completeOrder') }}">√</button>    
                                    
                                </div>


                            </div>

                        </div>

                    {% endfor %}

                </div>

                 

            {% endfor %}

                

        {% endfor %}

    {% endif %}
</div>