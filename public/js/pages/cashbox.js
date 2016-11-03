$(document).on('ready', function() {

    $(document).on('click', '.table-details-button', function(){
        var action = $(this).data("url");
        var cuenta = $(this).data("cuenta");

        var dataIn = new FormData();
        dataIn.append("cuenta_id", cuenta);

        //mifaces
        $.callAjax(dataIn, action, $(this));
    });

    $(document).on('click', '#btn-descuento', function(){
        var subtotal = parseInt(document.getElementById("subtotal").innerHTML);
        var descuento = parseInt(document.getElementById("descuento").value);
        if(isNaN(descuento)){
            descuento = 0;
        }
        var total = subtotal - descuento;
        if(total < 0) {
            total = 0;
        }
        document.getElementById("total").innerHTML = total;
    });

});


/* Procedimientos Post Ajax Call */
$(document).ajaxComplete(function(event,xhr,options){

    if(options.callName != null )
    {
        if(options.callName == "detallePedido"){
            openmodal("cuentas-modal");
        }
        if(options.callName == "pagarCuenta"){
            openmodal("pagar-modal");
        }
    }

});



//modal para mostrar modal
function openmodal(e) {
    $("#"+e).modal('show');
}