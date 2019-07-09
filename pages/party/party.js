(function() {
	$backup = 0;
	
	$(document).ready(function() {
		$('body').on('click', '#back', function() {
			$('#info').remove();
			$('h1').after($backup);
		});
		
		jQuery.fn.swap = function(b) { 
			// method from: http://blog.pengoworks.com/index.cfm/2008/9/24/A-quick-and-dirty-swap-method-for-jQuery
			b = jQuery(b)[0].parentNode.parentNode;
			var a = this[0].parentNode.parentNode;
			var t = a.parentNode.insertBefore(document.createTextNode(''), a); 
			b.parentNode.insertBefore(a, b); 
			t.parentNode.insertBefore(b, t); 
			t.parentNode.removeChild(t);
			StaticBase.post('pages/party/swapOrder.php', {ids: [$(a).attr('id'), $(b).attr('id')]});
			//return this; 
		};

		$("#draggable img").draggable({helper: "clone" });

		$("#draggable img").droppable({
			accept: "img",
			activeClass: "ui-state-hover",
			hoverClass: "ui-state-active",
			drop: function( event, ui ) {
				var draggable = ui.draggable, droppable = $(this),
					dragPos = draggable.position(), dropPos = droppable.position();
				draggable.swap(droppable);
			}
		});
		
		$('.name').click(function() {
			let id = $(this).closest('tr').attr('id');
			$backup = $('table').clone(true);
			$('table').remove();
			StaticBase.post('pages/party/getPokemonInfo.php', {partyPosition: id}).then(function(data) {
				let str = "<div id='info'>";
				str += `<div>${data[0]}</br>`;
				str += `<div><img src="../../sprites/${data[1]}.png"/></div>`;
				str += `<div>Level: ${data[2]}</div>`
				str += `<div>EXP: ${data[3]}</div>`
				str += '</div>';
				let attacks = JSON.parse(data[4]);
				for(var x=0;x<attacks.length;x++) {
					str += `<div>${attacks[x].name}</div>`;
				}
				str += `<div><button id="back">Back</button></div>`;
				$('.container').append(str);
			});
		});
	});
})();