{% extends "layouts/default.volt" %}

{% block content %} 
	<div class="card text-center card-full">
	    <form id="form" method="POST" enctype="multipart/form-data" class="scanner-form">
	        <fieldset>
		        <div class="row">
			    	<div class="wel-logo">
			        	 {{ image("img/mibar.png", "alt":"Logo", "class":"img-responsive") }}
			        </div>
			    </div>
		        <div class="row">
		        	<div class="col-xs-12 col-sm-6">
		        		<h1 class="title"><b>Paso 1</b></h1>
		        	    <h1 class="subtitle">Presiona para Subir el Código Qr</h1>
		                <div class="box text-center">
		                    <input type="hidden" id='url' value='{{ url('scanner') }}'>
		                        <input name='img' accept="image/*"  type="file" capture id="file-6" class="inputfile inputfile-5 hidden"/>
	                             <label for="file-6">
	                             	<figure>
	                             		<svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg></figure><span id="file-name"></span>
	                             </label>
		                </div>
		            </div> 
		        	<div class="col-xs-12 col-sm-6">
		        	<h1 class="title"><b>Paso 2</b></h1>
		        	    <h1 class="subtitle">Presiona para Acceder a nuestra Aplicación</h1>
		        		<button type="submit" class="btn btn-capture"><i class="fa fa-paper-plane"></i></button>
		        	</div>
		        </div>
		    </fieldset>	   
    	</form>
    </div>
{% endblock %}