{% extends "layouts/default.volt" %}

{% block content %}

    {{ partial("partials/nav_bartender") }}



    <div id="tables-content">
        {{ partial("controllers/waiter/tables/_index") }}

        <h1>Bartender</h1>
    </div>


{% endblock %}