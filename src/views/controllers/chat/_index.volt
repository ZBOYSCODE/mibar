{% extends "layouts/default.volt" %}

{% block content %}

    <div class="card card-full">
    	<div class="container">

			<div class="row">
				<div class="col-xs-12 col-sm-12">
					<div class="wel-logo pull-right">
			        	 {{ image("img/mibar.png", "alt":"Logo", "class":"img-responsive logo-chat") }}
			        </div>
				</div>
			</div>
            <br>
			<div class="row" id='contenido-chat'>
				<div class=" col-xs-12 col-sm-8 panel_chat" id="chat-content">
					<div class="panel">
						<div class="panel-heading"><i class="fa fa-comments"></i> Chat General</div>
						<div class="panel-body" id='chat'></div>
					</div>
					<form id='formMessage'>
						<div class="row form-group">
                            <div class="col-xs-12 col-sm-12">
                            	<input type="text" class='form-control' id='message' placeholder='Escribe un mensaje...'>
                            </div>
						</div>
						<button class='btn btn-main send-message' type='submit'>Enviar</button>
					</form>
				</div>
				<div class="col-xs-12 col-sm-4">
					<div class="panel">
						<div class="panel-heading">
							<i class="fa fa-users"></i><b> Usuarios Conectados</b>
						</div>
						<div class="panel-body" id='users'>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
		

	<input type="hidden" id='nickname' 	value='{{ username }} - Mesa {{ table }}'>
	
	
	<script src="http://192.168.85.120:8000/socket.io/socket.io.js"></script> 
	

{% endblock %}
