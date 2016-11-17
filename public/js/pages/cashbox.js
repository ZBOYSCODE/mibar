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


    $(document).on('change', "#select-mesas",function(){

        $('.button-active').removeClass('active');

        var mesa = $(this).val();


        if(mesa == 0){

            $(".table-item").show();      
        } else {

            $(".table-item").hide();
            mesa = $(".table-item").filter("[data-mesa='"+mesa+"']");
            mesa.show();
        }
    })

    $(document).on('change', "#select-clientes",function(){

        $('.button-active').removeClass('active');

        var cliente_id = $(this).val();


        if(cliente_id == 0){

            $(".table-item").show();      

        } else{

            $(".table-item").hide();

            cliente_id = $(".table-item").filter("[data-client='"+cliente_id+"']");

            cliente_id.show();
        }
    })



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
                $('body').removeClass('modal-open');
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


    