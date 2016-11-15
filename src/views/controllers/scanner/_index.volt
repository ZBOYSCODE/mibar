{% extends "layouts/default.volt" %}

{% block content %}

    <h1>Scanner</h1>
    {#<canvas></canvas>#}



	<input type="hidden" id='url' value='{{ url('scanner') }}'>

	<form id="form" method="POST" enctype="multipart/form-data">


	    <input name='img' accept="image/*"  type="file" capture/>

	    
	</form>

	<button id='captura_qr'>Captura</button>
	
{% endblock %}