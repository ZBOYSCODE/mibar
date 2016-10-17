 $(document).on('ready', function() {

 	var url = $("#frm").val();

 	$(document).on('click', '#add-menu-product', function() {

 		var producto = $(this).attr('data-producto');
 		agregar_productos_carro(producto);

 	});


 	function agregar_productos_carro() {

 		var pedido 	= [];

 		$(".input_pedidos").each(function() {

 			var producto = $(this).attr('data-producto');
 			var cantidad = $(this).val();
			

 			if (cantidad > 0) {
				
				var comment = $("#comment-"+producto+" textarea").val();

				var element = {};

	 			element.producto = producto;
	 			element.cantidad = cantidad;
	 			element.comment = comment;

	 			pedido.push(element);
 			}
 		}); 

 		enviar_pedido(pedido);
 	}

 	function enviar_pedido(pedido) {

 		var json = JSON.stringify(pedido);
	
		fun = $.xajax(json, url+'/addPedido');

		fun.success(function (data)
		{
			if(data.estado)
			{
				actualizar_pedidos(data.pedidos);
				
			}else{
				$.bootstrapGrowl(data.msg,{type:'danger'});
				$.log(data.msg);
			}
		});

 	}



 	function actualizar_pedidos(pedidos) {

 		

 	}






 	$(document).on('click', '.minus', function(){

 		var producto = $(this).attr('data-producto');
 		quitar_producto(producto);

 	});

 	$(document).on('click', '.plus', function(){

 		var producto = $(this).attr('data-producto');
 		agregar_producto(producto);

 	});

 	

 	function agregar_producto(producto) {

 		var input = $("#input-"+producto);

 		var num =  input.val() ;

 		num++;

 		input.val(num);
 	}

 	function quitar_producto(producto) {

 		var input = $("#input-"+producto);

 		var num =  input.val() ;

 		num--;

 		if(num <= 0) {
 			num = 0;
 		}

 		input.val(num);

 	}

 	

 });