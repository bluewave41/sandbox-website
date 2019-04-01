$(document).ready(function() {

	$('img').click(function(e) {
		tryEncounter();
	});
});

function tryEncounter() {
	$.ajax({
		url: 'scripts/encounter.php',
		dataType: "JSON",
		success: function(data) {
			var message = $('#message');
			message.empty();
			if(data.message) {
				message.text(data.message);
			}
			else {
				var str = "";
				str += "<div>Wild level "+ data.level + " " + pokemonList[data.id] + " appeared!</div>";
				str += `<img src="sprites/${data.id}.png"/>`;
				str += "<div>HP: "+data.hp+"</div>";
				str += "<button id='redirect'>Battle!</button>";
				message.html(str);
				$('#redirect').click(function() {
					location.href = 'battle.php';
				});
			}
		}
	});
}