$(document).on('ready', function() {

    $(document).on('click', '.table-details-button', function(){
        var action = $(this).data("url");
        var cuenta = $(this).data("cuenta");

        var dataIn = new FormData();
        dataIn.append("cuenta_id", cuenta);

        //mifaces
        $.callAjax(dataIn, action, $(this));
    });

});


/* Procedimientos Post Ajax Call */
$(document).ajaxComplete(function(event,xhr,options){

    if(options.callName != null )
    {
        if(options.callName == "detallePedido"){
            openmodal("cuentas-modal");
        }
    }

});



//modal para mostrar modal
function openmodal(e) {
    $("#"+e).modal('show');
}