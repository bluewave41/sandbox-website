(function() {
	$(document).ready(function() {
		$("#login").click(function(e) {
			let data = {
				type: 'login',
				username: $('#username').val(),
				password: $('#password').val(),
			};
			StaticBase.buttonClick(e, 'scripts/account.php', data, function(response) {
				if(response[0] == "Account created successfully." || response[0].startsWith('Welcome')) {
					setTimeout(function() {
						window.location.href = '../index/index.php';
					}, 2000);
				}
			});
		});
	});
})();