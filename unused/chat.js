$(document).ready(function() {
	var socket = io('localhost:3000');
	var chat = $('#chat');
	socket.on('connect', function() {
		console.log('q');
	});
	socket.on('user joined', function() {
		chat.append('<input type="text"></input>');
	});
});