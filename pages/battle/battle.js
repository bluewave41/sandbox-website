(function() {
	
	var $playerPokemon;
	var $enemyPokemon;
	var $log;
	
	$(document).ready(function() {
		$playerPokemon = $('td').eq(0).text();
		$enemyPokemon = $('td').eq(1).text();
		$log = $('#log');
		$('.attack').click(function() {
			let name = $(this).text();
			StaticBase.post('/pages/battle/attack.php', {attack: $(this).attr('id')}).then(function(response) {
				if(response[0] == -1) { //won battle, do something better here
					$log.append($playerPokemon + ' finished off wild ' + $enemyPokemon + ' with ' + name + '!</br>');
					$('#encounterHP').text(0);
					$log.append('Defeated wild ' + $enemyPokemon + '!');
				}
				else {
					let encounterHP = parseInt($('#encounterHP').text());
					$('#encounterHP').text(encounterHP -= response[0]);
					$log.append($playerPokemon + ' used ' + name + ' and did ' + response[0] + ' damage!' + '</br>');
					//$log.append($enemyPokemon + ' used ' + response[1] + '!' + '</br>');
				}
			});
		});
	});
})();