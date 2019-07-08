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
					$log.append($playerPokemon + ' earned ' + response[1] + ' exp points!</br>');
					$('#encounterHP').text(0);
					$log.append('Defeated wild ' + $enemyPokemon + '!');
				}
				else if(response[0] == -2) {
					$log.append($enemyPokemon + ' used ' + attacks[response[1]-1] + ' and did ' + response[2] + ' damage!' + '</br>');
					$log.append($playerPokemon + ' fainted!</br>');
					$('#playerHP').text(0);
				}
				else {
					let isPlayerFirst = response[0];
					let playerHP = parseInt($('#playerHP').text());
					let encounterHP = parseInt($('#encounterHP').text());
					let playerDamage = response[1];
					let enemyAttackID = response[2]-1;
					let enemyDamage = response[3];
					$('#playerHP').text(playerHP - enemyDamage); //dont do this here?
					$('#encounterHP').text(encounterHP - playerDamage);
					if(isPlayerFirst) { //
						$('#encounterHP').text(encounterHP - playerDamage);
						$log.append($playerPokemon + ' used ' + name + ' and did ' + playerDamage + ' damage!' + '</br>');
						$log.append($enemyPokemon + ' used ' + attacks[enemyAttackID] + ' and did ' + enemyDamage + ' damage!' + '</br>');
					}
					else {
						$log.append($enemyPokemon + ' used ' + attacks[enemyAttackID] + ' and did ' + enemyDamage + ' damage!' + '</br>');
						$log.append($playerPokemon + ' used ' + name + ' and did ' + playerDamage + ' damage!' + '</br>');

					}
				}
			});
		});
		$('#catch').click(function() {
			StaticBase.post('/pages/battle/catch.php', {}).then(function(response) {
				if(response == -3) {
					$('img').eq(1).attr('src', '../../sprites/items/pokeball.png');
					$log.append($enemyPokemon + ' was caught!');
				}
				else if(response == -4) {
					$log.append('Shoot! It was so close.</br>');
				}
			});
		});
	});
})();