$(document).on('ready', function() {

	$(document).on('click','.menu-type-item',function(){

		$('.button-active').removeClass('active');

		var url = $(this).data('url');

        var dataIn = new FormData();

        //mifaces
        $.callAjax(dataIn, url, $(this));		

	});



});



/* Procedimientos Post Ajax Call */
$(document).ajaxComplete(function(event,xhr,options){

    if(options.callName != null )
    {
        if(options.callName == ""){
        }
    }

});