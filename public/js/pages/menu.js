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

 		console.log("actualizar pedidos");

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

  $('.menu-type-item').on('click',function(){



    var action = $(this).data("url");
    var categoria = $(this).data("categoria");

    var dataIn = new FormData();

    dataIn.append("categoria",categoria);

    //mifaces
    $.callAjax(dataIn, action, $(this));


  });


 	

 	

 	

 });