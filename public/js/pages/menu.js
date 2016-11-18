$(document).on('ready', function() {


	//var nodeServer = 'http://192.168.85.120:8000';
    //var socket = io.connect(nodeServer);


 	var url 	= $("#frm").val();

  	actualizar_info();



 	$(document).on('click', '#add-menu-product', function() {

 		var producto = $(this).attr('data-producto');
 		agregar_productos_carro(producto);
 	});

 	$(document).on('click', '.delete-pedido', function() {

 		var pedido = $(this).attr('data-pedido');
 		delete_pedido(pedido);
 	});


 	$(document).on('click', '.minus', function(){

 		var producto = $(this).attr('data-producto');
 		quitar_producto(producto);
 	});

 	$(document).on('click', '.plus', function(){

 		var producto = $(this).attr('data-producto');
 		agregar_producto(producto);
 	});


 	function agregar_productos_carro() {

 		var pedido 	= [];

 		$(".input_pedidos").each(function() {

 			var producto 	= $(this).attr('data-producto'); 	// ID producto
 			var promo 		= $(this).attr('data-promocion');	// Indicamos cuando es una promoción
 			var cantidad 	= $(this).val();
			

 			if (cantidad > 0) {
				
				var comment = $("#comment-"+producto+" textarea").val();

				var element = {};

	 			element.producto 	= producto;
	 			element.cantidad 	= cantidad;
	 			element.promocion 	= promo; 
	 			element.comment 	= comment;

	 			pedido.push(element);
 			}
 		}); 

 		enviar_pedido(pedido);
 	}


 	function enviar_pedido(pedido) {

        var json = JSON.stringify(pedido);

 		var datos = {

 			'pedidos' : json
 		}
	
		fun = $.xajax(datos, url+'/addPedido');

		fun.success(function (data)
		{
			if(data.success)
			{

				alertify.success("Carro actualizado");

				// reset input
				$(".input_pedidos").val(0);

				actualizar_info();
				actualizar_precio_pedidos();
				
			}else{
				
				alertify.error(data.msg);

				$.log(data.msg);
			}
		});
 	}



 	function actualizar_info() {

 		var datos = {}

   		fun = $.xajax(datos, url+'/getResumenDatos');//getNumPedidos

		fun.success(function (data)
		{
				
			$(".carro-compra").text(data.total_pedidos);
			$(".precio-total").text("$ "+data.precio_total);

		});



 	}

 	function actualizar_precio_pedidos() {

 		$(".precio_pedidos").text("666.999");

 	}


 	

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

   	

   	$(document).on('click', '#Send-Products', function(){

   		swal({
	        title: '¿Estás Seguro?',
	        text: "Se enviarán todos los productos",
	        type: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#521852',
	        cancelButtonColor: '#d65cc0',
	        confirmButtonText: 'Enviar'
      	}).then(function() {

      		if(concretar_pedido()){

      			swal({
		        	title:'¡Pedido Concretado!',
		        	text: 'Atenderemos su solicitud a la brevedad.',
		        	type: 'success',
		        	confirmButtonColor: '#521852'

		        }).then(function() {

		          	$('#products-modal').modal('hide');
		        })  
      		}

      	});
      
   });

   	$(document).on('click', '.menu-prod', function(){


		$('.button-active').removeClass('active');
		$(this).children().addClass('active');

        var action = $(this).data("url");

        var dataIn = new FormData();

        //mifaces
        $.callAjax(dataIn, action, $(this));

    });


   	$(document).on('click', '.menu-promo', function(){

   		$('.button-active').removeClass('active');
   		$(this).children().addClass('active');

        var action = $(this).data("url");

        var dataIn = new FormData();

        //mifaces
        $.callAjax(dataIn, action, $(this));

    });

   	$(document).on('click', '.mis-pedidos', function(e){

    	var action = $(this).data("url");

    	var dataIn = new FormData();

    	//mifaces
    	$.callAjax(dataIn, action, $(this));
    
    	e.preventDefault();
    
  	}); 

  	$(document).on('click', '.mi-cuenta', function(e) {

    	var action = $(this).data("url");

    	var dataIn = new FormData();

    	//mifaces
    	$.callAjax(dataIn, action, $(this));
    
    	e.preventDefault();
    
  	}); 
 

    $(document).on('change', "#promo-categories",function(){


		$('.button-active').removeClass('active');

        var tipoPromo = $(this).val();

        if(tipoPromo == 0){

            $(".product-item").show();      


        } else{

            $(".product-item").hide();

            products = $(".product-item").filter("[data-categoria='"+tipoPromo+"']");


            if(products.length == 0){

            	div = $('<div/>', {
				    text : 'No existen elementos',
				    'class' : 'alert-elementos'
				});

            	$("#menu-products").append(div);

            }else {

            	products.show();
            }
            

        }

    });    


    $(document).on('change', "#prod-categories",function(){

		$('.button-active').removeClass('active');

        var subcategoria = $(this).val();


        if(subcategoria == 0){

            $(".product-item").show();      

        } else{

            $(".product-item").hide();

            products = $(".product-item").filter("[data-categoria='"+subcategoria+"']");

            if(products.length == 0){

            	div = $('<div/>', {
				    text : 'No existen elementos',
				    'class' : 'alert-elementos'
				});

            	$("#menu-products").append(div);

            }else {

            	products.show();
            }

        }

  	});

  	$(document).on('change', '#promo-prices', function(){

  		var vista = $(this).attr('data-view');

  		var obj = []
  		
  		
  		$(".item-"+vista).each( function() {
			
			var arr = []
  			
  			var precio = $(this).attr('data-precio');

  			arr.push(precio);
  			arr.push(this);

  			$(this).remove();

  			obj.push(arr);
  		});


  		switch( $(this).val() ) {

  			case '1':
  				ordenar_menor_precio(obj, vista)
  			break

  			case '2':
  				ordenar_mayor_precio(obj, vista)
  			break

  			default:
  				$("#opcion2").trigger('click')
  			break
  		}

  	}); 

  	function ordenar_menor_precio(obj, vista) {

  		obj.sort();
  		
  		$.each(obj, function(precio, item) {

  			$("#menu-products-"+vista).append(item[1]);
  		});
  	} 

  	function ordenar_mayor_precio(obj, vista) {

  		obj.sort();
  		obj.reverse();
  		
  		$.each(obj, function(precio, item) {

  			$("#menu-products-"+vista).append(item[1]);
  		});
  	} 


    function concretar_pedido() {

 		var datos = {}

   		fun = $.xajax(datos, url+'/concretarPedido');

		fun.success(function (data)
		{

			console.log(data);

			if(data.success)
			{
				socket.emit('new-order', data.cuenta );

				swal({
					title:'¡Pedido Concretado!',
					text: 'Atenderemos su solicitud a la brevedad.',
					type: 'success',
					confirmButtonColor: '#521852'

				}).then(function() {

					$('#products-modal').modal('hide');
					actualizar_info();
				}) 
				
			}else{
				
				swal({
					title:'¡Lo Sentimos!',
					text: 'No se pudo concretar el pedido, ¡Intente nuevamente!',
					type: 'error',
					confirmButtonColor: '#521852'

				}).then(function() {
					//$('#products-modal').modal('hide');
				}) 

			}
		});
   	}


   	function delete_pedido(pedido) {


   		var datos = {
   			'pedido' : pedido
   		}

   		fun = $.xajax(datos, url+'/removePedido');

		fun.success(function (data)
		{
			if(data.success)
			{
				$("#pedido-"+data.pedido).remove();

 				console.log("Pedido Nº "+data.pedido+"removido");

 				actualizar_info();
				
			}else{
				
				swal({
					title:'¡Lo Sentimos!',
					text: 'No se pudo eliminar el pedido, ¡Intente nuevamente!',
					type: 'error',
					confirmButtonColor: '#521852'

				}).then(function() {
					//$('#products-modal').modal('hide');
				}) 

			}
		});
   	}
   	

  
    /* Procedimientos Post Ajax Call */
	$(document).ajaxComplete(function(event,xhr,options){

		if(options.callName != null ) {
			if(options.callName == "changeMenu") {
				//active_Menu();
			}

			if(options.callName == "ordersButton") {
				openMyOrdersModal();
			}

			if(options.callName == "openmodalcuenta") {
				openMiCuentaModal();
			}
		}

	}); 


	$(document).on('click', '.button-active', function(){

		$(".button-active").removeClass('active');
		$(this).addClass('active');
	});


	 function openMyOrdersModal(){

	    $('#products-modal').modal('show');
	 }

	 function openMiCuentaModal() {
	 	$('#products-modal').modal('show');
	 }


 	
});











