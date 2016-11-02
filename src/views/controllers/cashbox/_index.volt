{% extends "layouts/default.volt" %}

{% block content %}

	{{ partial("partials/nav_waiter") }}


	<div id="tables-content">
		{{ partial("controllers/cashbox/table/_index") }}
	</div>


{% endblock %}