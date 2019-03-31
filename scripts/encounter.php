<?php
	//loaded map
	//encounter list
	include("Database.php");
	include("Pokemon.php");
	
	session_start();
	$chance = random_int(0, 100);
	
	$pokemon = new Pokemon($pdo, -1, 16, 3, 20);
	
	if($chance > 70) {
		$_SESSION['encountered'] = $pokemon->serialize();
		echo json_encode(get_object_vars($pokemon));
	}
	else {
		echo json_encode(array("message" => "Nothing found."));
	}
?>