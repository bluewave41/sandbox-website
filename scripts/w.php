<html>
<body>
<div></div>
	<?php
		include('Pokemon.php');
		include('Database.php');
		$pokemon = Pokemon::get($pdo, 59, 1);
		print_r($pokemon);
	?>
	
</body>
</html>