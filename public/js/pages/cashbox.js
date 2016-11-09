var total;

$(document).on('ready', function() {


    $(document).on('click', '.table-details-button', function(){
        var action = $(this).data("url");
        var cuenta = $(this).data("cuenta");

        var dataIn = new FormData();
        dataIn.append("cuenta_id", cuenta);

        //mifaces
        $.callAjax(dataIn, action, $(this));
    });


    $(document).on('click', '#btn-descuento', function(e) {

        total = 0;

        var action = $(this).data("url");
        var subtotal = parseInt(document.getElementById("subtotal").innerHTML);
        var descuento = parseInt(document.getElementById("descuento").value);
        var cuenta_id = $(this).attr('data-cuenta')

        if(isNaN(descuento)){
            descuento = 0;
        }

        if (descuento > subtotal) {
            descuento = subtotal;
        }


        var dataIn = new FormData();

        dataIn.append("cuenta_id", cuenta_id);
        dataIn.append("descuento", descuento);

        //mifaces
        $.callAjax(dataIn, action, $(this));

    });

    $(document).on('click', "#btn-pagar", function(e){

        e.preventDefault();

        var action = $(this).data("url");
        var cuenta = $(this).data("cuenta");
        var descuento = document.getElementById("descuento").value;

        var dataIn = new FormData();

        dataIn.append("cuenta_id", cuenta);
        dataIn.append("descuento", descuento);
        
        //$("#pagar-modal").modal('toggle');

        //mifaces
        $.callAjax(dataIn, action, $(this));
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

            if(options.callName == "completarPago") {

                //openmodal("boleta-modal");

                $("#pagar-modal").modal('toggle');
                $(".modal-backdrop").hide();
            }

            if(options.callName == 'updatePrecio'){

                updatePrecio();
            }
        }

    });

    function updatePrecio() {

        $("#total").text(total);
    }

    //modal para mostrar modal
    function openmodal(e) {
        $("#"+e).modal('show');
    }
});


    