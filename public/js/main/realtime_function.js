$(document).on('ready', function() {

	var url = $("#url-proyecto").val();

	/**
	 * Vista Mesero
	 *
	 * actualiza la lista de pendientes y emite un alert
	 */
	socket.on('new-order', function(data)
	{
		// Vista Waiter
		if( $("#waiter_tables_details_render").length > 0 ) {
		
			actualizar_total_pendientes(data);
		}
	});


	/**
	 * Vista Bartender y Kitchen
	 *
	 * actualiza el listado de pedidos pendientes
	 */
	socket.on('new-valid-orders', function(data) {

		// Vista Bartender
		if( $("#bartender_tables_details_render").length > 0 ) {
		
			actualizar_pedidos_pendientes(data);
		}
	});


	/**
	 * actualizar_pedidos_pendientes
	 *
	 * actualiza la lista de pedidos pendientes
	 */
	function actualizar_pedidos_pendientes(data) {

		var datos = {
			'fecha_desde' : $("#ultima-revision").val()
		}


		if( $("#categoria-producto").val() == 1 ) {

			var ruta = url+"bartender/getPendingOrders";
		} else {

			var ruta = url+"kitchen/getPendingOrders";
		}


        fun = $.xajax(datos, ruta );

        fun.success(function (data)
        {
            if(!data.success) {
                console.log(data.msg);
                return false;
            }

            $("#no_hay_pedidos").remove();

            $("#bartender_tables_details_render").append(data.toRend);

        });
        
	}

	/**
	 * actualizar_total_pendientes
	 *
	 * actualiza en vista waiter los datos de las mesas
	 * estado, total de pedidos y pedidos pendientes
	 */
	function actualizar_total_pendientes(cuenta_id){

		var datos = {
			'cuenta_id' : cuenta_id
		}


        //fun = $.xajax(datos, url+"waiter/getPendingOrdersByCuenta");
        fun = $.xajax(datos, url+"waiter/getMesaByCuenta");

        fun.success(function (data)
        {
            if(!data.success) {
                console.log(data.msg);
                return false;
            }

            //actualizamos solo la mesa correspondiente y agregamos animacion

            $("#waiter-totalpedidos-"+data.mesa_id).text(data.mesa.pedidosTotales);
			$("#waiter-pedidospendientes-"+data.mesa_id).text(data.mesa.pedidos_pendientes);
			$("#waiter-estado-"+data.mesa_id).text(data.mesa.estado);
			
			$("#table-item-"+data.mesa_id).addClass("item-new-socket");
			$("#table-item-"+data.mesa_id).addClass("animated");
			$("#table-item-"+data.mesa_id).addClass("pulse");

           /* 
           $.each( data.datos, function(mesa_id, mesa){

            	$("#waiter-totalpedidos-"+mesa_id).text(mesa.pedidosTotales);
				$("#waiter-pedidospendientes-"+mesa_id).text(mesa.pedidos_pendientes);
				$("#waiter-estado-"+mesa_id).text(mesa.estado);

				$("#table-item-"+mesa_id).addClass("animated");
				$("#table-item-"+mesa_id).addClass("pulse");
            });
            */

        });
	}

})