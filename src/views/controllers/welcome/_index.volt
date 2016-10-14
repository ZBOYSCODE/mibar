{% extends "layouts/default.volt" %}

{% block content %}

	<div class="card full-card">
		<div class="wel-card-content">
		    <div class="row">
		        <div class="wel-top-buttons inline pull-right">
		        	<button id="wel-reservations" class="btn" type="button" value="RESERVAS" />RESERVAS</button>
		    	    <button id="wel-login" class="btn" type="button" value="LOGIN" />LOGIN</button>
		        </div>
		    </div>
		    <div class="row">
		    	<div class="wel-logo">
		        	 {{ image("img/mibar.png", "alt":"Logo", "class":"img-responsive") }}
		        </div>
		    </div>
			<div class="row text-center">
				<h1 class="wel-title">¡Bienvenido!</h1>
				<h3>Por Favor, ingresa tu nombre</h3>
				<div class="form-group">
					<input id="wel-username" class="form-control wel-username" type="text">
				</div>
				<div class="wel-access-button">
					<button id="wel-access-button" class="btn" type="submit">ACCEDER</button>
				</div>
			</div>
			<div class="row wel-wrapper-footer">
				<div class="wel-footer">
					<p>Powered by <i class="fa fa-heart"></i> Zenta</p>
				</div>		
			</div>
		</div>
	</div>

{% endblock %}