{% extends "layouts/default.volt" %}

{% block content %}

	{{ partial("partials/nav_cashbox") }}



	<section class="section-content-top2">
		<div class="card">

			<h4>Cuentas por pagar: Mesa {{ mesa.numero }}</h4>

		</div>
	</section>


	<section class="">
        <div class="nav-filters card tables-filter">
            <div class="row">

                <div class="col-xs-12 col-md-6 col-md-offset-3">
                    <div class="nav-filter-item">
                    
                        <select name="select-clientes" id="select-clientes" class="form-control">
                            <option value="0">Cliente</option>

                            {% for cuenta in cuentasGroup %}
                                <option value="{{ cuenta['cliente'].id }}">{{ cuenta['cliente'].nombre }}</option>
                            {% endfor %}
                        </select>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

	<div id="tables-content-parent">
		{{ partial("controllers/cashbox/table/_index") }}
	</div>

{% endblock %}