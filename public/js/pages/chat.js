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
		newMsg(data.nick, data.msg);
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

	socket.on('loadChat', function(data){

		$.each(data, function(index, mensaje){

			newMsg(mensaje.nick, mensaje.msg)

		});
	});

	function newMsg(nick, msg) {

		chat.append("<b><i class='fa fa-chevron-right'></i> "+nick+'</b>: '+msg+"<br>");

		var altura = chat.height();

		chat.scrollTop(altura*1000);
	}

});