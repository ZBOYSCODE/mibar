{% extends "layouts/default.volt" %}

{% block content %}

{{ partial("partials/nav_waiter") }}

<section class="section-content-top2">
	<div class="nav-filters card tables-filter">
		<div class="row">
		<div class="col-xs-6 col-sm-6">
			<div class="nav-filter-item">
				 <select name="prod-categories" id="prod-categories" class="form-control">
				 	<option value="0">Todas las mesas</option>
				 	{% for mesa in mesas %}
				    	<option value="{{ mesa.id }}">Mesa {{ mesa.id }}</option>	
					{% endfor %}
				</select>
			</div>	
		</div>
		<div class="col-xs-6 col-sm-6">
			<div class="nav-filter-item">
				<select name="promo-prices" id="promo-prices" class="form-control">
				    <option value="Filtrar" class="filter">Filtrar Estado</option>
					<option value="reservada">Reservadas</option>
					<option value="disponibles">Disponibles</option>
					<option value="En proceso">En proceso</option>
				</select>
			</div>	
		</div>
		</div>
	</div>
</section>
	
<div id="tables-content">
	{{ partial("controllers/waiter/tables/_index") }}
</div>


{% endblock %}