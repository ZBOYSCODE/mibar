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
                        
                        <div class="table-item listado-pendientes" id='table-pedido-{{pedido.id}}' data-pedido="{{pedido.id}}" data-estado="1">


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

                                                class="btn btn-small btn-main table-order-button btn-concretar btn-main-margin-bottom-sm" 
                                                data-callName="delete-pedido" 
                                                data-url="{{ url('bartender/completeOrder') }}"><i class="fa fa-check"></i></button>    
                                    
                                </div>


                            </div>

                        </div>

                    {% endfor %}

                </div>

                 

            {% endfor %}

                

        {% endfor %}

    {% endif %}
</div>