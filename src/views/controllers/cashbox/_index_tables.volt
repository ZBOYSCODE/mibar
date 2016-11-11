{% extends "layouts/default.volt" %}

{% block content %}

    {{ partial("partials/nav_cashbox") }}

    <section class="section-content-top2">
        <div class="nav-filters card tables-filter">
            <div class="row">

                <div class="col-xs-6">
                    <div class="nav-filter-item">
                        <select name="select-mesas" id="select-mesas" class="form-control">
                            <option value="0">N° Mesa</option>

                            {% for mesa in mesas %}
                                <option value="{{ mesa.id }}">Mesa {{ mesa.numero }}</option>
                            {% endfor %}
                        </select>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <div id="tables_render">

        {% if mesas == false %}

            <h3>No hay mesas con cuentas</h3>

        {% else %}
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
                                <p class="title">MESA {{mesa.numero}} </p>
                                <p id="estado" class="description">Estado: {{ mesa.EstadosMesa.name }}</p>
                                <div class="row">
                                    <a href="{{ url("cashbox/table/")~mesa.id }}" class="btn btn-small btn-main pull-right" data-table="{{ mesa.id }}" data-url="waiter/tableDetails">Ver Cuentas</a>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            {% endfor %}
        {% endif %}


    </div>


{% endblock %}