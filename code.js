$(document).ready(function() {
	$("#register").click(function(e){
		buttonClick(e, createAccount);
	});
	$("#login").click(function(e){
		buttonClick(e, loginAccount);
	});
	$("#logout").click(function(e){
		logoutAccount();
	});
	$("#generateKey").click(function(e) {
		generateKey();
	});
});

function buttonClick(e, clickFunction) {
	e.preventDefault();
	$('.wrapper').addClass('form-success');
	$('form').fadeOut(500, function() {
		$('.loader').addClass('active');
		clickFunction().then(function(response) {
			$('.loader').removeClass('active');
			$('#message').text(response.message).css({'display': 'block'});
			setTimeout(function() {
				window.location.href = 'index.php';
			}, 2000);
		});
	});
}

function createAccount() {
	return new Promise(function(resolve, reject) {
		$.ajax({
			type: "POST",
			url: 'scripts/account.php',
			dataType: 'JSON',
			data: {
				type: 'register',
				username: $('#username').val(),
				password: $('#password').val(),
				email: $('#email').val(),
			},
			success: function(data) {
				resolve(data);
			}
		});
	});
}

function loginAccount() {
	return new Promise(function(resolve, reject) {
		$.ajax({
			type: "POST",
			url: 'scripts/account.php',
			dataType: 'JSON',
			data: {
				type: 'login',
				username: $('#username').val(),
				password: $('#password').val(),
			},
			success: function(data) {
				resolve(data);
			}
		});
	});
}

function logoutAccount() {
	$.ajax({
		type: "POST",
		url: 'scripts/account.php',
		data: {
			type: 'logout',
		},
		success: function(data) {
			location.reload();
		}
	});
}

function generateKey() {
	$.ajax({
		type: "POST",
		url: 'api/api.php',
		data: {
			type: 'generateKey',
		},
		success: function(data) {
			let $keys = $('#keys');
			if($keys.eq(0).text() == 'You have no keys.') {
				$keys.empty();
			}
			$keys.append(`<div>${data}</div>`);
		}
	});
}

function createTable() {
	$.ajax({
		type: "POST",
		url: 'scripts/userList.php',
		dataType: 'JSON',
		success: function(data) {
			let table = '<thead><tr><td>Username</td></tr></thead>';
			for(var x=0;x<data.length;x++) {
				table += '<tr><td>' + data[x].username + '</td></tr>';
			}
			console.log(table);
			$('#userList').html(table);
		}
	});
}