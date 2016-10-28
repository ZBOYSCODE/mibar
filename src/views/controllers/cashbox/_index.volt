{% extends "layouts/default.volt" %}

{% block content %}

{{ partial("partials/nav_waiter") }}

<section class="section-content-top2">
	<div class="nav-filters card tables-filter">
		<div class="row">
		<div class="col-xs-6 col-sm-6">
			<div class="nav-filter-item">
				 <select name="prod-categories" id="prod-categories" class="form-control">
				    <option value="0">N° Mesa</option>
					   {% for mesa in mesas %}
						   <option value="{{ mesa.id }}" class="filter">{{ mesa.numero }}</option>
					   {% endfor %}
				</select>
			</div>
		</div>
		<div class="col-xs-6 col-sm-6">
			<div class="nav-filter-item">
				<select name="promo-prices" id="promo-prices" class="form-control">
				    <option value="0" class="filter">Filtrar Estado</option>
					<option value="1" class="filter">Estado 1</option>
					<option value="2" class="filter">Estado 2</option>
					<option value="3" class="filter">Estado 3</option>
				</select>
			</div>	
		</div>
		</div>
	</div>
</section>
	



{% endblock %}