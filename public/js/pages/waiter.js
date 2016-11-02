$(document).on('ready', function() {




	$('.table-details-button').on('click',function(e){

	    var action = $(this).data("url");
        var table_id = $(this).data('table');

	    var dataIn = new FormData();

        dataIn.append('table_id', table_id);
        dataIn.append('cuenta_id', $(this).attr('data-cuenta') );
        dataIn.append('table_numero', $(this).attr('data-numero') );

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

    $(document).on('click', '#create-user', function(e){

        e.preventDefault();
        
        var url     = $(this).attr('data-url');
        var mesa    = $(this).attr('data-table');

        var dataIn = new FormData();

        dataIn.append('mesa',   mesa);

        //mifaces
        $.callAjax(dataIn, url, $(this)); 
    });

    $(document).on('click', '#store-cliente', function(e){

        var url     = $(this).attr('data-url');
        var mesa    = $(this).attr('data-table');

        var nombre    = $("#nombre-cliente").val();

        if(nombre == '') {

            $("#error-nombre-cliente").text("Debe ingresar el nombre del cliente.");
            return false;
        }

        var dataIn = new FormData();

        dataIn.append('table_id',   mesa);
        dataIn.append('nombre-cliente', nombre);

        //mifaces
        $.callAjax(dataIn, url, $(this)); 
        e.preventDefault();

    });

    $(document).on('click', '.table-order-button', function(){

        var url     = $(this).attr('url');
        var cuenta  = $(this).attr('cuenta');

        var dataIn = new FormData();

        dataIn.append('cuenta',cuenta);

        //mifaces
        $.callAjax(dataIn, url, $(this));        
        e.preventDefault();

    });

    /*$('.table-order-button').on('click',function(e){
        var route = "/mibar/qr/"+$(this).data("href");
        location.href= route;
    });
    */

    $(document).on('click','.detalle-cuenta',function(e){

        var url = $(this).data('url');
        var cuenta = $(this).data('cuenta');

        var dataIn = new FormData();

        dataIn.append('cuenta',cuenta);

        //mifaces
        $.callAjax(dataIn, url, $(this));        
        e.preventDefault();
    });    


    $(document).on('click','#btn-validar-pedidos',function(e){

        var url = $(this).data('url');
        var table_id = $(this).data('table');
        
        var dataIn = new FormData();

        $('.checkPedido').each(function(){

            if($(this).is(':checked')){
                dataIn.append('pedidosValidados[]', $(this).val());   
            } else {
                dataIn.append('pedidosNoValidados[]',$(this).val());    
            }
        });  

        dataIn.append('table_id',table_id);

        //mifaces
        $.callAjax(dataIn, url, $(this));
        
        e.preventDefault();

    });  

    $(document).on('click','.pedidos-pendientes',function(e){

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

         if(options.callName == "btn-validar-pedidos"){
            closeBillDetailsModal();

         }            
  
        if (options.callName == "create-user-modal"){
            openCreateUserModal();
        }

        if (options.callName == 'store-cliente-success'){

            closeCreateUserModal();
        }  

         if (options.callName == 'pedidos-pendientes'){

            openPendingOrdersModal();
        }  
         
    }

}); 

function openTableDetailsModal(){

    $('#table-details').modal('show');
}

function openCreateUserModal(){

    $('#create-client-modal').modal('show');
}

function openBillDetailsModal(){

    $('#bill-details').modal('show');
} 

function openPendingOrdersModal(){

    $('#pending_orders').modal('show');
} 

function closeBillDetailsModal(){
    $('#bill-details').modal('hide');

    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
}

function closeCreateUserModal() {

    $('#create-client-modal').modal('hide');

    $('body').removeClass('modal-open');
    $(".modal-backdrop").remove();
}

function closePendingOrdersModal() {

    $('#pending_orders').modal('hide');
    $('body').removeClass('modal-open');
    $(".modal-backdrop").remove();
}
