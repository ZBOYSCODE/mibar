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

  $('.menu-prod').on('click',function(){

    var action = $(this).data("url");

    var dataIn = new FormData();

    //mifaces
    $.callAjax(dataIn, action, $(this));


  });

  $('.menu-promo').on('click',function(){

    var action = $(this).data("url");

    var dataIn = new FormData();

    //mifaces
    $.callAjax(dataIn, action, $(this));


  });  

 	
 });