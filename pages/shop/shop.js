(function() {
	
	let items = []; //these indexes line up with database indexes
	
	$(document).ready(function() {
		$('input').change(function(e) {
			let total = 0;
			$('input').each(function(index, el) {
				let amount = $(el).val();
				items[index] = amount;
				total += amount * parseInt($(el).parent().prev().first().text());
			});
			$('#cost').text(total);
		});
		
		$('button').click(function() {
			StaticBase.post('pages/shop/purchase.php', {items: items}).then(function(response) {
				$('#response').text(response);
			});
		});
	});
	
})();