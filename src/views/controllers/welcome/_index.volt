{% extends "layouts/default.volt" %}

{% block content %}


	<div class="card full-card">
		<div class="wel-card-content">
		    <div class="row">
		        <div class="wel-top-buttons inline pull-right">
		        	<button id="wel-reservations" class="btn btn-secondary" type="button" value="RESERVAS" />RESERVAS</button>
		    	    <button id="wel-login" class="btn btn-secondary" type="button" value="LOGIN" />LOGIN</button>
		        </div>
		    </div>
		    <div class="row">
		    	<div class="wel-logo">
		        	 {{ image("img/mibar.png", "alt":"Logo", "class":"img-responsive") }}
		        </div>
		    </div>
			<div class="row text-center">
				<h1 class="wel-title">¡Bienvenido!</h1>


				<p>Estas ubicado en la mesa #{{ mesa.numero }}</p>
				
				<h3 class="wel-subtitle">Por Favor, ingresa tu nombre</h3>
				<p><?php $this->flashSession->output() ?></p>
				<form action="acceso/login" method='POST'>
					<div class="form-group">
						<input id="wel-username" name="wel-username" class="form-control wel-username" type="text">
					</div>
					<div class="wel-access-button">
						<button id="wel-access-button" class="btn btn-main" type="submit">ACCEDER</button>
					</div>
				</form>
			</div>
			<div class="row wel-wrapper-footer">
				<div class="wel-footer">
					<p>Powered by <i class="fa fa-heart"></i> Zenta</p>
				</div>		
			</div>
		</div>
	</div>

{% endblock %}