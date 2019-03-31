<?php
	include('Pokemon.php');
	$poke = new Pokemon(null, 1, 1, 1, 1);
	print_r($poke->serialize());
?>