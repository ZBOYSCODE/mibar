$(document).on('ready', function() {

	$('.table-details-button').on('click',function(e){

	    var action = $(this).data("url");

	    var dataIn = new FormData();

	    //mifaces
	    $.callAjax(dataIn, action, $(this));
	    
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
    }

}); 

function openTableDetailsModal(){

    $('#table-details').modal('show');
 }