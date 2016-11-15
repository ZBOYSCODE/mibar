{% extends "layouts/default.volt" %}

{% block content %}

    <h1>Scanner</h1>
    {#<canvas></canvas>#}



	<input type="hidden" id='url' value='{{ url('scanner') }}'>

	<form id="form" method="POST" enctype="multipart/form-data" action='{{ url('scanner/table') }}'>


		<input class='form-control' name='img' accept="image/*"  type="file" capture/>

	 	<button type='submit'>Aceptar</button>
	</form>

	<button id='captura_qr'>Captura</button>
	
{% endblock %}