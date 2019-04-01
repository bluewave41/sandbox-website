(function() {
	console.log('w');
	$(document).ready(function() {
		$("#generateKey").click(function(e) {
			generateKey();
		});	
	});

	function generateKey() {
		let $keys = $('#keys');
		StaticBase.post() {
			
		}
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
})();