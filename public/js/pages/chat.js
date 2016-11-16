$(document).ready(function(){

	var nodeServer = 'http://192.168.85.120:8000';
    var socket = io.connect(nodeServer);

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
		chat.append("<b>"+data.nick+'</b>: '+data.msg+"<br>");

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
				alink.appendChild(linkText);

			users.append(alink);
		}

	});



});