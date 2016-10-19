

 $(document).on('ready', function() {

 	var menuNav = "opcion1";
 	var url 	= $("#frm").val();
	$('#'+menuNav).addClass('active');

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

				$.bootstrapGrowl("Carro actualizado.",{type:'success'});

				// reset input
				$(".input_pedidos").val(0);

				actualizar_info();
				actualizar_precio_pedidos();
				
			}else{
				$.bootstrapGrowl(data.msg,{type:'danger'});
				$.log(data.msg);
			}
		});

 	}



 	function actualizar_info() {

 		var datos = {}

   		fun = $.xajax(datos, url+'/getNumPedidos');

		fun.success(function (data)
		{
			if(data.success) {
				
				$(".carro-compra").text(data.num);
				
			}

		});



 	}

 	function actualizar_precio_pedidos() {

 		$(".precio_pedidos").text("666.999");

 		console.log("precios actualizados");
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


        var action = $(this).data("url");

        var dataIn = new FormData();

        //mifaces
        $.callAjax(dataIn, action, $(this));

    });


   	$(document).on('click', '.menu-promo', function(){

        var action = $(this).data("url");

        var dataIn = new FormData();

        //mifaces
        $.callAjax(dataIn, action, $(this));

    });

   	$(document).on('click', '.nav-menu-cart', function(e){

    	var action = $(this).data("url");

    	var dataIn = new FormData();

    	//mifaces
    	$.callAjax(dataIn, action, $(this));
    
    	e.preventDefault();
    
  	}); 
 

    $(document).on('change', "#promo-categories",function(){

        var tipoPromo = $(this).val();

        if(tipoPromo == 0){

            $(".product-item").show();      


        } else{

            $(".product-item").hide();

            products = $(".product-item").filter("[data-categoria='"+tipoPromo+"']");

            products.show();

        }

    });    


    $(document).on('change', "#prod-categories",function(){

        var subcategoria = $(this).val();


        if(subcategoria == 0){

            $(".product-item").show();      

        } else{

            $(".product-item").hide();

            products = $(".product-item").filter("[data-categoria='"+subcategoria+"']");

            products.show();

        }

  });    


    function concretar_pedido() {

 		var datos = {}

   		fun = $.xajax(datos, url+'/concretarPedido');

		fun.success(function (data)
		{
			if(data.success)
			{
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
				active_Menu();
			}

			if(options.callName == "ordersButton") {
				openMyOrdersModal();
			}
		}

	}); 


 	function active_Menu() {

		$('.button-active').removeClass('active');

		if (menuNav == "opcion0"){
			$('#opcion0').addClass('active');
		}

		if (menuNav == "opcion1"){
			$('#opcion1').addClass('active');
		}

		if (menuNav == "opcion2"){
			$('#opcion2').addClass('active');
		}
	}

	 function openMyOrdersModal(){

	    $('#products-modal').modal('show');
	 }


 	
});











