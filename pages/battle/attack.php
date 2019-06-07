<?php
	include('../../scripts/Database.php');
	include('../../scripts/Pokemon.php');
	
	session_start();
	
	if(!isset($_POST['attack'])) {
		echo json_encode("No attack found.");
		return;
	}
	
	$attackIndex = $_POST['attack'];
	$pokemon = Pokemon::get($pdo, $_SESSION['id']); //validate session
	$attack = $pokemon->attacks->attacks[$attackIndex];
	$attack = $attack->calculateDamage($pokemon, $_SESSION['encountered']);
	$_SESSION['encountered']->hp -= $attack;
	if($_SESSION['encountered']->hp <= 0) {
		echo json_encode([-1]);
	}
	else {
		echo json_encode([$attack]);
	}
?>