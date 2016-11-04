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
        if (descuento > subtotal) {
            descuento = subtotal;
        }
        var total = subtotal - descuento;

        document.getElementById("descuentoinput").value = descuento;
        document.getElementById("total").innerHTML = total;
    });

    $(document).on('click', "#btn-pagar", function(){
        var action = $(this).data("url");
        var cuenta = $(this).data("cuenta");
        var descuento = document.getElementById("descuento").value;

        var dataIn = new FormData();

        dataIn.append("cuenta_id", cuenta);
        dataIn.append("descuento", descuento);
        $("#pagar-modal").modal('toggle');

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
        if(options.callName == "pagarCuenta"){
            openmodal("pagar-modal");
        }

        if(options.callName == "completarPago"){
            openmodal("boleta-modal");
        }
    }

});



//modal para mostrar modal
function openmodal(e) {
    $("#"+e).modal('show');
}