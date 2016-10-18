 var menuNav = "opcion1";

 $(document).on('ready', function() {

  $('#'+menuNav).addClass('active');

 	var url = $("#frm").val();
 	$(document).on('click', '#add-menu-product', function() {

 		var producto = $(this).attr('data-producto');
 		agregar_productos_carro(producto);

 	});

 	$(document).on('click', '.delete-pedido', function(){

 		var pedido = $(this).attr('data-pedido');

 		$("#pedido-"+pedido).remove();
 		console.log("Pedido Nº "+pedido+" removido");

 		actualizar_pedidos();
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

 		console.log("actualizar pedidos");


 		actualizar_precio_pedidos();

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

   
   $('#Send-Products').on('click', function(){

      swal({
        title: '¿Estás Seguro?',
        text: "Se enviarán todos los productos",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#521852',
        cancelButtonColor: '#d65cc0',
        confirmButtonText: 'Enviar'
      }).then(function() {
        swal({
          title:'¡Pedido Concretado!',
          text: 'Atenderemos su solicitud a la brevedad.',
          type: 'success',
          confirmButtonColor: '#521852'
        }).then(function() {
          $('#products-modal').modal('hide');
        })       
      });
      
   });

  $('.menu-prod').on('click',function(){

    var action = $(this).data("url");

    var dataIn = new FormData();

    //mifaces
    $.callAjax(dataIn, action, $(this));


  });

  $('.menu-promo').on('click',function(){

    var action = $(this).data("url");

    var dataIn = new FormData();

    //mifaces
    $.callAjax(dataIn, action, $(this));


  });  

  

    /* Procedimientos Post Ajax Call */
  $(document).ajaxComplete(function(event,xhr,options){

      if(options.callName != null )
      {
          if(options.callName == "changeMenu") {
              active_Menu();
          }
      }

  });


});

 	

 	function active_Menu(){

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


