$(document).on('ready', function() {

	$(document).on('click','.menu-type-item',function(){

		var url = $(this).data('url');
        var dataIn = new FormData();

        dataIn.append("status", status);

        //mifaces
        $.callAjax(dataIn, url, $(this));
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

});



/* Procedimientos Post Ajax Call */
$(document).ajaxComplete(function(event,xhr,options){

    if(options.callName != null )
    {
        if(options.callName == "completeOrders"){
        }
    }

});