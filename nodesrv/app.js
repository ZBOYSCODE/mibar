var express = require("express"),
	app = express(),
	server = require("http").createServer(app),
	io = require("socket.io").listen(server),
	nicknames = {},
	chat = [];

//server.listen(process.env.PORT, process.env.IP);
server.listen(8000);

app.get("/", function(req, res){
	
	res.sendfile( __dirname + '/index.html')

});


// SOCKETS
// cada vez que alguien se conecte se crea un nuevo socket
io.sockets.on( ('connection'), function(socket){
	

	

	socket.on('sendMessage', function(data){

		var msg = {
			'msg':data,
			'nick': socket.nickname
		};

		chat.push(msg);

		io.sockets.emit('newMessage', {msg: data, nick: socket.nickname});

	});

	socket.on('newUser', function(data, callback){

		if(data in nicknames){
			callback(false);
		}else{

			callback(true);
			socket.nickname = data;
			nicknames[socket.nickname] = 1;

			updateNickNames();
			sendMsg();
		}

	});

	socket.on('disconnect', function(data){

		if(!socket.nickname) return false;

		delete nicknames[socket.nickname];

		updateNickNames();

	});


	socket.on('new-order', function(data){

		console.log("nueva orden");
		console.log(data);
		
		io.sockets.emit('new-order', data);

	});

	socket.on('new-valid-orders', function(data) {

		console.log("nuevos pedidos validados");
		console.log(data);
		
		io.sockets.emit('new-valid-orders', data);
	});



	function updateNickNames()
	{
		io.sockets.emit('usernames', nicknames);
	}

	function sendMsg()
	{
		io.sockets.emit('loadChat', chat );
	}
});