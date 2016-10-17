 $(document).on('ready', function() {
   
   $('#Send-Products').on('click', function(){
      swal({
        title: '¿Estás Seguro?',
        text: "Se enviarán todos los productos",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#521852',
        cancelButtonColor: '#d65cc0',
        confirmButtonText: 'Enviar'
      }).then(function() {
        swal({
          title:'¡Pedido Concretado!',
          text: 'Atenderemos su solicitud a la brevedad.',
          type: 'success',
          confirmButtonColor: '#521852'
        }).then(function() {
          $('#products-modal').modal('hide');
        })       
      });
      
   });

  $('.menu-type-item').on('click',function(){



    var action = $(this).data("url");
    var categoria = $(this).data("categoria");

    var dataIn = new FormData();

    dataIn.append("categoria",categoria);

    //mifaces
    $.callAjax(dataIn, action, $(this));


  });

 	
 });