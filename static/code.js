var StaticBase = (function() {
	
	$(document).ready(function() {
		$("#logout").click(function(e){
			logoutAccount();
		});
	});
	
	function logoutAccount() {
		let data = {
			type: 'logout',
		};
		post('scripts/account.php', data).then(function() {
			console.log('w');
			location.reload();
		});
	}
	
	function post(url, data) {
		return new Promise(function(resolve, reject) {
			$.ajax({
				type: "POST",
				url: 'http://localhost/testsite/' + url,
				dataType: 'JSON',
				data: data,
				success: function(data) {
					resolve(data);
				},
				error: function(error) {
					console.log(error);
				}
			});
		});
	}
	
	return {
		buttonClick: function(e, url, data, callback) {
			e.preventDefault();
			$('.wrapper').addClass('form-success');
			$('form').fadeOut(500, function() {
				$('.loader').addClass('active');
				post(url, data).then(function(response) {
					$('.loader').removeClass('active');
					let errors = '';
					for(var x=0;x<response.length;x++) {
						errors += `<div>${response[x]}</div>`;
					}
					$('#message').html(errors).css({'display': 'block'});
					callback(response);
				});
			});
		},
		
		post: post
	};
})();