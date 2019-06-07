<?php
	//loaded map
	//encounter list
	include("Database.php");
	include("Pokemon.php");
	
	session_start();
	$chance = random_int(0, 100);
	
	$pokemon = new Pokemon($pdo, 16, -1, 3, 20);
	$pokemon->generateIVs();
	
	if($chance > 70) {
		$_SESSION['encountered'] = $pokemon;
		echo json_encode(get_object_vars($pokemon));
	}
	else {
		echo json_encode(array("message" => "Nothing found."));
	}
?>