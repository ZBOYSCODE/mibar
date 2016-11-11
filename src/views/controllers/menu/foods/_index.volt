<div class="nav-filters card">
	<div class="row">
		<div class="col-xs-6 col-sm-6">
			<div class="nav-filter-item">
				 <select name="promo-categories" id="promo-categories" class="form-control">
				    <option value="0">Todas las comidas</option>
                    {% for subcategoria in subcategorias %}
					   <option value="{{ subcategoria.id }}"> {{ subcategoria.nombre}} </option>
                    {% endfor %}
				</select>
			</div>	
		</div>
		<div class="col-xs-6 col-sm-6">
			<div class="nav-filter-item">
				<select name="promo-prices" id="promo-prices" class="form-control" data-view='food'>
				    <option value="0" class="filter">Ordenar</option>
                    <option value="1">Menor precio primero</option>
                    <option value="2">Mayor precio primero</option>
				</select>
			</div>	
		</div>
	</div>
</div>

    <div class="menu-products" id='menu-products-food'>

        {% for producto in productos %}


        	<div class="product-item card item-food" data-precio='{{ producto.precio }}' data-categoria="{{ producto.subcategoria_id }}">
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

        				    			<input type="text" class="form-control pull-right">

        				    			<input  type            = "number" 
                                                min             = '0'
                                                value           = '0' 
                                                class           = "form-control pull-right input_pedidos" 
                                                id              = 'input-{{producto.id}}' 
                                                data-producto   = '{{producto.id}}'
                                                data-promocion  = 0 >

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
			<button id="add-menu-product" class="btn btn-main" type="submit">AÑADIR PEDIDOS</button>
		</div>
	</div>	


<div id="orders-modal"></div>
