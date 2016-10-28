$(document).on('ready', function() {




	$('.table-details-button').on('click',function(e){

	    var action = $(this).data("url");
        var table_id = $(this).data('table');

	    var dataIn = new FormData();
        dataIn.append('table_id',table_id);

	    //mifaces
	    $.callAjax(dataIn, action, $(this));
	    
	    e.preventDefault();
    
    }); 


    $(document).on('change','#filtro-mesa',function(){

        var filtroMesa = $(this).val();

        if(filtroMesa == 0){

            $(".table-item").show();      

        } else{

            $(".table-item").hide();

            tables = $(".table-item").filter("[data-mesa='"+filtroMesa+"']");

            tables.show();

        }        
    
    }); 

    $(document).on('change','#filtro-estado-mesa',function(){

        var filtroEstadoMesa = $(this).val();

        if(filtroEstadoMesa == 0){

            $(".table-item").show();      

        } else{

            $(".table-item").hide();

            tables = $(".table-item").filter("[data-estado-mesa='"+filtroEstadoMesa+"']");

            tables.show();

        } 
    
    });     

    
    $('.table-order-button').on('click',function(e){

        var route = "/mibar/qr/"+$(this).data("href");
        location.href= route;
    
    }); 

    $(document).on('click','.detalle-cuenta',function(e){

        var url = $(this).data('url');
        var cuenta = $(this).data('cuenta');

        var dataIn = new FormData();

        dataIn.append('cuenta',cuenta);

        //mifaces
        $.callAjax(dataIn, url, $(this));        
        e.preventDefault();
    });     


    

	
});

  /* Procedimientos Post Ajax Call */
$(document).ajaxComplete(function(event,xhr,options){

    if(options.callName != null )
    {
         if(options.callName == "table-details-button"){
            openTableDetailsModal();
         }

         if(options.callName == "bill-details-button"){
            openBillDetailsModal();
         }         
    }

}); 

function openTableDetailsModal(){

    $('#table-details').modal('show');
}

function openBillDetailsModal(){

    $('#bill-details').modal('show');
} 