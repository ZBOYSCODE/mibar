<div class="nav-filters card">
	<div class="row">
		<div class="col-xs-6 col-sm-6">
			<div class="nav-filter-item">
				 <select name="promo-categories" id="promo-categories" class="form-control">
				    <option value="Filtrar">Filtrar Categoría</option>
                    {% for subcategoria in subcategorias %}
					   <option value="{{ subcategoria.id }}"> {{ subcategoria.nombre}} </option>
                    {% endfor %}
				</select>
			</div>	
		</div>
		<div class="col-xs-6 col-sm-6">
			<div class="nav-filter-item">
				<select name="promo-prices" id="promo-prices" class="form-control">
				    <option value="Filtrar" class="filter">Filtrar Precio</option>
					<option value="menos de 10 mil">menos de 10 mil</option>
					<option value="entre 10 y 20 mil">entre 10 y 20 mil</option>
				</select>
			</div>	
		</div>
	</div>
</div>

    <div class="menu-products">


        {% for producto in productos %}

        	<div class="product-item card">
        		<div class="row">
        			<div class="col-xs-4 col-sm-4">
        				<div class="product-item-img">
        					{{ image(producto.avatar, "alt":"", "class":"img-responsive") }}
        				</div>	
        			</div>
        			<div class="col-xs-8 col-sm-8">
        				<div class="product-item-details">
        				    <p class="title">{{producto.nombre}}</p>
        				    <p class="description">{{ producto.descripcion }}</p>
        				    <div class="row">
        				    	<div class="col-xs-4 col-sm-4">
        				    		<div class="price">$ {{ producto.precio }}</div>
        				    	</div>
        				    	<div class="col-xs-8 col-sm-8">
        				    		<div class="product-item-buttons pull-right">
        				    			<button class="minus" data-producto='{{producto.id}}'><i class="fa fa-minus"></i></button>
        				    			<button class="plus" data-producto='{{producto.id}}'><i class="fa fa-plus"></i></button>

        				    			<input  type            = "number" 
                                                min             = '0'
                                                value           = '0' 
                                                class           = "form-control pull-right input_pedidos" 
                                                id              = 'input-{{producto.id}}' 
                                                data-producto   = '{{producto.id}}'
                                                data-promocion  = 'false' >

        				    		</div>
        				    	</div>
        				    </div>
        				</div>	
        			</div>
        		</div>
        		<div class="row product-add-item-comment">
        			<button type="button" data-toggle="collapse" data-target="#comment-{{producto.id}}">
        				<i class="fa fa-plus"></i> Añadir Comentario
        			</button>
        			<div id="comment-{{producto.id}}" class="product-item-comment collapse">
        				<textarea name="comment" class="form-control" rows="3"></textarea>
        			</div>
        		</div>
        	</div>

        {% endfor %}

    </div>

	<div class="menu-footer">
		<div class="row menu-footer-buttons card">
			<button id="add-menu-product" class="btn btn-main" type="button">AÑADIR PEDIDOS</button>
		</div>
	</div>	




<form action="">
	<!-- Modal -->
	<div id="products-modal" class="menu-products-list-modal modal fade" role="dialog">
	    <div class="modal-dialog">
	    <!-- Modal content-->
		    <div class="modal-content">
			    <div class="modal-header card">
			        <button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title"><i class="fa fa-list-alt"></i> MIS PEDIDOS</h4>
			    </div>
			    <div class="row user-details card">
			    	<div class="col-xs-2 col-md-2">
			    		{{ image("img/avatars/default.png", "alt":"", "class":"img-responsive") }}
			    	</div>
			    	<div class="col-xs-10 col-md-10">
			    		<p>Orlando San Martín</p>
			    	</div>
			    </div>
			    <div class="modal-body">






			      <!-- Products -->







			        <div class="card" id='pedido-1'>
				      	<div class="product-item-modal">
				      		<button type="button" class="btn btn-small btn-main pull-right delete-pedido" data-pedido='1'>Eliminar</button>
				      		<p class="title">Ron Abuelo 3 años</p>
				      		<div class="row">
				      			<div class="col-xs-6 col-md-6">
				      				<p><b><i class="fa fa-bar-chart"></i> Cantidad: </b>4</p>
				      			</div>
				      			<div class="col-xs-6 col-md-6">
				      				<p><b><i class="fa fa-calculator"></i> Total Pedido: </b>$14.000</p>
				      			</div>
				      		</div>
				      		<div class="comment">
				      			<b><i class="fa fa-commenting"></i> Comentario:</b>
				      			<p>Con poca azucar, dos gotas de vinagre, 3 granos de sal y 4 onzas de licor de anis marca 3 palos.</p>
				      		</div>
				      	</div>
			        </div>

			        <div class="card" id='pedido-2'>
				      	<div class="product-item-modal">
				      		<button type="button" class="btn btn-small btn-main pull-right delete-pedido" data-pedido='2'>Eliminar</button>
				      		<p class="title">Ron Abuelo 3 años</p>
				      		<div class="row">
				      			<div class="col-xs-6 col-md-6">
				      				<p><b><i class="fa fa-bar-chart"></i> Cantidad: </b>4</p>
				      			</div>
				      			<div class="col-xs-6 col-md-6">
				      				<p><b><i class="fa fa-calculator"></i> Total Pedido: </b>$14.000</p>
				      			</div>
				      		</div>
				      		<div class="comment">
				      			<b><i class="fa fa-commenting"></i> Comentario:</b>
				      			<p>Con poca azucar, dos gotas de vinagre, 3 granos de sal y 4 onzas de licor de anis marca 3 palos.</p>
				      		</div>
				      	</div>
			        </div>

			        <div class="card" id='pedido-3'>
				      	<div class="product-item-modal">
				      		<button type="button" class="btn btn-small btn-main pull-right delete-pedido" data-pedido='3'>Eliminar</button>
				      		<p class="title">Ron Abuelo 3 años</p>
				      		<div class="row">
				      			<div class="col-xs-6 col-md-6">
				      				<p><b><i class="fa fa-bar-chart"></i> Cantidad: </b>4</p>
				      			</div>
				      			<div class="col-xs-6 col-md-6">
				      				<p><b><i class="fa fa-calculator"></i> Total Pedido: </b>$14.000</p>
				      			</div>
				      		</div>
				      		<div class="comment">
				      			<b><i class="fa fa-commenting"></i> Comentario:</b>
				      			<p>Con poca azucar, dos gotas de vinagre, 3 granos de sal y 4 onzas de licor de anis marca 3 palos.</p>
				      		</div>
				      	</div>
			        </div>








			    </div>
			    <div class="total card">
			    	<div class="row">
			    		<div class="col-xs-6 col-md-6">
			    			<p><b> Total a Pagar: </b></p>
			    		</div>
			    		<div class="col-xs-6 col-md-6">
			    			<p><b><i class="fa fa-usd"></i> 32.000</b></p>
			    		</div>
			    	</div>
			    </div>
			    <div class="modal-footer card">
			      <button id="Send-Products" type="button" class="btn btn-main">ENVIAR PEDIDO</button>
			    </div>
		    </div>
	    </div>
	</div>
</form>
	
