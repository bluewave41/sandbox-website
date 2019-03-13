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
			console.log(response);
			$('.loader').removeClass('active');
			$('#message').text(response.message).css({'display': 'block'});
			if(response.status >= 0) {
				setTimeout(function() {
					window.location.href = 'index.php';
				}, 2000);
			}
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
		dataType: 'JSON',
		data: {
			type: 'generateKey',
		},
		success: function(data) {
			let $keys = $('#keys');
			if(data.error) {
				if($keys.children().last().text() != 'You already have the maximum number of keys.') {
					$keys.append(`<div class="error">${data.message}</div>`);
				}
				return;
			}
			if($keys.eq(0).text() == 'You have no keys.') {
				$keys.empty();
			}
			$keys.append(`<div>${data.message}</div>`);
		},
	});
}