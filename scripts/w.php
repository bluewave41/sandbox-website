<html>
<body>
<div></div>
	<?php
		include('AttackList.php');
		$list = new AttackList([1]);
		print_r($list->attacks);
	?>
	
</body>
</html>