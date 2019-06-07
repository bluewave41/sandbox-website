(function() {
	$(document).ready(function() {
		$('img').click(function(e) {
			tryEncounter();
		});
	});
	
	function tryEncounter() {
		StaticBase.post('scripts/encounter.php', '').then(function(response) {
			var message = $('#message');
			message.empty();
			if(response.message) {
				message.text(response.message);
			}
			else {
				var str = "";
				str += "<div>Wild level "+ response.level + " " + response.name + " appeared!</div>";
				str += `<img src="../../sprites/${response.pokemonID}.png"/>`;
				str += "<div>HP: "+response.hp+"</div>";
				str += "<button id='redirect'>Battle!</button>";
				message.html(str);
				$('#redirect').click(function() {
					location.href = '../battle/battle.php';
				});
			}
		});
	}
})();