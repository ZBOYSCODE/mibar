{% extends "layouts/default.volt" %}

{% block content %}

	{{ partial("partials/nav_cashbox") }}

	<section class="section-content-top2">
		<div class="card">

			<h4>Cuentas pendientes de pago: Mesa <i class="fa fa-slack"></i>{{ mesa.numero }}</h4>

		</div>
	</section>

	<div id="tables-content">
		{{ partial("controllers/cashbox/table/_index") }}
	</div>


{% endblock %}