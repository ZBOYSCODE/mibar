{% extends "layouts/default.volt" %}

{% block content %}

    {{ partial("partials/nav_bartender") }}


    <section class="section-content-top">
    <div class="row menu-types">
        <div class="col-xs-6 col-sm-6 no-col-padding">


            <div class="menu-type-item card" data-url="bartender/changePendingOrders"  data-callName="changeMenu">
                <button type="button" id="opcion0" class="active button-active">
                    {{ image("img/icons/bar-pendiente.png", "alt":"Promos", "class":"img-responsive") }}
                    <p>Pendientes / En Proceso</p>
                </button>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 no-col-padding">

            <div class=" menu-type-item card" data-url="bartender/changeCompletedOrders"  data-callName="changeMenu">
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


    <div id="modal-content"></div>


{% endblock %}