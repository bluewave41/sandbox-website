<?php
	include('../../scripts/Database.php');
	include('../../scripts/Pokemon.php');
	
	session_start();
	
	if(!is_numeric($_POST['partyPosition'])) {
		echo 'Non numeric value passed.';
		exit();
	}
	
	$pokemon = Pokemon::getPosition($pdo, $_SESSION['id'], $_POST['partyPosition']);
	$attacks = $pokemon->getAttackNames();
	echo json_encode([$pokemon->name, $pokemon->pokemonNo, $pokemon->level, $pokemon->exp, $attacks]);
?>