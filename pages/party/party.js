(function() {
	$(document).ready(function() {
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

		$("img").draggable({helper: "clone" });

		$("img").droppable({
			accept: "img",
			activeClass: "ui-state-hover",
			hoverClass: "ui-state-active",
			drop: function( event, ui ) {
				var draggable = ui.draggable, droppable = $(this),
					dragPos = draggable.position(), dropPos = droppable.position();
				draggable.swap(droppable);
			}
		});
	});
})();