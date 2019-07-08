(function() {
	$(document).ready(function() {
		
		$(".starter").click(function(e) {
			starterClick($(e.target));
		});
		
		$("#register").click(function(e) {
			let errors = validate();
			if(errors) {
				e.preventDefault();
				alert(errors.join('\n'));	
				return;
			}
			let data = {
				type: 'register',
				username: $('#username').val(),
				password: $('#password').val(),
				email: $('#email').val(),
				starter: $('.selected').attr('id') || -1
			};
			StaticBase.buttonClick(e, 'scripts/account.php', data, function(response) {
				console.log(response);
			});
		});
		
		function starterClick(starter) {
			let starters = $('.starter');
			starters.removeClass('selected');
			starter.addClass('selected');
		}
		
		function validate() {
			let errors = [];
			if($('#username').val() == '') {
				errors.push("Username field is empty.");
			}
			if($('#password').val() == '') {
				errors.push("Password field is empty.");
			}
			if($('#email').val() == '') {
				errors.push("Email field is empty.");
			}
			if($('.selected').length == 0) {
				errors.push("You didn't select a starter.");
			}
			return errors;
		}
	});
})();