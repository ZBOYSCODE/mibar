$(document).on('ready', function() {

	var url = $("#url-proyecto").val();

	/**
	 * Vista Mesero
	 *
	 * actualiza la lista de pendientes y emite un alert
	 */
	socket.on('new-order', function(data)
	{
		if( $("#waiter_tables_details_render").length > 0 ) {

			console.log("Vista Waiter");
			console.log("se ha creado una nueva orden");
			
			actualizar_total_pendientes(data);
		}
		

	});


	function actualizar_total_pendientes(cuenta_id){

		var datos = {
			'cuenta_id' : cuenta_id
		}


        fun = $.xajax(datos, url+"waiter/getPendingOrdersByCuenta");

        fun.success(function (data)
        {
            if(!data.success) {
                console.log(data.msg);
                return false;
            }

            $.each( data.datos, function(mesa_id, mesa){

            	$("#waiter-totalpedidos-"+mesa_id).text(mesa.pedidosTotales);
				$("#waiter-pedidospendientes-"+mesa_id).text(mesa.pedidos_pendientes);
				$("#waiter-estado-"+mesa_id).text(mesa.estado);
            });

        });
	}

})