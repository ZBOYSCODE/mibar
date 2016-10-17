{% extends "layouts/main.volt" %}

{% block content %}

   <input type="hidden" id='frm' value="<?php echo $this->url->get('menu'); ?>" >

	<section class="section-content-top">
   		<div class="row menu-types">
   			<div class="col-xs-4 col-sm-4 no-col-padding">
   				<div class="menu-type-item card" data-url="menu/changeMenu" data-categoria="0">
	   				<button>
	   					{{ image("img/icons/promos.png", "alt":"Promos", "class":"img-responsive") }}
	   					<p>PROMOS</p>
	   				</button>  				    
   				</div>
   			</div>
   			<div class="col-xs-4 col-sm-4 no-col-padding">
   				<div class="menu-type-item card" data-url="menu/changeMenu" data-categoria="1">
   					<button>
   				    	{{ image("img/icons/drink2-icon.png", "alt":"Bebidas", "class":"img-responsive") }}
   						<p>BEBIDAS</p>
   					</button>
   				</div>
   			</div>
   			<div class="col-xs-4 col-sm-4 no-col-padding">
   				<div class="menu-type-item card" data-url="menu/changeMenu" data-categoria="2">
   					<button>
   				    	{{ image("img/icons/catering-icon.png", "alt":"Comidas", "class":"img-responsive") }}
   						<p>COMIDAS</p>
   					</button>
   				</div>
   			</div>
   		</div>	
	</section>

	<section>
		<div id="menu-products" class="menu-products">
			{{ partial("controllers/menu/promos/_index") }}
		</div>
	</section>


{% endblock %}