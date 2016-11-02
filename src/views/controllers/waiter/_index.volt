{% extends "layouts/default.volt" %}

{% block content %}

{{ partial("partials/nav_waiter") }}

<section class="section-content-top2">
	<div class="nav-filters card tables-filter">
		<div class="row">
		<div class="col-xs-6 col-sm-6">
			<div class="nav-filter-item">
				 <select name="filtro-mesa" id="filtro-mesa" class="form-control">
				 	<option value="0">Todas las mesas</option>

				 	{% for mesa in mesas %}
				    	<option value="{{ mesa.id }}">Mesa {{ mesa.numero }}</option>	
					{% endfor %}

				</select>
			</div>	
		</div>
		<div class="col-xs-6 col-sm-6">
			<div class="nav-filter-item">
				<select name="filtro-estado-mesa" id="filtro-estado-mesa" class="form-control">
				    <option value="0" class="filter">Todos los estados</option>
				 	{% for estadoMesa in estadosMesa %}
				    	<option value="{{ estadoMesa.id }}">{{estadoMesa.name}}</option>
					{% endfor %}

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