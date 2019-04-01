(function() {
	$(document).ready(function() {
		
		$(".starter").click(function(e) {
			starterClick($(e.target));
		});
		
		$("#register").click(function(e){
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
	});
})();