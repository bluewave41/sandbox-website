<?php
	include('Collection.php');
	include('Database.php');
	include('Party.php');
	$collection = new Party($pdo, 2);
	//$bag = new Bag($collection);
	print_r(count($collection->values));
?>