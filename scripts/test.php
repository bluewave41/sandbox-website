<?php
	include('Database.php');
	include('Pokemon.php');
	
	$baseHP = 108;
	$hpIV = 24;
	$level = 78;
	
	echo ((2*$baseHP+$hpIV+(74/4))*$level/100)+$level+10;
	
	//$pokemon = new Pokemon($pdo, -1, 1, 5, 30);
	//$pokemon->generateIVs();
	//$pokemon = get_object_vars($pokemon);
	//print_r($pokemon);
	//unset($pokemon['attacks']);
	//$str = "INSERT INTO pokemon(".join(array_keys($pokemon), ',').") VALUES ('".join($pokemon, "','")."')";
	//echo $str;
	//$values = ['Pokemonpdo', 'Pokemonerrors', 'lookup', 'ownerID', 'attacks'];
?>