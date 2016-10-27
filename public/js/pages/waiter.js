$(document).on('ready', function() {

	$('.table-details-button').on('click',function(e){

	    var action = $(this).data("url");

	    var dataIn = new FormData();

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

	
});

  /* Procedimientos Post Ajax Call */
$(document).ajaxComplete(function(event,xhr,options){

    if(options.callName != null )
    {
         if(options.callName == "table-details-button"){
            openTableDetailsModal();
         }
    }

}); 

function openTableDetailsModal(){

    $('#table-details').modal('show');
 }