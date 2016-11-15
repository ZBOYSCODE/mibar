var pedido_eliminado;

$(document).on('ready', function() {

	$(document).on('click','.menu-type-item2',function(){

		var url = $(this).data('url');
        var dataIn = new FormData();

        dataIn.append("status", status);

        //mifaces
        $.callAjax(dataIn, url, $(this));
    });


    $(document).on('click','#menu-pendientes',function(){

        renderPage();
    });

    $(document).on('click','#menu-listos',function(){

        renderPageListos();
    });


	$(document).on('click','.btn-concretar',function(){

		var url = $(this).data('url');
		var pedido = $(this).data('pedido');


        var dataIn = new FormData();

        dataIn.append('pedido',pedido);

        //mifaces
        $.callAjax(dataIn, url, $(this));		

	});	

    $(document).on('click', '.button-active', function(){
        $(".button-active").removeClass('active');
        $(this).addClass('active');
    });

    $(document).on('click','.pedido-details', function(){

		var url = $(this).data('url');
		var pedido = $(this).data('pedido');


        var dataIn = new FormData();

        dataIn.append('pedido',pedido);

        //mifaces
        $.callAjax(dataIn, url, $(this));
    });


    $(document).on('click', '.detalle_orden', function(){

        var mesa    = $(this).attr('data-mesa')
        var fecha   = $(this).attr('data-fecha')

        console.log("."+mesa+"_"+fecha)

        $("."+mesa+"_"+fecha).toggle();

    });
    

    /* Procedimientos Post Ajax Call */
    $(document).ajaxComplete(function(event,xhr,options){

        if(options.callName != null )
        {
            if(options.callName == "pedido-details"){

                openPedidoDetailsModal();
            }

            if(options.callName == 'delete-pedido'){
                removePedido();
            }

            if(options.callName == "render-page") {

                renderPage();
            }
        }

    });

    function removePedido() {

        if( pedido_eliminado != 'false' ){


            $("#table-pedido-"+pedido_eliminado).addClass('alert-delete');


            $("#table-pedido-"+pedido_eliminado).hide('slow', function() {

                var this_btn    = $("#btn-delete-"+pedido_eliminado);

                var mesa        = this_btn.attr('data-mesa');
                var fech        = this_btn.attr('data-fecha');
                
                $(this).remove();
                
                var cantidad    = $("."+mesa+"_"+fech+" div").length;

                if(cantidad == 0){

                    $("#btn-detalle-"+mesa+"_"+fech).addClass('alert-delete');

                    $("#btn-detalle-"+mesa+"_"+fech).hide('slow', function() {
                        $(this).remove();
                    });

                    $("#list-"+mesa+"_"+fech).hide('slow', function(){
                        $(this).remove();
                    });
                }
                
            });
        }

    }

    function renderPage() {

        var url = $("#url-bartender").val();

        //mifaces
        $.callAjax(null, url+"/renderPage", $("#url-bartender"));  
    }

    function renderPageListos() {

        var url = $("#url-bartender").val();

        //mifaces
        $.callAjax(null, url+"/renderPageListos", $("#url-bartender"));  
    }


    function openPedidoDetailsModal(){

        $('#pedido-details-modal').modal('show');

    }
});



