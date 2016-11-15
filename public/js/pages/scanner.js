$(document).on('ready', function() {


	$(document).on('click', '#captura_qr', function(e){

		
		e.preventDefault();
		
		var url = $("#url").val();

		var formData = new FormData( document.getElementById("form") );


		console.log(url);

	    $.ajax({
	        url: url+"/table",
	        type: 'POST',
	        data: formData,
	        async: true,
	        dataType: 'json',
	        success: function (data) {
	            
	        	if(data.success) {

	        		window.location.href = data.redirect

	        	} else {

	        		console.log(data);
	        		alert("¡ Debes fotografiar el QR !");
	        	}

	        },
	        cache: false,
	        contentType: false,
	        processData: false
	    });

	});

    $(document).on( 'change','.inputfile', function( e )
    {   
        var fileName = $('.inputfile')[0].files[0].name;
        $("#file-name").html( fileName );
        
    });

});