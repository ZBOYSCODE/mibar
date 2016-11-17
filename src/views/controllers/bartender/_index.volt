{% extends "layouts/default.volt" %}

{% block content %}

    {{ partial("partials/nav_bartender") }}

    <section class="section-content-top">
    <div class="row menu-types">
        <div class="col-xs-6 col-sm-6 no-col-padding">
            <div class="menu-type-item card margin-top-10"  id='menu-pendientes' data-callName='actualiza-ultima-revision'>
                <button type="button" id="opcion0" class="active button-active">
                    {{ image("img/icons/bar-pendiente.png", "alt":"Promos", "class":"img-responsive") }}
                    <p>Pend. / En Proceso</p>
                </button>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 no-col-padding">

            <div class=" menu-type-item card margin-top-10" id='menu-listos'>
                <button type="button" id="opcion1" class="button-active">

                    {{ image("img/icons/bar-entregado.png", "alt":"Bebidas", "class":"img-responsive") }}
                    <p>Listos</p>
                </button>
            </div>
        </div>
    </div>
    </section>

    <div id="tables-content">

        {{ partial("controllers/bartender/tables/pending") }}

    </div>

    <input type="hidden" id='url-bartender' value="{{ url('bartender') }}">
    <div id="modal-content"></div>


{% endblock %}