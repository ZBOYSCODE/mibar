{% extends "layouts/default.volt" %}

{% block content %}

	<style>
		#contenido{
			/*display: none;*/
		}

		#send-message{
			text-align: center;
		}

		#chat{
			overflow: auto;
			max-height: 200px;
		}

		#nickContainer{
			margin: 0 auto;
		}

		#login-error{
			display: none;
			margin: 1em;
		}

		#chat_abiertos div:hover{
			background-color: rgba(200,200,200,0.2);
			cursor: pointer;
		}

		#users a{
			display: block;
		}

		
	</style>

	<div class="container">

		<header class="page-header">
			<h1>MiChat</h1>
		</header>

		
			

		<div class="row" id='contenido'>


			<div class="col-md-8 panel_chat" id="chat-content">
				<div class="panel panel-success">
					<div class="panel-heading">Chat General</div>
					<div class="panel-body" id='chat'></div>
				</div>

				<form id='formMessage'>
					<div class="form-group">
						<input type="text" class='form-control' id='message' placeholder='Escribe un mensaje...'>
					</div>

					<button class='btn btn-primary col-xs-12' type='submit'>Enviar</button>
				</form>
			</div>



			<div class="col-md-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						Usuarios
					</div>
					<div class="panel-body" id='users'>
					</div>
				</div>
			</div>
		</div>



	</div>

	<input type="hidden" id='nickname' 	value='{{ username }} - Mesa {{ table }}'>
	
	
	<script src="http://192.168.85.120:8000/socket.io/socket.io.js"></script> 
	

{% endblock %}
