<html>
<body>
<div>www</div>
	<?php
		include('WildPokemon.php');
		
		$pokemon = new WildPokemon(null, 16, -1, 5);
		$pokemon->tryCatch();
	?>
	
</body>
</html>