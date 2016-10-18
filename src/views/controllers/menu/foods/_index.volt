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


    <div id="myOrder-modal"></div>


	
