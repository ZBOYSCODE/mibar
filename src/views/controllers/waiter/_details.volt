{% extends "layouts/default.volt" %}

{% block content %}

{{ partial("partials/nav_waiter") }}

<section class="section-content-top2">
	<div class="nav-filters card tables-filter">

		<div class="row">
			<div class="col-xs-12 col-md-6 col-md-offset-3">


				<div class="nav-filter-item">
					 <select name="filtro-cuenta" id="filtro-cuenta" class="form-control">
					 	<option value="0">Clientes</option>

					 	{% for cuenta in cuentas %}
					    	<option value="{{ cuenta.id }}">{{ cuenta.Clientes.nombre }} {{ cuenta.Clientes.apellido }}</option>	
						{% endfor %}

					</select>
				</div>
				
			</div>

		</div>
	</div>
</section>
	
<div id="tables-content">
	{{ partial("controllers/waiter/tables/details") }}
</div>

 <div id="table_modal_orders_render"></div>
 <div id="table_modal_pending_orders_render"></div>


{% endblock %}