$(document).ready(function(){

	//var socket 			= io.connect();
	var form 			= $("#formMessage");
	var message 		= $("#message");
	var chat 			= $("#chat");

	var nickname 		= $("#nickname");
	var users 			= $("#users");



	form.submit(function(e){

		e.preventDefault();

		if(message.val() != '')
		{
			socket.emit('sendMessage', message.val() );
			message.val('');
		}
	});


	if( nickname != null) {

		socket.emit('newUser', nickname.val(), function(data){


			if(data) {

				//$("#nickContainer").hide();
				//$("#login-error").hide();
				//$("#contenido").show();
			} else {

				$("#login-error").show();
			}
		});

	}
		
	
	socket.on('newMessage', function(data)
	{
		chat.append("<b><i class='fa fa-chevron-right'></i> "+data.nick+'</b>: '+data.msg+"<br>");

		var altura = chat.height();

		//console.log(altura);

		chat.scrollTop(altura*1000);
	});


	socket.on('usernames', function(data){

		users.html('');

		for(var username in data){

			var linkText = document.createTextNode(username);

			var alink = document.createElement('p');
				alink.title 	= 'usuario';
				//alink.href		='#';
				alink.className = 'chat_usr';
            var icon = document.createElement('i');
                icon.className = 'fa fa-user';
                alink.appendChild(icon);
                alink.appendChild(linkText);
			users.append(alink);
		}

	});



});