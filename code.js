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
	$(".starter").click(function(e) {
		starterClick($(e.target));
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
			let errors = '';
			for(var x=0;x<response.length;x++) {
				errors += `<div>${response[x]}</div>`;
			}
			$('#message').html(errors).css({'display': 'block'});
			if(response[0] == "Account created successfully." || response[0].startsWith('Welcome')) {
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
				starter: $('.selected').attr('id') || -1
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
	let $keys = $('#keys');
	$.ajax({
		type: "POST",
		url: 'api/api.php',
		dataType: 'JSON',
		data: {
			type: 'generateKey',
		},
		success: function(data) {
			console.log(data);
			if($keys.eq(0).text() == 'You have no keys.') {
				$keys.empty();
			}
			$keys.append(`<div>${data.key}</div>`);
		},
		error: function(data) {
			console.log($keys.children().last().text());
			if($keys.children().last().text() != "You already have the maximum number of keys.") {
				$keys.append(`<div class="error">${data.responseJSON.message}</div>`);
			}
		}
	});
}

function starterClick(starter) {
	console.log('w');
	let starters = $('.starter');
	starters.removeClass('selected');
	starter.addClass('selected');
}